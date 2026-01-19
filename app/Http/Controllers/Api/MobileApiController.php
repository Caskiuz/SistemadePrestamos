<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Prestamo;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\CashFlow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MobileApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'rol' => $user->rol
            ],
            'token' => $token
        ]);
    }

    public function dashboard()
    {
        $hoy = Carbon::today();
        
        return response()->json([
            'success' => true,
            'data' => [
                'prestamos_activos' => Prestamo::where('estado', 'activo')->count(),
                'prestamos_vencidos' => Prestamo::where('estado', 'vencido')->count(),
                'clientes_activos' => Cliente::whereHas('prestamos', function($q) {
                    $q->where('estado', 'activo');
                })->count(),
                'efectivo_caja' => CashFlow::sum('monto'),
                'prestamos_hoy' => Prestamo::whereDate('created_at', $hoy)->count(),
                'pagos_hoy' => CashFlow::where('tipo', 'ingreso')
                    ->whereDate('created_at', $hoy)
                    ->sum('monto')
            ]
        ]);
    }

    public function prestamos(Request $request)
    {
        $query = Prestamo::with(['cliente', 'productos'])
            ->orderBy('created_at', 'desc');

        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('cliente', function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('telefono', 'like', "%{$search}%");
            });
        }

        $prestamos = $query->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $prestamos->items(),
            'pagination' => [
                'current_page' => $prestamos->currentPage(),
                'last_page' => $prestamos->lastPage(),
                'total' => $prestamos->total()
            ]
        ]);
    }

    public function prestamo($id)
    {
        $prestamo = Prestamo::with(['cliente', 'productos.fotos', 'operaciones'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $prestamo
        ]);
    }

    public function registrarPago(Request $request, $prestamoId)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0.01',
            'tipo' => 'required|in:refrendo,liquidacion,abono_capital',
            'notas' => 'nullable|string'
        ]);

        $prestamo = Prestamo::findOrFail($prestamoId);

        $prestamo->operaciones()->create([
            'tipo' => $request->tipo,
            'descripcion' => $request->notas ?? "Pago {$request->tipo}",
            'abono' => $request->monto,
            'cargo' => 0,
            'saldo' => $prestamo->monto_pendiente - $request->monto,
            'usuario_id' => Auth::id()
        ]);

        $nuevoSaldo = $prestamo->monto_pendiente - $request->monto;
        
        if ($nuevoSaldo <= 0) {
            $prestamo->update([
                'estado' => 'liquidado',
                'monto_pendiente' => 0,
                'fecha_liquidacion' => now()
            ]);
        } else {
            $prestamo->update([
                'monto_pendiente' => $nuevoSaldo
            ]);
        }

        CashFlow::create([
            'tipo' => 'ingreso',
            'monto' => $request->monto,
            'descripcion' => "Pago préstamo #{$prestamo->folio}",
            'prestamo_id' => $prestamo->id,
            'usuario_id' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pago registrado correctamente',
            'prestamo' => $prestamo->fresh()
        ]);
    }
}