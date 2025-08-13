import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/chrisreedio/socialment/resources/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'stats4sd-red': 'var(--stats4sd-red)',
                'stats4sd-red-70': 'var(--stats4sd-red-transparent)',
                'stats4sd-grey': 'var(--stats4sd-grey)',
                'frn-green': 'var(--frn-green)',
            }
        },
    },

    plugins: [
        forms,
        typography
    ],
};
