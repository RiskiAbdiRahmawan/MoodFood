// Tailwind Configuration
window.tailwind.config = {
    theme: {
        extend: {
            colors: {
                'mood-primary': '#22c55e',
                'mood-secondary': '#10b981',
                'mood-accent': '#059669',
                'mood-light': '#dcfce7',
                'mood-yellow': '#fbbf24'
            },
            backgroundImage: {
                'mood-gradient': 'linear-gradient(135deg, #22c55e 0%, #10b981 50%, #059669 100%)',
                'card-gradient': 'linear-gradient(135deg, #22c55e 0%, #10b981 100%)',
                'hero-gradient': 'linear-gradient(135deg, rgba(34, 197, 94, 0.9) 0%, rgba(16, 185, 129, 0.9) 50%, rgba(5, 150, 105, 0.9) 100%)'
            }
        }
    }
};
