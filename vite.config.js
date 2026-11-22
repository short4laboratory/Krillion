import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                // Fredoka: rounded and bubbly, for headings, buttons and the logo.
                bunny('Fredoka', {
                    weights: [500, 600, 700],
                }),
                // Nunito: rounded and friendly, but easy to read at body sizes.
                bunny('Nunito', {
                    weights: [400, 600, 700],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
