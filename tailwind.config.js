/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/views/**/*.php",
    "./public/**/*.php"
  ],
  theme: {
    extend: {
      colors: {
        unsoed: {
            blue: '#003B5C',
            darkblue: '#002840',
            yellow: '#F2A900',
            lightyellow: '#ffbf2b',
        }
      },
      fontFamily: {
          sans: ['Outfit', 'sans-serif'],
          serif: ['Playfair Display', 'serif'],
      },
      boxShadow: {
          'glass': '0 8px 32px 0 rgba(0, 59, 92, 0.1)',
          'card': '0 10px 40px -10px rgba(0,0,0,0.08)',
      }
    },
  },
  plugins: [],
}
