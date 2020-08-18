module.exports = {
	purge: ['./views/**/*.blade.php', './views/**/*.html'],
	theme: {
		extend: {},
		screens: {
			sm: '640px',
			md: '768px',
			lg: '1024px',
			xl: '1280px',
		},
		extend: {
			colors: {
				purple: '#4951f2',
			},
		},
	},
	variants: {},
	plugins: [],
};
