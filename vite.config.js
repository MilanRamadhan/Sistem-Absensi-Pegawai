import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    // Tambahkan bagian server ini jika belum ada, atau pastikan sudah benar
    server: {
        host: "0.0.0.0", // Gunakan virtual host Anda
        port: 5173,
        hmr: {
            host: "sistem-kepegawaian.test",
            clientPort: 5173,
        },
        https: true, // Tambahkan baris ini untuk mengaktifkan HTTPS
    },
});
