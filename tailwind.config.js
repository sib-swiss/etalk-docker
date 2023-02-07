const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    theme: {
        extend: {},
    },

    content: [
        "./app/**/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./node_modules/tw-elements/dist/js/**/*.js",
    ],
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require("tw-elements/dist/plugin"),
    ],
};
