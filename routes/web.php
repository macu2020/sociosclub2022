<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConectController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\SocioController;
use App\Http\Controllers\Dashboard\InvitadoController; 
use App\Http\Controllers\Dashboard\ReporteController;  
 


//------> LOGIN 
Route::GET('/login',[ConectController::class,'getlogin2'] )->name('login'); 
Route::POST('/login',[ConectController::class, 'postLogin'] )->name('postLogin') ;
Route::GET('/',[ConectController::class,'getlogin'] )->name('homelogin');
Route::GET('/registr',[ConectController::class, 'getRegister'] )->name('getRegister') ;
Route::POST('/registr',[ConectController::class, 'postRegister'] )->name('registropost') ;
Route::GET('/logout',[ConectController::class, 'getlogout'] )->name('getlogout') ;

//------> VALIDA CHECKEMAIL
Route::POST('check_email_unique',[ConectController::class,'checkemail'] )->name('registropost') ;

 

//----> HOME BACKEND
Route::GET('/home',[DashboardController::class,'getHome'])->name('homess');
Route::POST('/showsocio',[DashboardController::class, 'getshowsoci'] )->name('showsocio') ; 
Route::GET('/home/buscaclave',[DashboardController::class,'buscaSoccio'])->name('buscciopost');
Route::POST('/invitado-socio',[DashboardController::class,'saveInvitad'])->name('posinvitado');
Route::GET('/asist-soc',[DashboardController::class,'getUpdateSoccio'])->name('updateSocio');
Route::GET('/asistnull-soc',[DashboardController::class,'getUpdatenullSoccio'])->name('updateSocionull');
Route::POST('invitado/check_dni_unique',[DashboardController::class,'checkdni'] )->name('chedni') ;

Route::POST('/busqueda',[DashboardController::class, 'postBuscasoci'] )->name('showsocio') ; 

Route::POST('/showsociomodal',[DashboardController::class, 'getshowsocimodal'] )->name('showsociomo') ; 
Route::POST('/showinviomodal',[DashboardController::class, 'getshowinvimodal'] )->name('showsociomo') ; 

//----> USUARIOS
Route::GET('/usuarios',[UserController::class,'getHomeUser'])->name('homeUser');
Route::GET('/add-user',[UserController::class,'getAddUser'])->name('homeaddUser');
Route::POST('/add-user',[UserController::class,'postAddUser'])->name('homeaddUser');
Route::POST('add-user/check_email_unique',[UserController::class,'checkemail'] )->name('registropost') ;
Route::GET('/edit/{id}/user',[UserController::class,'getEditUser'])->name('homeeditUser');
Route::POST('/edit/{id}/user',[UserController::class,'postEditUser'])->name('homeeditUserpost');
Route::GET('/user/{id}/delete',[UserController::class,'getuserdelete']);


//---> SOCIOS
Route::GET('/socios',[SocioController::class,'getHomeSoccio'])->name('homeSocio');
Route::GET('/add-soc',[SocioController::class,'getAddSoccio'])->name('addSocio');
Route::POST('/add-soc',[SocioController::class,'postAddSoccio'])->name('addSociopost');
Route::POST('soc/check_dni_unique',[SocioController::class,'checkdni'] )->name('chednisoc') ;
Route::POST('soc/check_email_uniq',[SocioController::class,'checkemails'] )->name('chednisoc') ;
Route::GET('/home/buscaclaveaddsoc',[SocioController::class,'buscaSoccio'])->name('buscciopost');
Route::GET('/edit/{id}/socio',[SocioController::class,'getEditSocio'])->name('homeeditSoci');
Route::POST('/edit/{id}/socio',[SocioController::class,'postEditSocio'])->name('homeeditSoci');
Route::GET('/socio/{id}/delete',[SocioController::class,'getsociodelete']);

Route::GET('/socio/{id}/updqr',[SocioController::class,'getupdateQr']);

//----> INVITADOS
Route::GET('/invitados',[InvitadoController::class,'getInvitados'])->name('homeInvi');
Route::GET('/edit/{id}/invi',[InvitadoController::class,'getEditInvit'])->name('homeeditInvi');
Route::POST('/edit/{id}/invi',[InvitadoController::class,'postEditInvit'])->name('homePostditInvi');
Route::GET('/invi/{id}/delete',[InvitadoController::class,'getinvitdelete']);


 
//---> DASHOBOARD HIGCHARTS  
		Route::GET('/',[DashboardController::class,'postDashboard']);

		
 //---> HOME RECEPCIONISTAS
Route::GET('consulta-ingreso',[DashboardController::class,'getConsulIngreso'])->name('homeconsul');
Route::GET('consulta-ingreso-invitado',[DashboardController::class,'getConsulIngresoinvi'])->name('homeconsul');

Route::GET('/edit/{id}/inviconsul',[DashboardController::class,'getEditInvitconsu'])->name('homeeditInvicon');

//----> REPORTES
Route::GET('reporte-socio',[ReporteController::class,'getReporHome'])->name('reporhomsoc');
Route::GET('reporte-invit',[ReporteController::class,'getReporHomeinvi'])->name('reporhominvi');


//-----> INGRESO POR CODIGO QR
Route::GET('/ingreso-qr',[DashboardController::class,'getHomeqr'])->name('homeingreqr');

Route::POST('/api/scan/{id}',[DashboardController::class,'postcamarasca'])->name('homescancam');

 
