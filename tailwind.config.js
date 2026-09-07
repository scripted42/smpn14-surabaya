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
                paper: '#F8FAFB',
                'paper-alt': '#FFFFFF',
                ink: '#0E1F38',
                schoolRed: '#1B7670',
                schoolTeal: '#1B7670',
                schoolNavy: '#0E1F38',
                schoolGold: '#D4A03A',
                schoolLine: '#E1E8EB',
                schoolGreen: '#0A182E',
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
