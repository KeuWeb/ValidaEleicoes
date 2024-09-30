const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.styles([
    'resources/css/global.css',
    'node_modules/bootstrap/dist/css/bootstrap.css',
    'node_modules/bootstrap-icons/font/bootstrap-icons.css',
    'node_modules/select2-bootstrap-5-theme/dist/select2.min.css',
    'node_modules/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css',
    'node_modules/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.rtl.min.css',
    'resources/css/popup.manager.css'
    ],'public/inc/file/css/global.css')
    
    .js([
        'resources/js/global.js',
        'resources/js/jquery-ui.js',
        'resources/js/jquery.form.min.js',
        'resources/js/mask.js',
        'resources/js/validate.js',
        'resources/js/function.js',
        'resources/js/popup.manager.js',
        'resources/js/cep.js'
    ],'public/inc/file/js/global.js')

    .js([
        'resources/adm/js/login.js',
        'resources/adm/js/type.js',
        'resources/adm/js/form.js',
        'resources/adm/js/rule.js',
        'resources/adm/js/communication.js',
        'resources/adm/js/mailing.js',
        'resources/adm/js/election.js',
        'resources/adm/js/user.js',
        'resources/adm/js/category.js',
        'resources/adm/js/company.js',
        'resources/adm/js/location.js',
        'resources/adm/js/uploads.js'
    ],'public/inc/file/js/adm.js')
    
    .copy([
        'node_modules/bootstrap-icons/font/fonts/bootstrap-icons.woff'
    ],'public/inc/file/css/fonts/bootstrap-icons.woff')

    .copy([
        'node_modules/bootstrap-icons/font/fonts/bootstrap-icons.woff2'
    ],'public/inc/file/css/fonts/bootstrap-icons.woff2')

    .copy([
        'node_modules/bootstrap/dist/js/bootstrap.js'
    ],'public/inc/file/js/bootstrap.js')

    .copy([
        'node_modules/jquery-mask-plugin/dist/jquery.mask.js'
    ],'public/inc/file/js/jquery.mask.js');
