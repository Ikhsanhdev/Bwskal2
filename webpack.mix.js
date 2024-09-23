const path = require('path');
const mix = require('laravel-mix');

mix.alias({
    '@': path.resolve(__dirname, 'resources/js'),
});

//  Register as external
mix.webpackConfig({
    externals: {
        "jquery": "jQuery"
    },
});

mix.disableSuccessNotifications();

mix.browserSync({
    proxy: 'pinandu-bws.test',
    open: false,
    port: 15200,
    //  Gunakan seperti ini
    // files: [
    //     'resources/views/**/!(modal-)*.php',
    //     `public/**/*.(js|css)`
    // ],
    //  Atau
    ignore: [
        `resources/views/**/modal-*.php`,
        `app/Http/Controllers/**/*.php`,
    ],
});

//  Nested postcss
mix.options({
    postCss: [
        require('tailwindcss/nesting'),
    ],
    processCssUrls: false,
})

//  APP
mix.js('resources/js/admin/app.js', 'public/assets/js/app.js')
    .sass('resources/css/admin/app.scss', 'public/assets/css/app.css')
    .sass('resources/css/admin/print.scss', 'public/assets/css/print.css')
    .options({
        terser: {
            extractComments: false,
        },
        cssNano: {
            minifyFontValues: {
                removeWeight: false,
            },
        },
    })
    .vue({ version: 2 })
    .version()

//  WEB
mix.js('resources/js/web/index.js', 'public/assets/js/web.js')
    .sass("resources/css/web/index.scss", "public/assets/css/web.css")
    .options({
        terser: {
            extractComments: false,
        },
        cssNano: {
            minifyFontValues: {
                removeWeight: false,
            },
        },
    })
    .vue({ version: 2 })
    .version()
