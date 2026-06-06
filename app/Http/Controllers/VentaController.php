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
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad'    => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        if ($request->cantidad > $producto->stock) {
            return back()
                ->withInput()
                ->withErrors(['cantidad' => "Stock insuficiente. Disponible: {$producto->stock} unidades."]);
        }

        DB::transaction(function () use ($request, $producto) {
            $total = $producto->precio * $request->cantidad;

            Venta::create([
                'producto_id' => $producto->id,
                'user_id'     => auth()->id(),
                'cantidad'    => $request->cantidad,
                'total'       => $total,
            ]);

            $producto->decrement('stock', $request->cantidad);
        });

        return redirect()->route('ventas.index')
                         ->with('success', "Venta registrada. Stock de \"{$producto->nombre}\" actualizado.");
    }
}