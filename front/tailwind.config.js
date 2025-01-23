/** @type {import('tailwindcss').Config} */
export default {
  content: ['./src/**/*.{html,js,svelte,ts}'],

  theme: {
    extend: {
      colors : {
        'main-app' : '#2563EB',
        'main-gray' : '#4B5563',
        'main-white' : '#FFFFFF',
        'main-black' : '#000000',
        'accent-green' : '#059669',
        'accent-red' : '#DC2626',
        'accent-orange' : '#EA580C',
        'auxiliary-blue' : '#DBEAFE',
        'auxiliary-gray' : '#F3F4F6',
        'auxiliary-darkblue' : '#1E3A8A'
      }
    }
  },

  plugins: []
};
