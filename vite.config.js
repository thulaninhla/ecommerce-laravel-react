import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        https: true,  // Force HTTPS for dev too
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'], // or .jsx if using React
            refresh: true,
        }),
    ],
});
