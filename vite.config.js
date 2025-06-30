import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    // Anda mungkin perlu menambahkan server host jika menggunakan WSL/Docker atau host non-default
    // server: {
    //     host: '0.0.0.0', // Untuk WSL/Docker, atau IP spesifik
    //     hmr: {
    //         host: 'aset-mgmt.test', // Sesuaikan dengan domain Anda jika perlu
    //     },
    // },
});
