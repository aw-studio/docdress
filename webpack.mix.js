const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.js('assets/js/app.js', 'publish/js')
	.sass('assets/sass/app.scss', 'publish/css')
	.options({
		processCssUrls: false,
		postCss: [tailwindcss('./tailwind.config.js')],
	});
