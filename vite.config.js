import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    server: {
      https: false,
      host: 'localhost',
      hmr: {
        host: 'localhost',
      },
    },
    plugins: [
        laravel({
            input: ["resources/css/app.scss", "resources/js/main.js"],
            refresh: true,
        }),
        vue({}),
    ],
});