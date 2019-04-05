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
Route::get('/store/productos', 'StoreController@lista_productos')->name('store.productos');
Route::get('/store/servicios', 'StoreController@lista_servicios')->name('store.servicios');
Route::get('/store/productos/{id}', 'StoreController@show_producto')->name('store.productos.show');
Route::get('/store/servicios/{id}', 'StoreController@show_servicio')->name('store.servicios.show');
Route::get('/store/cart/productos', 'StoreController@cart_productos')->name('store.productos.cart');
Route::get('/store/cart/servicios', 'StoreController@cart_servicios')->name('store.servicios.cart');
Route::post('/store/cart/productos/{id}', 'StoreController@add_cart_productos')->name('store.productos.cart.add');
Route::post('/store/cart/servicios/{id}', 'StoreController@add_cart_servicios')->name('store.servicios.cart.add');
Route::delete('/store/cart/productos/{id}', 'StoreController@delete_cart_productos')->name('store.productos.cart.delete');
Route::delete('/store/cart/servicios/{id}', 'StoreController@delete_cart_servicios')->name('store.servicios.cart.delete');
Route::post('/store/solicitud', 'StoreController@register_solicitud')->name('store.register.solicitud');
Route::post('/store/venta', 'StoreController@register_venta')->name('store.register.venta');

Route::get('/home/{estado?}', 'HomeController@index')->name('home');


Route::get('/profile','ProfileController@index')->name('profile');
Route::put('/profile/upload/imagen/{id}', ['uses' => 'ProfileController@upload_imagen', 'as' => 'profile.uploadImagen']);


Route::resource('usuarios/deleted', 'Root\Usuario\UsuarioSoftDeleteController',
[
    'names' => [
        'index' => 'usuarios.deleted.index',
        'update' => 'usuarios.deleted.update',
        'destroy' => 'usuarios.deleted.destroy'
    ]
]);

Route::resource('usuarios', 'Root\Usuario\UsuarioController');


Route::resource('tipos_medidas/deleted', 'Dato_basico\Tipo_medida\Tipo_medidaSoftDeleteController',
[
    'names' => [
        'index' => 'tipos_medidas.deleted.index',
        'update' => 'tipos_medidas.deleted.update',
        'destroy' => 'tipos_medidas.deleted.destroy'
    ]
]);

Route::resource('tipos_medidas', 'Dato_basico\Tipo_medida\Tipo_medidaController');


Route::resource('medidas/deleted', 'Dato_basico\Medida\MedidaSoftDeleteController',
[
    'names' => [
        'index' => 'medidas.deleted.index',
        'update' => 'medidas.deleted.update',
        'destroy' => 'medidas.deleted.destroy'
    ]
]);

Route::resource('medidas', 'Dato_basico\Medida\MedidaController');

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


Route::resource('productos/deleted', 'Comercio\Producto\ProductoSoftDeleteController',
[
    'names' => [
        'index' => 'productos.deleted.index',
        'update' => 'productos.deleted.update',
        'destroy' => 'productos.deleted.destroy'
    ]
]);

Route::resource('productos', 'Comercio\Producto\ProductoController');

Route::get('/productos/test/referencias', ['uses' => 'Comercio\Producto\ProductoController@test_referencias', 'as' => 'productos.testReferencias']);

Route::get('/productos/load/referencias/{id}', ['uses' => 'Comercio\Producto\ProductoController@load_referencias', 'as' => 'productos.loadReferencias']);

Route::get('/productos/load/imagenes/{id}', ['uses' => 'Comercio\Producto\ProductoController@load_imagenes', 'as' => 'productos.loadImagenes']);

Route::get('/productos/load/row/imagenes/{id}', ['uses' => 'Comercio\Producto\ProductoController@load_row_imagenes', 'as' => 'productos.loadRowImagenes']);

Route::post('/productos/upload/imagenes/{id}', ['uses' => 'Comercio\Producto\ProductoController@upload_imagenes', 'as' => 'productos.uploadImagenes']);

Route::delete('/productos/delete/imagenes/{id}', ['uses' => 'Comercio\Producto\ProductoController@delete_imagenes', 'as' => 'productos.deleteImagenes']);


