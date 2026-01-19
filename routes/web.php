<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\RecepcionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibroDiarioController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ApartadoController;
use App\Http\Controllers\HistorialController;

// Autenticación
Route::middleware(['web'])->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/logear', [AuthController::class, 'logear'])->name('logear');
});

// Utilidades de desarrollo
Route::get('/clear-cache', function() {
    \Artisan::call('config:clear');
    \Artisan::call('route:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    return 'Cache limpiado. <a href="/">Ir al login</a>';
});

Route::get('/run-migrations', function() {
    try {
        \Artisan::call('migrate', ['--force' => true]);
        $output = \Artisan::output();
        
        $user = \App\Models\User::where('email', 'admin@admin.com')->first();
        if (!$user) {
            \App\Models\User::create([
                'name' => 'Admin',
                'nombre' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => \Hash::make('12345678'),
                'rol' => 'Gerente',
            ]);
        }
        
        return 'Migraciones ejecutadas y usuario admin creado.<br><pre>' . $output . '</pre><br><a href="/">Ir al login</a>';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});


Route::middleware("auth")->group(function () {
    Route::get('/home', [Dashboard::class, 'index'])->name('dashboard.index');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::prefix('clientes')->middleware('auth')->group(function () {
    Route::get('/', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/create', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/{cliente}', [ClienteController::class, 'show'])->name('clientes.show');
    Route::get('/{cliente}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
});


Route::prefix('recepciones')->middleware('auth')->group(function () {
    Route::get('{recepcion}/pdf', [RecepcionController::class, 'generatePdf'])->name('recepciones.pdf');
    Route::get('/', [RecepcionController::class, 'index'])->name('recepciones.index');
    Route::get('/create', [RecepcionController::class, 'create'])->name('recepciones.create');
    Route::post('/', [RecepcionController::class, 'store'])->name('recepciones.store');
    Route::get('/{recepcion}', [RecepcionController::class, 'show'])->name('recepciones.show');
    Route::get('/{recepcion}/edit', [RecepcionController::class, 'edit'])->name('recepciones.edit');
    Route::put('/{recepcion}', [RecepcionController::class, 'update'])->name('recepciones.update');
    Route::delete('/{recepcion}', [RecepcionController::class, 'destroy'])->name('recepciones.destroy');
});


 
Route::prefix('equipos')->middleware('auth')->group(function () {
    Route::get('/', [EquipoController::class, 'index'])->name('equipos.index');
    Route::get('/create', [EquipoController::class, 'create'])->name('equipos.create');
    Route::post('/', [EquipoController::class, 'store'])->name('equipos.store');
    Route::get('/{equipo}', [EquipoController::class, 'show'])->name('equipos.show');
    Route::get('/{equipo}/edit', [EquipoController::class, 'edit'])->name('equipos.edit');
    Route::put('/{equipo}', [EquipoController::class, 'update'])->name('equipos.update');
    Route::delete('/{equipo}', [EquipoController::class, 'destroy'])->name('equipos.destroy');
});

Route::prefix('usuarios')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\UsuariosController::class, 'index'])->name('usuarios.index');
    Route::get('/create', [\App\Http\Controllers\UsuariosController::class, 'create'])->name('usuarios.create');
    Route::post('/', [\App\Http\Controllers\UsuariosController::class, 'store'])->name('usuarios.store');
    Route::get('/{usuario}', [\App\Http\Controllers\UsuariosController::class, 'show'])->name('usuarios.show');
    Route::get('/{usuario}/edit', [\App\Http\Controllers\UsuariosController::class, 'edit'])->name('usuarios.edit');
    Route::put('/{usuario}', [\App\Http\Controllers\UsuariosController::class, 'update'])->name('usuarios.update');
    Route::delete('/{usuario}', [\App\Http\Controllers\UsuariosController::class, 'destroy'])->name('usuarios.destroy');
    Route::patch('/{id}/toggle', [\App\Http\Controllers\UsuariosController::class, 'toggle'])->name('usuarios.toggle');
});

Route::prefix('cotizaciones')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\CotizacionController::class, 'index'])->name('cotizaciones.index');
    Route::get('/create', [\App\Http\Controllers\CotizacionController::class, 'create'])->name('cotizaciones.create');
    Route::get('/create-from-recepcion/{id}', [\App\Http\Controllers\CotizacionController::class, 'createFromRecepcion'])->name('cotizaciones.createFromRecepcion');
    Route::post('/{id}', [\App\Http\Controllers\CotizacionController::class, 'store'])->name('cotizaciones.store');
    Route::get('/{id}/edit', [\App\Http\Controllers\CotizacionController::class, 'edit'])->name('cotizaciones.edit');
    Route::get('/{id}/show', [\App\Http\Controllers\CotizacionController::class, 'show'])->name('cotizaciones.show');
    Route::put('/{id}', [\App\Http\Controllers\CotizacionController::class, 'update'])->name('cotizaciones.update');
    Route::get('/{id}/pdf', [\App\Http\Controllers\CotizacionController::class, 'generarPdf'])->name('cotizaciones.pdf');
    Route::delete('/{id}', [\App\Http\Controllers\CotizacionController::class, 'destroy'])->name('cotizaciones.destroy');
});
 Route::prefix('contabilidad/ingresos')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\IngresosController::class, 'index'])->name('ingresos.index');
    Route::get('/create', [\App\Http\Controllers\IngresosController::class, 'create'])->name('ingresos.create');
    Route::post('/', [\App\Http\Controllers\IngresosController::class, 'store'])->name('ingresos.store');
    Route::get('/{id}/edit', [\App\Http\Controllers\IngresosController::class, 'edit'])->name('ingresos.edit');
    Route::put('/{id}', [\App\Http\Controllers\IngresosController::class, 'update'])->name('ingresos.update');
    Route::delete('/{id}', [\App\Http\Controllers\IngresosController::class, 'destroy'])->name('ingresos.destroy');
    Route::get('/{id}/show', [\App\Http\Controllers\IngresosController::class, 'show'])->name('ingresos.show');
    
});
Route::prefix('contabilidad/egresos')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\EgresosController::class, 'index'])->name('egresos.index');
    Route::get('/create', [\App\Http\Controllers\EgresosController::class, 'create'])->name('egresos.create');
    Route::post('/', [\App\Http\Controllers\EgresosController::class, 'store'])->name('egresos.store');
    Route::post('/cuentas', [\App\Http\Controllers\EgresosController::class, 'storeCuenta'])->name('cuentas.store');
    Route::get('/{id}/show', [\App\Http\Controllers\EgresosController::class, 'show'])->name('egresos.show');
    Route::get('/cuentas/create', [\App\Http\Controllers\EgresosController::class, 'createCuenta'])->name('cuentas.create');
    Route::get('/{id}/edit', [\App\Http\Controllers\EgresosController::class, 'edit'])->name('egresos.edit');
    Route::put('/{id}', [\App\Http\Controllers\EgresosController::class, 'update'])->name('egresos.update');
    Route::delete('/{id}', [\App\Http\Controllers\EgresosController::class, 'destroy'])->name('egresos.destroy');
});

