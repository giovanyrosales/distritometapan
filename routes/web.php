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



Route::get('/', [LoginController::class,'index'])->name('login');

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

