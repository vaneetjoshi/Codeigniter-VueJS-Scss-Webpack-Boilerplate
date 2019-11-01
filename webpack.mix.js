let mix = require('laravel-mix');

// setting the public directory to public (this is where the mix-manifest.json gets created)
mix.setPublicPath('assets/')
    // transpiling, babelling, minifying and creating the public/js/main.js out of our assets
    // .sass('resources/sass/main.scss', 'public/css')
    // .sass('resources/sass/admin/admin.scss', 'public/css/admin')

/* For VueJS Scripts */
const scriptsFolder = 'VueJs/js/';
const fs = require('fs');

fs.readdirSync(scriptsFolder).forEach(file => {
    mix.js(scriptsFolder + file, 'assets/js/' + file);
})
/* VueJS Scripts End */

/* For SASS Scripts */
const SCSSFolder = 'SCSS/';

fs.readdirSync(SCSSFolder).forEach(file => {
    mix.sass(SCSSFolder + file, 'assets/css/' );
})
/* SASS Scripts End */

// aliases so instead of e.g. '../../components/test' we can import files like '@/components/test'
mix.webpackConfig({
    resolve: {
        alias: {
            "@": path.resolve(
                __dirname,
                "VueJS/js"
            ),
            "@sass": path.resolve(
                __dirname,
                "SCSS"
            ),
        }
    }
});

mix.version()