Route::prefix('contabilidad/libro-diario')->middleware('auth')->group(function () {
    Route::get('/', [LibroDiarioController::class, 'index'])->name('libro-diario.index');
});

Route::prefix('contabilidad/sueldos')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\SueldosHcController::class, 'index'])->name('sueldos.index');
    Route::post('/trabajadores', [\App\Http\Controllers\SueldosHcController::class, 'storeTrabajador'])->name('trabajadores.store');
    Route::post('/pagos', [\App\Http\Controllers\SueldosHcController::class, 'storeSueldo'])->name('sueldos.store');
    Route::delete('/sueldos/{id}', [\App\Http\Controllers\SueldosHcController::class, 'destroy'])->name('sueldos.destroy');
    Route::delete('/trabajadores/{id}', [\App\Http\Controllers\SueldosHcController::class, 'destroyTrabajador'])->name('trabajadores.destroy');
    Route::get('/api/trabajadores', [\App\Http\Controllers\SueldosHcController::class, 'getTrabajadores'])->name('trabajadores.api');
});

// Sucursales / Almacenes
Route::prefix('almacenes')->middleware('auth')->group(function () {
    Route::get('/', [AlmacenController::class, 'index'])->name('almacenes.index');
    Route::get('/create', [AlmacenController::class, 'create'])->name('almacenes.create');
    Route::post('/', [AlmacenController::class, 'store'])->name('almacenes.store');
    Route::get('/{almacen}', [AlmacenController::class, 'show'])->name('almacenes.show');
    Route::get('/{almacen}/edit', [AlmacenController::class, 'edit'])->name('almacenes.edit');
    Route::put('/{almacen}', [AlmacenController::class, 'update'])->name('almacenes.update');
    Route::delete('/{almacen}', [AlmacenController::class, 'destroy'])->name('almacenes.destroy');
});

