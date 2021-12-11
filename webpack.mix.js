const mix = require('laravel-mix');



 
 
mix.js('resources/js/app.js', 'public/js')
	.js('resources/js/jslogin.js', 'public/js')	
    .js('resources/js/jsrecatpcha.js', 'public/js') 	
    .js('resources/js/jshome.js', 'public/js') 	
    .sass('resources/sass/app.scss', 'public/css')
    //.postCss('resources/css/cssbackend.css', 'public/css') 
    .postCss('resources/css/csslogin.css', 'public/css')
    .postCss('resources/css/csshome.css', 'public/css')
    .setResourceRoot('../')    
    .sourceMaps()
	 
  /*.webpackConfig({
  resolve: {
      fallback: {
       	 "path": false ,
         "fs": false,
          "crypto": false,
       }
   }
})  */