module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      fontFamily: {
        playfair: ['"Playfair Display"', 'serif'],
        poppins: ['"Poppins"', 'sans-serif'],
      },  
      scrollBehavior: {
        smooth: 'smooth',
      },
    },
  },
  plugins: [],
}