// Inventario por Almacén
Route::prefix('inventario')->middleware('auth')->group(function () {
    Route::get('/', [ProductoController::class, 'inventarioIndex'])->name('inventario.index');
    Route::get('/create', [ProductoController::class, 'create'])->name('inventario.create');
    Route::post('/', [ProductoController::class, 'store'])->name('inventario.store');
    Route::get('/{id}', [ProductoController::class, 'inventarioShow'])->name('inventario.show');
    Route::get('/{id}/edit', [ProductoController::class, 'edit'])->name('inventario.edit');
    Route::put('/{id}', [ProductoController::class, 'update'])->name('inventario.update');
    Route::delete('/{id}', [ProductoController::class, 'destroy'])->name('inventario.destroy');
    Route::post('/{id}/foto', [ProductoController::class, 'subirFoto'])->name('inventario.foto.subir');
    Route::delete('/{id}/foto', [ProductoController::class, 'eliminarFoto'])->name('inventario.foto.eliminar');
});

// Préstamos / Empeños
Route::prefix('prestamos')->middleware('auth')->group(function () {
    Route::get('/', [PrestamoController::class, 'index'])->name('prestamos.index');
    Route::get('/create', [PrestamoController::class, 'create'])->name('prestamos.create');
    Route::post('/', [PrestamoController::class, 'store'])->name('prestamos.store');
    Route::get('/{prestamo}', [PrestamoController::class, 'show'])->name('prestamos.show');
    Route::get('/{prestamo}/pdf', [PrestamoController::class, 'pdf'])->name('prestamos.pdf');
    Route::get('/{prestamo}/contrato', [PrestamoController::class, 'contrato'])->name('prestamos.contrato');
    Route::get('/{prestamo}/contrato/download', [PrestamoController::class, 'contratoDownload'])->name('prestamos.contrato.download');
    Route::post('/{prestamo}/pagar', [PrestamoController::class, 'registrarPago'])->name('prestamos.pagar');
    Route::post('/{prestamo}/cancelar', [PrestamoController::class, 'cancelar'])->name('prestamos.cancelar');
    Route::post('/{prestamo}/expirar', [PrestamoController::class, 'expirar'])->name('prestamos.expirar');
    Route::post('/{prestamo}/descuento', [PrestamoController::class, 'aplicarDescuento'])->name('prestamos.descuento');
    Route::post('/productos/{producto}/fotos', [PrestamoController::class, 'subirFotos'])->name('productos.fotos.subir');
    Route::delete('/fotos/{foto}', [PrestamoController::class, 'eliminarFoto'])->name('productos.fotos.eliminar');
    Route::post('/productos/{producto}/limpiar-fotos-rotas', [PrestamoController::class, 'limpiarFotosRotas'])->name('productos.fotos.limpiar');
});

