const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .postCss('resources/css/app.css', 'public/css')
    .postCss('resources/css/site.css', 'public/css')
    .copyDirectory('resources/img', 'public/img')
    .sourceMaps(false, 'source-map')
