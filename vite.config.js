import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    server: {
      hmr: {
        host: '89.111.152.136',
      },
      cors: {
        origin: false,
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