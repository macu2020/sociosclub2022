window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');

    //------> JQuery validation
    	var macuri = require('jquery-validation');
  
    //------> SwiAlert2
     	window.selct = require('select2/dist/js/select2.full.min');

    //------> Select2
      window.Swal = require('sweetalert2');

  	
  	//------>Alertify
     	window.alertify = require('alertifyjs/build/alertify.min.js');

    //------> OVERLAY  	
 		window.overlay = require('gasparesganga-jquery-loading-overlay');


   //---> camara   
  // var instascan = require('@mathewparet/instascan'); 
   //var Instascan = require('instascan');
  /* const instascan = require('instascan/src/camera.js');
  const instascan3 = require('instascan/src/zxing.js');
  const instascan2 = require('instascan/src/scanner.js'); 
  */

 	//-->Highcharts
    	window.Highcharts = require('highcharts/highcharts.js');
    	require('highcharts/highcharts-3d.js')(Highcharts);  
    	require('highcharts/modules/exporting')(Highcharts);  
    	require('highcharts/themes/dark-unica.js')(Highcharts);  

 

  //-->DAtatablejs
   		window.JSZip = require("jszip");
  		var pdfMake = require('pdfmake/build/pdfmake.js');
  		var pdfFonts = require('pdfmake/build/vfs_fonts.js');
  		pdfMake.vfs = pdfFonts.pdfMake.vfs; 

  		require( 'datatables.net-bs4' );
  		require( 'datatables.net-buttons-bs4' );
  		require( 'datatables.net-buttons/js/buttons.html5.js' );
  		require( 'datatables.net-responsive-bs4' ); 
  		require( 'datatables.net-buttons/js/buttons.print.js' )();

  		require( 'datatables-buttons-excel-styles/js/buttons.html5.styles.templates.min.js' )(); 
 		

} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
