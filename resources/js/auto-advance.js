/**
 * After the final catch, count down and move on to the results ([data-auto-advance] with data-seconds
 * and data-href). The ring drains like the question timer and the number ticks each second.
 */
export function initAutoAdvance() {
    const timer = document.querySelector('[data-auto-advance]');

    if (!timer) {
        return;
    }

    const seconds = Number(timer.dataset.seconds);
    const count = timer.querySelector('[data-auto-advance-count]');
    const ring = timer.querySelector('[data-auto-advance-ring]');
    const circumference = Number(ring.getAttribute('stroke-dasharray'));
    const deadline = performance.now() + seconds * 1000;
    let shown = seconds;

    const tick = (now) => {
        const remaining = Math.max(0, deadline - now);
        const remainingSeconds = Math.ceil(remaining / 1000);

        ring.setAttribute('stroke-dashoffset', circumference * (1 - remaining / (seconds * 1000)));

        if (remainingSeconds !== shown) {
            shown = remainingSeconds;
            count.textContent = remainingSeconds;
            timer.setAttribute('aria-label', `Results in ${remainingSeconds} seconds`);
            count.classList.remove('is-ticking');
            void count.offsetWidth; // Restart the tick animation.
            count.classList.add('is-ticking');
        }

        if (remaining > 0) {
            requestAnimationFrame(tick);
        } else {
            window.location.assign(timer.dataset.href);
        }
    };

    requestAnimationFrame(tick);
}
