const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
  .js('resources/js/group_edit.js', 'public/js')
  .js('resources/js/group_manage.js', 'public/js')
  .js('resources/js/note_edit.js', 'public/js')
  .js('resources/js/note_manage.js', 'public/js')
  .sass('resources/sass/welcome.scss', 'public/css')
  .sass('resources/sass/home.scss', 'public/css')
  .sass('resources/sass/group_manage.scss', 'public/css')
  .sass('resources/sass/note_manage.scss', 'public/css')
  .sass('resources/sass/note_editread.scss', 'public/css')
  .sass('resources/sass/app.scss', 'public/css');
