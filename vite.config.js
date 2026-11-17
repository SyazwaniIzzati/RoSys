import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                    'resources/js/app.js', 
                    'resources/css/homepage.css',
                    'resources/css/auth.css',
                    'resources/css/admin.css',
                    'resources/css/dashboard.css',
                    'resources/css/customer-dashboard.css',
                   ],
            refresh: true,
        }),
    ],
});
