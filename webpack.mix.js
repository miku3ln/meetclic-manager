const mix = require('laravel-mix');


//run mix data command
// npm install for user laravel-mix
// npm run production js use input output
const folder = {
    src: "resources/templates/backend/minton/", // source files
    dist: "public/", // build files
    dist_assets: "public/assets/", //build assets files
    dist_libs: "public/libs/", //build assets libs without templates
    srcInputFrontend: "resources/templates/frontend/furniture-ecommerce-bootstrap4", // source files
    srcOutputFrontend: "public/frontend", // source files

};
//mix.js('resources/js/manager/frontend/plugins.js', 'public/js/compiled/plugins/plugin-zebra.js');
//mix.js("resources/js/template/AppVarkale.js", 'public/js/compiled/AppInit/AppVarkale.js');


mix.js('public/js/mixImport/AppManagerImport.js', 'public/js/mixImport/AppManagerImportBundle.js')
    .vue() // Si estás usando Vue 2, asegúrate de tener laravel-mix en una versión compatible con Vue 2.
    .version();
