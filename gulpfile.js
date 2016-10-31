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
    mix.copy(npmDir + 'angular-ui-bootstrap/dist/ui-bootstrap.js',jsDir);
    mix.copy(npmDir + 'moment/moment.js',jsDir);
    mix.copy(npmDir + 'moment-timezone/moment-timezone.js',jsDir);
    mix.copy(npmDir + 'angular-moment/angular-moment.min.js',jsDir);
    mix.copy(npmDir + 'nya-bootstrap-select/dist/js/nya-bs-select.min.js',jsDir);
    mix.copy(npmDir + 'angular-lazy-img/release/angular-lazy-img.js',jsDir);
    mix.copy(npmDir + 'angular-filter/dist/angular-filter.min.js',jsDir);
    mix.copy(npmDir + 'highcharts-ng/dist/highcharts-ng.min.js',jsDir);
    mix.scripts([
    	'angular.min.js',
    	'angular-route.min.js',
        'angular-cookies.min.js',
        'angular-animate.min.js',
        'angular-resource.min.js',
        'angular-sanitize.min.js',
        'ui-bootstrap.js',
        'moment.js',
        'moment-timezone.js',
        'angular-moment.min.js',
        'nya-bs-select.min.js',
        'angular-lazy-img.js',
        'angular-filter.min.js',
        'highcharts-ng.min.js',
    ], 'public/js/vendor.js');	
});
