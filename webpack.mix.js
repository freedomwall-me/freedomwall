const mix = require("laravel-mix")

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

// jquery and js-cookie
mix.js("resources/js/app.js", "public/js")
    .copy("node_modules/jquery/dist/jquery.min.js", "public/js")
    .copy("node_modules/js-cookie/dist/js.cookie.min.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .postCss("resources/css/app.css", "public/css")
    // enable source maps only when not in production
    .sourceMaps(!mix.inProduction(), "source-map")