// Ruta para servir imágenes directamente
Route::get('/foto/{filename}', function ($filename) {
    $path = public_path('fotos/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
});

// Ruta de prueba para fotos
Route::get('/test-fotos', [PrestamoController::class, 'testFotos']);

// Apartados
Route::prefix('apartados')->middleware('auth')->group(function () {
    Route::get('/', [ApartadoController::class, 'index'])->name('apartados.index');
    Route::get('/create', [ApartadoController::class, 'create'])->name('apartados.create');
    Route::post('/', [ApartadoController::class, 'store'])->name('apartados.store');
    Route::get('/{apartado}', [ApartadoController::class, 'show'])->name('apartados.show');
});

// Compras
Route::prefix('compras')->middleware('auth')->group(function () {
    Route::get('/', [CompraController::class, 'index'])->name('compras.index');
    Route::get('/create', [CompraController::class, 'create'])->name('compras.create');
    Route::post('/', [CompraController::class, 'store'])->name('compras.store');
    Route::get('/{compra}', [CompraController::class, 'show'])->name('compras.show');
    Route::get('/{compra}/contrato', [CompraController::class, 'generarContrato'])->name('compras.contrato');
    Route::get('/{compra}/contrato/download', [CompraController::class, 'descargarContrato'])->name('compras.contrato.download');
});

// Ventas
Route::prefix('ventas')->middleware('auth')->group(function () {
    Route::get('/', [VentaController::class, 'index'])->name('ventas.index');
    Route::get('/create', [VentaController::class, 'create'])->name('ventas.create');
    Route::post('/', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('/{venta}', [VentaController::class, 'show'])->name('ventas.show');
    Route::get('/{venta}/factura', [VentaController::class, 'factura'])->name('ventas.factura');
    Route::get('/{venta}/factura/download', [VentaController::class, 'facturaDownload'])->name('ventas.factura.download');
});

// Reportes avanzados
Route::prefix('reportes')->middleware('auth')->group(function () {
    Route::get('/', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/excel', [ReporteController::class, 'excel'])->name('reportes.excel');
    Route::get('/cashflow', [\App\Http\Controllers\CashFlowController::class, 'index'])->name('reportes.cashflow');
    Route::get('/summary', [ReporteController::class, 'summary'])->name('reportes.summary');
    Route::get('/prestamos-vigentes', [ReporteController::class, 'prestamosVigentes'])->name('reportes.prestamos.vigentes');
    Route::get('/prestamos-por-vencer', [ReporteController::class, 'prestamosPorVencer'])->name('reportes.prestamos.por-vencer');
    Route::get('/prestamos-vencidos', [ReporteController::class, 'prestamosVencidos'])->name('reportes.prestamos.vencidos');
    Route::get('/prestamos-expirados', [ReporteController::class, 'prestamosExpirados'])->name('reportes.prestamos.expirados');
    Route::get('/prestamos-liquidados', [ReporteController::class, 'prestamosLiquidados'])->name('reportes.prestamos.liquidados');
    Route::get('/apartados-vigentes', [ReporteController::class, 'apartadosVigentes'])->name('reportes.apartados.vigentes');
    Route::get('/apartados-vencidos', [ReporteController::class, 'apartadosVencidos'])->name('reportes.apartados.vencidos');
    Route::post('/registrar-movimiento', [ReporteController::class, 'registrarMovimiento'])->name('reportes.registrar-movimiento');
});

// Historial
Route::prefix('historial')->middleware('auth')->group(function () {
    Route::get('/', [HistorialController::class, 'index'])->name('historial.index');
});

// Configuración avanzada
Route::prefix('configuracion')->middleware('auth')->group(function () {
    Route::get('/', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::get('/empresa', [ConfiguracionController::class, 'empresa'])->name('configuracion.empresa');
    Route::get('/prestamos', [ConfiguracionController::class, 'prestamos'])->name('configuracion.prestamos');
    Route::get('/tarifas', [ConfiguracionController::class, 'tarifas'])->name('configuracion.tarifas');
    Route::get('/notificaciones', [ConfiguracionController::class, 'notificaciones'])->name('configuracion.notificaciones');
    Route::get('/sistema', [ConfiguracionController::class, 'sistema'])->name('configuracion.sistema');
    Route::get('/seguridad', [ConfiguracionController::class, 'seguridad'])->name('configuracion.seguridad');
    Route::get('/reportes', [ConfiguracionController::class, 'reportes'])->name('configuracion.reportes');
    Route::put('/actualizar', [ConfiguracionController::class, 'actualizar'])->name('configuracion.actualizar');
});

// Notificaciones
Route::prefix('notificaciones')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\NotificacionController::class, 'index'])->name('notificaciones.index');
    Route::patch('/{id}/marcar-leida', [\App\Http\Controllers\NotificacionController::class, 'marcarLeida'])->name('notificaciones.marcar-leida');
    Route::get('/alertas', [\App\Http\Controllers\NotificacionController::class, 'getAlertas'])->name('notificaciones.alertas');
});

// Renovaciones
Route::prefix('renovaciones')->middleware('auth')->group(function () {
    Route::post('/{prestamo}/renovar', [\App\Http\Controllers\RenovacionController::class, 'renovar'])->name('renovaciones.renovar');
});

