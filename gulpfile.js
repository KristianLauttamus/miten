var elixir = require('laravel-elixir');

// Vueify
//var vueify = require('laravel-elixir-browserify').init("vueify");

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

elixir(function(mix) {
    mix.sass('app.scss');

    mix.browserSync({proxy: 'miten.dev'});

    // Vueify
    //mix.vueify('addGuide.js', {insertGlobals: true, transform: "vueify", output: "public/js"});
});