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
mix.styles([
    'resources/assets/plugins/animate/animate.css',
    'resources/assets/plugins/fontawesome-free/css/all.min.css',
    'resources/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css',
    'resources/assets/plugins/pace/pace.min.css',
    'resources/assets/plugins/toast/toastr.min.css',
    'resources/assets/plugins/sweetAlert/bootstrap-4.min.css',
    'resources/assets/plugins/select2/css/select2.min.css',
    'resources/assets/plugins/select2/css/select2-bootstrap.min.css',
    'resources/assets/dist/css/adminlte.min.css',
],'public/css/plantilla.css');

mix.scripts([
    'resources/assets/plugins/jquery/jquery.min.js',
    'resources/assets/plugins/bootstrap/js/bootstrap.bundle.min.js',
    'resources/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
    'resources/assets/plugins/pace/pace.min.js',
    'resources/assets/plugins/toast/toastr.min.js',
    'resources/assets/plugins/sweetAlert/sweetalert2.all.min.js',
    'resources/assets/plugins/select2/js/select2.full.min.js',
    'resources/assets/dist/js/adminlte.js',
    'resources/assets/dist/js/demo.js',
],'public/js/plantilla.js')
    .js('resources/js/app.js','public/js/app.js');
mix.styles([
    'resources/assets/login/css/bootstrap.css',
    'resources/assets/login/css/waves.css',
    'resources/assets/login/css/animate.css',
    'resources/assets/login/css/materialize.css',
    'resources/assets/login/css/style.css',
],'public/login/login.css');
mix.scripts([
    'resources/assets/login/js/jquery.min.js',
    'resources/assets/login/js/bootstrap.js',
    'resources/assets/login/js/waves.js',
    'resources/assets/login/js/jquery.validate.js',
    'resources/assets/login/js/admin.js',
    'resources/assets/login/js/sign-in.js',
],'public/login/login.js');
mix.js([
    'resources/js/app-login.js',
    'resources/js/login.js',
],'public/login/app-login.js');
