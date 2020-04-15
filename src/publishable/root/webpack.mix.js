let mix = require('laravel-mix');

require('mix-tailwindcss');

mix.js('resources/js/front/front.js', 'js')
   .js('resources/js/admin/admin.js', 'js')
   .sass('resources/sass/front/front.scss', 'css')
   .sass('resources/sass/admin/admin.scss', 'css')
   .sass('resources/sass/auth/auth.scss', 'css')
   .version()
   .tailwind();
