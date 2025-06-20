<<<<<<< HEAD
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
=======
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
>>>>>>> 1871dce885169eddbdd6e1f679e891f946aa85e2

export default defineConfig({
    plugins: [
        laravel({
<<<<<<< HEAD
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
=======
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
>>>>>>> 1871dce885169eddbdd6e1f679e891f946aa85e2
});
