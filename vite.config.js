import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    // server: {
    //     hmr: {
    //         host: "localhost",
    //     },
    //     watch: {
    //         usePolling: true,
    //     },
    // },
    plugins: [
        laravel({
            input: ["resources/css/app.scss", "resources/js/main.js"],
            refresh: true,
        }),
        vue({}),
    ],
    define: {
        VITE_BACKEND_URL: process.env.VITE_BACKEND_URL,
    }
});