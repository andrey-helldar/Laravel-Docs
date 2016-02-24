var elixir = require('laravel-elixir');

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
    mix
            .sass([
                'styles.scss'
            ], 'public/css/ui.css')
            .scripts([
                '../../../node_modules/jquery/dist/jquery.min.js',
                '../../../node_modules/materialize-css/dist/js/materialize.min.js'
            ], 'public/js/lib.js')
            .scripts([
                'app.js'
            ], 'public/js/ui.js')
            .copy('resources/assets/images', 'public/images')
            .copy('node_modules/materialize-css/font/material-design-icons', 'public/build/font')
            .copy('node_modules/materialize-css/font/roboto', 'public/build/font')
            .version([
                'css/ui.css',
                'js/lib.js',
                'js/ui.js'
            ]);
});
