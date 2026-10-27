import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // app.* = 기존(v1) 페이지 마크업, jc.* = 2026-10 리뉴얼 디자인 시스템, legacy-reskin = 기존 페이지 새 톤 입히기
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/jc.css', 'resources/css/legacy-reskin.css', 'resources/js/jc.js'],
            refresh: true,
        }),
    ],
});
