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
use App\Http\Controllers\SeguridadController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ApartadoController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\EgresoController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\DeployController;


// Crear un usuario administrador, solo usar una vez
Route::middleware(['web'])->group(function () {
    Route::get('/crear-admin', [AuthController::class, 'crearAdmin']);
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/logear', [AuthController::class, 'logear'])->name('logear');
});

// Ruta para limpiar cache
Route::get('/clear-cache', function() {
    \Artisan::call('config:clear');
    \Artisan::call('route:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    return 'Cache limpiado. <a href="/">Ir al login</a>';
});

// Ruta para ejecutar migraciones
Route::get('/run-migrations', function() {
    try {
        \Artisan::call('migrate', ['--force' => true]);
        $output = \Artisan::output();
        
        // Crear usuario admin si no existe
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

// BYPASS COMPLETO - SIN MIDDLEWARE AUTH
Route::get('/dashboard-bypass', function() {
    // Login forzado
    $user = \App\Models\User::where('email', 'admin@admin.com')->first();
    if ($user) {
        \Auth::login($user);
        session()->regenerate();
        session()->save();
    }
    
    // Mostrar dashboard básico
    return '
    <!DOCTYPE html>
    <html>
    <head>
        <title>HC Servicios - Dashboard</title>
        <meta charset="utf-8">
        <style>
            body { font-family: Arial; margin: 40px; background: #f5f5f5; }
            .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            .header { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-bottom: 30px; }
            .menu { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 30px; }
            .menu-item { background: #007bff; color: white; padding: 20px; text-align: center; border-radius: 5px; text-decoration: none; transition: background 0.3s; }
            .menu-item:hover { background: #0056b3; }
            .info { background: #e7f3ff; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1 class="header">🏭 HC Servicios Industrial - Dashboard</h1>
            
            <div class="info">
                <strong>✅ Sistema funcionando correctamente</strong><br>
                Usuario: ' . (\Auth::check() ? \Auth::user()->email : 'No autenticado') . '<br>
                Fecha: ' . date('d/m/Y H:i:s') . '
            </div>
            
            <div class="menu">
                <a href="/clientes" class="menu-item">👥 Clientes</a>
                <a href="/recepciones" class="menu-item">📋 Recepciones</a>
                <a href="/equipos" class="menu-item">⚙️ Equipos</a>
                <a href="/usuarios" class="menu-item">👤 Usuarios</a>
                <a href="/cotizaciones" class="menu-item">💰 Cotizaciones</a>
                <a href="/prestamos" class="menu-item">🏦 Préstamos</a>
                <a href="/inventario" class="menu-item">📦 Inventario</a>
                <a href="/reportes" class="menu-item">📊 Reportes</a>
                <a href="/configuracion" class="menu-item">⚙️ Configuración</a>
            </div>
            
            <div style="margin-top: 30px; text-align: center; color: #666;">
                <small>Sistema de Gestión HC Servicios Industrial</small>
            </div>
        </div>
    </body>
    </html>';
});

// Ruta de debug para verificar tabla sessions
Route::get('/debug-sessions', function() {
    try {
        $sessions = \DB::table('sessions')->count();
        return ['sessions_table_exists' => true, 'sessions_count' => $sessions];
    } catch (\Exception $e) {
        return ['sessions_table_exists' => false, 'error' => $e->getMessage()];
    }
});
Route::get('/debug-auth', function() {
    $user = \Auth::user();
    $check = \Auth::check();
    $id = \Auth::id();
    $guard = \Auth::getDefaultDriver();
    
    // Verificar usuario en base de datos
    $dbUser = \App\Models\User::where('email', 'rijarwow@gmail.com')->first();
    
    return [
        'authenticated' => $check,
        'user_id' => $id,
        'user' => $user,
        'guard' => $guard,
        'session_id' => session()->getId(),
        'session_data' => session()->all(),
        'db_user' => $dbUser ? [
            'id' => $dbUser->id,
            'email' => $dbUser->email,
            'activo' => $dbUser->activo ?? 'campo no existe'
        ] : 'no encontrado'
    ];
});

// TEST LOGIN - SIN REDIRECTS
Route::post('/test-login', function(\Illuminate\Http\Request $request) {
    $output = [];
    $output[] = '=== TEST LOGIN DEBUG ===';
    $output[] = 'Email: ' . $request->input('email');
    $output[] = 'Password: ' . $request->input('password');
    $output[] = 'Password Length: ' . strlen($request->input('password') ?? '');
    
    try {
        $email = $request->input('email');
        $password = $request->input('password');
        
        if (!$email || !$password) {
            $output[] = 'ERROR: Email o contraseña vacíos';
            return '<pre>' . implode("\n", $output) . '</pre><br><a href="/">Volver</a>';
        }
        
        $output[] = 'Buscando usuario...';
        $user = \App\Models\User::where('email', $email)->first();
        
        if (!$user) {
            $output[] = 'ERROR: Usuario no encontrado';
            $output[] = 'Usuarios disponibles:';
            $users = \App\Models\User::all(['email']);
            foreach ($users as $u) {
                $output[] = '  - ' . $u->email;
            }
            return '<pre>' . implode("\n", $output) . '</pre><br><a href="/">Volver</a>';
        }
        
        $output[] = 'Usuario encontrado: ' . $user->email;
        $output[] = 'Verificando contraseña...';
        
        if (!\Hash::check($password, $user->password)) {
            $output[] = 'ERROR: Contraseña incorrecta';
            $output[] = 'Hash en BD: ' . substr($user->password, 0, 20) . '...';
            return '<pre>' . implode("\n", $output) . '</pre><br><a href="/">Volver</a>';
        }
        
        $output[] = 'Contraseña correcta!';
        $output[] = 'Intentando login...';
        
        \Auth::login($user);
        session()->regenerate();
        session()->save();
        
        if (\Auth::check()) {
            $output[] = 'LOGIN EXITOSO!';
            $output[] = 'Usuario logueado: ' . \Auth::user()->email;
            $output[] = 'Session ID: ' . session()->getId();
            return '<pre>' . implode("\n", $output) . '</pre><br><a href="/home">Ir al Dashboard</a>';
        } else {
            $output[] = 'ERROR: Login falló después de Auth::login()';
            return '<pre>' . implode("\n", $output) . '</pre><br><a href="/">Volver</a>';
        }
        
    } catch (\Exception $e) {
        $output[] = 'EXCEPCIÓN: ' . $e->getMessage();
        $output[] = 'Trace: ' . $e->getTraceAsString();
        return '<pre>' . implode("\n", $output) . '</pre><br><a href="/">Volver</a>';
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
 Route::prefix('contabilidad/ingresos')->middleware(['auth', 'rol.contable'])->group(function () {
    Route::get('/', [\App\Http\Controllers\IngresosController::class, 'index'])->name('ingresos.index');
    Route::get('/create', [\App\Http\Controllers\IngresosController::class, 'create'])->name('ingresos.create');
    Route::post('/', [\App\Http\Controllers\IngresosController::class, 'store'])->name('ingresos.store');
    Route::get('/{id}/edit', [\App\Http\Controllers\IngresosController::class, 'edit'])->name('ingresos.edit');
    Route::put('/{id}', [\App\Http\Controllers\IngresosController::class, 'update'])->name('ingresos.update');
    Route::delete('/{id}', [\App\Http\Controllers\IngresosController::class, 'destroy'])->name('ingresos.destroy');
    Route::get('/{id}/show', [\App\Http\Controllers\IngresosController::class, 'show'])->name('ingresos.show');
    
});
Route::prefix('contabilidad/egresos')->middleware(['auth', 'rol.contable'])->group(function () {
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

Route::prefix('contabilidad/libro-diario')->middleware(['auth', 'rol.contable'])->group(function () {
    Route::get('/', [LibroDiarioController::class, 'index'])->name('libro-diario.index');
});

Route::prefix('contabilidad/sueldos')->middleware(['auth', 'rol.contable'])->group(function () {
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
});

// Préstamos / Empeños
Route::prefix('prestamos')->middleware('auth')->group(function () {
    Route::get('/', [PrestamoController::class, 'index'])->name('prestamos.index');
    Route::get('/create', [PrestamoController::class, 'create'])->name('prestamos.create');
    Route::post('/', [PrestamoController::class, 'store'])->name('prestamos.store');
    Route::get('/{prestamo}', [PrestamoController::class, 'show'])->name('prestamos.show');
    Route::get('/{prestamo}/pdf', [PrestamoController::class, 'pdf'])->name('prestamos.pdf');
    Route::post('/{prestamo}/pagar', [PrestamoController::class, 'registrarPago'])->name('prestamos.pagar');
    Route::post('/{prestamo}/cancelar', [PrestamoController::class, 'cancelar'])->name('prestamos.cancelar');
    Route::post('/{prestamo}/expirar', [PrestamoController::class, 'expirar'])->name('prestamos.expirar');
    Route::post('/{prestamo}/descuento', [PrestamoController::class, 'aplicarDescuento'])->name('prestamos.descuento');
});

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
});

// Ventas
Route::prefix('ventas')->middleware('auth')->group(function () {
    Route::get('/', [VentaController::class, 'index'])->name('ventas.index');
    Route::get('/create', [VentaController::class, 'create'])->name('ventas.create');
    Route::post('/', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('/{venta}', [VentaController::class, 'show'])->name('ventas.show');
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
    Route::get('/sucursal', [ConfiguracionController::class, 'sucursal'])->name('configuracion.sucursal');
    Route::get('/empleados', [ConfiguracionController::class, 'empleados'])->name('configuracion.empleados');
    Route::get('/intereses', [ConfiguracionController::class, 'intereses'])->name('configuracion.intereses');
    Route::get('/recibos', [ConfiguracionController::class, 'recibos'])->name('configuracion.recibos');
    Route::get('/region', [ConfiguracionController::class, 'region'])->name('configuracion.region');
    Route::get('/roles', [ConfiguracionController::class, 'roles'])->name('configuracion.roles');
});

// Sucursales / Almacenes (vista web)
Route::get('/almacenes', [AlmacenController::class, 'index'])->name('almacenes.index');
