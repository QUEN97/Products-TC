/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
     './templates/**/*.php',   // Asegúrate de que las vistas de CakePHP estén cubiertas
    './src/**/*.php'
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

