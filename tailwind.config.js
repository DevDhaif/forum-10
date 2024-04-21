const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    important: true,
    darkMode: 'media',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        // "./node_modules/flowbite/**/*.js",
        // 'node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx}',
        // 'node_modules/flowbite/**/*.{js,jsx,ts,tsx}',
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            textColor: ['dark'],

            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ]
};
