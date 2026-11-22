import { prefersReducedMotion } from './motion';

/**
 * The dive between questions.
 *
 * Leaving: playDiveOut() sinks the question card out of view before the page changes.
 * Arriving: the page loads at the previous depth (body[data-descend-to]) and sinks to the new one —
 * the water darkens via the animatable --depth property, depth counters climb, and the gauge marker slides down.
 */

const DESCENT_MS = 2600;
const DIVE_OUT_MS = 450;

const easeInOut = (t) => (t < 0.5 ? 4 * t ** 3 : 1 - (-2 * t + 2) ** 3 / 2);

function countUp(counter) {
    const from = Number(counter.dataset.from);
    const to = Number(counter.dataset.to);
    const format = (meters) => Math.round(meters).toLocaleString('en-US');

    if (from === to || prefersReducedMotion()) {
        counter.textContent = format(to);

        return;
    }

    const startedAt = performance.now();
    const step = (now) => {
        const t = Math.min(1, (now - startedAt) / DESCENT_MS);
        counter.textContent = format(from + (to - from) * easeInOut(t));

        if (t < 1) {
            requestAnimationFrame(step);
        }
    };

    requestAnimationFrame(step);
}

export function initDescent() {
    const target = document.body.dataset.descendTo;

    document.querySelectorAll('[data-depth-counter]').forEach(countUp);

    if (target === undefined) {
        return;
    }

    // Wait two frames so the starting depth is painted before the transition begins.
    requestAnimationFrame(() => requestAnimationFrame(() => {
        document.body.style.setProperty('--depth', target);

        const marker = document.querySelector('[data-gauge-marker]');
        const fill = document.querySelector('[data-gauge-fill]');
        marker?.style.setProperty('top', `${marker.dataset.toPercent}%`);
        fill?.style.setProperty('height', `${fill.dataset.toPercent}%`);
    }));
}

/**
 * Sink the question card out of view. Resolves when it's gone, so the caller can submit.
 */
export function playDiveOut() {
    const card = document.querySelector('[data-dive-card]');

    if (!card || prefersReducedMotion()) {
        return Promise.resolve();
    }

    card.classList.add('is-diving');

    return new Promise((resolve) => setTimeout(resolve, DIVE_OUT_MS));
}
