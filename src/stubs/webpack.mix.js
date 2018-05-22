let mix = require('laravel-mix');

require('laravel-mix-tailwind');


mix.js('resources/assets/js/front/front.js', 'js')
   .js('resources/assets/js/admin/admin.js', 'js')
   .sass('resources/assets/sass/front/front.scss', 'css')
   .sass('resources/assets/sass/admin/admin.scss', 'css')
   .sass('resources/assets/sass/auth/auth.scss', 'css')
   .version()
   .tailwind();
