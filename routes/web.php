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

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');;

Route::get('/', 'StoreController@index')->name('welcome');
Route::get('/store/productos', 'StoreController@lista_Productos')->name('store.productos');
Route::get('/store/servicios', 'StoreController@lista_Servicios')->name('store.servicios');

Route::resource('usuarios/deleted', 'Root\Usuario\UsuarioSoftDeleteController',
[
    'names' => [
        'index' => 'usuarios.deleted.index',
        'update' => 'usuarios.deleted.update',
        'destroy' => 'usuarios.deleted.destroy'
    ]
])->middleware('verified');;

Route::resource('usuarios', 'Root\Usuario\UsuarioController')->middleware('verified');;

Route::resource('tipos_medidas/deleted', 'Dato_basico\Tipo_medida\Tipo_medidaSoftDeleteController',
[
    'names' => [
        'index' => 'tipos_medidas.deleted.index',
        'update' => 'tipos_medidas.deleted.update',
        'destroy' => 'tipos_medidas.deleted.destroy'
    ]
])->middleware('verified');;

Route::resource('tipos_medidas', 'Dato_basico\Tipo_medida\Tipo_medidaController')->middleware('verified');;

Route::resource('medidas/deleted', 'Dato_basico\Medida\MedidaSoftDeleteController',
[
    'names' => [
        'index' => 'medidas.deleted.index',
        'update' => 'medidas.deleted.update',
        'destroy' => 'medidas.deleted.destroy'
    ]
]);

Route::resource('medidas', 'Dato_basico\Medida\MedidaController')->middleware('verified');;

Route::resource('especialidades/deleted', 'Clasificacion\Especialidad\EspecialidadSoftDeleteController',
[
    'names' => [
        'index' => 'especialidades.deleted.index',
        'update' => 'especialidades.deleted.update',
        'destroy' => 'especialidades.deleted.destroy'
    ]
]);

Route::resource('especialidades', 'Clasificacion\Especialidad\EspecialidadController');

Route::resource('categorias/deleted', 'Clasificacion\Categoria\CategoriaSoftDeleteController',
[
    'names' => [
        'index' => 'categorias.deleted.index',
        'update' => 'categorias.deleted.update',
        'destroy' => 'categorias.deleted.destroy'
    ]
]);

Route::resource('categorias', 'Clasificacion\Categoria\CategoriaController');

Route::resource('marcas/deleted', 'Comercio\Marca\MarcaSoftDeleteController',
[
    'names' => [
        'index' => 'marcas.deleted.index',
        'update' => 'marcas.deleted.update',
        'destroy' => 'marcas.deleted.destroy'
    ]
]);

Route::resource('marcas', 'Comercio\Marca\MarcaController');

Route::resource('productos/deleted', 'Comercio\ProductoMarca\ProductoSoftDeleteController',
[
    'names' => [
        'index' => 'productos.deleted.index',
        'update' => 'productos.deleted.update',
        'destroy' => 'productos.deleted.destroy'
    ]
]);

Route::resource('productos', 'Comercio\Producto\ProductoController');

Route::resource('clientes/deleted', 'Contacto\Cliente\ClienteSoftDeleteController',
[
    'names' => [
        'index' => 'clientes.deleted.index',
        'update' => 'clientes.deleted.update',
        'destroy' => 'clientes.deleted.destroy'
    ]
]);
Route::resource('clientes', 'Contacto\Cliente\ClienteController');

Route::resource('colaboradores/deleted', 'Contacto\Colaborador\ColaboradorSoftDeleteController',
[
    'names' => [
        'index' => 'colaboradores.deleted.index',
        'update' => 'colaboradores.deleted.update',
        'destroy' => 'colaboradores.deleted.destroy'
    ]
]);

Route::resource('colaboradores', 'Contacto\Colaborador\ColaboradorController');

Route::resource('servicios/deleted', 'Actividad\Servicio\ServicioSoftDeleteController',
[
    'names' => [
        'index' => 'servicios.deleted.index',
        'update' => 'servicios.deleted.update',
        'destroy' => 'servicios.deleted.destroy'
    ]
]);

Route::resource('servicios', 'Actividad\Servicio\ServicioController');

Route::resource('ordenes/deleted', 'Actividad\Orden\OrdenSoftDeleteController',
[
    'names' => [
        'index' => 'ordenes.deleted.index',
        'update' => 'ordenes.deleted.update',
        'destroy' => 'ordenes.deleted.destroy'
    ]
]);

Route::resource('ordenes', 'Actividad\Orden\OrdenController');