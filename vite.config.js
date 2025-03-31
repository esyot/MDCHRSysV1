import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        vue(),
    ],
    server: {
        host: "localhost",
        port: 5173,
        cors: true,
        hmr: {
            clientPort: 5173,
        },
        watch: {
            usePolling: true,
        },
    },
});
