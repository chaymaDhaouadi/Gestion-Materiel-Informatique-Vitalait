import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '127.0.0.1',  // pas [::1]
        port: 5173,
        strictPort: true,
        cors: {
            origin: ['http://vitalait:8000'],  // autorise ton domaine Laravel
            methods: ['GET', 'POST', 'PUT', 'DELETE'],
            allowedHeaders: ['*'],
            credentials: true,
        },
    },
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
    ],
});