Route::resource('compras/deleted', 'Comercio\Compra\CompraSoftDeleteController',
[
    'names' => [
        'index' => 'compras.deleted.index',
        'update' => 'compras.deleted.update',
        'destroy' => 'compras.deleted.destroy'
    ]
]);

Route::resource('compras', 'Comercio\Compra\CompraController');

Route::get('/compras/detalles/{id}', ['uses' => 'Comercio\Compra\CompraController@get_detalles', 'as' => 'compras.getDetalles']);
Route::get('/compras/detalles/form/{id}/{editar}', ['uses' => 'Comercio\Compra\CompraController@form_detalles', 'as' => 'compras.formDetalles']);
Route::get('/compras/detalles/productos/{id}/{editar}', ['uses' => 'Comercio\Compra\CompraController@get_productos', 'as' => 'compras.getProductos']);
Route::get('/compras/detalles/proveedores/{id}/{editar}', ['uses' => 'Comercio\Compra\CompraController@get_proveedores', 'as' => 'compras.getProveedores']);
Route::post('/compras/detalles/add', ['uses' => 'Comercio\Compra\CompraController@add_detalles', 'as' => 'compras.addDetalles']);
Route::put('/compras/detalles/update/{id}', ['uses' => 'Comercio\Compra\CompraController@update_detalles', 'as' => 'compras.updateDetalles']);
Route::put('/compras/detalles/state/{id}', ['uses' => 'Comercio\Compra\CompraController@state_detalles', 'as' => 'compras.stateDetalles']);
Route::delete('/compras/detalles/delete/{id}', ['uses' => 'Comercio\Compra\CompraController@delete_detalles', 'as' => 'compras.deleteDetalles']);


Route::get('ventas/index/{estado?}', ['uses' => 'Comercio\Venta\VentaController@index', 'as' => 'ventas.index']);

Route::get('/ventas/create/{fecha?}', ['uses' => 'Comercio\Venta\VentaController@create', 'as' => 'ventas.create']);

Route::resource('ventas/deleted', 'Comercio\Venta\CompraSoftDeleteController',
[
    'names' => [
        'index' => 'ventas.deleted.index',
        'update' => 'ventas.deleted.update',
        'destroy' => 'ventas.deleted.destroy'
    ]
]);

Route::resource('ventas', 'Comercio\Venta\VentaController',
[
    'except' => ['index','create']
]);

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

Route::get('/colaboradores/servicios/{id}/{isSearching}', ['uses' => 'Contacto\Colaborador\ColaboradorController@get_servicios', 'as' => 'colaboladores.getServicios']);
Route::post('/colaboradores/servicios/add', ['uses' => 'Contacto\Colaborador\ColaboradorController@add_servicios', 'as' => 'colaboladores.addServicios']);
Route::delete('/colaboradores/servicios/delete', ['uses' => 'Contacto\Colaborador\ColaboradorController@delete_servicios', 'as' => 'colaboladores.deleteServicios']);

Route::resource('proveedores/deleted', 'Contacto\Proveedor\ProveedorSoftDeleteController',
[
    'names' => [
        'index' => 'proveedores.deleted.index',
        'update' => 'proveedores.deleted.update',
        'destroy' => 'proveedores.deleted.destroy'
    ]
]);

Route::resource('proveedores', 'Contacto\Proveedor\ProveedorController');

Route::get('/proveedores/productos/{id}/{isSearching}', ['uses' => 'Contacto\Proveedor\ProveedorController@get_productos', 'as' => 'proveedores.getProductos']);
Route::post('/proveedores/productos/add', ['uses' => 'Contacto\Proveedor\ProveedorController@add_productos', 'as' => 'proveedores.addProductos']);
Route::delete('/proveedores/productos/delete', ['uses' => 'Contacto\Proveedor\ProveedorController@delete_productos', 'as' => 'proveedores.deleteProductos']);



Route::resource('servicios/deleted', 'Actividad\Servicio\ServicioSoftDeleteController',
[
    'names' => [
        'index' => 'servicios.deleted.index',
        'update' => 'servicios.deleted.update',
        'destroy' => 'servicios.deleted.destroy'
    ]
]);

Route::resource('servicios', 'Actividad\Servicio\ServicioController');

Route::get('/servicios/detalles/{id}', ['uses' => 'Actividad\Servicio\ServicioController@get_servicios_detalles', 'as' => 'servicios.getServiciosDetalles']);

