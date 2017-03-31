const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
    mix.sass('app.scss')
      .sass('admin.scss')
      .copy('resources/images', 'public/images')
      .copy('resources/fonts', 'public/fonts')
      .copy('resources/js/select2.min.js', 'public/js/select2.min.js')
      .copy('node_modules/font-awesome/fonts', 'public/fonts')
      .copy('node_modules/font-awesome/css/font-awesome.min.css', 'public/css/font-awesome.min.css');
    
    
    mix.webpack('app.js')
      .webpack('admin.js');
    
    mix.version(['./fonts', './images', 'css/app.css', 'js/app.js']);
});
