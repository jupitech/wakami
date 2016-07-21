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

    mix.copy(npmDir + 'angular/angular.min.js',jsDir);
    mix.copy(npmDir + 'angular-route/angular-route.min.js',jsDir);
    mix.copy(npmDir + 'angular-cookies/angular-cookies.min.js',jsDir);
    mix.copy(npmDir + 'angular-animate/angular-animate.min.js',jsDir);
    mix.copy(npmDir + 'angular-resource/angular-resource.min.js',jsDir);
    mix.copy(npmDir + 'angular-sanitize/angular-sanitize.min.js',jsDir);
    mix.copy(npmDir + 'ui-select/dist/select.min.js',jsDir);
    mix.copy(npmDir + 'angular-ui-bootstrap/dist/ui-bootstrap.js',jsDir);
    mix.scripts([
    	'angular.min.js',
    	'angular-route.min.js',
        'angular-cookies.min.js',
        'angular-animate.min.js',
        'angular-resource.min.js',
        'angular-sanitize.min.js',
        'select.min.js',
        'ui-bootstrap.js'
    ], 'public/js/vendor.js');	
});
