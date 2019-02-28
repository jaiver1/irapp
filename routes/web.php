<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['verify' => true]);


Route::get('/', 'StoreController@index')->name('welcome');
Route::get('/store/productos', 'StoreController@lista_Productos')->name('store.productos');
Route::get('/store/servicios', 'StoreController@lista_Servicios')->name('store.servicios');


Route::get('/home/{estado?}', 'HomeController@index')->name('home')->middleware('verified');


Route::get('/profile','ProfileController@index')->name('profile')->middleware('verified');
Route::put('/profile/upload/imagen/{id}', ['uses' => 'ProfileController@upload_imagen', 'as' => 'profile.uploadImagen'])->middleware('verified');


Route::resource('usuarios/deleted', 'Root\Usuario\UsuarioSoftDeleteController',
[
    'names' => [
        'index' => 'usuarios.deleted.index',
        'update' => 'usuarios.deleted.update',
        'destroy' => 'usuarios.deleted.destroy'
    ]
])->middleware('verified');

Route::resource('usuarios', 'Root\Usuario\UsuarioController')->middleware('verified');


Route::resource('tipos_medidas/deleted', 'Dato_basico\Tipo_medida\Tipo_medidaSoftDeleteController',
[
    'names' => [
        'index' => 'tipos_medidas.deleted.index',
        'update' => 'tipos_medidas.deleted.update',
        'destroy' => 'tipos_medidas.deleted.destroy'
    ]
])->middleware('verified');

Route::resource('tipos_medidas', 'Dato_basico\Tipo_medida\Tipo_medidaController')->middleware('verified');


Route::resource('medidas/deleted', 'Dato_basico\Medida\MedidaSoftDeleteController',
[
    'names' => [
        'index' => 'medidas.deleted.index',
        'update' => 'medidas.deleted.update',
        'destroy' => 'medidas.deleted.destroy'
    ]
])->middleware('verified');

Route::resource('medidas', 'Dato_basico\Medida\MedidaController')->middleware('verified');


Route::resource('especialidades/deleted', 'Clasificacion\Especialidad\EspecialidadSoftDeleteController',
[
    'names' => [
        'index' => 'especialidades.deleted.index',
        'update' => 'especialidades.deleted.update',
        'destroy' => 'especialidades.deleted.destroy'
    ]
])->middleware('verified');

Route::resource('especialidades', 'Clasificacion\Especialidad\EspecialidadController')->middleware('verified');


Route::resource('categorias/deleted', 'Clasificacion\Categoria\CategoriaSoftDeleteController',
[
    'names' => [
        'index' => 'categorias.deleted.index',
        'update' => 'categorias.deleted.update',
        'destroy' => 'categorias.deleted.destroy'
    ]
])->middleware('verified');

Route::resource('categorias', 'Clasificacion\Categoria\CategoriaController')->middleware('verified');


Route::resource('marcas/deleted', 'Comercio\Marca\MarcaSoftDeleteController',
[
    'names' => [
        'index' => 'marcas.deleted.index',
        'update' => 'marcas.deleted.update',
        'destroy' => 'marcas.deleted.destroy'
    ]
])->middleware('verified');

Route::resource('marcas', 'Comercio\Marca\MarcaController')->middleware('verified');


Route::resource('productos/deleted', 'Comercio\Producto\ProductoSoftDeleteController',
[
    'names' => [
        'index' => 'productos.deleted.index',
        'update' => 'productos.deleted.update',
        'destroy' => 'productos.deleted.destroy'
    ]
])->middleware('verified');

Route::resource('productos', 'Comercio\Producto\ProductoController')->middleware('verified');

Route::get('/productos/test/referencias', ['uses' => 'Comercio\Producto\ProductoController@test_referencias', 'as' => 'productos.testReferencias'])->middleware('verified');

Route::get('/productos/load/referencias/{id}', ['uses' => 'Comercio\Producto\ProductoController@load_referencias', 'as' => 'productos.loadReferencias'])->middleware('verified');

Route::get('/productos/load/imagenes/{id}', ['uses' => 'Comercio\Producto\ProductoController@load_imagenes', 'as' => 'productos.loadImagenes'])->middleware('verified');

Route::get('/productos/load/row/imagenes/{id}', ['uses' => 'Comercio\Producto\ProductoController@load_row_imagenes', 'as' => 'productos.loadRowImagenes'])->middleware('verified');

Route::post('/productos/upload/imagenes/{id}', ['uses' => 'Comercio\Producto\ProductoController@upload_imagenes', 'as' => 'productos.uploadImagenes'])->middleware('verified');

