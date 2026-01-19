<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuracion;

class ConfiguracionSeeder extends Seeder
{
    public function run()
    {
        $configuraciones = [
            // Empresa
            ['clave' => 'empresa_nombre', 'valor' => 'Préstamos Santa Ana', 'categoria' => 'empresa', 'descripcion' => 'Nombre de la empresa'],
            ['clave' => 'empresa_direccion', 'valor' => 'Santa Ana, Bolivia', 'categoria' => 'empresa', 'descripcion' => 'Dirección principal'],
            ['clave' => 'empresa_telefono', 'valor' => '+591 2-000-0000', 'categoria' => 'empresa', 'descripcion' => 'Teléfono principal'],
            ['clave' => 'empresa_email', 'valor' => 'info@prestamossantaana.com', 'categoria' => 'empresa', 'descripcion' => 'Email corporativo'],
            ['clave' => 'empresa_nit', 'valor' => '1234567890', 'categoria' => 'empresa', 'descripcion' => 'NIT de la empresa'],
            ['clave' => 'empresa_pais', 'valor' => 'Bolivia', 'categoria' => 'empresa', 'descripcion' => 'País de operación'],
            
            // Préstamos
            ['clave' => 'prestamo_interes_mensual', 'valor' => '10', 'tipo' => 'number', 'categoria' => 'prestamos', 'descripcion' => 'Tasa de interés mensual (%)'],
            ['clave' => 'prestamo_plazo_dias', 'valor' => '30', 'tipo' => 'number', 'categoria' => 'prestamos', 'descripcion' => 'Plazo estándar en días'],
            ['clave' => 'prestamo_monto_minimo', 'valor' => '50', 'tipo' => 'number', 'categoria' => 'prestamos', 'descripcion' => 'Monto mínimo de préstamo'],
            ['clave' => 'prestamo_monto_maximo', 'valor' => '50000', 'tipo' => 'number', 'categoria' => 'prestamos', 'descripcion' => 'Monto máximo de préstamo'],
            ['clave' => 'prestamo_porcentaje_avaluo', 'valor' => '70', 'tipo' => 'number', 'categoria' => 'prestamos', 'descripcion' => 'Porcentaje máximo sobre avalúo'],
            
            // Tarifas
            ['clave' => 'tarifa_comision_prestamo', 'valor' => '2.5', 'tipo' => 'number', 'categoria' => 'tarifas', 'descripcion' => 'Comisión por préstamo (%)'],
            ['clave' => 'tarifa_almacenamiento', 'valor' => '10', 'tipo' => 'number', 'categoria' => 'tarifas', 'descripcion' => 'Tarifa de almacenamiento mensual'],
            ['clave' => 'tarifa_mora', 'valor' => '5', 'tipo' => 'number', 'categoria' => 'tarifas', 'descripcion' => 'Penalización por mora (%)'],
            ['clave' => 'tarifa_renovacion', 'valor' => '1', 'tipo' => 'number', 'categoria' => 'tarifas', 'descripcion' => 'Comisión por renovación (%)'],
            
            // Notificaciones
            ['clave' => 'notif_dias_vencimiento', 'valor' => '3', 'tipo' => 'number', 'categoria' => 'notificaciones', 'descripcion' => 'Días antes de vencimiento para alertar'],
            ['clave' => 'notif_automaticas', 'valor' => '1', 'tipo' => 'boolean', 'categoria' => 'notificaciones', 'descripcion' => 'Activar notificaciones automáticas'],
            ['clave' => 'notif_hora_envio', 'valor' => '08:00', 'categoria' => 'notificaciones', 'descripcion' => 'Hora de envío de notificaciones'],
            
            // Sistema
            ['clave' => 'sistema_backup_frecuencia', 'valor' => 'diario', 'categoria' => 'sistema', 'descripcion' => 'Frecuencia de backup automático'],
            ['clave' => 'sistema_zona_horaria', 'valor' => 'America/La_Paz', 'categoria' => 'sistema', 'descripcion' => 'Zona horaria del sistema'],
            ['clave' => 'sistema_moneda', 'valor' => 'BOB', 'categoria' => 'sistema', 'descripcion' => 'Moneda del sistema'],
            ['clave' => 'sistema_moneda_simbolo', 'valor' => 'Bs.', 'categoria' => 'sistema', 'descripcion' => 'Símbolo de la moneda'],
            ['clave' => 'sistema_pais', 'valor' => 'Bolivia', 'categoria' => 'sistema', 'descripcion' => 'País del sistema'],
            ['clave' => 'sistema_tiempo_sesion', 'valor' => '120', 'tipo' => 'number', 'categoria' => 'sistema', 'descripcion' => 'Tiempo de sesión en minutos'],
            
            // Seguridad
            ['clave' => 'seguridad_intentos_login', 'valor' => '3', 'tipo' => 'number', 'categoria' => 'seguridad', 'descripcion' => 'Intentos de login fallidos permitidos'],
            ['clave' => 'seguridad_auditoria', 'valor' => '1', 'tipo' => 'boolean', 'categoria' => 'seguridad', 'descripcion' => 'Activar auditoría de acciones'],
            ['clave' => 'seguridad_retencion_logs', 'valor' => '90', 'tipo' => 'number', 'categoria' => 'seguridad', 'descripcion' => 'Días de retención de logs'],
        ];

        foreach ($configuraciones as $config) {
            Configuracion::updateOrCreate(
                ['clave' => $config['clave']],
                $config
            );
        }
    }
}