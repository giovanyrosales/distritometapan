<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Backend\Perfil\PerfilController;
use App\Http\Controllers\Backend\Roles\RolesController;
use App\Http\Controllers\Controles\ControlController;
use App\Http\Controllers\Backend\Roles\PermisoController;
use App\Http\Controllers\Backend\Extras\Slider\SliderController;
use App\Http\Controllers\Backend\Extras\Noticia\NoticiaController;
use App\Http\Controllers\Backend\Extras\Finanzas\FinanzasController;
use App\Http\Controllers\Backend\Extras\Compras\ComprasController;
use App\Http\Controllers\Backend\Extras\Programa\ProgramaController;
use App\Http\Controllers\Backend\Extras\Servicio\ServicioController;
use App\Http\Controllers\Frontend\Front\FrontendController;


Route::get('/admin', [LoginController::class,'index'])->name('login');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

// --- CONTROL WEB ---
Route::get('/panel', [ControlController::class,'indexRedireccionamiento'])->name('admin.panel');

// --- ROLES ---
Route::get('/admin/roles/index', [RolesController::class,'index'])->name('admin.roles.index');
Route::get('/admin/roles/tabla', [RolesController::class,'tablaRoles']);
Route::get('/admin/roles/lista/permisos/{id}', [RolesController::class,'vistaPermisos']);
Route::get('/admin/roles/permisos/tabla/{id}', [RolesController::class,'tablaRolesPermisos']);
Route::post('/admin/roles/permiso/borrar', [RolesController::class, 'borrarPermiso']);
Route::post('/admin/roles/permiso/agregar', [RolesController::class, 'agregarPermiso']);
Route::get('/admin/roles/permisos/lista', [RolesController::class,'listaTodosPermisos']);
Route::get('/admin/roles/permisos-todos/tabla', [RolesController::class,'tablaTodosPermisos']);
Route::post('/admin/roles/borrar-global', [RolesController::class, 'borrarRolGlobal']);

// --- PERMISOS ---
Route::get('/admin/permisos/index', [PermisoController::class,'index'])->name('admin.permisos.index');
Route::get('/admin/permisos/tabla', [PermisoController::class,'tablaUsuarios']);
Route::post('/admin/permisos/nuevo-usuario', [PermisoController::class, 'nuevoUsuario']);
Route::post('/admin/permisos/info-usuario', [PermisoController::class, 'infoUsuario']);
Route::post('/admin/permisos/editar-usuario', [PermisoController::class, 'editarUsuario']);
Route::post('/admin/permisos/nuevo-rol', [PermisoController::class, 'nuevoRol']);
Route::post('/admin/permisos/extra-nuevo', [PermisoController::class, 'nuevoPermisoExtra']);
Route::post('/admin/permisos/extra-borrar', [PermisoController::class, 'borrarPermisoGlobal']);


// --- PERFIL ---
Route::get('/admin/editar-perfil/index', [PerfilController::class,'indexEditarPerfil'])->name('admin.perfil');
Route::post('/admin/editar-perfil/actualizar', [PerfilController::class, 'editarUsuario']);

// --- SIN PERMISOS VISTA 403 ---
Route::get('sin-permisos', [ControlController::class,'indexSinPermiso'])->name('no.permisos.index');


// SLIDER
Route::get('/admin/slider/index', [SliderController::class,'indexSlider'])->name('admin.slider.index');
Route::get('/admin/slider/tabla', [SliderController::class,'tablaSlider']);
Route::post('/admin/slider/nuevo', [SliderController::class, 'nuevoSlider']);
Route::post('/admin/slider/informacion', [SliderController::class, 'informacionSlider']);
Route::post('/admin/slider/posicion', [SliderController::class, 'actualizarPosicionSlider']);
Route::post('/admin/slider/editar', [SliderController::class, 'editarSlider']);
Route::post('/admin/slider/borrar', [SliderController::class, 'borrarSlider']);


// NOTICIA
Route::get('/admin/noticia/index', [NoticiaController::class,'indexNoticia'])->name('admin.noticia.index');
Route::get('/admin/noticia/tabla', [NoticiaController::class,'tablaNoticia']);
Route::post('/admin/noticia/nuevo', [NoticiaController::class, 'nuevoNoticia']);
Route::post('/admin/noticia/informacion', [NoticiaController::class, 'informacionNoticia']);
Route::post('/admin/noticia/editar', [NoticiaController::class, 'editarNoticia']);
Route::post('/admin/noticia/borrar', [NoticiaController::class, 'borrarNoticia']);

// IMAGENES - NOTICIA
Route::get('/admin/noticiaimagen/index/{id}', [NoticiaController::class,'indexNoticiaImagen']);
Route::get('/admin/noticiaimagen/tabla/{id}', [NoticiaController::class,'tablaNoticiaImagen']);
Route::post('/admin/noticiaimagen/nuevo', [NoticiaController::class, 'nuevoNoticiaImagen']);
Route::post('/admin/noticiaimagen/borrar', [NoticiaController::class, 'borrarNoticiaImagen']);


