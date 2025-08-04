/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: ['./index.html', './src/**/*.{js,ts,jsx,tsx}'],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#E6EBF4',
          100: '#C2D1E8',
          200: '#9AB3DB',
          300: '#7195CE',
          400: '#537FC5',
          500: '#3568BC',
          600: '#2A5396',
          700: '#203E71',
          800: '#15294B',
          900: '#0A2342',
        },
        secondary: {
          50: '#E6F7F7',
          100: '#C2EEEF',
          200: '#9AE4E6',
          300: '#71DADD',
          400: '#53D0D4',
          500: '#35C7CB',
          600: '#2CA6A4',
          700: '#22827D',
          800: '#175D57',
          900: '#0D3B36',
        },
        accent: {
          50: '#FDF8E9',
          100: '#FAEFC8',
          200: '#F8E6A7',
          300: '#F5DD87',
          400: '#F2D566',
          500: '#EFCC45',
          600: '#E6C229',
          700: '#C4A022',
          800: '#927919',
          900: '#60510F',
        },
        success: {
          500: '#10B981',
          600: '#059669',
        },
        warning: {
          500: '#F59E0B',
          600: '#D97706',
        },
        error: {
          500: '#EF4444',
          600: '#DC2626',
        },
      },
      fontFamily: {
        sans: [
          'Inter',
          'ui-sans-serif',
          'system-ui',
          '-apple-system',
          'BlinkMacSystemFont',
          'Segoe UI',
          'Roboto',
          'Helvetica Neue',
          'Arial',
          'sans-serif',
        ],
      },
      animation: {
        'fade-in': 'fadeIn 0.5s ease-in-out',
        'slide-up': 'slideUp 0.5s ease-out',
        'slide-down': 'slideDown 0.3s ease-out',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { transform: 'translateY(20px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        slideDown: {
          '0%': { transform: 'translateY(-20px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
      },
      boxShadow: {
        'product': '0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025)',
        'nav': '0 4px 6px -1px rgba(0, 0, 0, 0.05)',
        'card': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
      }
    },
  },
  plugins: [],
};