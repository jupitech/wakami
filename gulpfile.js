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

elixir(function(mix) {
    mix.sass('app.scss');

    var npmDir ='node_modules/',
    	jsDir = 'resources/assets/js';

    mix.copy(npmDir + 'vue/dist/vue.min.js',jsDir);
    mix.copy(npmDir + 'vue-resource/dist/vue-resource.min.js',jsDir);
    mix.copy(npmDir + 'angular/angular.min.js',jsDir);
    mix.copy(npmDir + 'angular-route/angular-route.min.js',jsDir);
    mix.copy(npmDir + 'angular-cookies/angular-cookies.min.js',jsDir);
    mix.copy(npmDir + 'angular-animate/angular-animate.min.js',jsDir);
    mix.copy(npmDir + 'angular-touch/angular-touch.min.js',jsDir);
    mix.scripts([
    	'vue.min.js',
    	'vue-resource.min.js',
    	'angular.min.js',
    	'angular-route.min.js',
        'angular-cookies.min.js',
        'angular-animate.min.js',
        'angular-touch.min.js'
    ], 'public/js/vendor.js');	
});
