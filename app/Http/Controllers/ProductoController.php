<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('nombre')->paginate(15);
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        if (auth()->user()->rol !== 'ADMIN') {
            abort(403, 'Solo el ADMIN puede realizar esta acción.');
        }
        return view('productos.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->rol !== 'ADMIN') {
            abort(403);
        }

        $request->validate([
            'codigo'      => 'required|unique:productos,codigo|max:50',
            'nombre'      => 'required|max:150',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'laboratorio' => 'required|max:100',
        ]);

        Producto::create($request->only(['codigo', 'nombre', 'precio', 'stock', 'laboratorio']));

        return redirect()->route('productos.index')
                         ->with('success', 'Producto creado correctamente.');
    }

    public function edit(Producto $producto)
    {
        if (auth()->user()->rol !== 'ADMIN') {
            abort(403);
        }
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        if (auth()->user()->rol !== 'ADMIN') {
            abort(403);
        }

        $request->validate([
            'codigo'      => 'required|unique:productos,codigo,' . $producto->id . '|max:50',
            'nombre'      => 'required|max:150',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'laboratorio' => 'required|max:100',
        ]);

        $producto->update($request->only(['codigo', 'nombre', 'precio', 'stock', 'laboratorio']));

        return redirect()->route('productos.index')
                         ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        if (auth()->user()->rol !== 'ADMIN') {
            abort(403);
        }

        if ($producto->ventas()->count() > 0) {
            return redirect()->route('productos.index')
                             ->with('error', 'No se puede eliminar: tiene ventas registradas.');
        }

        $producto->delete();

        return redirect()->route('productos.index')
                         ->with('success', 'Producto eliminado.');
    }
}