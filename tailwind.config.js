import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                paper: '#EDEAD9',
                'paper-alt': '#FBFAF5',
                ink: '#1F2A44',
                schoolRed: '#9B3226',
                schoolGold: '#C99A3E',
                schoolLine: '#A79E8C',
                schoolGreen: '#2F4A3C',
            },
            fontFamily: {
                display: ['"IBM Plex Serif"', 'serif'],
                sans: ['"IBM Plex Sans"', 'sans-serif'],
                mono: ['"IBM Plex Mono"', 'monospace'],
            },
        },
    },

    plugins: [forms],
};
