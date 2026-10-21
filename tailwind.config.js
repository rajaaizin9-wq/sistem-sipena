/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './app/Views/**/*.php',
    './resources/**/*.css',
  ],
  theme: {
    extend: {
      colors: {
        bnn: {
          950: '#082b4c',
          800: '#0d4f83',
          600: '#1678b8',
          300: '#8ec9e8',
          100: '#eaf5fb',
          ink: '#17324d',
          muted: '#63778b',
          line: '#d9e5ec',
        },
      },
      maxWidth: { container: '1160px' },
    },
  },
  plugins: [],
};
