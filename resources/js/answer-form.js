import { playCast } from './cast';
import { playDiveOut } from './descent';

/**
 * Spell-checks an answer before it is submitted.
 *
 * Enter asks the server whether the answer is on the question's answer key (nothing is recorded):
 * - accepted: the cast or dive animation plays and the answer is submitted
 * - near miss: "Did you mean “Skull”?" appears above the box; Enter again (or clicking the name)
 *   replaces the typed text with the suggestion and submits it
 * - wrong: the message appears above the box and the answer stays for editing
 *
 * When the timer runs out it submits with timed_out=1, which skips the check (the server autocorrects).
 * If the check can't be reached, the answer is submitted and the server validates it instead.
 */
export function initAnswerForm() {
    const form = document.querySelector('form[data-answer-form]');

    if (!form) {
        return;
    }

    const input = form.querySelector('[name="answer"]');
    const feedback = form.querySelector('[data-answer-feedback]');
    const timedOut = form.querySelector('[data-timed-out]');
    const buttons = form.querySelectorAll('[type="submit"]');
    const suggestionTemplate = document.querySelector('[data-suggestion-template]');
    const csrfToken = form.querySelector('[name="_token"]').value;

    let state = 'idle';
    let suggestion = form.dataset.suggestion ? { label: form.dataset.suggestion, forText: input.value } : null;

    const setBusy = (isBusy) => {
        [form, ...buttons].forEach((element) => (isBusy
            ? element.setAttribute('aria-busy', 'true')
            : element.removeAttribute('aria-busy')));
    };

    const clearFeedback = () => {
        feedback.replaceChildren();
        input.removeAttribute('aria-invalid');
    };

    const showMessage = (message) => {
        const paragraph = document.createElement('p');
        paragraph.className = 'suggestion-pop text-sm text-rose-200';
        paragraph.textContent = message;
        feedback.replaceChildren(paragraph);
        input.setAttribute('aria-invalid', 'true');
        input.select();
    };

    const showSuggestion = (label) => {
        const prompt = suggestionTemplate.content.firstElementChild.cloneNode(true);
        prompt.querySelector('[data-suggestion-label]').textContent = label;
        feedback.replaceChildren(prompt);
        bindSuggestionButton();
        input.focus();
    };

    const leave = async () => {
        state = 'leaving';
        form.dispatchEvent(new CustomEvent('answer:leaving'));
        buttons.forEach((button) => button.setAttribute('disabled', ''));
        input.readOnly = true;
        await (form.hasAttribute('data-cast') ? playCast() : playDiveOut());
        HTMLFormElement.prototype.submit.call(form);
    };

    const acceptSuggestion = () => {
        input.value = suggestion.label;
        suggestion = null;
        clearFeedback();
        leave();
    };

    function bindSuggestionButton() {
        feedback.querySelector('[data-accept-suggestion]')?.addEventListener('click', () => {
            if (state === 'idle' && suggestion) {
                acceptSuggestion();
            }
        });
    }

    const check = async (answer) => {
        try {
            const response = await fetch(form.dataset.checkUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ answer }),
            });

            if (response.status === 422) {
                const body = await response.json();

                return { status: 'rejected', message: body.errors?.answer?.[0] ?? body.message };
            }

            return response.ok ? await response.json() : null;
        } catch {
            return null;
        }
    };

    input.addEventListener('input', () => {
        if (suggestion && input.value !== suggestion.forText) {
            suggestion = null;
        }

        if (feedback.childElementCount > 0) {
            clearFeedback();
        }
    });

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        if (state !== 'idle') {
            return;
        }

        if (timedOut.value === '1') {
            leave();

            return;
        }

        if (suggestion && input.value === suggestion.forText) {
            acceptSuggestion();

            return;
        }

        state = 'checking';
        setBusy(true);
        const result = await check(input.value.trim());
        setBusy(false);
        state = 'idle';

        // The clock ran out while we were checking, or the check couldn't run: let the server decide.
        if (timedOut.value === '1' || result === null || result.status === 'accepted') {
            leave();

            return;
        }

        if (result.status === 'suggestion') {
            suggestion = { label: result.suggestion, forText: input.value };
            showSuggestion(result.suggestion);

            return;
        }

        showMessage(result.message);
    });

    bindSuggestionButton();
}
