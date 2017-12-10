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

Route::group(['domain' => 'tpv.simplepos.dcb', 'namespace' => 'Tpv'], function () {
	// Authentication Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('tpv.login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('tpv.logout');

    // Password Reset Routes...
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('tpv.password.email');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('tpv.password.request');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('tpv.password.reset');

    //Route::group(['middleware' => ['auth']], function () {
    	Route::get('/', 'IndexController@index')->name('tpv.home');
    	Route::get('ventas', 'IndexController@sales')->name('tpv.ventas');
    	Route::get('aparcadas', 'IndexController@parked')->name('tpv.aparcadas');
    	Route::get('venta/{id}', 'IndexController@sale')->name('tpv.venta');
        Route::post('movimiento-efectivo', 'IndexController@processMove')->name('tpv.movimiento-efectivo');
    	Route::get('aparcar-venta', 'IndexController@parkSale')->name('tpv.aparcar-venta');
    	Route::get('recuperar-venta/{id}', 'IndexController@unparkSale')->name('tpv.recuperar-venta');
    	Route::get('cancelar-venta/{id?}', 'IndexController@cancelSale')->name('tpv.cancelar-venta');
    	Route::get('buscar-producto', 'IndexController@searchProduct')->name('tpv.buscar-producto');
    	Route::get('devolucion', 'IndexController@returnSale')->name('tpv.devolucion');
    	Route::get('guardar-venta', 'IndexController@saveSale')->name('tpv.guardar-venta');
    	Route::get('imprimir-venta/{id}', 'IndexController@printSale')->name('tpv.imprimir-venta');

    	Route::get('abrir-caja', 'CashController@openCash')->name('tpv.abrir-caja');
    	Route::post('abrir-caja', 'CashController@processOpenCash');
    	Route::get('cerrar-caja', 'CashController@closeCash')->name('tpv.cerrar-caja');
    	Route::post('cerrar-caja', 'CashController@processCloseCash');
    	Route::get('imprimir-cierre/{id}', 'CashController@printClose')->name('tpv.imprimir-cierre');
    //});
});

/*Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
Route::get('password/email', ['as' => 'password/email', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset/{token}', ['as' => 'password/reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
Route::get('password.reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => ['auth']], function()
{*/
	Route::get('/', ['as' => '/', 'uses' => 'IndexController@index']);
	Route::get('home', ['as' => '/', 'uses' => 'IndexController@index']);
	Route::get('importar', ['as' => 'importar', 'uses' => 'ImportController@index']);
	Route::get('importar/{module}', ['as' => 'importar-form', 'uses' => 'ImportController@import']);
	Route::post('importar/{module}', 'ImportController@processImport');

	// Informes
	Route::get('informes', ['as' => 'informes', 'uses' => 'ReportController@index']);

	// Proveedores
	Route::get('proveedores', ['as' => 'proveedores', 'uses' => 'ProviderController@index']);
	Route::get('nuevo-proveedor', ['as' => 'nuevo-proveedor', 'uses' => 'ProviderController@add']);
	Route::post('nuevo-proveedor', 'ProviderController@save');
	Route::get('editar-proveedor/{id}', ['as' => 'editar-proveedor', 'uses' => 'ProviderController@edit']);
	Route::post('editar-proveedor', 'ProviderController@update');
	Route::get('eliminar-proveedor/{id}', 'ProviderController@delete');
	Route::post('eliminar-proveedores', 'ProviderController@deleteMultiple');

	// Pedidos
	Route::get('pedidos', ['as' => 'pedidos', 'uses' => 'OrderController@index']);
	Route::get('nuevo-pedido', ['as' => 'nuevo-pedido', 'uses' => 'OrderController@add']);
	Route::post('nuevo-pedido', 'OrderController@save');
	Route::get('editar-pedido/{id}', ['as' => 'editar-pedido', 'uses' => 'OrderController@edit']);
	Route::post('editar-pedido', 'OrderController@update');
	Route::get('eliminar-pedido/{id}', 'OrderController@delete');
	Route::post('eliminar-pedidos', 'OrderController@deleteMultiple');
	Route::get('imprimir-pedido/{id}', ['as' => 'imprimir-pedido', 'uses' => 'OrderController@print']);

	// Productos
	Route::get('productos', ['as' => 'productos', 'uses' => 'ProductController@index']);
	Route::get('nuevo-producto', ['as' => 'nuevo-producto', 'uses' => 'ProductController@add']);
	Route::post('nuevo-producto', 'ProductController@save');
	Route::get('editar-producto/{id}', ['as' => 'editar-producto', 'uses' => 'ProductController@edit']);
	Route::post('editar-producto', 'ProductController@update');
	Route::get('eliminar-producto/{id}', 'ProductController@delete');
	Route::post('eliminar-productos', 'ProductController@deleteMultiple');
	Route::post('activar-productos', 'ProductController@activateMultiple');
	Route::post('desactivar-productos', 'ProductController@deactivateMultiple');
	Route::get('buscar-productos', 'ProductController@search');
	Route::get('eliminar-producto-relacionado', 'ProductController@deleteRelated');
	Route::get('subir-producto/{id}', 'ProductController@moveUp');
	Route::get('bajar-producto/{id}', 'ProductController@moveDown');

	// Ventas
	Route::get('ventas', ['as' => 'ventas', 'uses' => 'SaleController@index']);
	Route::get('nueva-venta', ['as' => 'nueva-venta', 'uses' => 'SaleController@add']);
	Route::post('nueva-venta', 'SaleController@save');
	Route::get('editar-venta/{id}', ['as' => 'editar-venta', 'uses' => 'SaleController@edit']);
	Route::post('editar-venta', 'SaleController@update');
	Route::get('eliminar-venta/{id}', 'SaleController@delete');
	Route::post('eliminar-ventas', 'SaleController@deleteMultiple');
	Route::get('exportar-venta/{id}', 'SaleController@export');

	// Usuarios
	Route::get('usuarios', ['as' => 'usuarios', 'uses' => 'UserController@index']);
	Route::get('nuevo-usuario', ['as' => 'nuevo-usuario', 'uses' => 'UserController@add']);
	Route::post('nuevo-usuario', 'UserController@save');
	Route::get('editar-usuario/{id}', ['as' => 'editar-usuario', 'uses' => 'UserController@edit']);
	Route::post('editar-usuario', 'UserController@update');
	Route::get('eliminar-usuario/{id}', 'UserController@delete');
	Route::post('eliminar-usuarios', 'UserController@deleteMultiple');

	// Archivos
	Route::post('file-upload', 'FileController@upload');
	Route::get('descargar-archivo/{id}', 'FileController@download');
	Route::get('eliminar-archivo/{id}', 'FileController@delete');
	Route::get('renombrar-archivo/{id}', 'FileController@rename');
	Route::get('limpiar-archivos', 'FileController@clear');
	Route::post('orden-galeria', 'ImageController@saveOrder');

//});
