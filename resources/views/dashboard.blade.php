@extends('layouts.app')
@section('titulo', 'Dashboard')

@section('content')

<h1 style="font-size:1.4rem; font-weight:800; margin-bottom:1.25rem; color:#111;">
     Panel de Control — {{ now()->format('d/m/Y') }}
</h1>

{{-- ─── TARJETAS DE ESTADÍSTICAS ─── --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label"> Ventas del día (Bs.)</div>
        <div class="stat-value">{{ number_format($totalVentasDia, 2) }}</div>
    </div>
    <div class="stat-card warning">
        <div class="stat-label"> Transacciones hoy</div>
        <div class="stat-value">{{ $cantidadVentasDia }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label"> Total productos</div>
        <div class="stat-value">{{ $totalProductos }}</div>
    </div>
    <div class="stat-card danger">
        <div class="stat-label"> Stock crítico (&lt;5)</div>
        <div class="stat-value">{{ $productosStockBajo->count() }}</div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">

    {{-- ─── PRODUCTOS CON STOCK BAJO ─── --}}
    <div class="card">
        <div class="card-title"> Productos con Stock Bajo (menos de 5 unidades)</div>
        @if($productosStockBajo->isEmpty())
            <p style="color:#16a34a; font-weight:600;"> Todos los productos tienen stock suficiente.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Laboratorio</th>
                        <th style="text-align:center;">Stock</th>
                        @if(auth()->user()->esAdmin())
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($productosStockBajo as $p)
                    <tr>
                        <td><strong>{{ $p->nombre }}</strong><br><small style="color:#6b7280;">{{ $p->codigo }}</small></td>
                        <td>{{ $p->laboratorio }}</td>
                        <td style="text-align:center;">
                            @if($p->stock == 0)
                                <span class="stock-badge stock-out">Sin stock</span>
                            @else
                                <span class="stock-badge stock-low">{{ $p->stock }} uds.</span>
                            @endif
                        </td>
                        @if(auth()->user()->esAdmin())
                        <td>
                            <a href="{{ route('productos.edit', $p) }}" class="btn btn-warning btn-sm">Reponer</a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- ─── ÚLTIMAS VENTAS DEL DÍA ─── --}}
    <div class="card">
        <div class="card-title">🛒 Últimas Ventas del Día</div>
        @if($ultimasVentas->isEmpty())
            <p style="color:#6b7280;">No hay ventas registradas hoy todavía.</p>
            <a href="{{ route('ventas.create') }}" class="btn btn-primary" style="margin-top:.5rem;">Registrar primera venta</a>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th style="text-align:center;">Cant.</th>
                        <th style="text-align:right;">Total (Bs.)</th>
                        <th>Vendedor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ultimasVentas as $v)
                    <tr>
                        <td>{{ $v->producto->nombre }}</td>
                        <td style="text-align:center;">{{ $v->cantidad }}</td>
                        <td style="text-align:right; font-weight:700; color:#16a34a;">{{ number_format($v->total, 2) }}</td>
                        <td style="font-size:.8rem; color:#6b7280;">{{ $v->user->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top:1rem; text-align:right;">
                <a href="{{ route('ventas.index') }}" class="btn btn-secondary btn-sm">Ver todas</a>
                <a href="{{ route('ventas.create') }}" class="btn btn-primary btn-sm">Nueva venta</a>
            </div>
        @endif
    </div>

</div>
@endsection