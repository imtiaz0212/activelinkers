/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        extend: {
            typography: {
                DEFAULT: {
                    css: {
                        fontSize: "18px",
                        fontWeight: "400",
                        maxWidth: "100%",
                        code: {
                            "&::before": {
                                content: "",
                            },
                            "&::after": {
                                content: "",
                            },
                        },
                    },
                },
            },
            fontFamily: {
                syne: ["Syne", "sans-serif"],
                inter: ["Inter", "serif"],
            },
            boxShadow: {
                custom: "0px 1px 6px 2px rgba(0,0,0,0.30)",
            },
            colors: {
                primary: "#FF8B4A",
                backendPrimary: "#F78721",
                secondary: "#7572FD",
                tertiary: "#11162C",
                success: "#27AE60",
                warning: "#E2B93B",
                error: "#EB5757",
                darkblue: "#00005C",
                bluegray: "#627193",
                black1: "#2B2B2B",
                black2: "#1D1D1D",
                black3: "#282828",
                gray1: "#333333",
                gray2: "#4F4F4F",
                gray3: "#828282",
                gray4: "#BDBDBD",
                gray5: "E0E0E0",
                bgColor: "#11162C ",
            },

            container: {
                padding: "16px",
                center: true,
            },

            keyframes: {
                marquee: {
                    "0%": { transform: "translateX(100%)" },
                    "100%": { transform: "translateX(-100%)" },
                },
                scale: {
                    "0%": {
                        transform: "scale(1)",
                    },
                    "50%": {
                        transform: "scale(.8)",
                    },
                    "100%": {
                        transform: "scale(1)",
                    },
                },
                updown: {
                    "0%": {
                        transform: "translateY(0)",
                    },
                    "50%": {
                        transform: "translateY(10px)",
                    },
                    "100%": {
                        transform: "translateY(0)",
                    },
                },
                scrolldown: {
                    "0%": {
                        transform: "translateX(-50%) translateY(35px)",
                    },
                    "50%": {
                        transform: "translateX(-50%) translateY(20px)",
                    },
                    "100%": {
                        transform: "translateX(-50%) translateY(35px)",
                    },
                },
            },
            animation: {
                marquee: "marquee 25s linear infinite",
                scale: "scale 15s linear infinite",
                updown: "updown 5s linear infinite",
                scrolldown: "scrolldown 2s linear infinite alternate",
            },
        },
    },
    plugins: [require("flowbite/plugin"), require("@tailwindcss/typography")],
};
