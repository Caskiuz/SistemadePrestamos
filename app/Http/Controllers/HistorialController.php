<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class HistorialController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'sold');
        $q = $request->get('q');

        $query = Producto::query();

        // Filtrar por estado
        switch ($status) {
            case 'sold':
                $query->where('estado', 'vendido');
                $statusLabel = 'vendidas';
                break;
            case 'settled':
                $query->where('estado', 'liquidado');
                $statusLabel = 'liquidadas';
                break;
            case 'cancelled':
                $query->where('estado', 'cancelado');
                $statusLabel = 'canceladas';
                break;
            default:
                $query->where('estado', 'vendido');
                $statusLabel = 'vendidas';
        }

        // Búsqueda segura
        if ($q) {
            $query->where(function($query) use ($q) {
                $searchTerm = '%' . addslashes($q) . '%';
                $query->where('nombre', 'like', $searchTerm)
                      ->orWhere('descripcion', 'like', $searchTerm)
                      ->orWhere('numero_serie', 'like', $searchTerm);
            });
        }

        $prendas = $query->with('almacen')->orderBy('updated_at', 'desc')->get()->map(function($prenda) use ($status) {
            return [
                'folio' => $prenda->numero_serie ?? $prenda->id,
                'descripcion' => $prenda->nombre . ($prenda->descripcion ? ' - ' . $prenda->descripcion : ''),
                'fecha_formateada' => $prenda->updated_at->format('d M Y'),
                'hora_formateada' => $prenda->updated_at->format('h:i A'),
                'monto_formateado' => '$' . number_format($prenda->precio_venta ?? $prenda->valuacion ?? 0, 2),
                'tipo_label' => ucfirst($status === 'sold' ? 'Vendido' : ($status === 'settled' ? 'Liquidado' : 'Cancelado')),
                'color' => $status === 'sold' ? '#4CAF50' : ($status === 'settled' ? '#2196F3' : '#F44336'),
            ];
        });

        return view('modules.historial.index', compact('prendas', 'status', 'statusLabel'));
    }
}
