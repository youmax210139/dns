const mix = require('laravel-mix')
const path = require('path')

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

mix.autoload({
  jquery: ['$', 'window.jQuery', 'jQuery'],
  'popper.js/dist/umd/popper.js': ['Popper']
})
  .js('resources/js/app.js', 'public/js')
  .copy('resources/js/now-ui-dashboard.min.js', 'public/js')
  .sass('resources/scss/vendor.scss', 'public/css/vendor.css')
  .sass('resources/scss/app.scss', 'public/css/app.css')
  .options({
    processCssUrls: false
  })
  .webpackConfig({
    output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
    resolve: {
      alias: {
        vue$: 'vue/dist/vue.runtime.esm.js',
        '@': path.resolve('resources/js'),
      },
    },
  })
  .version()
  .sourceMaps()
