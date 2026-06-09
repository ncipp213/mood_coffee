/** @type {import('tailwindcss').Config} */
    export default {
    darkMode: 'class', // Aktifkan dark mode dengan strategi kelas manual
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
        fontFamily: {
            'poppins': ['Poppins', 'sans-serif'], // Tambahkan font Poppins untuk tampilan modern
        },
        },
    },
    plugins: [],
}