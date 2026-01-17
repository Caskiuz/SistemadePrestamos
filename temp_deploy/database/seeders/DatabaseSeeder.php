<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\Recepcion;
use App\Models\Cotizacion;
use App\Models\CotizacionEquipo;
use App\Models\CotizacionRepuesto;
use App\Models\CotizacionServicio;
use App\Models\FotoEquipo;
use App\Models\NombreCuenta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Almacen;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Almacenes
        $this->call(AlmacenSeeder::class);
        $this->call(ProductoSeeder::class);

        // Usuarios
        User::create([
            'name' => 'Ricardo',
            'nombre' => 'Ricardo',
            'email' => 'rijarwow@gmail.com',
            'rol' => 'Gerente',
            'activo' => true,
            'password' => Hash::make('123456789'),
        ]);
        User::create([
            'name' => 'Tito Herbas',
            'nombre' => 'Tito Herbas',
            'email' => 'titoherbas@hcservicioindustrial.com',
            'rol' => 'Gerente',
            'activo' => true,
            'password' => '$2y$12$4HH70Th74AA5FJwaBuaScum7dxvf4tr6MGCVTGI6w.jSrxilr2d4C',
        ]);
        User::create([
            'name' => 'Augusto Velasquez',
            'nombre' => 'Augusto Velasquez',
            'email' => 'augustovelasquez@hcservicioindustrial.com',
            'rol' => 'Contabilidad',
            'activo' => true,
            'password' => '$2y$12$qQNcf34LI0GQTT0KMcx/KONHlh3Qy5qRkzbbHxhvVMeZB3zQ745ZC',
        ]);
        User::create([
            'name' => 'Jose Ito',
            'nombre' => 'Jose Ito',
            'email' => 'joseito@hcservicioindustrial.com',
            'rol' => 'Supervisor',
            'activo' => true,
            'password' => '$2y$12$uJSWSP4/6Tiyenqm56rDp.v7PSTXtyQ9QwoV4UKCeSYS1apdXdXx2',
        ]);

        $this->call(ClienteSeeder::class);

        // Préstamos
        $this->call(PrestamoSeeder::class);

        // Pagos
        $this->call(PagoSeeder::class);

        // Devoluciones
        $this->call(DevolucionSeeder::class);

        // Garantías
        $this->call(GarantiaSeeder::class);

        // Reportes de préstamos
        $this->call(ReportePrestamoSeeder::class);

        // Empleados
        $this->call(EmpleadoSeeder::class);

        // Intereses
        $this->call(InteresSeeder::class);

        // Compras
        $this->call(CompraSeeder::class);

        // Ventas
        $this->call(VentaSeeder::class);
// Cliente


// Recepcion (¡debe ir antes que Equipo!)
Recepcion::create([
    'id' => 1,
    'numero_recepcion' => 'REC-005512',
    'cliente_id' => 1,
    'user_id' => 4,
    'fecha_ingreso' => '2025-08-19 00:00:00',
    'hora_ingreso' => '09:54:00',
    'estado' => 'DIAGNOSTICADO',
    'created_at' => '2025-08-19 14:02:18',
    'updated_at' => '2025-08-19 14:13:57',
    'deleted_at' => null,
]);

