let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');

require('laravel-mix-purgecss');

mix.setPublicPath('public');

mix
    .autoload({
      jquery: ['$', 'window.jQuery']
    })
    .webpackConfig({
      externals: {
        "jquery": "jQuery"
      }
    });

mix
    .copyDirectory('resources/fonts', 'public/fonts')
    .copyDirectory('resources/images', 'public/images');

mix
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
      processCssUrls: false,
      postCss: [tailwindcss('./tailwind.config.js')]
    })
    .purgeCss();

mix.browserSync({
  proxy: 'sage.test',
  files: [
    "public/**/*",
    "app/**/*.php",
    "resources/**/*.php",
  ]
});

if (mix.inProduction()) {
  mix.version();
}
else {
  mix.sourceMaps();
}