// Tarifas y Comisiones
Route::prefix('tarifas')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\TarifaController::class, 'index'])->name('tarifas.index');
    Route::post('/', [\App\Http\Controllers\TarifaController::class, 'store'])->name('tarifas.store');
    Route::post('/{prestamo}/aplicar-comision', [\App\Http\Controllers\TarifaController::class, 'aplicarComision'])->name('tarifas.aplicar-comision');
});

// Subastas
Route::prefix('subastas')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\SubastaController::class, 'index'])->name('subastas.index');
    Route::get('/create/{prestamo}', [\App\Http\Controllers\SubastaController::class, 'create'])->name('subastas.create');
    Route::post('/', [\App\Http\Controllers\SubastaController::class, 'store'])->name('subastas.store');
    Route::get('/{subasta}', [\App\Http\Controllers\SubastaController::class, 'show'])->name('subastas.show');
    Route::post('/{subasta}/ofertar', [\App\Http\Controllers\SubastaController::class, 'ofertar'])->name('subastas.ofertar');
    Route::post('/{subasta}/finalizar', [\App\Http\Controllers\SubastaController::class, 'finalizar'])->name('subastas.finalizar');
});

// Reportes Avanzados
Route::prefix('reportes-avanzados')->middleware('auth')->group(function () {
    Route::get('/rentabilidad', [\App\Http\Controllers\ReporteAvanzadoController::class, 'rentabilidad'])->name('reportes.rentabilidad');
    Route::get('/riesgo-crediticio', [\App\Http\Controllers\ReporteAvanzadoController::class, 'riesgoCrediticio'])->name('reportes.riesgo-crediticio');
    Route::get('/recuperacion', [\App\Http\Controllers\ReporteAvanzadoController::class, 'estadisticasRecuperacion'])->name('reportes.recuperacion');
    Route::get('/flujo-efectivo', [\App\Http\Controllers\ReporteAvanzadoController::class, 'flujoEfectivo'])->name('reportes.flujo-efectivo');
});

// Transferencias entre Sucursales
Route::prefix('transferencias')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\TransferenciaController::class, 'index'])->name('transferencias.index');
    Route::get('/create', [\App\Http\Controllers\TransferenciaController::class, 'create'])->name('transferencias.create');
    Route::post('/', [\App\Http\Controllers\TransferenciaController::class, 'store'])->name('transferencias.store');
    Route::post('/{transferencia}/recibir', [\App\Http\Controllers\TransferenciaController::class, 'recibir'])->name('transferencias.recibir');
    Route::get('/consolidado', [\App\Http\Controllers\TransferenciaController::class, 'consolidado'])->name('transferencias.consolidado');
});

// Verificaciones Externas
Route::prefix('verificaciones')->middleware('auth')->group(function () {
    Route::post('/{cliente}/identidad', [\App\Http\Controllers\VerificacionController::class, 'verificarIdentidad'])->name('verificaciones.identidad');
    Route::post('/{cliente}/centrales-riesgo', [\App\Http\Controllers\VerificacionController::class, 'consultarCentrales'])->name('verificaciones.centrales');
});

// Garantías Adicionales
Route::prefix('garantias')->middleware('auth')->group(function () {
    Route::post('/{prestamo}/aval', [\App\Http\Controllers\GarantiaController::class, 'agregarAval'])->name('garantias.aval');
    Route::post('/{prestamo}/seguro', [\App\Http\Controllers\GarantiaController::class, 'agregarSeguro'])->name('garantias.seguro');
    Route::post('/{prestamo}/cruzada', [\App\Http\Controllers\GarantiaController::class, 'agregarCruzada'])->name('garantias.cruzada');
});

// Workflow y Aprobaciones
Route::prefix('workflow')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\WorkflowController::class, 'index'])->name('workflows.index');
    Route::post('/', [\App\Http\Controllers\WorkflowController::class, 'store'])->name('workflows.store');
    Route::post('/{tipo}/{id}/solicitar-aprobacion', [\App\Http\Controllers\WorkflowController::class, 'solicitarAprobacion'])->name('workflows.solicitar');
    Route::post('/aprobaciones/{id}/procesar', [\App\Http\Controllers\WorkflowController::class, 'aprobar'])->name('workflows.aprobar');
    Route::get('/pendientes', [\App\Http\Controllers\WorkflowController::class, 'pendientes'])->name('workflows.pendientes');
});

