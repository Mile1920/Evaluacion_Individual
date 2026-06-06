<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{

    public function index()
    {
        $ventas = Venta::with(['producto', 'user'])
                        ->whereDate('created_at', today())
                        ->orderByDesc('created_at')
                        ->paginate(20);

        $totalDia = Venta::whereDate('created_at', today())->sum('total');

        return view('ventas.index', compact('ventas', 'totalDia'));
    }

    public function create()
    {

        $productos = Producto::where('stock', '>', 0)->orderBy('nombre')->get();
        return view('ventas.create', compact('productos'));
    }

    public function store(Request $request)
    {
        
        $producto = Producto::findOrFail($request->producto_id);

        if (!$request->producto_id) {
            return back()->withErrors(['producto_id' => 'Seleccione un producto.']);
        }
        if (!$request->cantidad) {
            return back()->withErrors(['cantidad' => 'Ingrese una cantidad.']);
        }
        if ($request->cantidad <= 0) {
            return back()->withErrors(['cantidad' => 'La cantidad debe ser mayor a 0.']);
        }
        if ($request->cantidad > $producto->stock) {
            return back()->withErrors(['cantidad' => 'Stock insuficiente.']);
        }

        $total = $producto->precio * $request->cantidad;
        Venta::create([
            'producto_id' => $request->producto_id,
            'user_id'     => auth()->id(),
            'cantidad'    => $request->cantidad,
            'total'       => $total,
        ]);
        $producto->stock = $producto->stock - $request->cantidad;
        $producto->save();

        return redirect()->route('ventas.index')->with('success', 'Venta registrada.');
    }
}