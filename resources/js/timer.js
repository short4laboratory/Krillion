/**
 * The per-question countdown. The server says how many seconds are left (it owns the real deadline);
 * this drains the ring smoothly, ticks the number once a second, and when it reaches zero submits
 * whatever has been typed with timed_out=1. On the boat, that submit still plays the cast.
 */

const WARNING_AT = 10;
const CRITICAL_AT = 5;

function restartAnimation(element, className) {
    element.classList.remove(className);
    void element.offsetWidth; // Force a reflow so the animation plays again.
    element.classList.add(className);
}

export function initQuestionTimer() {
    const timer = document.querySelector('[data-question-timer]');
    const form = timer?.closest('form');

    if (!timer || !form) {
        return;
    }

    const ring = timer.querySelector('[data-timer-ring]');
    const seconds = timer.querySelector('[data-timer-seconds]');
    const bubble = timer.querySelector('[data-timer-bubble]');
    const announcer = timer.querySelector('[data-timer-announcer]');
    const input = form.querySelector('[name="answer"]');
    const timedOut = form.querySelector('[data-timed-out]');

    const total = Number(timer.dataset.secondsTotal);
    const remainingAtLoad = Number(timer.dataset.secondsRemaining);
    const circumference = Number(ring.getAttribute('stroke-dasharray'));
    const deadline = performance.now() + remainingAtLoad * 1000;
    let shownSeconds = remainingAtLoad;
    let isStopped = false;

    // Only stop once the answer is really on its way (a spell-check prompt keeps the clock running).
    form.addEventListener('answer:leaving', () => {
        isStopped = true;
        timer.classList.add('is-stopped');
    });

    const expire = () => {
        isStopped = true;
        timer.dataset.urgency = 'critical';
        timer.classList.add('is-expired');
        announcer.textContent = "Time's up!";
        input.required = false;
        input.readOnly = true;
        timedOut.value = '1';
        form.requestSubmit();
    };

    const render = (now) => {
        if (isStopped) {
            return;
        }

        const remainingMs = Math.max(0, deadline - now);
        const remainingSeconds = Math.ceil(remainingMs / 1000);

        ring.setAttribute('stroke-dashoffset', circumference * (1 - remainingMs / (total * 1000)));

        if (remainingSeconds !== shownSeconds) {
            shownSeconds = remainingSeconds;
            seconds.textContent = remainingSeconds;
            timer.setAttribute('aria-label', `${remainingSeconds} seconds left`);
            timer.dataset.urgency = remainingSeconds <= CRITICAL_AT ? 'critical' : remainingSeconds <= WARNING_AT ? 'warning' : 'calm';
            restartAnimation(seconds, 'is-ticking');
            restartAnimation(bubble, 'is-rising');

            if (remainingSeconds === WARNING_AT || remainingSeconds === CRITICAL_AT) {
                announcer.textContent = `${remainingSeconds} seconds left`;
            }
        }

        if (remainingMs <= 0) {
            expire();

            return;
        }

        requestAnimationFrame(render);
    };

    if (remainingAtLoad <= 0) {
        expire();

        return;
    }

    requestAnimationFrame(render);
}