// Backup y Seguridad
Route::prefix('sistema')->middleware('auth')->group(function () {
    Route::get('/backups', [\App\Http\Controllers\BackupController::class, 'index'])->name('sistema.backups');
    Route::post('/backup/generar', [\App\Http\Controllers\BackupController::class, 'generar'])->name('sistema.backup.generar');
    Route::get('/auditoria', [\App\Http\Controllers\AuditoriaController::class, 'index'])->name('sistema.auditoria');
});

// Automatización
Route::prefix('automatizacion')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\AutomatizacionController::class, 'index'])->name('automatizacion.index');
    Route::post('/notificacion-manual', [\App\Http\Controllers\AutomatizacionController::class, 'enviarNotificacionManual'])->name('automatizacion.notificacion-manual');
    Route::post('/ejecutar-proceso', [\App\Http\Controllers\AutomatizacionController::class, 'ejecutarProcesoBatch'])->name('automatizacion.ejecutar-proceso');
    Route::get('/estadisticas', [\App\Http\Controllers\AutomatizacionController::class, 'getEstadisticasAjax'])->name('automatizacion.estadisticas');
});

// Dashboard Avanzado
Route::prefix('dashboard-avanzado')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\DashboardAvanzadoController::class, 'index'])->name('dashboard.avanzado');
    Route::get('/data', [\App\Http\Controllers\DashboardAvanzadoController::class, 'getDataAjax'])->name('dashboard.avanzado.data');
});

// Documentación
Route::prefix('documentacion')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\DocumentacionController::class, 'index'])->name('documentacion.index');
});

// Ruta temporal de diagnóstico
Route::get('/diagnostico-fotos', function() {
    $output = "=== DIAGNÓSTICO DE FOTOS ===\n\n";
    
    $output .= "1. Fotos en base de datos:\n";
    $fotos = \App\Models\FotoEquipo::all();
    foreach($fotos as $foto) {
        $output .= "ID: {$foto->id} | Producto: {$foto->equipo_id} | Ruta: {$foto->ruta}\n";
        $rutaCompleta = public_path($foto->ruta);
        $output .= "   Archivo existe: " . (file_exists($rutaCompleta) ? "SÍ" : "NO") . "\n";
        $output .= "   Ruta completa: {$rutaCompleta}\n\n";
    }
    
    $output .= "2. Productos con fotos:\n";
    $productos = \App\Models\Producto::with('fotos')->get();
    foreach($productos as $producto) {
        if($producto->fotos->count() > 0) {
            $output .= "Producto ID: {$producto->id} | Nombre: {$producto->nombre} | Fotos: {$producto->fotos->count()}\n";
        }
    }
    
    $output .= "\n3. Archivos físicos en public/fotos:\n";
    $archivos = glob(public_path('fotos/*'));
    foreach($archivos as $archivo) {
        if(is_file($archivo)) {
            $output .= basename($archivo) . " (" . filesize($archivo) . " bytes)\n";
        }
    }
    
    return '<pre>' . $output . '</pre>';
})->middleware('auth');

// Limpiar fotos rotas
Route::get('/limpiar-fotos', function() {
    $eliminadas = 0;
    $fotos = \App\Models\FotoEquipo::all();
    
    foreach($fotos as $foto) {
        $rutaCompleta = public_path($foto->ruta);
        if (!file_exists($rutaCompleta)) {
            $foto->delete();
            $eliminadas++;
        }
    }
    
    return "<h3>Limpieza completada</h3><p>Se eliminaron {$eliminadas} registros de fotos sin archivo físico.</p><a href='/diagnostico-fotos'>Ver diagnóstico</a><br><a href='/prestamos'>Ir a préstamos</a>";
})->middleware('auth');

// Limpiar fotos de un producto específico
Route::post('/limpiar-fotos-producto/{id}', function($id) {
    $eliminadas = 0;
    $fotos = \App\Models\FotoEquipo::where('equipo_id', $id)->get();
    
    foreach($fotos as $foto) {
        $rutaCompleta = public_path($foto->ruta);
        if (!file_exists($rutaCompleta)) {
            $foto->delete();
            $eliminadas++;
        }
    }
    
    return response()->json([
        'success' => true,
        'message' => "Se eliminaron {$eliminadas} registros de fotos rotas",
        'eliminadas' => $eliminadas
    ]);
})->middleware('auth');