// FINANZAS
Route::get('/admin/finanzas/index', [FinanzasController::class,'indexFinanzas'])->name('admin.finanzas.index');
Route::get('/admin/finanzas/tabla', [FinanzasController::class,'tablaFinanzas']);
Route::post('/admin/finanzas/nuevo', [FinanzasController::class, 'nuevoFinanzas']);
Route::post('/admin/finanzas/informacion', [FinanzasController::class, 'informacionFinanzas']);
Route::post('/admin/finanzas/editar', [FinanzasController::class, 'editarFinanzas']);
Route::post('/admin/finanzas/borrar', [FinanzasController::class, 'borrarFinanzas']);

// UCP
Route::get('/admin/ucp/index', [FinanzasController::class,'indexUcp'])->name('admin.ucp.index');
Route::get('/admin/ucp/tabla', [FinanzasController::class,'tablaUcp']);
Route::post('/admin/ucp/informacion', [FinanzasController::class, 'informacionUcp']);
Route::post('/admin/ucp/editar', [FinanzasController::class, 'editarUcp']);


// COMPRAS
Route::get('/admin/compras/index', [ComprasController::class,'indexCompras'])->name('admin.compras.index');
Route::get('/admin/compras/tabla', [ComprasController::class,'tablaCompras']);
Route::post('/admin/compras/nuevo', [ComprasController::class, 'nuevoCompras']);
Route::post('/admin/compras/informacion', [ComprasController::class, 'informacionCompras']);
Route::post('/admin/compras/editar', [ComprasController::class, 'editarCompras']);
Route::post('/admin/compras/borrar', [ComprasController::class, 'borrarCompras']);


// PROGRAMA MUNICIPAL
Route::get('/admin/programa/index', [ProgramaController::class,'indexPrograma'])->name('admin.programa.index');
Route::get('/admin/programa/tabla', [ProgramaController::class,'tablaPrograma']);
Route::post('/admin/programa/nuevo', [ProgramaController::class, 'nuevoPrograma']);
Route::post('/admin/programa/informacion', [ProgramaController::class, 'informacionPrograma']);
Route::post('/admin/programa/editar', [ProgramaController::class, 'editarPrograma']);
Route::post('/admin/programa/borrar', [ProgramaController::class, 'borrarPrograma']);


// SERVICIO MUNICIPAL
Route::get('/admin/servicio/index', [ServicioController::class,'indexServicio'])->name('admin.servicio.index');
Route::get('/admin/servicio/tabla', [ServicioController::class,'tablaServicio']);
Route::post('/admin/servicio/nuevo', [ServicioController::class, 'nuevoServicio']);
Route::post('/admin/servicio/informacion', [ServicioController::class, 'informacionServicio']);
Route::post('/admin/servicio/editar', [ServicioController::class, 'editarServicio']);
Route::post('/admin/servicio/borrar', [ServicioController::class, 'borrarServicio']);




//*****************************   FRONTEND   ******************************************

Route::get('/', [FrontendController::class,'index']);

Route::get('/servicios',[FrontendController::class,'obtenerTodosServicios']);
Route::get('/servicio/{nombre}',[FrontendController::class,'serviciosPorNombre']);

Route::get('/contravencional',[FrontendController::class,'paginaContravencional']);
Route::get('/downloadc/{nombre}',[FrontendController::class,'descargaContravencional']);

Route::get('/galeria',[FrontendController::class,'todasFotografias']);

Route::get('/noticias', [FrontendController::class,'todasNoticias']);
Route::get('/noticia/{nombre}',[FrontendController::class,'noticiaPorNombre']);
Route::get('/download/{nombre}',[FrontendController::class,'descargarArchivo']);

Route::get('/programas',[FrontendController::class,'todosLosProgramas']);
Route::get('/programa/{nombre}',[FrontendController::class,'programaPorNombre']);

//TU ALCALDIA
Route::get('/historia',[FrontendController::class,'paginaHistoria']);
Route::get('/direccion',[FrontendController::class,'paginaGobierno']);

//REVISTA
//Route::get('/revista','FrontendController@getRevista');



// UCP
Route::post('/admin/informacion-ucp',[ProgramaController::class,'informacionUCP']);




// --- NOTICIAS FRONTEND ---

// --- FINANZAS FRONTEND ---
Route::get('/finanzas', [FrontendController::class,'indexFinanzas']);
Route::get('/descargar/finanzas/documento/{id}', [FrontendController::class,'descargarDocumentoFinanzas']);

// --- COMPRAS FRONTEND ---
Route::get('/compras', [FrontendController::class,'indexCompras'])->name('compras.publicas');
