import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig(({ mode }) => {
    const isLocal = mode === "development";
    const config = {
        plugins: [
            laravel({
                input: ["resources/css/app.scss", "resources/js/main.js"],
                refresh: true,
            }),
            vue({}),
        ],
    };
    if (isLocal) {
        config.server = {
            hmr: {
                host: "localhost",
            },
            watch: {
                usePolling: true,
            },
        };
    }
    return config;
});