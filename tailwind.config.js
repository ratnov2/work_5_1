const colors = require("tailwindcss/colors");

module.exports = {
    darkMode: "class",
    content: [
        "./app/Containers/**/*.blade.php", 
        "./resources/views/components/**/*.blade.php", 
        "./resources/views/errors/**/*.blade.php", 
        "./resources/**/*.js", 
        "./resources/**/*.vue"
    ],
    theme: {
        colors: {
            transparent: "transparent",
            current: "currentColor",
            black: colors.black,
            white: colors.white,
            gray: {
                50: "#f5f4f5",
                100: "#f5f4f5",
                200: "#e6e4e7",
                300: "#aba6af",
                400: "#a7a3ab",
                500: "#77737a",
                600: "#545156",
                700: "#444046",
                800: "#201e26",
                900: "#1c1a22",
                1000: "#15141a",
            },
            indigo: colors.indigo,
            red: colors.red,
            blue: colors.blue,
            yellow: colors.yellow,
            amber: colors.amber,
            emerald: colors.emerald,
            purple: colors.purple,
            violet: colors.violet,
            pink: colors.pink,
            fuchsia: colors.fuchsia,
            rose: colors.rose,
            green: colors.green,
            cyan: colors.cyan,
            orange: colors.orange,
            lime: colors.lime,
        },

        extend: {
            width: {
                "92": "23rem",
            },
            scale: {
                "120": "1.2",
            },
            height: {
                "92": "23rem",
                "100": "25rem",
                "124": "31rem",
            },
            blur: {
                xs: "2px",
            },
            minHeight: {
                "24": "6rem",
                "96": "24rem",
                "100": "25rem",
            },
            maxHeight: {
                "48": "12rem",
                "96": "24rem",
                "100": "25rem",
            },
            maxWidth: {
                "28": "7rem",
                "32": "8rem",
                "96": "24rem",
            },
            fontSize: {
                xss: ".59rem",
            },
            animation: {
                widthFull: "widthFull 4s ease-in-out",
                "spin-slow": "spin 3s linear infinite",
                "pulse-fast": "pulse 700ms linear infinite",
            },

            keyframes: {
                widthFull: {
                    "0%": { width: 0 + "%" },
                    "100%": { width: 100 + "%" },
                },
            },

            colors: {
                transparent: "transparent",
                current: "currentColor",
                gray: {
                    "850": "#19202f",
                    "650": "#333c4c",
                },
            },
            transitionProperty: {
                width: "width",
                height: "height",
            },
        },
    },

    variants: {
        extend: {
            width: ["group-hover"],
            height: ["group-hover"],
            textColor: ["responsive", "hover", "focus", "group-hover"],
            translate: ["active", "group-hover"],
            scale: ["active", "group-hover"],
        },
    },

    plugins: [],
};
