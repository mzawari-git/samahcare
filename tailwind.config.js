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
        mono: ['Tajawal', 'monospace'],
        display: ['"Playfair Display"', 'serif'],
        body: ['Inter', 'sans-serif'],
        arabic: ['"Noto Sans Arabic"', 'Tajawal', 'sans-serif'],
      },
      colors: {
        brand: {
          50: 'var(--brand-50, #FEF2F2)',
          100: 'var(--brand-100, #FEE2E2)',
          200: 'var(--brand-200, #FECACA)',
          300: 'var(--brand-300, #FCA5A5)',
          400: 'var(--brand-400, #F87171)',
          500: 'var(--brand-500, #DC2626)',
          600: 'var(--brand-600, #B91C1C)',
          700: 'var(--brand-700, #991B1B)',
          800: 'var(--brand-800, #7F1D1D)',
          900: 'var(--brand-900, #450A0A)',
        },
        accent: {
          50: 'var(--accent-50, #FAF6F2)',
          100: 'var(--accent-100, #f5ede5)',
          200: 'var(--accent-200, #ead9c9)',
          300: 'var(--accent-300, #d9bda5)',
          400: 'var(--accent-400, #c49a7c)',
          500: 'var(--accent-500, #a87a5c)',
          600: 'var(--accent-600, #8d6348)',
          700: 'var(--accent-700, #724e39)',
          800: 'var(--accent-800, #5a3d2d)',
          900: 'var(--accent-900, #FAF6F2)',
        },
        rose: {
          primary: '#DC2626',
          dark: '#991B1B',
          light: '#FEE2E2',
        },
        cream: '#FAF6F2',
        charcoal: '#2C2C2A',
        surface: 'var(--surface, #ffffff)',
        'surface-alt': 'var(--surface-alt, #FEF2F2)',
        ink: 'var(--ink, #2C2C2A)',
        'ink-muted': 'var(--ink-muted, #6b7280)',
        'ink-dim': 'var(--ink-dim, #9ca3af)',
        glass: {
          bg: 'var(--glass-bg, rgba(255, 255, 255, 0.9))',
          border: 'var(--glass-border, rgba(220, 38, 38, 0.08))',
        },
      },
      backgroundImage: {
        'gradient-primary': 'var(--gradient-primary)',
        'gradient-hero': 'var(--gradient-hero)',
      },
      boxShadow: {
        'neon': 'var(--neon-glow)',
        'neon-strong': 'var(--neon-glow-strong)',
        'neon-text': 'var(--neon-text-shadow)',
        'accent-neon': 'var(--accent-glow)',
        'accent-neon-strong': 'var(--accent-glow-strong)',
        'glass': '0 4px 30px rgba(0, 0, 0, 0.5)',
      },
      animation: {
        'scan': 'scan 3s ease-in-out infinite alternate',
        'shine': 'shine 5s linear infinite',
        'float-slow': 'floatSlow 8s ease-in-out infinite',
        'float-fast': 'floatFast 4s ease-in-out infinite',
        'marquee-rtl': 'marqueeRtl 25s linear infinite',
        'marquee-ltr': 'marqueeLtr 25s linear infinite',
        'pulse-neon': 'pulseNeon 2s ease-in-out infinite',
        'page-in': 'pageIn 0.35s ease-out',
        'fade-up': 'fadeUp 0.6s ease-out',
        'ping-neon': 'pingNeon 1.5s cubic-bezier(0, 0, 0.2, 1) infinite',
        'rotate-slow': 'rotateSlow 20s linear infinite',
      },
      keyframes: {
        scan: {
          '0%': { top: '5%', opacity: '0' },
          '10%': { opacity: '1' },
          '90%': { opacity: '1' },
          '100%': { top: '95%', opacity: '0' },
        },
        shine: {
          to: { backgroundPosition: '200% center' },
        },
        floatSlow: {
          '0%, 100%': { transform: 'translate(0, 0)' },
          '50%': { transform: 'translate(-10px, -20px)' },
        },
        floatFast: {
          '0%, 100%': { transform: 'translate(0, 0)' },
          '50%': { transform: 'translate(15px, 15px)' },
        },
        marqueeRtl: {
          '0%': { transform: 'translateX(0)' },
          '100%': { transform: 'translateX(50%)' },
        },
        marqueeLtr: {
          '0%': { transform: 'translateX(-50%)' },
          '100%': { transform: 'translateX(0)' },
        },
        pulseNeon: {
          '0%, 100%': { boxShadow: 'var(--neon-glow)' },
          '50%': { boxShadow: 'var(--neon-glow-strong)' },
        },
        pageIn: {
          from: { opacity: '0', transform: 'translateY(8px)' },
          to: { opacity: '1', transform: 'translateY(0)' },
        },
        fadeUp: {
          from: { opacity: '0', transform: 'translateY(20px)' },
          to: { opacity: '1', transform: 'translateY(0)' },
        },
        pingNeon: {
          '75%, 100%': { transform: 'scale(2)', opacity: '0' },
        },
        rotateSlow: {
          to: { transform: 'rotate(360deg)' },
        },
      },
    },
  },
  plugins: [],
}
