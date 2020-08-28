const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.js('assets/js/app.js', 'publish/public/js')
	.js('assets/js/search.js', 'publish/public/js')
	.sass('assets/sass/app.scss', 'publish/public/css')
	.options({
		processCssUrls: false,
		postCss: [tailwindcss('./tailwind.config.js')],
	});