Route::delete('/productos/delete/imagenes/{id}', ['uses' => 'Comercio\Producto\ProductoController@delete_imagenes', 'as' => 'productos.deleteImagenes'])->middleware('verified');


Route::resource('clientes/deleted', 'Contacto\Cliente\ClienteSoftDeleteController',
[
    'names' => [
        'index' => 'clientes.deleted.index',
        'update' => 'clientes.deleted.update',
        'destroy' => 'clientes.deleted.destroy'
    ]
])->middleware('verified');
Route::resource('clientes', 'Contacto\Cliente\ClienteController')->middleware('verified');


Route::resource('colaboradores/deleted', 'Contacto\Colaborador\ColaboradorSoftDeleteController',
[
    'names' => [
        'index' => 'colaboradores.deleted.index',
        'update' => 'colaboradores.deleted.update',
        'destroy' => 'colaboradores.deleted.destroy'
    ]
])->middleware('verified');

Route::resource('colaboradores', 'Contacto\Colaborador\ColaboradorController')->middleware('verified');

Route::get('/colaboradores/servicios/{id}/{isSearching}', ['uses' => 'Contacto\Colaborador\ColaboradorController@get_servicios', 'as' => 'colaboladores.getServicios'])->middleware('verified');
Route::post('/colaboradores/servicios/add', ['uses' => 'Contacto\Colaborador\ColaboradorController@add_servicios', 'as' => 'colaboladores.addServicios'])->middleware('verified');
Route::delete('/colaboradores/servicios/delete', ['uses' => 'Contacto\Colaborador\ColaboradorController@delete_servicios', 'as' => 'colaboladores.deleteServicios'])->middleware('verified');


Route::resource('servicios/deleted', 'Actividad\Servicio\ServicioSoftDeleteController',
[
    'names' => [
        'index' => 'servicios.deleted.index',
        'update' => 'servicios.deleted.update',
        'destroy' => 'servicios.deleted.destroy'
    ]
])->middleware('verified');

Route::resource('servicios', 'Actividad\Servicio\ServicioController')->middleware('verified');

Route::get('/servicios/detalles/{id}', ['uses' => 'Actividad\Servicio\ServicioController@get_servicios_detalles', 'as' => 'servicios.getServiciosDetalles'])->middleware('verified');

Route::get('/ordenes/index/{estado?}', ['uses' => 'Actividad\Orden\OrdenController@index', 'as' => 'ordenes.index'])->middleware('verified');
Route::get('/ordenes/create/{fecha?}', ['uses' => 'Actividad\Orden\OrdenController@create', 'as' => 'ordenes.create'])->middleware('verified');

Route::resource('ordenes/deleted', 'Actividad\Orden\OrdenSoftDeleteController',
[
    'names' => [
        'update' => 'ordenes.deleted.update',
        'destroy' => 'ordenes.deleted.destroy'
    ]
])->middleware('verified');

Route::get('/ordenes/deleted/index/{estado?}', ['uses' => 'Actividad\Orden\OrdenSoftDeleteController@index', 'as' => 'ordenes.deleted.index'])->middleware('verified');

Route::resource('ordenes', 'Actividad\Orden\OrdenController',
[
    'except' => ['index','create']
])->middleware('verified');

Route::get('/ordenes/detalles/{id}', ['uses' => 'Actividad\Orden\OrdenController@get_detalles', 'as' => 'ordenes.getDetalles'])->middleware('verified');
Route::get('/ordenes/detalles/form/{id}/{editar}', ['uses' => 'Actividad\Orden\OrdenController@form_detalles', 'as' => 'ordenes.formDetalles'])->middleware('verified');
Route::get('/ordenes/detalles/servicios/{id}/{editar}', ['uses' => 'Actividad\Orden\OrdenController@get_servicios', 'as' => 'ordenes.getServicios'])->middleware('verified');
Route::get('/ordenes/detalles/colaboradores/{id}/{editar}', ['uses' => 'Actividad\Orden\OrdenController@get_colaboradores', 'as' => 'ordenes.getColaboradores'])->middleware('verified');
Route::post('/ordenes/detalles/add', ['uses' => 'Actividad\Orden\OrdenController@add_detalles', 'as' => 'ordenes.addDetalles'])->middleware('verified');
Route::put('/ordenes/detalles/update/{id}', ['uses' => 'Actividad\Orden\OrdenController@update_detalles', 'as' => 'ordenes.updateDetalles'])->middleware('verified');
