/**
 * The opening cast. When the first answer is submitted from the boat, the fisher swings the rod back,
 * whips it forward, the bobber arcs out over the water, splashes down and sinks — then the form submits
 * and the dive continues underwater. Later answers submit normally.
 *
 * Coordinates are in the boat scene's SVG viewBox (see components/boat-scene.blade.php).
 */

import { prefersReducedMotion } from './motion';

const ROD_PIVOT = { x: 812, y: 506 };
const ROD_TIP = { x: 690, y: 378 };
const IDLE_LURE = { x: 668, y: 562 };
const LANDING = { x: 540, y: 566 };
const SUNK = { x: 552, y: 720 };

const BACKSWING_END = 300;
const FORWARD_END = 520;
const SETTLE_END = 900;
const RELEASE = 420;
const SPLASHDOWN = 1100;
const SPLASH_END = 1500;
const SINK_END = 2100;
const VEIL_AT = 1550;

const lerp = (from, to, t) => from + (to - from) * t;
const clamp = (t) => Math.min(1, Math.max(0, t));
const easeOut = (t) => 1 - (1 - t) ** 3;
const easeInOut = (t) => (t < 0.5 ? 4 * t ** 3 : 1 - (-2 * t + 2) ** 3 / 2);
const progress = (time, start, end) => clamp((time - start) / (end - start));

function rotateAroundPivot(point, degrees) {
    const radians = (degrees * Math.PI) / 180;
    const dx = point.x - ROD_PIVOT.x;
    const dy = point.y - ROD_PIVOT.y;

    return {
        x: ROD_PIVOT.x + dx * Math.cos(radians) - dy * Math.sin(radians),
        y: ROD_PIVOT.y + dx * Math.sin(radians) + dy * Math.cos(radians),
    };
}

function rodAngleAt(time) {
    if (time < BACKSWING_END) {
        return lerp(0, 28, easeInOut(progress(time, 0, BACKSWING_END)));
    }

    if (time < FORWARD_END) {
        return lerp(28, -32, easeOut(progress(time, BACKSWING_END, FORWARD_END)));
    }

    return lerp(-32, -12, easeInOut(progress(time, FORWARD_END, SETTLE_END)));
}

function quadraticPoint(start, control, end, t) {
    return {
        x: (1 - t) ** 2 * start.x + 2 * (1 - t) * t * control.x + t ** 2 * end.x,
        y: (1 - t) ** 2 * start.y + 2 * (1 - t) * t * control.y + t ** 2 * end.y,
    };
}

/**
 * Play the cast from the boat scene. Resolves when the bobber has sunk, so the caller can submit.
 */
export function playCast() {
    const scene = document.querySelector('[data-boat-scene]');

    if (!scene || prefersReducedMotion()) {
        return Promise.resolve();
    }

    const rod = scene.querySelector('#cast-rod');
    const line = scene.querySelector('#cast-line');
    const lure = scene.querySelector('#cast-lure');
    const splash = scene.querySelector('#cast-splash');
    const veil = scene.querySelector('[data-cast-veil]');

    return new Promise((resolve) => {
        scene.classList.add('is-casting');

        const releaseTip = rotateAroundPivot(ROD_TIP, rodAngleAt(RELEASE));
        const flightControl = { x: lerp(releaseTip.x, LANDING.x, 0.45), y: 140 };
        const startedAt = performance.now();

        const render = (now) => {
            const time = now - startedAt;
            const tip = rotateAroundPivot(ROD_TIP, rodAngleAt(time));
            let bobber;
            let lineControl;

            if (time < RELEASE) {
                const dangle = { x: tip.x - 4, y: tip.y + 34 };
                bobber = {
                    x: lerp(IDLE_LURE.x, dangle.x, easeOut(progress(time, 0, BACKSWING_END))),
                    y: lerp(IDLE_LURE.y, dangle.y, easeOut(progress(time, 0, BACKSWING_END))),
                };
                lineControl = { x: (tip.x + bobber.x) / 2, y: (tip.y + bobber.y) / 2 };
            } else if (time < SPLASHDOWN) {
                bobber = quadraticPoint(releaseTip, flightControl, LANDING, progress(time, RELEASE, SPLASHDOWN));
                lineControl = { x: (tip.x + bobber.x) / 2, y: Math.min(tip.y, bobber.y) - 30 };
            } else {
                const sinking = easeInOut(progress(time, SPLASH_END, SINK_END));
                bobber = { x: lerp(LANDING.x, SUNK.x, sinking), y: lerp(LANDING.y, SUNK.y, sinking) };
                lineControl = { x: (tip.x + bobber.x) / 2 + 30, y: Math.max(tip.y, LANDING.y) - 10 };
            }

            rod.setAttribute('transform', `rotate(${rodAngleAt(time)} ${ROD_PIVOT.x} ${ROD_PIVOT.y})`);
            lure.setAttribute('transform', `translate(${bobber.x} ${bobber.y})`);
            line.setAttribute('d', `M${tip.x} ${tip.y} Q${lineControl.x} ${lineControl.y} ${bobber.x} ${bobber.y}`);

            const splashing = progress(time, SPLASHDOWN, SPLASH_END);
            if (splashing > 0 && splashing < 1) {
                splash.setAttribute('cx', LANDING.x);
                splash.setAttribute('cy', LANDING.y);
                splash.setAttribute('rx', 4 + 38 * easeOut(splashing));
                splash.setAttribute('ry', 1 + 8 * easeOut(splashing));
                splash.setAttribute('opacity', 1 - splashing);
            } else {
                splash.setAttribute('opacity', 0);
            }

            if (time >= VEIL_AT) {
                veil?.classList.replace('opacity-0', 'opacity-70');
            }

            if (time < SINK_END) {
                requestAnimationFrame(render);
            } else {
                resolve();
            }
        };

        requestAnimationFrame(render);
    });
}
