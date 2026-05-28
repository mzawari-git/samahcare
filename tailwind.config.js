/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/views/**/*.blade.php',
    './resources/views/**/*.php',
    './js/**/*.js',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Tajawal', 'sans-serif'],
      },
      colors: {
        brand: {
          50: 'var(--brand-50, #fdf8f9)',
          100: 'var(--brand-100, #fbe8ec)',
          200: 'var(--brand-200, #f7d1d9)',
          300: 'var(--brand-300, #f0adb9)',
          400: 'var(--brand-400, #e38a9a)',
          500: 'var(--brand-500, #d97a8c)',
          600: 'var(--brand-600, #c56174)',
          700: 'var(--brand-700, #a8495c)',
          800: 'var(--brand-800, #8a3a4b)',
          900: 'var(--brand-900, #6d2d3b)',
        },
        surface: 'var(--surface, #faf9f8)',
        ink: 'var(--ink, #1c1917)',
      },
      animation: {
        'marquee': 'marquee 25s linear infinite',
        'float': 'float 6s ease-in-out infinite',
        'shimmer': 'shimmer 1.5s infinite',
        'page-in': 'pageIn 0.35s ease-out',
        'count-up': 'countUp 2s ease-out',
      },
      keyframes: {
        marquee: {
          '0%': { transform: 'translateX(0)' },
          '100%': { transform: 'translateX(-50%)' },
        },
        float: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-20px)' },
        },
        shimmer: {
          '0%': { backgroundPosition: '200% 0' },
          '100%': { backgroundPosition: '-200% 0' },
        },
        pageIn: {
          from: { opacity: '0', transform: 'translateY(8px)' },
          to: { opacity: '1', transform: 'translateY(0)' },
        },
        countUp: {
          from: { opacity: '0', transform: 'translateY(20px)' },
          to: { opacity: '1', transform: 'translateY(0)' },
        },
      },
    },
  },
  plugins: [],
}
