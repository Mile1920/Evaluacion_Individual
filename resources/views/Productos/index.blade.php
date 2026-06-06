@extends('layouts.app')
@section('titulo', 'Productos')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
    <h1 style="font-size:1.4rem; font-weight:800; color:#111;">Gestión de Productos</h1>
    @if(auth()->user()->esAdmin())
        <a href="{{ route('productos.create') }}" class="btn btn-primary">+ Nuevo Producto</a>
    @endif
</div>

<div class="card">
    @if($productos->isEmpty())
        <p style="color:#6b7280; text-align:center; padding:2rem 0;">
            No hay productos registrados.
            @if(auth()->user()->esAdmin())
                <a href="{{ route('productos.create') }}">Crear el primero →</a>
            @endif
        </p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Laboratorio</th>
                    <th style="text-align:right;">Precio (Bs.)</th>
                    <th style="text-align:center;">Stock</th>
                    @if(auth()->user()->esAdmin())
                    <th style="text-align:center;">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                <tr>
                    <td><code style="background:#f3f4f6; padding:2px 6px; border-radius:4px; font-size:.8rem;">{{ $producto->codigo }}</code></td>
                    <td><strong>{{ $producto->nombre }}</strong></td>
                    <td>{{ $producto->laboratorio }}</td>
                    <td style="text-align:right; font-weight:700;">{{ number_format($producto->precio, 2) }}</td>
                    <td style="text-align:center;">
                        @if($producto->stock == 0)
                            <span class="stock-badge stock-out">0 — Sin stock</span>
                        @elseif($producto->stock < 5)
                            <span class="stock-badge stock-low">{{ $producto->stock }} — Bajo</span>
                        @else
                            <span class="stock-badge stock-ok">{{ $producto->stock }}</span>
                        @endif
                    </td>
                    @if(auth()->user()->esAdmin())
                    <td style="text-align:center;">
                        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('productos.destroy', $producto) }}" method="POST"
                              style="display:inline;"
                              onsubmit="return confirm('¿Eliminar el producto {{ $producto->nombre }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top:1rem;">
            {{ $productos->links() }}
        </div>
    @endif
</div>

@endsection