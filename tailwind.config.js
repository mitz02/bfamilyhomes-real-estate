/** @type {import('tailwindcss').Config} */

// Attempt to load ShadCN config if installed
let shadcnConfig = {};
try {
  shadcnConfig = require("shadcn/ui/tailwind.config");
} catch (e) {
  console.warn("ShadCN UI config not found, continuing with default Tailwind config.");
}

module.exports = {
  darkMode: ["class"],
  content: [
    ...(shadcnConfig.content || []),
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "*.{js,ts,jsx,tsx,mdx}",
  ],
  theme: {
    extend: {
      ...((shadcnConfig.theme && shadcnConfig.theme.extend) || {}),
      colors: {
        ...(((shadcnConfig.theme && shadcnConfig.theme.extend && shadcnConfig.theme.extend.colors) || {})),
        primary: {
          50: "#fff7ed",
          100: "#ffedd5",
          200: "#fed7aa",
          300: "#fdba74",
          400: "#fb923c",
          500: "#f97316", // Deep Orange
          600: "#ea580c",
          700: "#c2410c",
          800: "#9a3412",
          900: "#7c2d12",
        },
        accent: {
          DEFAULT: "#eab308", // Golden Yellow
          dark: "#ca8a04",
        },
        secondary: {
          50: "#eef2ff",
          100: "#e8f0fe",
          200: "#c7d2fe",
          300: "#a5b4fc",
          400: "#818cf8",
          500: "#3b5bdb",
          600: "#2e4ac0",
          700: "#253b9e",
          800: "#1d2d7a",
          900: "#16205a",
        },
        danger: {
          DEFAULT: "#ef4444",
          dark: "#dc2626",
        },
      },
      fontFamily: {
        sans: ["Plus Jakarta Sans", "system-ui", "sans-serif"],
      },
      borderRadius: {
        lg: "var(--radius)",
        md: "calc(var(--radius) - 2px)",
        sm: "calc(var(--radius) - 4px)",
      },
    },
  },
  plugins: [
    ...(shadcnConfig.plugins || []),
    require("tailwindcss-animate"), // make sure this is installed
  ],
};