Route::get('/servicios/load/imagenes/{id}', ['uses' => 'Actividad\Servicio\ServicioController@load_imagenes', 'as' => 'servicios.loadImagenes']);

Route::get('/servicios/load/row/imagenes/{id}', ['uses' => 'Actividad\Servicio\ServicioController@load_row_imagenes', 'as' => 'servicios.loadRowImagenes']);

Route::post('/servicios/upload/imagenes/{id}', ['uses' => 'Actividad\Servicio\ServicioController@upload_imagenes', 'as' => 'servicios.uploadImagenes']);

Route::delete('/servicios/delete/imagenes/{id}', ['uses' => 'Actividad\Servicio\ServicioController@delete_imagenes', 'as' => 'servicios.deleteImagenes']);


Route::get('/ordenes/index/{estado?}', ['uses' => 'Actividad\Orden\OrdenController@index', 'as' => 'ordenes.index']);
Route::get('/ordenes/create/{fecha?}', ['uses' => 'Actividad\Orden\OrdenController@create', 'as' => 'ordenes.create']);

Route::get('/ordenes/deleted/index/{estado?}', ['uses' => 'Actividad\Orden\OrdenSoftDeleteController@index', 'as' => 'ordenes.deleted.index']);

Route::resource('ordenes/deleted', 'Actividad\Orden\OrdenSoftDeleteController',
[
    'names' => [
        'update' => 'ordenes.deleted.update',
        'destroy' => 'ordenes.deleted.destroy'
    ]
]);


Route::resource('ordenes', 'Actividad\Orden\OrdenController',
[
    'except' => ['index','create']
]);

Route::get('/ordenes/detalles/{id}', ['uses' => 'Actividad\Orden\OrdenController@get_detalles', 'as' => 'ordenes.getDetalles']);
Route::get('/ordenes/detalles/form/{id}/{editar}', ['uses' => 'Actividad\Orden\OrdenController@form_detalles', 'as' => 'ordenes.formDetalles']);
Route::get('/ordenes/detalles/servicios/{id}/{editar}', ['uses' => 'Actividad\Orden\OrdenController@get_servicios', 'as' => 'ordenes.getServicios']);
Route::get('/ordenes/detalles/colaboradores/{id}/{editar}', ['uses' => 'Actividad\Orden\OrdenController@get_colaboradores', 'as' => 'ordenes.getColaboradores']);
Route::post('/ordenes/detalles/add', ['uses' => 'Actividad\Orden\OrdenController@add_detalles', 'as' => 'ordenes.addDetalles']);
Route::put('/ordenes/detalles/update/{id}', ['uses' => 'Actividad\Orden\OrdenController@update_detalles', 'as' => 'ordenes.updateDetalles']);
Route::put('/ordenes/detalles/state/{id}', ['uses' => 'Actividad\Orden\OrdenController@state_detalles', 'as' => 'ordenes.stateDetalles']);
Route::delete('/ordenes/detalles/delete/{id}', ['uses' => 'Actividad\Orden\OrdenController@delete_detalles', 'as' => 'ordenes.deleteDetalles']);

Route::get('/solicitudes/index/{estado?}', ['uses' => 'Actividad\Solicitud\SolicitudController@index', 'as' => 'solicitudes.index']);
Route::get('/solicitudes/{id}', ['uses' => 'Actividad\Solicitud\SolicitudController@show', 'as' => 'solicitudes.show']);
Route::post('/solicitudes/{id}', ['uses' => 'Actividad\Solicitud\SolicitudController@approve', 'as' => 'solicitudes.approve']);
Route::put('/solicitudes/{id}', ['uses' => 'Actividad\Solicitud\SolicitudController@cancel', 'as' => 'solicitudes.cancel']);

Route::get('/cliente/compras/pay', ['uses' => 'Comercio\Venta\VentaController@pay', 'as' => 'compras.pay']);
Route::put('/cliente/compras/{id}', ['uses' => 'Comercio\Venta\VentaController@cancel', 'as' => 'compras.cancel']);

Route::get('/cliente/compras/{id}/{estado?}', ['uses' => 'Comercio\Venta\VentaController@info', 'as' => 'compras.info']);
