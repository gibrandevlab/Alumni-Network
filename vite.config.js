import path from 'path';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    base: './',
    publicDir: 'fake_dir_so_vite_does_not_throw_a_fit',
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/dashboard/member-setting.js',
                'resources/js/dashboard/dashboard.js',
                'resources/js/navbar-burger.js',
                'resources/js/Event.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@js': path.resolve('resources/js'),
        },
    },
});

