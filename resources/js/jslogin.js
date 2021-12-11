

var macuriwebmac = function() {
  var body = $('body'),
        getId = null,                       //-------> variable vacia
        isMobile = !1,                      //-------> variable false
        urlPathname = window.location.pathname,//---> ruta y el nombre de archivo de la página actual
        domainurl = 'http://localhost/sociosclub2021/public'; 

  Toptitop = function() { 
      if ( (/windows phone/i.test(navigator.userAgent)) ||(/android/i.test(navigator.userAgent)) || 
                    (/iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream)      ) {
                isMobile = !0;  //---->se convierte en true
             };
              fn.documentAjax();
              fn.documentOnload();
              fn.documentReady();
          },
          fn = { 
                documentAjax: function()   {
                    $(document).ajaxStop(function() { 
                        //fn.login();
                        //-->llama como unevento previo de estar cargando
                    }); 
                },
                documentOnload:function()  { 
                    $(window).on('load', function() {
                      });  
                 },
                documentReady: function()  {
                  fn.otros()
                  fn.tooglelogin()
                  fn.validaregister()
                  fn.validalogin()
                }, 
                tooglelogin:function(){
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
                otros: function() {       //----> Otros Elementos 
               
                  if ($(".alert").length > 0){//----> alerta Errores
                        alertify.alert()
                              .setting({
                              'title':'Se ha producido un error : ',
                              'label':'ok',
                              'message': $('.alert').html() ,
                              'onok': function(){ alertify.error('😔 Vuelva a intentar !!!');}
                              }).show();
                  }
                  if ($(".suceess").length > 0){//--> alerta success
                        alertify.alert()
                        .setting({
                          'title':$('.titlesuceess').html(),
                          'label':'ok',
                          'message': $('.suceess').html() ,
                          'onok': function(){ alertify.success($('#subitisucess').html());}
                        }).show();
                  }        

                  //------> VALIDACIONES                
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
                    $("#last_name").bind('keypress',  function(event){
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
                      if (  this.value.length === 10) {
                      return false;
                      }
                    });
                    $("#conf_pass").bind('keypress', function(event) {
                      if (  this.value.length === 10) {
                            return false;
                      }
                    });  
                    $("#mensaj").bind('keypress', function(event)    {
                          var regex = new RegExp("^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ0-9. ]+$");
                          var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                          if (!regex.test(key)) {
                            event.preventDefault();
                            return false;
                          }
                          if (  this.value.length === 120) {
                            return false;
                           }
                    });
                  //------> VALIDACIUON JQUERYVALIDATOR 
                    jQuery.validator.addMethod("noSpace", function(value, element) {

                      return value == "" || value.trim().length != 0;
                    }, "No dejar espacios vacios");

                }, 
                validaregister:function(){
                  $('#regitration_form').validate({
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
                        required:true,
                        email:true,
                          remote: {
                              url: domainurl+"/check_email_unique",
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
                       },
                        grecaptcha:"required"

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
                         grecaptcha:"El campo Captcha es obligatorio"
                     },
                     errorPlacement:function(error,element){
                          if(element.attr('name')=='terms'){
                            error.appendTo($('#terms_error'));
                          }
                          else if(element.attr('name')=='grecaptcha'){
                              error.appendTo($('#hiddenRecaptchaRegisterError'));
                          }
                          else{
                            error.insertAfter(element);
                          }
                     },
                       submitHandler:function(form){
                          //animacion 
                          $.LoadingOverlay("show");
                           form.submit();
                       }
                  });                    
                },
                validalogin:function(){
                  $('#login_form').validate({
                      ignore:'.ignore',
                      errorClass:'invalid',
                      validClass:'success',
                      rules:{

                       email:{
                          required:true,
                          email:true,
                          noSpace: true   
                       },
                       password:{
                          required:true,
                          minlength:6,
                          maxlength:10,
                          noSpace: true 
                       },
                       selecperfil:{  
                          required:true
                        },
                        grecaptcha:"required"

                      },
                       messages: {

                          email: {
                            required: "El Correo es obligatorio",
                            email: "Su dirección de correo electrónico es invalido"
                          },
                          password:{
                              required:"Ingrese su password",
                              minlength:"Porfavor minimo 6 caracteres",
                              maxlength:"Prfavor maximo 10 caracteres"
                          },
                          selecperfil: {
                            required: "Perfil requerido"
                          },
                          grecaptcha:"El campo Captcha es obligatorio"
                       },
                       errorPlacement:function(error,element){
                          if(element.attr('name')=='grecaptcha'){
                              error.appendTo($('#hiddenRecaptchaLoginError'));
                          }
                          else{
                              error.insertAfter(element);
                          }
                       },
                       submitHandler:function(form){
                          
                          $.LoadingOverlay("show");
                          form.submit();
                       }
                  });
                },
                }
      Toptitop()
  }(jQuery, window); 


 
         

 





           




    


 









 
 

















