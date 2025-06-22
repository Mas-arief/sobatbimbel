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
      keyframes: {
        floatAround: {
          '0%, 100%': { opacity: '0', transform: 'translate(0, 0)' },
          '10%': { opacity: '1', transform: 'translateY(-10px)' },
          '25%': { transform: 'translateX(10px)' },
          '50%': { opacity: '0.7', transform: 'translateY(10px)' },
          '75%': { transform: 'translateX(-10px)' },
          '90%': { opacity: '0', transform: 'translateY(0)' },
        }
      },
      animation: {
        floating: 'floatAround 10s ease-in-out infinite',
      }
    },
  },
  plugins: [],
}
  