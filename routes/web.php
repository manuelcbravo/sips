<?php

use Illuminate\Support\Facades\Route;

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

Route::post('loginEncrypt', 'Auth\\AuthController@customLogin')->name('logincustom');
Route::post('logoutEncrypt', 'Auth\\AuthController@LogOut')->name('logoutcustom');
Route::get('/read-xml', 'XmlController@getXml');
Route::get('prueba_impresora', 'PruebasController@Impresora');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => 'checkRole:1'], function () {
        Route::get('/', 'DashboardController@index_general');
    });

    Route::group(['middleware' => 'checkRole:1'], function () {
        Route::resource('lineas', CatLinea::class)->name('lineas', '*');
        Route::get('lineasL', 'CatLinea@getData');
        Route::resource('marcas', CatMarca::class)->name('marcas', '*');
        Route::get('marcasL', 'CatMarca@getData');

        Route::resource('empresa', EmpresaController::class)->name('empresa', '*');
    });

    Route::resource('usuarios', UsersController::class)->name('usuarios', '*');
    Route::post('usuarios/actualizar', 'UsersController@actualizar');
    Route::get('perfil', 'UsersController@index_perfil')->name('perfil.index');
    Route::get('usersL', 'UsersController@getUsuarios');

    Route::resource('clientes', TblClienteController::class)->name('clientes', '*');
    Route::get('clientesL', 'TblClienteController@getClientes');
    Route::get('buscar_cliente/{key}','TblClienteController@getCliente');

    ///////////// Egresos //////////////////////
    Route::resource('egresos', TblEgresoController::class)->name('egresos', '*');
    Route::get('egresosL', 'TblEgresoController@getEgresos');
    //////////////////////////////////////////////////////////////

    ///////////// ingresos //////////////////////
    Route::resource('ingresos', TblIngresoController::class)->name('ingresos', '*');
    Route::get('ingresosL', 'TblIngresoController@getIngresos');
    ////////////////////////////////////////////////////////////////


    ////////////////////////////////////////////////////////////////Inventarios//////////////////////////////////////////
    Route::resource('productos', TblProductoController::class)->name('productos', '*');
    Route::post('productosL', 'TblProductoController@getProductos');
    Route::get('productos/buscar/{id}', 'TblProductoController@getProducto');

//articulo
    Route::resource('articulos', TblArticuloController::class)->name('articulos', '*');
    Route::post('articulosL', 'TblArticuloController@getData');
    Route::get('articulos/buscar/{id}', 'TblArticuloController@getArticulo');
    Route::get('buscar_articulo/{key}','TblArticuloController@getArticulosBuscar');

    //inventario
    Route::resource('inventarios', TblInventarioSucursaleController::class)->name('inventarios', '*');
    Route::post('inventarioL/{id_sucursal}/{id_almacen}', 'TblInventarioSucursaleController@getData');

    //inventario movimientos
    Route::resource('movimientos', TblInventarioMovimientoController::class)->name('movimientos', '*');
    Route::post('inventario_movimientos/{id_sucursal}', 'TblInventarioMovimientoController@getData');
    Route::post('ajuste_inventario', 'TblInventarioMovimientoController@setAjuste');
    Route::post('traspaso_inventario', 'TblInventarioMovimientoController@setTraspaso');


    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////ventas//////////////////////////////////////////
    Route::resource('ventas', TblVentaController::class)->name('ventas','*');
    Route::get('ventasL','TblVentaController@getVentas');
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////compras//////////////////////////////////////////

    /////////////////// compras //////////////////////
    Route::resource('compras', TblComprasController::class)->name('compras','*');
    Route::post('compras_upload_xml','TblComprasController@setXML');
    Route::get('comprasL','TblComprasController@getCompras');

    /////////////////// detalles_compras //////////////////////
    Route::resource('detalle_compras', TblComprasDetalleController::class)->name('detalle_compras','*');
    Route::get('compras_detalle/{id}','TblComprasDetalleController@getComprasDetalle');
    Route::get('compras_nuevo/{id}','TblComprasDetalleController@getCompraNuevo');
    Route::post('compras_nuevo','TblComprasDetalleController@setCompraNuevo');
    Route::post('compras_cambio','TblComprasDetalleController@setCompraCambio');
    Route::post('compras_articulo','TblComprasDetalleController@setCompraArticulo');
    Route::get('compra_traspaso/{id}','TblComprasDetalleController@getTraspaso');
    Route::post('compra_traspaso','TblComprasDetalleController@setTraspaso');

    // pago compras //
    Route::resource('pago_compras', TblComprasPagoController::class)->name('pago_compras','*');
    Route::get('pago_comprasT/{id}','TblComprasPagoController@getPagos');

    /////////////////////////////////////////

    /////////////////// proveedores //////////////////////
    Route::resource('proveedores', TblProveedoresController::class)->name('proveedores','*');
    Route::get('proveedoresL','TblProveedoresController@getProveedores');
    Route::get('buscar_proveedor/{key}','TblProveedoresController@getProveedor');
    /////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////catalogos//////////////////////////////////////////

    /////////////////// sucursales //////////////////////
    Route::resource('sucursales', TblSucursalController::class)->name('sucursales','*');
    Route::get('sucursalesL','TblSucursalController@getsucursal');
    /////////////////////////////////////////

    /////////////////// bancos //////////////////////
    Route::resource('bancos', TblBancoController::class)->name('bancos','*');
    Route::get('bancosL','TblBancoController@getBancos');
    /////////////////////////////////////////

    /////////////////// almacen //////////////////////
    Route::resource('almacen', TblAlmaceneController::class)->name('almacen','*');
    Route::get('almacenL','TblAlmaceneController@getAlmacen');
    /////////////////////////////////////////

    /////////////////// proveedores //////////////////////
    Route::resource('proveedores', TblProveedoresController::class)->name('proveedores','*');
    Route::get('proveedoresL','TblProveedoresController@getProveedores');
    /////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //////////////// Seguimientos //////////////////////
    Route::resource('seguimiento', TblSeguimientoController::class)->name('seguimiento', '*');
    Route::get('seguimientoL/{id}/{table}', 'TblSeguimientoController@getSeguimiento');
    /////////////////////////////////////////

    /// ///////////// Archivos //////////////////////
    Route::resource('archivos', TblArchivoController::class)->name('archivos', '*');
    Route::get('archivosL/{id}/{car}/{table}', 'TblArchivoController@getArchivo');
    Route::get('archivos/{id}', 'TblArchivoController@getArchivoT');
    Route::post('archivos_rename', 'TblArchivoController@setRename');
    Route::post('archivos_tipo', 'TblArchivoController@setTipo');
    Route::post('archivos_tipo2', 'ContratoController@setTipo');
    Route::delete('del_archivos_tipo2/{id}', 'ContratoController@destroy');
    Route::get('documentos/{path}/{filename}', 'TblArchivoController@getDocumentos');
    /////////////////////////////////////////

    Route::resource('fotos', TblFotoController::class)->name('fotos', '*');
    Route::post('articulosFoto/', 'TblFotoController@setFoto');
    Route::post('articulosFotosDel/', 'TblFotoController@setPhotosDelete');

    ///////////config y helper /////////////7
    Route::get('catalogos', 'HelperController@getCatalogos');
    Route::get('sucursales_h/{id}', 'HelperController@getSucuralAlmacenes');
    Route::get('cp/{id}', 'HelperController@getCp');
    Route::get('barcode/{id}', 'HelperController@getBarcode');

});