// Equipo (ahora sí, después de Recepcion)
Equipo::create([
    'id' => 1,
    'cliente_id' => 1,
    'recepcion_id' => 1,
    'nombre' => 'Motor eléctrico',
    'tipo' => 'MOTOR_ELECTRICO',
    'modelo' => 'Acople',
    'marca' => 'Sew - Eurodrive',
    'color' => 'Azul',
    'numero_serie' => null,
    'potencia' => null,
    'potencia_unidad' => 'Watts',
    'voltaje' => '220',
    'hp' => '1',
    'rpm' => '1680',
    'hz' => '50',
    'amperaje' => null,
    'cable_positivo' => 'No',
    'cable_negativo' => 'No',
    'kva_kw' => null,
    'partes_faltantes' => null,
    'observaciones' => null,
    'created_at' => '2025-08-19 14:02:18',
    'updated_at' => '2025-08-19 14:02:18',
    'deleted_at' => null,
        ]);

        // Cotización y relaciones
        Cotizacion::create([
            'id' => 1,
            'recepcion_id' => 1,
            'fecha' => '2025-08-19',
            'subtotal' => 51.00,
            'descuento' => 0.00,
            'total' => 51.00,
            'created_at' => '2025-08-19 14:13:57',
            'updated_at' => '2025-08-21 19:32:55',
        ]);
        CotizacionEquipo::create([
            'id' => 3,
            'cotizacion_id' => 1,
            'equipo_id' => 1,
            'trabajo_realizar' => 'DIAGNOSTICO',
            'precio_trabajo' => 50.00,
            'total_repuestos' => 1.00,
            'created_at' => '2025-08-21 19:32:55',
            'updated_at' => '2025-08-21 19:32:55',
        ]);
        CotizacionRepuesto::create([
            'id' => 3,
            'cotizacion_equipo_id' => 3,
            'nombre' => 'DIAGNOSTICO',
            'cantidad' => 1,
            'precio_unitario' => 1.00,
            'created_at' => '2025-08-21 19:32:55',
            'updated_at' => '2025-08-21 19:32:55',
        ]);
        CotizacionServicio::create([
            'id' => 3,
            'cotizacion_equipo_id' => 3,
            'nombre' => 'DIAGNOSTICO',
            'created_at' => '2025-08-21 19:32:55',
            'updated_at' => '2025-08-21 19:32:55',
        ]);

        // Fotos de equipos
        FotoEquipo::create([
            'id' => 1,
            'equipo_id' => 1,
            'ruta' => 'equipos_fotos/equipo_1_1755612138_fM5NpdNz.jpg',
            'descripcion' => 'Foto subida',
            'created_at' => '2025-08-19 14:02:19',
            'updated_at' => '2025-08-19 14:02:19',
        ]);
        FotoEquipo::create([
            'id' => 2,
            'equipo_id' => 1,
            'ruta' => 'equipos_fotos/equipo_1_1755612139_WDj7flk4.jpg',
            'descripcion' => 'Foto subida',
            'created_at' => '2025-08-19 14:02:20',
            'updated_at' => '2025-08-19 14:02:20',
        ]);
        FotoEquipo::create([
            'id' => 3,
            'equipo_id' => 1,
            'ruta' => 'equipos_fotos/equipo_1_1755612140_vpn0BtXc.jpg',
            'descripcion' => 'Foto subida',
            'created_at' => '2025-08-19 14:02:22',
            'updated_at' => '2025-08-19 14:02:22',
        ]);
        FotoEquipo::create([
            'id' => 4,
            'equipo_id' => 1,
            'ruta' => 'equipos_fotos/equipo_1_1755612142_BVsSnn6o.jpg',
            'descripcion' => 'Foto subida',
            'created_at' => '2025-08-19 14:02:24',
            'updated_at' => '2025-08-19 14:02:24',
        ]);
        FotoEquipo::create([
            'id' => 5,
            'equipo_id' => 1,
            'ruta' => 'equipos_fotos/equipo_1_1755612144_Ku5Qva5R.jpg',
            'descripcion' => 'Foto subida',
            'created_at' => '2025-08-19 14:02:25',
            'updated_at' => '2025-08-19 14:02:25',
        ]);

        // Nombre cuentas (solo los dos primeros, agrega el resto igual)
        NombreCuenta::create([
            'id' => 1,
            'nombre_cuenta' => 'Banco bissa LP',
            'descripcion' => 'Credito casa',
            'created_at' => '2025-08-22 19:25:03',
            'updated_at' => '2025-08-22 19:25:03',
        ]);
        NombreCuenta::create([
            'id' => 2,
            'nombre_cuenta' => 'Alquiler',
            'descripcion' => 'Alquiler taller y almacen',
            'created_at' => '2025-08-22 19:28:59',
            'updated_at' => '2025-08-22 19:28:59',
        ]);
        NombreCuenta::create([
            'id' => 3,
            'nombre_cuenta' => 'Atencion medica externa',
            'descripcion' => 'Hospital',
            'created_at' => '2025-08-22 19:30:01',
            'updated_at' => '2025-08-22 19:30:01',
        ]);
        NombreCuenta::create([
            'id' => 4,
            'nombre_cuenta' => 'Aguinaldos',
            'descripcion' => 'Aguinaldo',
            'created_at' => '2025-08-22 19:30:37',
            'updated_at' => '2025-08-22 19:30:37',
        ]);
        NombreCuenta::create([
            'id' => 5,
            'nombre_cuenta' => 'Combustible y lubricantes',
            'descripcion' => 'Gasolina, aceite y otros lubricantes',
            'created_at' => '2025-08-22 19:31:40',
            'updated_at' => '2025-08-22 19:31:40',
        ]);
        NombreCuenta::create([
            'id' => 6,
            'nombre_cuenta' => 'Materia prima',
            'descripcion' => 'Materiales que usamos pero es en general',
            'created_at' => '2025-08-22 19:32:27',
            'updated_at' => '2025-08-22 19:32:27',
        ]);
        NombreCuenta::create([
            'id' => 7,
            'nombre_cuenta' => 'Materia prima alambre',
            'descripcion' => 'Alambre',
            'created_at' => '2025-08-22 19:32:42',
            'updated_at' => '2025-08-22 19:32:42',
        ]);
        NombreCuenta::create([
            'id' => 8,
            'nombre_cuenta' => 'Materia prima capacitor',
            'descripcion' => 'Capacitores',
            'created_at' => '2025-08-22 19:32:58',
            'updated_at' => '2025-08-22 19:32:58',
        ]);
        NombreCuenta::create([
            'id' => 9,
            'nombre_cuenta' => 'Materia prima rodamiento',
            'descripcion' => 'Rodamientos en general',
            'created_at' => '2025-08-22 19:45:10',
            'updated_at' => '2025-08-22 19:45:10',
        ]);
        NombreCuenta::create([
            'id' => 10,
            'nombre_cuenta' => 'Material de escritorio',
            'descripcion' => 'Material de escritorio',
            'created_at' => '2025-08-22 19:45:52',
            'updated_at' => '2025-08-22 19:45:52',
        ]);
        NombreCuenta::create([
            'id' => 11,
            'nombre_cuenta' => 'Material de limpieza',
            'descripcion' => 'Material de limpieza',
            'created_at' => '2025-08-22 19:46:18',
            'updated_at' => '2025-08-22 19:46:18',
        ]);
        NombreCuenta::create([
            'id' => 12,
            'nombre_cuenta' => 'Otros gastos',
            'descripcion' => 'Gastos varios, torneria y otros',
            'created_at' => '2025-08-22 19:46:58',
            'updated_at' => '2025-08-22 19:46:58',
        ]);
        NombreCuenta::create([
            'id' => 13,
            'nombre_cuenta' => 'Refrigerio y alimentacion',
            'descripcion' => 'Almuerzo cena para el personal HC',
            'created_at' => '2025-08-22 19:47:33',
            'updated_at' => '2025-08-22 19:47:33',
        ]);
        NombreCuenta::create([
            'id' => 14,
            'nombre_cuenta' => 'Sueldos y salarios',
            'descripcion' => 'Sueldos',
            'created_at' => '2025-08-22 19:47:49',
            'updated_at' => '2025-08-22 19:47:49',
        ]);
        NombreCuenta::create([
            'id' => 15,
            'nombre_cuenta' => 'Suministros agua',
            'descripcion' => 'Agua',
            'created_at' => '2025-08-22 19:48:08',
            'updated_at' => '2025-08-22 19:48:08',
        ]);
        NombreCuenta::create([
            'id' => 16,
            'nombre_cuenta' => 'Telefono',
            'descripcion' => 'Carga de creditos',
            'created_at' => '2025-08-22 19:48:22',
            'updated_at' => '2025-08-22 19:48:22',
        ]);
        NombreCuenta::create([
            'id' => 17,
            'nombre_cuenta' => 'Transporte',
            'descripcion' => 'Pasaje y viaticos',
            'created_at' => '2025-08-22 19:49:52',
            'updated_at' => '2025-08-22 19:49:52',
        ]);
        NombreCuenta::create([
            'id' => 18,
            'nombre_cuenta' => 'Uniformes',
            'descripcion' => 'Uniformes',
            'created_at' => '2025-08-22 19:50:13',
            'updated_at' => '2025-08-22 19:50:13',
        ]);
        NombreCuenta::create([
            'id' => 19,
            'nombre_cuenta' => 'Internet',
            'descripcion' => 'Internet taller y galpon',
            'created_at' => '2025-08-22 19:50:29',
            'updated_at' => '2025-08-22 19:50:29',
        ]);
        NombreCuenta::create([
            'id' => 20,
            'nombre_cuenta' => 'Servicios basicos',
            'descripcion' => 'Agua y luz',
            'created_at' => '2025-08-22 19:50:45',
            'updated_at' => '2025-08-22 19:50:45',
        ]);
        NombreCuenta::create([
            'id' => 21,
            'nombre_cuenta' => 'Donaciones',
            'descripcion' => 'Donaciones',
            'created_at' => '2025-08-22 19:50:58',
            'updated_at' => '2025-08-22 19:50:58',
        ]);
        NombreCuenta::create([
            'id' => 22,
            'nombre_cuenta' => 'Mantenimiento vehiculo',
            'descripcion' => 'Mantenimiento vehiculo',
            'created_at' => '2025-08-22 19:51:19',
            'updated_at' => '2025-08-22 19:51:19',
        ]);
        NombreCuenta::create([
            'id' => 23,
            'nombre_cuenta' => 'Gastos no deducibles',
            'descripcion' => 'Gastos no relacione con el taller',
            'created_at' => '2025-08-22 19:51:44',
            'updated_at' => '2025-08-22 19:51:44',
        ]);
        NombreCuenta::create([
            'id' => 24,
            'nombre_cuenta' => 'Servicios externos',
            'descripcion' => 'Servicios que se realiza fuera del taller',
            'created_at' => '2025-08-22 19:52:09',
            'updated_at' => '2025-08-22 19:52:09',
        ]);
        NombreCuenta::create([
            'id' => 25,
            'nombre_cuenta' => 'Herramientas',
            'descripcion' => 'Herramientas',
            'created_at' => '2025-08-22 19:52:21',
            'updated_at' => '2025-08-22 19:52:21',
        ]);
        NombreCuenta::create([
            'id' => 26,
            'nombre_cuenta' => 'Beneficios sociales',
            'descripcion' => 'Beneficios sociales',
            'created_at' => '2025-08-22 19:52:39',
            'updated_at' => '2025-08-22 19:52:39',
        ]);
        NombreCuenta::create([
            'id' => 27,
            'nombre_cuenta' => 'IUE',
            'descripcion' => 'IUE',
            'created_at' => '2025-08-22 19:52:48',
            'updated_at' => '2025-08-22 19:52:48',
        ]);
        NombreCuenta::create([
            'id' => 28,
            'nombre_cuenta' => 'Impuestos',
            'descripcion' => 'Iva e it y otros',
            'created_at' => '2025-08-22 19:53:08',
            'updated_at' => '2025-08-22 19:53:08',
        ]);
        NombreCuenta::create([
            'id' => 29,
            'nombre_cuenta' => 'Provision aguinaldos',
            'descripcion' => 'Provision aguinaldos',
            'created_at' => '2025-08-22 19:53:25',
            'updated_at' => '2025-08-22 19:53:25',
        ]);

        // Apartados
        $this->call(\Database\Seeders\ApartadoSeeder::class);
        // Ingresos
        $this->call(\Database\Seeders\IngresoSeeder::class);
        // Egresos
        $this->call(\Database\Seeders\EgresoSeeder::class);
    }
}