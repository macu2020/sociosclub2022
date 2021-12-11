

var macuriwebmac = function() {
  var body = $('body'),
        getId = null,                       //-------> variable vacia
        isMobile = !1,                      //-------> variable false
        urlPathname = window.location.pathname,//---> ruta y el nombre de archivo de la página actual
       // domainurl = window.location.hostname,//--->tambien (host) ruta del dominio
        domainurl = 'http://localhost/sociosclub2021/public'; 
   Toptitop = function() { 
      if ( (/windows phone/i.test(navigator.userAgent)) ||(/android/i.test(navigator.userAgent)) || 
                    (/iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream)      ) {
                isMobile = !0;  //---->se convierte en true
             };
              fn.documentAjax();
              fn.documentOnload();
              fn.documentReady();
              fn.showsocios()
          },
          fn = { 
                documentAjax: function()   {
                    $(document).ajaxStop(function() { 
                        //fn.login();
                     }); 
                },
                documentOnload:function()  { 
                    $(window).on('load', function() {
                     });  
                 },
                documentReady: function()  {
                  fn.headerHome()
                  fn.otros()
                  fn.homeUserTabla()
                  fn.imgprevia()
                  fn.tooglelogin()
                  fn.validaAddUser()
                  fn.validaEditUser()
                  fn.homeSocioTabla()
                  fn.changeSocio()
                  fn.modalefecto()
                  fn.validAddinvit()
                  fn.validEditinvit()
                  fn.homeInvitaTabla()
                  fn.validaAddSoc()
                  fn.validaEditSoc()
                  fn.graficosbackend()
                  fn.tablereportsoci()
                  fn.tablereportinvi()
                  fn.fechaHoraActual()
                  //fn.showBuscSocio()
                  fn.modalingrsSoci()
                  fn.modalingrsInvi()
                  fn.codigoqr() 
                 },
                headerHome: function() {//------> Header Home  (nav)
                    const hamburger = document.querySelector('.header-content .hamburger');
                    const mobile_menu = document.querySelector('.header-content .nav-list ul');
                    const header = document.querySelector('.header-content');
                    const headerin = document.querySelector('.stikyheder');
                      //-----> Icon amburguesa
                    if (hamburger) {
                      hamburger.addEventListener('click', () => {
                      hamburger.classList.toggle('active');
                      mobile_menu.classList.toggle('active');
                                              
                      
                     });

                    document.addEventListener('scroll',() => {
                        var scroll_position = window.scrollY;

                         if (scroll_position > 50) {        
                          headerin.style.display = 'none';
                        }else{headerin.style.display = 'block'; } 
                        
                        if (scroll_position > 250) {  
                          header.style.background = 'linear-gradient(180deg, rgba(2,0,36,1) 0%, rgba(37,150,190,1) 56%, rgba(0,212,255,1) 100%)';                  
                        }else if (scroll_position < 250 && $(window).width() > 1024 ) {
                          header.style.background = '#FBE6C2';                  
                        } 
                    });

                    if ($(window).width() < 1024)           { 

                      header.style.background = 'linear-gradient(180deg, rgba(2,0,36,1) 0%, rgba(37,150,190,1) 56%, rgba(0,212,255,1) 100%)';                  
                    }

                    } 
                    $(".anclinicila").click(function(event) { 
                      hamburger.classList.toggle('active');
                      mobile_menu.classList.toggle('active');
                    });
                    //-----> HEADER MOVIL
                    $('.header-content .nav-list ul li').click(function() {
                      $(this).addClass('selected');
                      $(this).siblings().removeClass('selected');
                      });
                      $('.sub-menu_nav ol').hide();
                      $(".sub-menu_nav .afirst").click(function (e) {
                        e.preventDefault()
                        $(this).parent(".sub-menu_nav").children("ol").slideToggle("100");
                    });
                },
                otros: function()      {//------> Valida-Alert-Otros
                  
                  //-----> SELECT 2 CONFIG    
                  $('.select-soci').select2({
                        language: {
                            noResults: function() {
                              return "No hay resultado";        
                            },
                            searching: function() {
                              return "Buscando..";
                            }
                        }
                  });

                  //-----> ALERTIFY CONFIG
                  if ($(".alert").length > 0)  { 
                      alertify.alert()
                        .setting({
                        'title':'Se ha producido un error : ',
                        'label':'ok',
                        'message': $('.alert').html() ,
                        'onok': function(){ alertify.error('😔 Vuelva a intentar !!!');}
                      }).show();
                  }
                  if ($(".suceess").length > 0){ 
                        alertify.alert()
                        .setting({
                          'title':$('.titlesuceess').html(),
                          'label':'ok',
                          'message': $('.suceess').html() ,
                          'onok': function(){ alertify.success($('#subitisucess').html());}
                        }).show();
                  } 

                  //-----> TOOLTIP CONFIG   
                  $('[data-toggle="tooltip"]').tooltip() 

                  
                  //-----> JQUERY VALIDATION 
                    jQuery.validator.addMethod("noSpace", function(value, element) {
                      
                      return value == "" || value.trim().length != 0;
                    }, "No dejar espacios vacios");
                    jQuery.validator.addMethod("lettersonly", function(value, element) {
                       
                        return this.optional(element) || /^[a-zA-Z ]+$/i.test(value);
                    }, "Solo permite letras"); 
                    function validar(value){ //---> metodo para valida DNI
                      var ex_regular_dni; 
                      ex_regular_dni = /^\d{8}(?:[-\s]\d{4})?$/;
                      if(ex_regular_dni.test (value) == true){
                            return true;
                      }else{
                          return false;
                       }
                    }
                    $.validator.addMethod('dnivalida', function(value,element){

                        return this.optional(element) || validar(value);
                    }, "Dni invalido");

                  //-----> PRE - VALIDACIONES
                    $("#celu").bind('keypress', function(event)      { 
                      var regex = new RegExp("^[0-9]+$");
                      var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                      if (!regex.test(key)) {
                        event.preventDefault();
                        return false;
                      }
                      if (event.which < 48 || event.which > 57 || this.value.length === 12) {
                        return false;
                      }
                    });
                    $("#email").bind('keypress', function(event)     { 
                      if (  this.value.length === 35) {
                          return false;
                      }
                    });
                    $("#first_name").bind('keypress', function(event){ 
                      var regex = new RegExp("^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ ]+$");
                      var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                      if (!regex.test(key)) { event.preventDefault();
                            return false;
                      }
                      if (  this.value.length === 25) {
                            return false;
                      }
                    });
                    $("#last_name").bind('keypress',function(event)  { 
                      var regex = new RegExp("^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ ]+$");
                      var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                      if (!regex.test(key)) {
                        event.preventDefault();
                        return false;
                      }
                      if (  this.value.length === 25) {
                            return false;
                      }
                    });
                    $("#password").bind('keypress', function(event)  { 
                      if (  this.value.length === 10) { return false;
                      }
                    });
                    $("#conf_pass").bind('keypress', function(event) { 
                      if (  this.value.length === 10) {
                          return false;
                      }
                    }); 
                    $("#clave_socio").bind('keypress',function(event){ 
                     if (  this.value.length === 7) {
                          return false;
                        }
                    });
                    $("#placa_socio").bind('keypress',function(event){ 
                     if (  this.value.length === 7) {
                          return false;
                        }
                    }); 
                    $("#clavetit").bind('keypress',function(event)   { 
                      if (  this.value.length === 7) {
                          return false;
                        }
                    });
                    $("#dni").bind('keypress', function(event)       { 
                      var regex = new RegExp("^[0-9]+$");
                      var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                      if (!regex.test(key)) {
                        event.preventDefault();
                        return false;
                      }
                       if (event.which < 48 || event.which > 57 || this.value.length === 8) {
                        return false;
                       }
                    });        
                },
                showsocios:function(){  //------> Mostrar socio Home
                  $('#form-showsocios').validate({ 
                    ignore:'.ignore',
                    errorClass:'invalid',
                    validClass:'success',
                    rules:{
                      clave_socio:{
                          required:true,
                          minlength:2,
                          maxlength:7,
                          noSpace: true    
                         },
                    },
                    messages: {
                        clave_socio: {
                            required:"Ingrese clave de socio",
                            minlength:"minimo 2 carateres ",
                            maxlength:"maximo 7 carateres ",
                         },
                    },
                    errorPlacement:function(error,element){

                       error.insertAfter(element);
                    },
                    submitHandler:function(form){
                      //animacion 
                      /*$.LoadingOverlay("show");
                       form.submit();*/
                      let _token = $('input[name="_token"]').val()
                      let clave = $("#clave_socio").val() ;
                      let carga = $(".img_banner");
                      let carga2 = $(".img_banner2");

                      $.ajax({
                        url: form.action,
                        type: form.method,
                        dataType: 'json',
                        data: {clave:clave,_token:_token},

                         beforeSend: function(objeto){
                           carga.addClass('loading')
                           carga2.addClass('loading')
                           $(".titu").css({
                             opacity: '0' 
                           });
                            },
                         })
                      .done(function(data) {             
                        carga.removeClass("loading");
                        carga2.removeClass("loading");
                        let datamacuri=data.datacla

                         console.log(datamacuri)
                        let datatitular = '';
                        let datafamilia = '';
                        for(var i=0; i< datamacuri.length; ++i){
                          if (datamacuri[i].tipo === 'Titular' || datamacuri[i].tipo === 'Conyuge') { 
                            if (datamacuri[i].avatar === null) {
                              var photo =`${domainurl}/img/iconos/user-avatar.png`;
                            }else{
                              var  photo =`${domainurl}/uploads_socios/soc_${datamacuri[i].idsoc}/av_`+datamacuri[i].avatar;
                            } 
                            if (datamacuri[i].placa !== null) {
                              $("#placa_socio").val(datamacuri[i].placa)
                            }
                            datatitular +=`
                            <div class="titu d-flex flex-column justify-content-center align-items-center   ">
                               <p>${datamacuri[i].tipo}</p>
                              <img src="${photo}" alt="" width="90" height="90" id="img-updat-${datamacuri[i].idsoc}" class="img-soci-dash rounded ${(datamacuri[i].estadosoc == "0" ? "disabled" : "enabled")}">
                              <p class="pt-2 psubnombre"  >${datamacuri[i].name} ${datamacuri[i].lastname}</p>
                              <div class="maines">
                                <label class="switch">
                                <input ${(datamacuri[i].estadosoc == "0" ? "" : "checked")}  class="checksoc"  type="checkbox" value="${datamacuri[i].idsoc}" />
                                <span class="slider round icon"></span>
                                 </label>
                              </div>
                            </div>`;
                          } 

                          if (datamacuri[i].tipo === 'Familiar' ) {
                              if (datamacuri[i].avatar === null) {
                                var photo =`${domainurl}/img/iconos/user-avatar.png`;
                              }else{
                                var  photo =`${domainurl}/uploads_socios/soc_${datamacuri[i].idsoc}/av_`+datamacuri[i].avatar;
                              } 
                              datafamilia +=`
                              <div class="titu d-flex flex-column justify-content-center align-items-center  ">
                                <p>${datamacuri[i].tipo}</p>
                                 <img src="${photo}" alt="" width="90" height="90" id="img-updat-${datamacuri[i].idsoc}" class="img-soci-dash rounded ${(datamacuri[i].estadosoc == "0" ? "disabled" : "enabled")}">
                                <p class="pt-2 psubnombre">${datamacuri[i].name} ${datamacuri[i].lastname}</p>

                                <div class="maines">
                                  <label class="switch">
                                <input ${(datamacuri[i].estadosoc == "0" ? "" : "checked")} class="checksoc"  type="checkbox" value="${datamacuri[i].idsoc}" />
                                  <span class="slider round icon"></span>
                                   </label>
                                </div>
                              </div>`;
                          }       
                        }

                        carga.html(datatitular)
                        carga2.html(datafamilia)

                        if (data.datacla == "") {
                          carga.html('<div> <h2> Socio no encontrado !!!</h2></div>')
                          carga2.html('<div> <h2> Socio no encontrado !!!</h2></div>')
                        }
                        // console.log("success");
                      })
                      .fail(function() {
                        console.log("error");
                      })
                      .always(function() {

                        $( '.checksoc' ).on( 'click', function() {
                          if( $(this).is(':checked') ){
                            $(this).prop('disabled', true);
                              let valorid=$(this).val()
                              $("#img-updat-"+valorid).removeClass('disabled')
                              $("#img-updat-"+valorid).addClass('enabled')
                               $.ajax({
                                url: domainurl+'/asist-soc',
                                type: 'GET',
                                dataType: 'json',
                                data: {clave:$(this).val(),_token:_token},
                              })
                              .done(function(data) {
                                console.log(data)
                                console.log("success");
                              })
                              .fail(function() {
                                console.log("error");
                              })
                              .always(function() {
                                console.log("complete");
                              });
                              //alert("El checkbox con valor " + $(this).val() + " ha sido seleccionado");
                          } /*else {
                                // Hacer algo si el checkbox ha sido deseleccionado
                                let valorid=$(this).val()
                                $("#img-updat-"+valorid).removeClass('enabled')
                                $("#img-updat-"+valorid).addClass('disabled')
                                $.ajax({
                                  url: domainurl+'/asistnull-soc',
                                  type: 'GET',
                                  dataType: 'json',
                                  data: {clave:$(this).val(),_token:_token},
                                })
                                .done(function(data) {
                                  console.log(data)
                                  console.log("success");
                                })
                                .fail(function() {
                                  console.log("error");
                                })
                          }*/
                        });
                          //console.log("complete");
                      });
                    },
                  });
                },
                showBuscSocio:function(){//------> Buscar socio Home
                  $('#form-busca-socios').validate({ 
                    ignore:'.ignore',
                    errorClass:'invalid',
                    validClass:'success',
                    rules:{
                      clave_socio:{
                          required:true,
                          minlength:2,
                          maxlength:7,
                          noSpace: true    
                         },
                    },
                    messages: {
                        clave_socio: {
                            required:"Ingrese clave de socio",
                            minlength:"minimo 2 carateres ",
                            maxlength:"maximo 7 carateres ",
                         },
                    },
                    errorPlacement:function(error,element){

                       error.insertAfter(element);
                    },
                    submitHandler:function(form){
                      //animacion 
                      /*$.LoadingOverlay("show");
                       form.submit();*/
                      let _token = $('input[name="_token"]').val()
                      let clave = $("#clave_socio_busca").val() ;
                      let carga = $(".img_banner");
                      let carga2 = $(".img_banner2");

                      $.ajax({
                        url: form.action,
                        type: form.method,
                        dataType: 'json',
                        data: {clave:clave,_token:_token},

                         beforeSend: function(objeto){
                           carga.addClass('loading')
                           carga2.addClass('loading')
                           $(".titu").css({
                             opacity: '0' 
                           });
                            },
                         })
                      .done(function(data) {             
                        carga.removeClass("loading");
                        carga2.removeClass("loading");

                        let datamacuri=data.datacla
                         console.log(datamacuri)
                        let datatitular = '';
                        let datafamilia = '';
                        for(var i=0; i< datamacuri.length; ++i){  
                          if (datamacuri[i].tipo === 'Titular' || datamacuri[i].tipo === 'Conyuge') { 
                            if (datamacuri[i].avatar === null) {
                              var photo =`${domainurl}/img/iconos/user-avatar.png`;
                            }else{
                              var  photo =`${domainurl}/uploads_socios/soc_${datamacuri[i].idsoc}/av_`+datamacuri[i].avatar;
                            } 
                            datatitular +=`
                            <div class="titu d-flex flex-column justify-content-center align-items-center p-3">
                               <p>${datamacuri[i].tipo}</p>
                              <img src="${photo}" alt="" width="90" height="90" id="img-updat-${datamacuri[i].idsoc}" class="img-soci-dash rounded ${(datamacuri[i].estadosoc == "0" ? "disabled" : "enabled")}">
                              <p class="pt-2"  >${datamacuri[i].name} ${datamacuri[i].lastname}</p>
                              <div class="maines">
                                <label class="switch">
                                <input ${(datamacuri[i].estadosoc == "0" ? "" : "checked")}  class="checksoc"  type="checkbox" value="${datamacuri[i].idsoc}" />
                                <span class="slider round icon"></span>
                                 </label>
                              </div>
                            </div>`;
                          } 

                          if (datamacuri[i].tipo === 'Familiar' ) {
                              if (datamacuri[i].avatar === null) {
                                var photo =`${domainurl}/img/iconos/user-avatar.png`;
                              }else{
                                var  photo =`${domainurl}/uploads_socios/soc_/av_`+datamacuri[i].avatar;
                              } 
                              datafamilia +=`
                              <div class="titu d-flex flex-column justify-content-center align-items-center p-3">
                                <p>${datamacuri[i].tipo}</p>
                                 <img src="${photo}" alt="" width="90" height="90" id="img-updat-${datamacuri[i].idsoc}" class="img-soci-dash rounded ${(datamacuri[i].estadosoc == "0" ? "disabled" : "enabled")}">
                                <p class="pt-2">${datamacuri[i].name} ${datamacuri[i].lastname}</p>

                                <div class="maines">
                                  <label class="switch">
                                <input ${(datamacuri[i].estadosoc == "0" ? "" : "checked")} class="checksoc"  type="checkbox" value="${datamacuri[i].idsoc}" />
                                  <span class="slider round icon"></span>
                                   </label>
                                </div>
                              </div>`;
                          }       
                        }

                        carga.html(datatitular)
                        carga2.html(datafamilia)

                        if (data.datacla == "") {
                          carga.html('<div> <h2> El Socio no ingreso !!!</h2></div>')
                          carga2.html('<div> <h2>El Socio no ingreso !!!</h2></div>')
                        }
                         console.log("success");
                      })
                      .fail(function() {
                        console.log("error");
                      })
                      .always(function() {

                        $( '.checksoc' ).on( 'click', function() {
                          if( $(this).is(':checked') ){
                              let valorid=$(this).val()
                              $("#img-updat-"+valorid).removeClass('disabled')
                              $("#img-updat-"+valorid).addClass('enabled')
                               $.ajax({
                                url: domainurl+'/asist-soc',
                                type: 'GET',
                                dataType: 'json',
                                data: {clave:$(this).val(),_token:_token},
                              })
                              .done(function(data) {
                                console.log(data)
                                console.log("success");
                              })
                              .fail(function() {
                                console.log("error");
                              })
                              .always(function() {
                                console.log("complete");
                              });
                              //alert("El checkbox con valor " + $(this).val() + " ha sido seleccionado");
                          } else {
                                // Hacer algo si el checkbox ha sido deseleccionado
                                let valorid=$(this).val()
                                $("#img-updat-"+valorid).removeClass('enabled')
                                $("#img-updat-"+valorid).addClass('disabled')
                                $.ajax({
                                  url: domainurl+'/asistnull-soc',
                                  type: 'GET',
                                  dataType: 'json',
                                  data: {clave:$(this).val(),_token:_token},
                                })
                                .done(function(data) {
                                  console.log(data)
                                  console.log("success");
                                })
                                .fail(function() {
                                  console.log("error");
                                })
                          }
                        });
                          //console.log("complete");
                      });
                    },
                  });
                },
                homeUserTabla:function(){//-----> User Tabla Home   
                  $("#tbl_users").DataTable( {
                    language: {
                              "lengthMenu": "Mostrar _MENU_ registros",
                              "zeroRecords": "No se encontraron resultados",
                              "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                              "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                              "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                              "sSearch": "Buscar:",
                              "oPaginate": {
                                  "sFirst": "Primero",
                                  "sLast":"Último",
                                  "sNext":"Siguiente",
                                  "sPrevious": "Anterior"
                           },
                         "sProcessing":"Procesando...",
                              },                           
                    responsive: true,           
                    dom: 'Bfrtilp',
                    buttons:[    
                        {
                           extend: 'pdfHtml5',
                           text: '<img src='+domainurl+'/img/iconos/iconpdf.png width="100%" class="img-fluid">  ',
                           titleAttr: 'Exportar a PDF' ,
                           messageTop: 'Registro de Usuario',
                                title:'Tabla de Usuarios',
                           className: 'btn btn-danger' ,
                           exportOptions: {
                                columns: [0, 1, 3,4],
                                alignment: 'center',
                            },
                           excelStyles:{
                             template: 'blue_gray_medium'
                           },
                            customize:function(doc) {                          
                              doc.defaultStyle.alignment = 'center';                       
                                    doc.styles.title = {
                                        color: 'red',
                                        fontSize: '30',
                                        alignment: 'center'
                                    }
                                    doc.styles['td:nth-child(2)'] = { 
                                        width: '100px',
                                        'max-width': '100px'
                                    }
                                }
                        },
                        {
                            extend: 'print',
                            text: '<img src='+domainurl+'/img/iconos/iconimp.png width="100%" class="img-fluid">  ',
                            titleAttr: 'imprimir' ,
                            className: 'btn btn-secondary',
                            exportOptions: {
                                columns: [0, 1, 3,4],
                            },
                          },
                          {
                        extend:    'excelHtml5',
                        text:      '<img src='+domainurl+'/img/iconos/icoexcel.png width="100%" class="img-fluid">   ',
                        titleAttr: 'Exportar a Excel',
                        className: 'btn btn-success',
                        exportOptions: {
                                columns: [0, 1, 3,4]
                            },
                            excelStyles: [                      // Add an excelStyles definition
                              {                 
                                 template: "black_medium",   // Apply the "green_medium" template
                              },
                                  {
                                      cells: "sh",                                   
                                    style:{
                                      alignment: {
                                            vertical: "centerContinuous",
                                            horizontal: "centerContinuous",
                                            wrapText: true,
                                        },
                                      font:{
                                        b:true,
                                        color: "FFFFFF",

                                      },
                                      
                                      fill:{
                                        pattern:{
                                           style: "thick",
                                          bgColor:'fd0a43',
                                          color: "457B9D",    // Fill color 
                                        }
                                      }
                                    }
                                  },
                                  {
                                      cells: "A:",                                   
                                    style:{
                                      alignment: {
                                            vertical: "centerContinuous",
                                            horizontal: "centerContinuous",
                                            wrapText: true,
                                        }
                                    }
                                  }
                                ] 
                        }
                          ],                     
                  })
                  //---->eliminar
                  $('#tbl_users tbody').on( 'click', 'a[data-id="elicli"]', function () {
                  let ide=this.name, nom=$(this).attr('data-nom'); 
                  Swal.fire({
                    title: '¿Estas seguro de eliminar "'+nom +'" ?',
                    text: "No podrás revertir esto !!!",
                     showCancelButton: true,
                     confirmButtonText: 'Si, eliminar ',
                     backdrop: ` rgba(0, 0, 0, 0.7) `
                  }).then((result) => {
                      if (result.isConfirmed) {
                      let _token = $('input[name="_token"]').val()

                        $.ajax({
                          url: domainurl+'/user/'+ide+'/delete/',
                          type: 'GET',  
                          beforeSend: function() {
                                  $.LoadingOverlay("show");
                           },     
                        })
                        .done(function(data) {
                            $.LoadingOverlay("hide")
                          Swal.fire({
                           icon: 'success',
                             title: "Tu Usuario a sido eliminado.",
                             confirmButtonText: "Aceptar",
                             
                          })
                          .then(function(){
                               location.reload();      
                            });
                          console.log("success");
                        })
                        .fail(function() {
                            $.LoadingOverlay("hide")
                          Swal.fire({
                             icon: 'error',
                               title: "No se pudo eliminar el usuario.",
                               text: 'Intente de nuevo',
                               confirmButtonText: "Aceptar",
                            }).then(function(){
                               location.reload();      
                            });
                          console.log("error");
                        }) 
                       
                      }
                  })
                  });                          
                },
                homeSocioTabla:function(){//----> Socio Tabla Home  
                  $("#tbl_socio").DataTable( {
                    language: {
                              "lengthMenu": "Mostrar _MENU_ registros",
                              "zeroRecords": "No se encontraron resultados",
                              "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                              "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                              "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                              "sSearch": "Buscar:",
                              "oPaginate": {
                                  "sFirst": "Primero",
                                  "sLast":"Último",
                                  "sNext":"Siguiente",
                                  "sPrevious": "Anterior"
                           },
                         "sProcessing":"Procesando...",
                              },                           
                    responsive: true,           
                    dom: 'Bfrtilp',
                    buttons:[    
                        {
                           extend: 'pdfHtml5',
                           text: '<img src='+domainurl+'/img/iconos/iconpdf.png width="100%" class="img-fluid">  ',
                           titleAttr: 'Exportar a PDF' ,
                           messageTop: 'Registro de Socios',
                                title:'Tabla de Socios',
                           className: 'btn btn-danger' ,
                           exportOptions: {
                                columns: [0, 1, 3,4,5,6,7,8,9],
                                alignment: 'center',
                            },
                           excelStyles:{
                             template: 'blue_gray_medium'
                           },
                            customize:function(doc) {                          
                              doc.defaultStyle.alignment = 'center';                       
                                    doc.styles.title = {
                                        color: 'red',
                                        fontSize: '30',
                                        alignment: 'center'
                                    }
                                    doc.styles['td:nth-child(2)'] = { 
                                        width: '100px',
                                        'max-width': '100px'
                                    }
                                }
                        },
                        {
                            extend: 'print',
                            text: '<img src='+domainurl+'/img/iconos/iconimp.png width="100%" class="img-fluid">  ',
                            titleAttr: 'imprimir' ,
                            className: 'btn btn-secondary',
                            exportOptions: {
                                columns: [0, 1, 3,4,5,6,7,8,9],
                            },
                          },
                          {
                        extend:    'excelHtml5',
                        text:      '<img src='+domainurl+'/img/iconos/icoexcel.png width="100%" class="img-fluid">   ',
                        titleAttr: 'Exportar a Excel',
                        className: 'btn btn-success',
                        exportOptions: {
                                columns: [0, 1, 3,4,5,6,7,8,9],
                            },
                            excelStyles: [                      // Add an excelStyles definition
                              {                 
                                 template: "black_medium",   // Apply the "green_medium" template
                              },
                                  {
                                      cells: "sh",                                   
                                    style:{
                                      alignment: {
                                            vertical: "centerContinuous",
                                            horizontal: "centerContinuous",
                                            wrapText: true,
                                        },
                                      font:{
                                        b:true,
                                        color: "FFFFFF",

                                      },
                                      
                                      fill:{
                                        pattern:{
                                           style: "thick",
                                          bgColor:'fd0a43',
                                          color: "457B9D",    // Fill color 
                                        }
                                      }
                                    }
                                  },
                                  {
                                      cells: "A:",                                   
                                    style:{
                                      alignment: {
                                            vertical: "centerContinuous",
                                            horizontal: "centerContinuous",
                                            wrapText: true,
                                        }
                                    }
                                  }
                                ] 
                        }
                          ],                     
                  })
                  //---->eliminar
                  $('#tbl_socio tbody').on( 'click', 'a[data-id="elicli"]', function () {
                    let ide=this.name, nom=$(this).attr('data-nom'); 
                     Swal.fire({
                      title: '¿Estas seguro de eliminar "'+nom +'" ?',
                      text: "No podrás revertir esto !!!",
                       showCancelButton: true,
                       confirmButtonText: 'Si, eliminar ',
                       backdrop: ` rgba(0, 0, 0, 0.7)  `
                    }).then((result) => {
                        if (result.isConfirmed) {
                        let _token = $('input[name="_token"]').val()
                          $.ajax({
                            url: domainurl+'/socio/'+ide+'/delete/',
                            type: 'GET', 
                            beforeSend: function() {
                                  $.LoadingOverlay("show");
                           },     
                          })
                          .done(function(data) {
                            $.LoadingOverlay("hide")
                            console.log("success");
                            Swal.fire({
                             icon: 'success',
                               title: "Tu Socio a sido eliminado.",
                               confirmButtonText: "Aceptar",
                               
                            })
                            .then(function(){
                                       location.reload();      
                              });
                          })
                          .fail(function() {
                            $.LoadingOverlay("hide")
                            Swal.fire({
                             icon: 'error',
                               title: "No se pudo eliminar el socio.",
                               text: 'Intente de nuevo',
                               confirmButtonText: "Aceptar",
                            }).then(function(){
                               location.reload();      
                            });
                            console.log("error");
                          }) 
                         
                        }
                    })
                  });      
                  //---->Update socio QR
                  $('#tbl_socio tbody').on( 'click', 'a[data-id="upqr"]', function () {
                    let ide=this.name, nom=$(this).attr('data-nom'); 
                     Swal.fire({
                      title: '¿Generando Codigo QR para el socio "'+nom +'" ?',
                        showCancelButton: true,
                       confirmButtonText: 'Si, Generar ',
                       backdrop: ` rgba(0, 0, 0, 0.7)  `
                    }).then((result) => {
                        if (result.isConfirmed) {
                        let _token = $('input[name="_token"]').val()

                          $.ajax({
                            url: domainurl+'/socio/'+ide+'/updqr/',
                            type: 'GET', 
                            beforeSend: function() {
                                  $.LoadingOverlay("show");
                           },     
                          })
                          .done(function(data) {
                            $.LoadingOverlay("hide")
                             console.log("success");
                            Swal.fire({
                             icon: 'success',
                               title: "Se a generado un nuevo Qr para este socio.",
                               confirmButtonText: "Aceptar",
                            })
                          })
                          .fail(function() {
                            $.LoadingOverlay("hide")
                            Swal.fire({
                             icon: 'error',
                               title: "No se pudo crear el QR.",
                               text: 'Intente de nuevo',
                               confirmButtonText: "Aceptar",
                            }).then(function(){
                               location.reload();      
                            });
                            console.log("error");
                          }) 
                         
                         
                        }
                    })
                  });                    
                },
                tooglelogin:function(){   //----> Show password     
                  $(".toggle-password").click(function() {   
                  $(this).toggleClass("fa-eye fa-eye-slash");
                  let input = $($(this).attr("toggle"));
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                  });
                },
                imgprevia:function(){     //----> Imagen previa     
                  if ($("#customFile").length > 0){
                    let archivoInput = document.getElementById('customFile');
                    archivoInput.addEventListener('change',function(){
                      let archivoRuta = archivoInput.value;
                          let extPermitidas = /(.jpg|.jpeg|.png)$/i;
                          if(!extPermitidas.exec(archivoRuta)){
                          Swal.fire({icon: 'error',title:'Oops...',text: 'Esto no es una imagen!!!', })
                              $("#img-maci").attr("src",domainurl+"/images/imgnopas.jpg");
                                 archivoInput.value = '';
                              return false;
                        }
                      })
                  } 
                   
                  function filePreview(input) {     //----> IMG-PREVIA-MARCA 
                    let imgmacuri=$ ( "#img-maci");
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                           $("#img-maci").attr("src",e.target.result);
                         };                    
                              reader.readAsDataURL(input.files[0]);
                         }
                  }
                   
                  $("#customFile").change( function () {

                    filePreview( this );
                  });
                },
                validaAddUser:function(){ //----> Valida user Add   
                  $('#save_user').validate({
                      ignore:'.ignore',
                      errorClass:'invalid',
                      validClass:'success',
                      rules:{
                       first_name:{
                        required:true,
                        minlength:2,
                        maxlength:25,
                        noSpace: true    
                       },
                       last_name:{
                        required:true,
                        minlength:2,
                        maxlength:25,
                        noSpace: true    
                       },
                       email:{
                          // se envia a una ruta de un controlador par saber si existe el correo 
                        required:true,
                        email:true,
                          remote: {
                              url: domainurl+"/add-user/check_email_unique",
                              type: "post",
                              data: {
                                email: function() {
                                  return $( "#email" ).val();
                                },
                                '_token':$('meta[name="csrf-token"]').attr('content')
                              }
                          }       
                       },
                       password:{
                        required:true,
                        minlength:6,
                        maxlength:10
                       },
                       selecperfil:{  
                          required:true
                        },
                       conf_pass:{
                        required:true,
                        maxlength:10,
                        equalTo:'#password'
                       } 

                      },
                     messages: {
                        first_name: {
                          required:"Porfavor ingrese su nombre",
                              minlength:"Porfavor minimo 2 caracteres",
                              maxlength:"Prfavor maximo 25 caracteres"
                        },
                        last_name: {
                          required:"Porfavor ingrese el apellido",
                              minlength:"Porfavor minimo 2 caracteres",
                              maxlength:"Prfavor maximo 25 caracteres"
                        },
                        selecperfil: {
                        required: "Perfil requerido"
                      },
                        email: {
                          required: "Porfavor ingrese su Email",
                          email: "Su correo electrónico no es valido",
                          remote:"Correo electrónico ya en uso.Prueba con otro"
                        },
                        password:{
                          required:"Ingrese su password",
                              minlength:"Porfavor minimo 6 caracteres",
                              maxlength:"Prfavor maximo 10 caracteres"
                        },
                        conf_pass:{
                          required:"Necesita la confirmacion de su password",
                          equalTo:"La contraseña no conciden"
                        },
                      },
                     errorPlacement:function(error,element){
                            error.insertAfter(element);
                      },
                       submitHandler:function(form){
                          //animacion 
                          console.log("ahora macuri")
                          $.LoadingOverlay("show");
                           form.submit();
                       }
                  });                    
                },
                validaEditUser:function(){//----> Valida user Edit  
                  $('#edit_user').validate({
                      ignore:'.ignore',
                      errorClass:'invalid',
                      validClass:'success',
                      rules:{
                       first_name:{
                        required:true,
                        minlength:2,
                        maxlength:25,
                        noSpace: true    
                       },
                       last_name:{
                        required:true,
                        minlength:2,
                        maxlength:25,
                        noSpace: true    
                       },
                       email:{
                          // se envia a una ruta de un controlador par saber si existe el correo 
                        required:true 
                               
                       },
                       password:{
                         minlength:6,
                        maxlength:10
                       },
                       selecperfil:{  
                          required:true
                        },
                       conf_pass:{
                         maxlength:10,
                        equalTo:'#password'
                       } 

                      },
                     messages: {
                        first_name: {
                          required:"Porfavor ingrese su nombre",
                              minlength:"Porfavor minimo 2 caracteres",
                              maxlength:"Prfavor maximo 25 caracteres"
                        },
                        last_name: {
                          required:"Porfavor ingrese el apellido",
                              minlength:"Porfavor minimo 2 caracteres",
                              maxlength:"Prfavor maximo 25 caracteres"
                        },
                        selecperfil: {
                        required: "Perfil requerido"
                      },
                        email: {
                          required: "Porfavor ingrese su Email",
                          email: "Su correo electrónico no es valido",
                          remote:"Correo electrónico ya en uso.Prueba con otro"
                        },
                        password:{
                          required:"Ingrese su password",
                              minlength:"Porfavor minimo 6 caracteres",
                              maxlength:"Prfavor maximo 10 caracteres"
                        },
                        conf_pass:{
                          required:"Necesita la confirmacion de su password",
                          equalTo:"La contraseña no conciden"
                        },
                      },
                     errorPlacement:function(error,element){
                            error.insertAfter(element);
                      },
                       submitHandler:function(form){
                          //animacion 
                          console.log("ahora macuri")
                          $.LoadingOverlay("show");
                           form.submit();
                       }
                  });                    
                },
                changeSocio:function(){   //----> Select Camb Perfil
                  $('#rowtit').hide(); 
                  $('#notitu').hide(); 
                  $('#sititu').hide(); 
                  $('#selecperfil').change(function(){
                    if ($('#selecperfil').val() == '1') {
                          $('#sititu').show('3000'); 
                          $('#rowtit').hide('3000'); 
                          $('#notitu').hide('3000'); 
                      }else if($('#selecperfil').val() == '2'  ) {
                          $('#sititu').show('3000'); 
                          $('#rowtit').show('3000'); 
                          $('#notitu').hide('3000');
                      } else if( $('#selecperfil').val() == '3') {
                          $('#rowtit').show('3000'); 
                          $('#notitu').show('3000');  
                          $('#sititu').hide('3000');   
                      } else if( $('#selecperfil').val() === '') {
                          $('#rowtit').hide('3000'); 
                          $('#notitu').hide('3000');  
                          $('#sititu').hide('3000');   
                      } 
                  });
                },
                modalefecto:function(){   //----> Modal Add Invitado
                  $(".btninvitado").hide()
                    //---> METODO PARA CARGA RENGO DE INVITADOS MAXMIMO
                    function move(dataporc) {
                      var elem = document.getElementById("myBar");
                      var width = 10;
                      var id = setInterval(frame, 10);
                      function frame() {
                        if (width >= dataporc) {
                          clearInterval(id);
                        } else {
                          width++;
                          elem.style.width = width + '%';
                          document.getElementById("label").innerHTML = width * 1  + '%';
                        }
                      }
                    }



                  //-----> keyup codigo buscar cliente 
                  $("#clave_socio").keyup(function(event) {

                      event.preventDefault()
                      let inputclav = $(this).val()
                      let _token = $('input[name="_token"]').val()
                      //console.log(inputclav)
                       $.ajax({
                         url: domainurl+'/home/buscaclave/',
                         type: 'GET',
                        dataType: 'json',
                        data: {inputclav:inputclav,_token:_token},
                       })
                       .done(function(data) {
                        // console.log(data)
                        // console.log(data.datasoc)
                          // VER DATOS DEL SOCIO 
                          if (data.datasoc != null ) {
                            $(".btninvitado").slideDown()
                               $("#nomsocioti").val(data.datasoc.name+" " + data.datasoc.lastname)
                          }else{

                              $(".btninvitado").slideUp()
                          }
                          // VER ADULTOS  DE INVITADOS
                          if (data.adulto != null ) {

                              $("#adulto").val(data.adulto)
                          } else{

                              $("#adulto").val(0)
                          }
                          // VER  NIÑOS   DE INVITADOS
                          if(data.nino != null){

                            $("#nino").val(data.nino)
                          } else{

                            $("#nino").val(0)
                          }
  
                          // VER CUPOS DE INVITADOS DISPONIBLE
                          if (data.continvit != null) {
                            console.log()
                            move(parseInt(data.continvit) * 25)
                              $("#cupUsa").slideDown( "slow", function() {
                                // Animation complete.
                                $(this).html('0'+data.continvit)
                                 let difecupos = 4 - parseInt(data.continvit);
                              ///  console.log(difecupos)
                                 if (difecupos == 0) {
                                 // console.log("excedio su nivel")
                                    $("#cuplib").css({color: '#FF0000' }).html('--')
                                    $("#myBar").css({
                                      background: '#FF0000' 
                                    });
                                 }else{
                                    $("#cuplib").css({color: '#008000' }).html(difecupos)
                                    $("#myBar").css({
                                      background: '#008000' 
                                    });
                                 }
                               });
                          }else{
                            let elemen = $("#myBar").width(0)
                            $("#label").html(0 +'%')
                             $("#cupUsa").slideUp( "slow", function() {
                                // Animation complete.
                                $(this).html('00')
                              });
                                $("#cuplib").slideUp( "slow", function() {
                                // Animation complete.
                                $(this).html('00')
                              });

                          }
                           
                           
                       })
                       .fail(function() {
                        console.log("error");
                       })  
                  });
                  
                  //-----> Ancla Invitado por dia
                  $(".btninvitado").click(function(event) {
                    event.preventDefault()
                      if ($("#clave_socio").val() != '') {
                        let codsoci  = $("#clave_socio").val();
                        let nomtitul = $("#nomsocioti").val()
                        showPopup(nomtitul,codsoci)
                      }
                  });

                  function showPopup(nomtitul,codsoci){      //--> Metodo Modal
                        event.preventDefault()
                        $("#cod-soci-hidden").html(codsoci)
                        $("#cod-soci").val(codsoci) 
                        $("#titul").val(nomtitul)
                      
                        $('#modalPed').removeClass('contmod-efectsalir');
                        $('#modalPed').addClass('contmod-efect');
                        $('.body_m').addClass('body_m_efect');
                  } 

                  $(".btn-close-popup").click(function(event){//--->Close Modal 
                        $('#modalPed').addClass('contmod-efectsalir');
                        $('.body_m').removeClass('body_m_efect');
                  });

                  $("#btncerrar").click(function(event) {     //--->Close Modal 
                      event.preventDefault()
                        $('#modalPed').addClass('contmod-efectsalir');
                        $('.body_m').removeClass('body_m_efect');
                  });
                },
                validAddinvit:function(){ //----> Valida Invitad Add
                  $('#form-invitado-save').validate({
                      ignore:'.ignore',
                      errorClass:'invalid',
                      validClass:'success',
                      rules:{
                       name:{
                        required:true,
                        minlength:2,
                        maxlength:25,
                        noSpace: true    
                       },
                       lastname:{
                        required:true,
                        minlength:2,
                        maxlength:25,
                        noSpace: true    
                       },
                       dni:{
                          // se envia a una ruta de un controlador par saber si existe el correo 
                        required:true,
                        digits:true,
                        max:99999999,
                        dnivalida:true,
                        remote: {
                              url: domainurl+"/invitado/check_dni_unique",
                              type: "post",
                              data: {
                                dni: function() {
                                  return $( "#dni" ).val();
                                },
                                '_token':$('meta[name="csrf-token"]').attr('content')
                              }
                        }       
                       },
                       selecatego:{
                        required:true,
                       },
                      },
                     messages: {
                        name: {
                          required:"Porfavor ingrese su nombre",
                          minlength:"Porfavor minimo 2 caracteres",
                          maxlength:"Prfavor maximo 25 caracteres"
                        },
                        lastname: {
                          required:"Porfavor ingrese el apellido",
                          minlength:"Porfavor minimo 2 caracteres",
                          maxlength:"Prfavor maximo 25 caracteres"
                        },
                        selecatego: {
                        required: "Seleccione Adulto o niño"
                        },
                        dni: {
                          required:"Ingrese Su Dni Aquí..💬",
                          digits:"Solo permite Números Aquí💬",
                          max:"Máximo 8 digitos",
                          remote:"Dni ya existente !!!"

                        },
                         
                      },
                     errorPlacement:function(error,element){
                            error.insertAfter(element);
                      },
                       submitHandler:function(form){
                          //animacion 
                          console.log("ahora macuri")
                          $.LoadingOverlay("show");
                           form.submit();
                       }
                  });
                },
                validEditinvit:function(){//----> Valid Invitad Edit
                  $('#edit_invit').validate({
                      ignore:'.ignore',
                      errorClass:'invalid',
                      validClass:'success',
                      rules:{
                       first_name:{
                        required:true,
                        minlength:2,
                        maxlength:25,
                        noSpace: true    
                       },
                       last_name:{
                        required:true,
                        minlength:2,
                        maxlength:25,
                        noSpace: true    
                       },
                       dni:{
                          // se envia a una ruta de un controlador par saber si existe el correo 
                        required:true,
                        digits:true,
                        max:99999999,
                        dnivalida:true,
                               
                       },
                       selecperfil:{
                        required:true,
                       },
                        selecclave:{
                        required:true,
                       },
                        

                      },
                     messages: {
                        first_name: {
                          required:"Porfavor ingrese su nombre",
                          minlength:"Porfavor minimo 2 caracteres",
                          maxlength:"Prfavor maximo 25 caracteres"
                        },
                        last_name: {
                          required:"Porfavor ingrese el apellido",
                          minlength:"Porfavor minimo 2 caracteres",
                          maxlength:"Prfavor maximo 25 caracteres"
                        },
                        selecperfil: {
                        required: "Seleccione Adulto o niño"
                        },
                        selecclave: {
                        required: "Seleccione La clave del socio"
                        },
                        dni: {
                          required:"Ingrese Su Dni Aquí..💬",
                          digits:"Solo permite Números Aquí💬",
                          max:"Máximo 8 digitos",
                          remote:"Dni ya existente !!!"

                        },
                         
                      },
                     errorPlacement:function(error,element){
                            error.insertAfter(element);
                      },
                       submitHandler:function(form){
                          //animacion 
                          console.log("ahora macuri")
                          $.LoadingOverlay("show");
                           form.submit();
                       }
                  });
                },
                homeInvitaTabla:function(){//---> Invitad Tabl Home 
                  $("#tbl_invit").DataTable( {
                    language: {
                              "lengthMenu": "Mostrar _MENU_ registros",
                              "zeroRecords": "No se encontraron resultados",
                              "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                              "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                              "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                              "sSearch": "Buscar:",
                              "oPaginate": {
                                  "sFirst": "Primero",
                                  "sLast":"Último",
                                  "sNext":"Siguiente",
                                  "sPrevious": "Anterior"
                           },
                         "sProcessing":"Procesando...",
                              },                           
                    responsive: true,           
                    dom: 'Bfrtilp',
                    buttons:[    
                        {
                           extend: 'pdfHtml5',
                           text: '<img src='+domainurl+'/img/iconos/iconpdf.png width="100%" class="img-fluid">  ',
                           titleAttr: 'Exportar a PDF' ,
                           messageTop: 'Registro de INVITADOS',
                                title:'Tabla de Invitados',
                           className: 'btn btn-danger' ,
                           exportOptions: {
                                columns: [0, 1,2, 3,4,5,6],
                                alignment: 'center',
                            },
                           excelStyles:{
                             template: 'blue_gray_medium'
                           },
                            customize:function(doc) {                          
                              doc.defaultStyle.alignment = 'center';                       
                                    doc.styles.title = {
                                        color: 'red',
                                        fontSize: '30',
                                        alignment: 'center'
                                    }
                                    doc.styles['td:nth-child(2)'] = { 
                                        width: '100px',
                                        'max-width': '100px'
                                    }
                                }
                        },
                        {
                            extend: 'print',
                            text: '<img src='+domainurl+'/img/iconos/iconimp.png width="100%" class="img-fluid">  ',
                            titleAttr: 'imprimir' ,
                            className: 'btn btn-secondary',
                            exportOptions: {
                                columns: [0, 1,2, 3,4,5,6],
                            },
                          },
                          {
                        extend:    'excelHtml5',
                        text:      '<img src='+domainurl+'/img/iconos/icoexcel.png width="100%" class="img-fluid">   ',
                        titleAttr: 'Exportar a Excel',
                        className: 'btn btn-success',
                        exportOptions: {
                                columns: [0, 1,2, 3,4,5,6],
                            },
                            excelStyles: [                      // Add an excelStyles definition
                              {                 
                                 template: "black_medium",   // Apply the "green_medium" template
                              },
                                  {
                                      cells: "sh",                                   
                                    style:{
                                      alignment: {
                                            vertical: "centerContinuous",
                                            horizontal: "centerContinuous",
                                            wrapText: true,
                                        },
                                      font:{
                                        b:true,
                                        color: "FFFFFF",

                                      },
                                      
                                      fill:{
                                        pattern:{
                                           style: "thick",
                                          bgColor:'fd0a43',
                                          color: "457B9D",    // Fill color 
                                        }
                                      }
                                    }
                                  },
                                  {
                                      cells: "A:",                                   
                                    style:{
                                      alignment: {
                                            vertical: "centerContinuous",
                                            horizontal: "centerContinuous",
                                            wrapText: true,
                                        }
                                    }
                                  }
                                ] 
                        }
                          ],                     
                  })
                  //---->eliminar
                  $('#tbl_invit tbody').on( 'click', 'a[data-id="elicli"]', function () {
                  let ide=this.name, nom=$(this).attr('data-nom'); 
                  Swal.fire({
                    title: '¿Estas seguro de eliminar "'+nom +'" ?',
                    text: "No podrás revertir esto !!!",
                     showCancelButton: true,
                     confirmButtonText: 'Si, eliminar ',
                     backdrop: ` rgba(0, 0, 0, 0.7) `
                  }).then((result) => {
                      if (result.isConfirmed) {
                      let _token = $('input[name="_token"]').val()

                        $.ajax({
                          url: domainurl+'/invi/'+ide+'/delete/',
                          type: 'GET',
                          beforeSend: function() {
                                  $.LoadingOverlay("show");
                           },      
                        })
                        .done(function(data) {
                           $.LoadingOverlay("hide")
                          Swal.fire({
                           icon: 'success',
                             title: "Tu Invitado a sido eliminado.",
                             confirmButtonText: "Aceptar",
                          })
                          .then(function(){
                                     location.reload();      
                            });
                          console.log("success");
                        })
                        .fail(function() {
                            $.LoadingOverlay("hide")
                          Swal.fire({
                             icon: 'error',
                               title: "No se pudo eliminar el invitado.",
                               text: 'Intente de nuevo',
                               confirmButtonText: "Aceptar",
                            }).then(function(){
                               location.reload();      
                            });
                          console.log("error");
                        }) 
                       
                      }
                  })
                  });                          
                },
                validaAddSoc:function(){   //---> Valida Socio Add  
                  $('#save_soci').validate({
                          ignore:'.ignore',
                          errorClass:'invalid',
                          validClass:'success',
                          rules:{
                            first_name:{
                              required:true,
                              minlength:2,
                              maxlength:25,
                              noSpace: true    
                            },
                            last_name:{
                              required:true,
                              minlength:2,
                              maxlength:25,
                              noSpace: true    
                            },
                            selecperfil: {
                              required:true,
                            },
                            dni:{
                              required:true,
                              digits:true,
                              dnivalida:true,
                              max:99999999,
                              remote: {
                                    url: domainurl+"/soc/check_dni_unique",
                                    type: "post",
                                    data: {
                                      dni: function() {
                                        return $( "#dni" ).val();
                                      },
                                      '_token':$('meta[name="csrf-token"]').attr('content')
                                    }
                              }      
                            },
                            email:{
                              required:true,
                              email:true,
                              remote: {
                                  url: domainurl+"/soc/check_email_uniq",
                                  type: "post",
                                  data: {
                                    email: function() {
                                      return $( "#email" ).val();
                                    },
                                    '_token':$('meta[name="csrf-token"]').attr('content')
                                  }
                              }        
                            },
                             

                          },
                         messages: {
                            first_name: {
                              required:"Porfavor ingrese su nombre",
                              minlength:"Porfavor minimo 2 caracteres",
                              maxlength:"Prfavor maximo 25 caracteres"
                            },
                            last_name: {
                              required:"Porfavor ingrese el apellido",
                              minlength:"Porfavor minimo 2 caracteres",
                              maxlength:"Prfavor maximo 25 caracteres"
                            },
                            dni: {
                              required:"Ingrese Su Dni Aquí..💬",
                              digits:"Solo permite Números Aquí💬",
                              max:"Máximo 8 digitos",
                              remote:"Dni ya existente !!!"
                            },
                            selecperfil: {
                              required: "Seleccione Perfil del socio"
                            },
                            email: {
                              required: "Porfavor ingrese su Email",
                              email: "Su correo electrónico no es valido",
                              remote:"Correo electrónico ya en uso.Prueba con otro"
                            },
                          },
                         errorPlacement:function(error,element){
                                  error.insertAfter(element);

                          },
                           submitHandler:function(form){
                              //animacion 
                              console.log("ahora macuri")
                              $.LoadingOverlay("show");
                               form.submit();
                           }
                      });

                  //-----> keyup codigo buscar CLAVE 
                  $("#clavetit").keyup(function(event) {
                      event.preventDefault()
                      let inputclav = $(this).val()
                      let _token = $('input[name="_token"]').val()
                      //console.log(inputclav)
                       $.ajax({
                         url: domainurl+'/home/buscaclaveaddsoc/',
                         type: 'GET',
                        dataType: 'json',
                        data: {inputclav:inputclav,_token:_token},
                       })
                       .done(function(data) {
                           if (data.daresult == true) {
                              $("#perorso").html('Socio Registrado <i class="far fa-check-circle"></i>').css({
                                color: '#008000',
                              });
                              $("#clavetit").css({
                                'border':'1px solid #008000',
                                'background-color':' #BDE5AD',
                                color: '#000',
                                'box-shadow': 'none'
                              });
                          }else{
                              $("#perorso").html('Socio no registrado <i class="fas fa-exclamation-circle"></i>').css({
                                color: '#FE1A00',
                              });
                              $("#clavetit").css({
                                'border':'1px solid #FE1A00',
                                'background-color':' #F3A7B8',
                                color: '#000',
                                'box-shadow': 'none'
                              });
                          }                           
                       })
                       .fail(function() {
                        console.log("error");
                       })  
                  });
                },
                validaEditSoc:function(){  //---> Valida Socio Edit 
                  $('#edit_soci').validate({
                          ignore:'.ignore',
                          errorClass:'invalid',
                          validClass:'success',
                          rules:{
                            first_name:{
                              required:true,
                              minlength:2,
                              maxlength:25,
                              noSpace: true    
                            },
                            last_name:{
                              required:true,
                              minlength:2,
                              maxlength:25,
                              noSpace: true    
                            },
                            selecperfil: {
                              required:true,
                            },
                            dni:{
                              required:true,
                              digits:true,
                              dnivalida:true,
                              max:99999999,
                            },
                            email:{
                              required:true,
                              email:true,
                            },
                          },
                         messages: {
                            first_name: {
                              required:"Porfavor ingrese su nombre",
                              minlength:"Porfavor minimo 2 caracteres",
                              maxlength:"Prfavor maximo 25 caracteres"
                            },
                            last_name: {
                              required:"Porfavor ingrese el apellido",
                              minlength:"Porfavor minimo 2 caracteres",
                              maxlength:"Prfavor maximo 25 caracteres"
                            },
                            dni: {
                              required:"Ingrese Su Dni Aquí..💬",
                              digits:"Solo permite Números Aquí💬",
                              max:"Máximo 8 digitos",
                             },
                            selecperfil: {
                              required: "Seleccione Perfil del socio"
                            },
                            email: {
                              required: "Porfavor ingrese su Email",
                              email: "Su correo electrónico no es valido",
                             },
                          },
                         errorPlacement:function(error,element){
                                  error.insertAfter(element);

                          },
                           submitHandler:function(form){
                              //animacion 
                              console.log("ahora macuri")
                              $.LoadingOverlay("show");
                               form.submit();
                           }
                  });

                  //-----> keyup codigo buscar CLAVE 
                  $("#clavetit").keyup(function(event) {
                      event.preventDefault()
                      let inputclav = $(this).val()
                      let _token = $('input[name="_token"]').val()
                      //console.log(inputclav)
                       $.ajax({
                         url: domainurl+'/home/buscaclaveaddsoc/',
                         type: 'GET',
                        dataType: 'json',
                        data: {inputclav:inputclav,_token:_token},
                       })
                       .done(function(data) {
                           if (data.daresult == true) {
                              $("#perorso").html('Socio Registrado <i class="far fa-check-circle"></i>').css({
                                color: '#008000',
                              });
                              $("#clavetit").css({
                                'border':'1px solid #008000',
                                'background-color':' #BDE5AD',
                                color: '#000',
                                'box-shadow': 'none'
                              });
                          }else{
                              $("#perorso").html('Socio no registrado <i class="fas fa-exclamation-circle"></i>').css({
                                color: '#FE1A00',
                              });
                              $("#clavetit").css({
                                'border':'1px solid #FE1A00',
                                'background-color':' #F3A7B8',
                                color: '#000',
                                'box-shadow': 'none'
                              });
                          }                           
                       })
                       .fail(function() {
                        console.log("error");
                       })  
                  });
                },
                graficosbackend:function(){//---> Higchart backends 
                  if ($("#histo01").length > 0) {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                      url: domainurl,
                      type: 'GET',
                      dataType: 'json',
                      async:true,
                      data: {_token: _token},
                    })
                    .done(function(data) {
                        let data1 = data[1],
                          data2 = data[2],
                          data3 = data[3],
                          data4 = data[4],
                          data5 = data[5] ,
                          data6 = data[6]  ;
                
                        //---> HISTOGRAMA 01 LINEAL(socio X hora )  
                            var chart1 = new Highcharts.Chart({
                              chart: {
                                renderTo: 'histo01',  // Le doy el nombre a la gráfica
                                type: 'line', // Pongo que tipo de gráfica es
                                options3d:{
                                  enabled:true,
                                  alpha:15,
                                  beta:15,
                                  depth:100,
                                  viewDistance:25
                                }
                              },
                              title: {
                                text: 'Socios por Hora'  // Titulo (Opcional)
                              },
                              subtitle: {
                                text: 'WebM@c 2021'   // Subtitulo (Opcional)
                              },
                              // Pongo los datos en el eje de las 'X'
                              xAxis:{
                                reversed: false,
                                title: {
                                    enabled: true,
                                    text: 'Horas del dia'
                                },
                                labels: {
                                    format: '{value}:00 hs.'
                                },
                                 
                                 showLastLabel: true
                              },
                              yAxis: {
                                title: {
                                    text: 'N° socios ingresados'
                                },
                                labels: {
                                    format: '{value}🚶‍'
                                },
                                allowDecimals: false,
                                 
                                lineWidth: 1
                              },
                              legend:{
                                layout: 'vertical',
                                align:'up',
                                x: 0,
                                    y: 100,
                                verticalAlign : 'middle'
                              },
                              // Doy formato al la "cajita" que sale al pasar el ratón por encima de la gráfica
                              tooltip: {
                                        headerFormat: '<b style="text-shadow: none !important;color:red;font-weight: 300" >{point.x}:00 hs</b><br/>',

                                    pointFormat: "<span style='color:{point.color}'>N°soc: {point.name} </span> <b>{point.y} </b>"
                              },
                              // Doy opciones a la gráfica
                              plotOptions:{
                                column:{
                                  depth:25
                                },
                                pointStart:2010
                              },
                              credits: {
                                  enabled: false
                                },      
                              // Doy los datos de la gráfica para dibujarlas
                              series:[{
                                name:"Socios X Hora ⌚ ",
                                    data:data1
                                    }],
                                responsive: {
                                  rules: [{
                                    condition: {
                                        maxWidth: 500
                                    },
                                    chartOptions: {
                                        legend: {
                                            layout: 'horizontal',
                                            align: 'center',
                                            verticalAlign: 'bottom'
                                        }
                                    }
                                }]
                             }              
                            }); 
                        //---> HISTOGRAMA 02 PASTEL(adulto% niños%)  
                            var chart2 = new Highcharts.Chart({
                              chart: {
                                renderTo: 'histo02',  // Le doy el nombre a la gráfica
                                    plotBackgroundColor: null,
                                    plotBorderWidth: null,
                                    plotShadow: false,
                                    type: 'pie'
                              },
                              title: {
                                text: 'socios <br> Adultos - Niños'  // Titulo (Opcional)
                              },
                              subtitle: {
                                text: 'WebM@c 2021'   // Subtitulo (Opcional)
                              },
                                tooltip: {
                                  enabled: true,
                                     headerFormat: '<b style="text-shadow: none !important;color:red;font-weight: 300" >{point.key}</b><br/>',

                                    pointFormat: " <span style='color:{point.color}'>{series.name}: </span><b>{point.percentage:.1f}%</b>  "
                         
                                },
                                accessibility: {
                                    point: {
                                        valueSuffix: '%'
                                    }
                                },
                                plotOptions: {
                                    pie: {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        dataLabels: {
                                            enabled: true,
                                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                            connectorColor: 'red'
                                        },showInLegend: true
                                    }
                                },
                              credits: {
                                  enabled: false
                                },      
                              // Doy los datos de la gráfica para dibujarlas
                              series:[{
                                 name:"N°Soc",
                                    data:data2
                                    }]                
                            })
                        //---> HISTOGRAMA 03 COLUMNA(socio X dias )  
                            var chart3 = new Highcharts.Chart({
                              chart: {
                                renderTo: 'histo03',  // Le doy el nombre a la gráfica
                                 type: 'column', // Pongo que tipo de gráfica es
                                options3d:{
                                  enabled:true,
                                  alpha:15,
                                  beta:25,
                                  depth:100,
                                  viewDistance:25
                                }
                              },
                              title: {
                                text: 'Socios por Día'  // Titulo (Opcional)
                              },
                              subtitle: {
                                text: 'WebM@c 2021'   // Subtitulo (Opcional)
                              },
                              // Pongo los datos en el eje de las 'X'
                              xAxis: {
                                                  type:'category'
                                                },
                              yAxis: {
                                title: {
                                    text: 'N° socios ingresados'
                                },
                                labels: {
                                    format: '{value}🚶‍'
                                },
                                allowDecimals: false,
                                 
                                lineWidth: 1
                              },
                              legend:{
                                layout: 'vertical',
                                align:'up',
                                x: 0,
                                    y: 100,
                                verticalAlign : 'middle'
                              },
                              // Doy formato al la "cajita" que sale al pasar el ratón por encima de la gráfica
                              tooltip: {
                                headerFormat: '<b style="text-shadow: none !important;color:red;font-weight: 300" >{point.key}</b><br/>',
                                pointFormat: "<span style='color:{point.color}'>N°soc:  </span> <b>{point.y} </b>"
                              },
                              // Doy opciones a la gráfica
                              plotOptions:{
                                column:{
                                  depth:25
                                },
                                pointStart:2010
                              },
                              credits: {
                                  enabled: false
                                },      
                              // Doy los datos de la gráfica para dibujarlas
                              series:[{
                                name:"Socios X Dia 📆 ",
                                    data:data3
                                    }],
                                responsive: {
                                  rules: [{
                                    condition: {
                                        maxWidth: 500
                                    },
                                    chartOptions: {
                                        legend: {
                                            layout: 'horizontal',
                                            align: 'center',
                                            verticalAlign: 'bottom'
                                        }
                                    }
                                }]
                             }              
                            });


                        //---> HISTOGRAMA 04 COLUMNA(invitado X dias)  
                            var chart4 = new Highcharts.Chart({
                              chart: {
                                renderTo: 'histo04',  // Le doy el nombre a la gráfica
                                 type: 'column', // Pongo que tipo de gráfica es
                                options3d:{
                                  enabled:true,
                                   alpha:15,
                                  beta:25,
                                  depth:100,
                                  viewDistance:25
                                }
                              },
                              title: {
                                text: 'Invitado por Día'  // Titulo (Opcional)
                              },
                              subtitle: {
                                text: 'WebM@c 2021'   // Subtitulo (Opcional)
                              },
                              // Pongo los datos en el eje de las 'X'
                              xAxis: {
                                      type:'category'
                                      },
                              yAxis: {
                                title: {
                                    text: 'N° ingreso de invitados'
                                },
                                labels: {
                                    format: '{value}🚶‍'
                                },
                                allowDecimals: false,
                                 
                                lineWidth: 1
                              },
                              legend:{
                                layout: 'vertical',
                                align:'up',
                                x: 0,
                                    y: 100,
                                verticalAlign : 'middle'
                              },
                              // Doy formato al la "cajita" que sale al pasar el ratón por encima de la gráfica
                              tooltip: {
                                headerFormat: '<b style="text-shadow: none !important;color:red;font-weight: 300" >{point.key}</b><br/>',
                                pointFormat: "<span style='color:{point.color}'>N°inv:  </span> <b>{point.y} </b>"
                              },
                              // Doy opciones a la gráfica
                              plotOptions:{
                                column:{
                                  depth:25
                                },
                                pointStart:2010
                              },
                              credits: {
                                  enabled: false
                                },      
                              // Doy los datos de la gráfica para dibujarlas
                              series:[{
                                name:"invitados X Dia 📆 ",
                                    data:data4
                                    }],
                                responsive: {
                                  rules: [{
                                    condition: {
                                        maxWidth: 500
                                    },
                                    chartOptions: {
                                        legend: {
                                            layout: 'horizontal',
                                            align: 'center',
                                            verticalAlign: 'bottom'
                                        }
                                    }
                                }]
                             }              
                            }); 
                        //---> HISTOGRAMA 05 LINEAL(invitado X hora )  
                            var chart5 = new Highcharts.Chart({
                              chart: {
                                renderTo: 'histo05',  // Le doy el nombre a la gráfica
                                type: 'line', // Pongo que tipo de gráfica es
                                options3d:{
                                  enabled:true,
                                  alpha:15,
                                  beta:15,
                                  depth:100,
                                  viewDistance:25
                                }
                              },
                              title: {
                                text: 'Invitados por Hora'  // Titulo (Opcional)
                              },
                              subtitle: {
                                text: 'WebM@c 2021'   // Subtitulo (Opcional)
                              },
                              // Pongo los datos en el eje de las 'X'
                              xAxis:{
                                reversed: false,
                                title: {
                                    enabled: true,
                                    text: 'Horas del dia'
                                },
                                labels: {
                                    format: '{value}:00 hs.'
                                },
                                 
                                 showLastLabel: true
                              },
                              yAxis: {
                                title: {
                                    text: 'N° Invitados '
                                },
                                labels: {
                                    format: '{value}🚶‍'
                                },
                                allowDecimals: false,
                                 
                                lineWidth: 1
                              },
                              legend:{
                                layout: 'vertical',
                                align:'up',
                                x: 0,
                                    y: 100,
                                verticalAlign : 'middle'
                              },
                              // Doy formato al la "cajita" que sale al pasar el ratón por encima de la gráfica
                              tooltip: {
                                    headerFormat: '<b style="text-shadow: none !important;color:red;font-weight: 300" >{point.x}:00 hs</b><br/>',
                                    pointFormat: "<span style='color:{point.color}'>N°Inv: {point.name} </span> <b>{point.y} </b>"
                              },
                              // Doy opciones a la gráfica
                              plotOptions:{
                                column:{
                                  depth:25
                                },
                                pointStart:2010
                              },
                              credits: {
                                  enabled: false
                                },      
                              // Doy los datos de la gráfica para dibujarlas
                              series:[{
                                name:"Invitados X Hora ⌚ ",
                                    data:data5
                                    }],
                                responsive: {
                                  rules: [{
                                    condition: {
                                        maxWidth: 500
                                    },
                                    chartOptions: {
                                        legend: {
                                            layout: 'horizontal',
                                            align: 'center',
                                            verticalAlign: 'bottom'
                                        }
                                    }
                                }]
                             }              
                            });
                        //---> HISTOGRAMA 06 PASTEL(adulto% niños%)  
                            var chart6 = new Highcharts.Chart({
                              chart: {
                                renderTo: 'histo06',  // Le doy el nombre a la gráfica
                                    plotBackgroundColor: null,
                                    plotBorderWidth: null,
                                    plotShadow: false,
                                    type: 'pie'
                              },
                              title: {
                                text: 'invitados <br> Adultos - Niños'  // Titulo (Opcional)
                              },
                              subtitle: {
                                text: 'WebM@c 2021'   // Subtitulo (Opcional)
                              },
                                tooltip: {
                                  enabled: true,
                                     headerFormat: '<b style="text-shadow: none !important;color:red;font-weight: 300" >{point.key}</b><br/>',

                                    pointFormat: " <span style='color:{point.color}'>{series.name}: </span><b>{point.percentage:.1f}%</b>  "
                         
                                },
                                accessibility: {
                                    point: {
                                        valueSuffix: '%'
                                    }
                                },
                                plotOptions: {
                                    pie: {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        dataLabels: {
                                            enabled: true,
                                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                            connectorColor: 'red'
                                        },showInLegend: true
                                    }
                                },
                              credits: {
                                  enabled: false
                                },      
                              // Doy los datos de la gráfica para dibujarlas
                              series:[{
                                 name:"N°Soc",
                                    data:data6
                                    }]                
                            })





                      Highcharts.setOptions({ //----> color degrado higchart
                        colors: Highcharts.getOptions().colors.map(function(color) {
                          return {
                              radialGradient: {
                                  cx: 0.5,
                                  cy: 0.3,
                                  r: 0.7
                              },
                              stops: [
                                  [0, color],
                                  [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
                              ]
                          };
                        })
                      });

                    })
                    .fail(function() {
                      console.log("error");
                    })
                  }
                },
                tablereportsoci:function(){//---> SocioReport Tabla 
                  $("#tbl_socio_repor").DataTable( {
                    language: {
                              "lengthMenu": "Mostrar _MENU_ registros",
                              "zeroRecords": "No se encontraron resultados",
                              "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                              "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                              "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                              "sSearch": "Buscar:",
                              "oPaginate": {
                                  "sFirst": "Primero",
                                  "sLast":"Último",
                                  "sNext":"Siguiente",
                                  "sPrevious": "Anterior"
                           },
                         "sProcessing":"Procesando...",
                              },                           
                    responsive: true,           
                    dom: 'Bfrtilp',
                    buttons:[    
                        {
                           extend: 'pdfHtml5',
                           text: '<img src='+domainurl+'/img/iconos/iconpdf.png width="100%" class="img-fluid">  ',
                           titleAttr: 'Exportar a PDF' ,
                           messageTop: 'Reporte de Socios',
                                title:'Tabla de Reporte Socios',
                           className: 'btn btn-danger' ,
                           exportOptions: {
                                columns: [0, 1, 3,4,5,6,7,8,9],
                                alignment: 'center',
                            },
                           excelStyles:{
                             template: 'blue_gray_medium'
                           },
                            customize:function(doc) {                          
                              doc.defaultStyle.alignment = 'center';                       
                                    doc.styles.title = {
                                        color: 'red',
                                        fontSize: '30',
                                        alignment: 'center'
                                    }
                                    doc.styles['td:nth-child(2)'] = { 
                                        width: '100px',
                                        'max-width': '100px'
                                    }
                                }
                        },
                        {
                            extend: 'print',
                            text: '<img src='+domainurl+'/img/iconos/iconimp.png width="100%" class="img-fluid">  ',
                            titleAttr: 'imprimir' ,
                            className: 'btn btn-secondary',
                            exportOptions: {
                                columns: [0, 1, 3,4,5,6,7,8,9],
                            },
                          },
                          {
                        extend:    'excelHtml5',
                        text:      '<img src='+domainurl+'/img/iconos/icoexcel.png width="100%" class="img-fluid">   ',
                        titleAttr: 'Exportar a Excel',
                        className: 'btn btn-success',
                        exportOptions: {
                                columns: [0, 1, 3,4,5,6,7,8,9],
                            },
                            excelStyles: [                      // Add an excelStyles definition
                              {                 
                                 template: "black_medium",   // Apply the "green_medium" template
                              },
                                  {
                                      cells: "sh",                                   
                                    style:{
                                      alignment: {
                                            vertical: "centerContinuous",
                                            horizontal: "centerContinuous",
                                            wrapText: true,
                                        },
                                      font:{
                                        b:true,
                                        color: "FFFFFF",

                                      },
                                      
                                      fill:{
                                        pattern:{
                                           style: "thick",
                                          bgColor:'fd0a43',
                                          color: "457B9D",    // Fill color 
                                        }
                                      }
                                    }
                                  },
                                  {
                                      cells: "A:",                                   
                                    style:{
                                      alignment: {
                                            vertical: "centerContinuous",
                                            horizontal: "centerContinuous",
                                            wrapText: true,
                                        }
                                    }
                                  }
                                ] 
                        }
                          ],                     
                  })
                },
                tablereportinvi:function(){//---> InvitaReport Tabla
                  $("#tbl_invit_repor").DataTable( {
                    language: {
                              "lengthMenu": "Mostrar _MENU_ registros",
                              "zeroRecords": "No se encontraron resultados",
                              "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                              "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                              "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                              "sSearch": "Buscar:",
                              "oPaginate": {
                                  "sFirst": "Primero",
                                  "sLast":"Último",
                                  "sNext":"Siguiente",
                                  "sPrevious": "Anterior"
                           },
                         "sProcessing":"Procesando...",
                              },                           
                    responsive: true,           
                    dom: 'Bfrtilp',
                    buttons:[    
                        {
                           extend: 'pdfHtml5',
                           text: '<img src='+domainurl+'/img/iconos/iconpdf.png width="100%" class="img-fluid">  ',
                           titleAttr: 'Exportar a PDF' ,
                           messageTop: 'Reporte de INVITADOS',
                                title:'Tabla de Reporte Invitados',
                           className: 'btn btn-danger' ,
                           exportOptions: {
                                columns: [0, 1,2, 3,4,5],
                                alignment: 'center',
                            },
                           excelStyles:{
                             template: 'blue_gray_medium'
                           },
                            customize:function(doc) {                          
                              doc.defaultStyle.alignment = 'center';                       
                                    doc.styles.title = {
                                        color: 'red',
                                        fontSize: '30',
                                        alignment: 'center'
                                    }
                                     
                                }
                        },
                        {
                            extend: 'print',
                            text: '<img src='+domainurl+'/img/iconos/iconimp.png width="100%" class="img-fluid">  ',
                            titleAttr: 'imprimir' ,
                            className: 'btn btn-secondary',
                            exportOptions: {
                                columns: [0, 1,2, 3,4,5],
                            },
                          },
                          {
                        extend:    'excelHtml5',
                        text:      '<img src='+domainurl+'/img/iconos/icoexcel.png width="100%" class="img-fluid">   ',
                        titleAttr: 'Exportar a Excel',
                        className: 'btn btn-success',
                        exportOptions: {
                                columns: [0, 1,2, 3,4,5],
                            },
                            excelStyles: [                      // Add an excelStyles definition
                              {                 
                                 template: "black_medium",   // Apply the "green_medium" template
                              },
                                  {
                                      cells: "sh",                                   
                                    style:{
                                      alignment: {
                                            vertical: "centerContinuous",
                                            horizontal: "centerContinuous",
                                            wrapText: true,
                                        },
                                      font:{
                                        b:true,
                                        color: "FFFFFF",

                                      },
                                      
                                      fill:{
                                        pattern:{
                                           style: "thick",
                                          bgColor:'fd0a43',
                                          color: "457B9D",    // Fill color 
                                        }
                                      }
                                    }
                                  },
                                  {
                                      cells: "A:",                                   
                                    style:{
                                      alignment: {
                                            vertical: "centerContinuous",
                                            horizontal: "centerContinuous",
                                            wrapText: true,
                                        }
                                    }
                                  }
                                ] 
                        }
                          ],                     
                  }) 
                },
                fechaHoraActual:function(){//---> Fecha header ACtua
                  var actualizahora = function(){
                  let fecha = new Date(),
                    horas  = fecha.getHours(),ampm,
                      minutos=fecha.getMinutes(), 
                    segundos=fecha.getSeconds(), 
                    diaSemana=fecha.getDay(),
                    dia=fecha.getDate(),
                    mes=fecha.getMonth(),
                    year=fecha.getFullYear();

                    if ($("#fecha").length > 0){
                      let fec =document.getElementById('fecha')
                      let semana = ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'];
                      let meses= ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'];

                      if (horas >= 12) {horas = horas - 12;ampm ='PM';
                      }else{  ampm= 'AM'; }
                      if (horas == 0) {horas = 12;}           
                      if (minutos < 10) { minutos ="0"+minutos}
                      if (segundos< 10){segundos ="0"+segundos}

                      fec.textContent =year +' '+ meses[mes]+' '+dia+' '+ semana[diaSemana]+' '+horas+':'+ minutos+':'+segundos 
                    }

                  }
                  actualizahora();
                  var intervalo= setInterval(actualizahora,1000)          
                },
                modalingrsSoci:function(){
                  function showPopup(){
                      $('.pop-up').addClass('show');
                      $('.pop-up-wrap').addClass('show');
                  }

                  $("#close").click(function(){
                      $('.pop-up').removeClass('show');
                      $('.pop-up-wrap').removeClass('show');
                      $("#h2invimodls").html($("#clave_socio").val())

                  });

                  $(".btn-abrir").click(function(event) {
                    event.preventDefault()
                      let clave = $("#clave_socio").val() ;
                      let _token = $('input[name="_token"]').val()

                    if ($("#clave_socio").val() === "") {
                       Swal.fire(
                        'No ingreso una clave de socio',
                        'Rellenar el campo clave',
                        'question'
                      )
                    }else{
                      $.ajax({
                        url: domainurl+'/showsociomodal',
                        type: 'POST',
                        dataType: 'json',
                        data: {clave:clave,_token:_token},
                      })
                      .done(function(datas) {
                        //console.log(datas)
                        if (datas.datacla == "") {
                           Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'No existe este Socio o',
                                footer: '<h3 href="" class="text-center">Problamente no tiene ninguna socio ingresado !!!</h3>'
                          })
                        }else{
                           $("#tbl_sociomodal").DataTable( {
                              processing: true,
                              serverSide: true, 
                              destroy: true,
                              searching: true,
                              responsive: true,           
                              scrollY: '300px',
                              "bPaginate": false, //hide pagination
                              "bFilter": false, //hide Search bar
                              "bInfo": false, // hide showing entries
                              ajax  : {
                                    url: domainurl+'/showsociomodal',
                                    data : { clave:clave,_token:_token },
                                    type : 'post',
                                    dataSrc: 'datacla',
                                    /*dataSrc: function ( data ) {
                                            //Make your callback here.
                                            //alert("Done!");
                                             //return json.datacla;
                                             console.log(data)
                                        }*/ 
                              },
                              columns: [ 
                                        { "data" :"full_name" },
                                        { "data": "avatar", 
                                          "render": function (avatar, type, row, idsoc) {
                                          if (avatar) {
                                              return '<img src="'+domainurl+'/uploads_socios/soc_'+row.idsoc+'/av_'+avatar+'" style="height:50px;width:50px;" />';
                                           }else{
                                              return '<img src="http://localhost/sociosclub2021/public/img/iconos/user-avatar.png" style="height:50px;width:50px;" />';
                                          }
                                        },},
                                        { "data" :"tipo" },
                                        { "data" :"dni" },
                                        { "data" :"diasox" },
                                      ],
                              language: {
                                        "lengthMenu": "Mostrar _MENU_ registros",
                                        "zeroRecords": "No se encontraron resultados",
                                        "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                                        "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                                        "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                                        "sSearch": "Buscar:",
                                        "oPaginate": {
                                            "sFirst": "Primero",
                                            "sLast":"Último",
                                            "sNext":"Siguiente",
                                            "sPrevious": "Anterior"
                                     },
                                   "sProcessing":"Procesando...",
                                        },                           
                                dom: 'Bfrtilp',
                                buttons:[    
                                    {
                                       extend: 'pdfHtml5',
                                       text: '<img src='+domainurl+'/img/iconos/iconpdf.png width="100%" class="img-fluid">  ',
                                       titleAttr: 'Exportar a PDF' ,
                                       messageTop: 'Registro de Socios',
                                            title:'Tabla de Socios',
                                       className: 'btn btn-danger' ,
                                       exportOptions: {
                                            columns: [0, 1, 3,4,5,6,7,8,9],
                                            alignment: 'center',
                                        },
                                       excelStyles:{
                                         template: 'blue_gray_medium'
                                       },
                                        customize:function(doc) {                          
                                          doc.defaultStyle.alignment = 'center';                       
                                                doc.styles.title = {
                                                    color: 'red',
                                                    fontSize: '30',
                                                    alignment: 'center'
                                                }
                                                doc.styles['td:nth-child(2)'] = { 
                                                    width: '100px',
                                                    'max-width': '100px'
                                                }
                                            }
                                    },
                                    {
                                        extend: 'print',
                                        text: '<img src='+domainurl+'/img/iconos/iconimp.png width="100%" class="img-fluid">  ',
                                        titleAttr: 'imprimir' ,
                                        className: 'btn btn-secondary',
                                        exportOptions: {
                                            columns: [0, 1, 3,4,5,6,7,8,9],
                                        },
                                      },
                                      {
                                    extend:    'excelHtml5',
                                    text:      '<img src='+domainurl+'/img/iconos/icoexcel.png width="100%" class="img-fluid">   ',
                                    titleAttr: 'Exportar a Excel',
                                    className: 'btn btn-success',
                                    exportOptions: {
                                            columns: [0, 1, 3,4,5,6,7,8,9],
                                        },
                                        excelStyles: [                      // Add an excelStyles definition
                                          {                 
                                             template: "black_medium",   // Apply the "green_medium" template
                                          },
                                              {
                                                  cells: "sh",                                   
                                                style:{
                                                  alignment: {
                                                        vertical: "centerContinuous",
                                                        horizontal: "centerContinuous",
                                                        wrapText: true,
                                                    },
                                                  font:{
                                                    b:true,
                                                    color: "FFFFFF",

                                                  },
                                                  
                                                  fill:{
                                                    pattern:{
                                                       style: "thick",
                                                      bgColor:'fd0a43',
                                                      color: "457B9D",    // Fill color 
                                                    }
                                                  }
                                                }
                                              },
                                              {
                                                  cells: "A:",                                   
                                                style:{
                                                  alignment: {
                                                        vertical: "centerContinuous",
                                                        horizontal: "centerContinuous",
                                                        wrapText: true,
                                                    }
                                                }
                                              }
                                            ] 
                                    }
                                      ],                     
                                  })
                                showPopup()
                        }
                        //console.log("success");
                      })
                      .fail(function() {
                        console.log("error");
                      })
                      .always(function() {
                      //  console.log("complete");
                      });
                    }
                  });
                },
                modalingrsInvi:function(){
                  function showPopupInvit(){
                       $('.pop-up2').addClass('show');
                      $('.pop-up-wrap2').addClass('show');
                      $("#h2invimodls").html($("#clave_socio").val())
                  }
                  $("#close2").click(function(){
                      $('.pop-up2').removeClass('show');
                      $('.pop-up-wrap2').removeClass('show');
                  });
                  $(".btn-abrir-invi").click(function(event) {
                    event.preventDefault()
                      let clave = $("#clave_socio").val() ;
                      let _token = $('input[name="_token"]').val()

                    if ($("#clave_socio").val() === "") {
                      Swal.fire(
                        'No ingreso una clave de socio',
                        'Rellenar el campo clave',
                        'question'
                      )
                    }else{
                      $.ajax({
                        url: domainurl+'/showsociomodal',
                        type: 'POST',
                        dataType: 'json',
                        data: {clave:clave,_token:_token},
                      })
                      .done(function(datas) {
                          console.log(datas)
                        if (datas.datacla == "") {
                              Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'No existe este Socio o',
                                footer: '<h3 href="" class="text-center">Problamente no tiene ninguna socio ingresado !!!</h3>'
                              })
                        }else{
                             $("#tbl_sociomodalinvi").DataTable( {
                              processing: true,
                              serverSide: true, 
                              destroy: true,
                              searching: true,
                              responsive: true,           
                              scrollY: '300px',
                              "bPaginate": false, //hide pagination
                              "bFilter": false, //hide Search bar
                              "bInfo": false, // hide showing entries
                              ajax  : {
                                    url: domainurl+'/showinviomodal',
                                    data : { clave:clave,_token:_token },
                                    type : 'post',
                                    dataSrc: 'datacla',
                              },
                              columns: [ 
                                        { "data" :"full_name" },
                                        { "data" :"dniinvi" },
                                        { "data" :"diasox" },
                                        { "data" :"clasesoc" },
                                      ],
                              language: {
                                        "lengthMenu": "Mostrar _MENU_ registros",
                                        "zeroRecords": "No se encontraron resultados",
                                        "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                                        "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                                        "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                                        "sSearch": "Buscar:",
                                        "oPaginate": {
                                            "sFirst": "Primero",
                                            "sLast":"Último",
                                            "sNext":"Siguiente",
                                            "sPrevious": "Anterior"
                                     },
                                   "sProcessing":"Procesando...",
                                        },                           
                                dom: 'Bfrtilp',
                                buttons:[    
                                    {
                                       extend: 'pdfHtml5',
                                       text: '<img src='+domainurl+'/img/iconos/iconpdf.png width="100%" class="img-fluid">  ',
                                       titleAttr: 'Exportar a PDF' ,
                                       messageTop: 'Registro de Socios',
                                            title:'Tabla de Socios',
                                       className: 'btn btn-danger' ,
                                       exportOptions: {
                                            columns: [0, 1,2, 3 ],
                                            alignment: 'center',
                                        },
                                       excelStyles:{
                                         template: 'blue_gray_medium'
                                       },
                                        customize:function(doc) {                          
                                          doc.defaultStyle.alignment = 'center';                       
                                                doc.styles.title = {
                                                    color: 'red',
                                                    fontSize: '30',
                                                    alignment: 'center'
                                                }
                                                doc.styles['td:nth-child(2)'] = { 
                                                    width: '100px',
                                                    'max-width': '100px'
                                                }
                                            }
                                    },
                                    {
                                        extend: 'print',
                                        text: '<img src='+domainurl+'/img/iconos/iconimp.png width="100%" class="img-fluid">  ',
                                        titleAttr: 'imprimir' ,
                                        className: 'btn btn-secondary',
                                        exportOptions: {
                                            columns: [0, 1,2, 3 ],
                                        },
                                      },
                                      {
                                    extend:    'excelHtml5',
                                    text:      '<img src='+domainurl+'/img/iconos/icoexcel.png width="100%" class="img-fluid">   ',
                                    titleAttr: 'Exportar a Excel',
                                    className: 'btn btn-success',
                                    exportOptions: {
                                            columns: [0, 1,2, 3 ],
                                        },
                                        excelStyles: [                      // Add an excelStyles definition
                                          {                 
                                             template: "black_medium",   // Apply the "green_medium" template
                                          },
                                              {
                                                  cells: "sh",                                   
                                                style:{
                                                  alignment: {
                                                        vertical: "centerContinuous",
                                                        horizontal: "centerContinuous",
                                                        wrapText: true,
                                                    },
                                                  font:{
                                                    b:true,
                                                    color: "FFFFFF",

                                                  },
                                                  
                                                  fill:{
                                                    pattern:{
                                                       style: "thick",
                                                      bgColor:'fd0a43',
                                                      color: "457B9D",    // Fill color 
                                                    }
                                                  }
                                                }
                                              },
                                              {
                                                  cells: "A:",                                   
                                                style:{
                                                  alignment: {
                                                        vertical: "centerContinuous",
                                                        horizontal: "centerContinuous",
                                                        wrapText: true,
                                                    }
                                                }
                                              }
                                            ] 
                                    }
                                      ],                     
                            }) 
                            showPopupInvit()
                        }
                        //console.log("success");
                      })
                      .fail(function() {
                        console.log("error");
                      })
                      .always(function() {
                      //  console.log("complete");
                      });
                    }
                  }); 
                },
                codigoqr:function(){

                var Musique = new Audio();

                  $("#btnscan").click(function(event) {
                    /* Act on the event */
                    event.preventDefault()
                      $(".loadvideo").addClass('loading')
                    scan()



                  });

                  function scan(){
      let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

        scanner.addListener('scan', function (content) {
          if(content!=''){
             $(".loadvideo").removeClass('loading')

            var _token = $('input[name="_token"]').val();
            $.ajax({
              url: domainurl+'/api/scan/'+content,
              type: 'POST',
              dataType: 'json',
              data: {_token: _token},
            })
            .done(function(data) {
              console.log(data)
              console.log(data.msg)
              console.log("success");

                if( data.msg =='ok'){ //-----------> SOCIO no INGRESO
                    scanner.stop()
                    if (data.datasocio['avatar']) {
                      $("#img-qr").attr("src",domainurl+"/uploads_socios/soc_"+data.datasocio['id']+"/av_"+data.datasocio['avatar']);
                    }else{
                      $("#img-qr").attr("src",domainurl+"/img/iconos/user-avatar.png");
                    }                    $('#clave_socio').val(data.datasocio['clave']);
                    $('#nom-qr').html(data.datasocio['name']);
                    $('#ape-qr').html(data.datasocio['lastname']);
                      if (data.datasocio['perfil_id'] == 1) {
                    $('#perfil-qr').html("Titular");
                      }else if(data.datasocio['perfil_id'] == 2){
                    $('#perfil-qr').html("Conyuge");
                      }else if(data.datasocio['perfil_id'] == 3){
                    $('#perfil-qr').html("Familiar");
                      }
                      Musique.src = "http://localhost/sociosclub2021/public/success.wav";
                        Musique.play();
                    Swal.fire('Bienvenido '+data.datasocio['name'],
                              'Te estabamos esperando',
                              'success')
                    .then(function () {
                          scanner.start()
                      })

                }else if(data.msg =='existe'){//---> SOCIO YA INGRESO
                  scanner.stop()
                  if (data.datasocio['avatar']) {
                    $("#img-qr").attr("src",domainurl+"/uploads_socios/soc_"+data.datasocio['id']+"/av_"+data.datasocio['avatar']);
                  }else{
                    $("#img-qr").attr("src",domainurl+"/img/iconos/user-avatar.png");
                  }
                  
                  $('#clave_socio').val(data.datasocio['clave']);
                  $('#nom-qr').html(data.datasocio['name']);
                  $('#ape-qr').html(data.datasocio['lastname']);
                    if (data.datasocio['perfil_id'] == 1) {
                  $('#perfil-qr').html("Titular");
                    }else if(data.datasocio['perfil_id'] == 2){
                  $('#perfil-qr').html("Conyuge");
                    }else if(data.datasocio['perfil_id'] == 3){
                  $('#perfil-qr').html("Familiar");
                    }
                    Musique.src = "http://localhost/sociosclub2021/public/error.mp3";
                      Musique.play();
                      Swal.fire('¡¡Advertencia El socio ya ingreso!!',
                            'No podemos registrar su ingreso otra vez.',
                            'warning'
                      ).then(function () {
                          scanner.start()
                      })
                }      

            })
            .fail(function() {
              Musique.src = "http://localhost/sociosclub2021/public/erroring.mp3";
                      Musique.play();
                      Swal.fire('El socio no existe o no esta registrado !!!',
                            'No podemos registrar su ingreso. ',
                            'error'
                      ).then(function () {
                          scanner.start()
                      })
              console.log("error");
            })
            .always(function() {
              console.log("complete");
            });
            
        }
      }); 
       Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      }); 
     }
                },
              }
      Toptitop()
  }(jQuery, window); 


 
         

 





           




    


 









 
 

















