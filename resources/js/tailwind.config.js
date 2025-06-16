/** @type {import('tailwindcss').Config} */
export default {
    content: [
      './resources/views/**/*.blade.php',
      './resources/js/**/*.js',
    ],
    theme: {
      extend: {
        fontFamily: {
          sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui'],
        },
      },
    },
    plugins: [],
  }
  