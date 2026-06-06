@extends('layouts.app')
@section('titulo', 'Ventas del Día')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
    <h1 style="font-size:1.4rem; font-weight:800; color:#111;">🛒 Ventas del Día — {{ now()->format('d/m/Y') }}</h1>
    <a href="{{ route('ventas.create') }}" class="btn btn-primary">+ Registrar Venta</a>
</div>

{{-- Resumen total --}}
<div class="card" style="background:linear-gradient(135deg,#15803d,#16a34a); color:#fff; padding:1rem 1.5rem; margin-bottom:1.5rem;">
    <div style="font-size:.85rem; opacity:.85; font-weight:600;">TOTAL VENTAS HOY</div>
    <div style="font-size:2rem; font-weight:900;">Bs. {{ number_format($totalDia, 2) }}</div>
    <div style="font-size:.8rem; opacity:.7; margin-top:.25rem;">{{ $ventas->total() }} transacciones registradas</div>
</div>

<div class="card">
    @if($ventas->isEmpty())
        <p style="text-align:center; color:#6b7280; padding:2rem 0;">
            No hay ventas registradas hoy.
            <a href="{{ route('ventas.create') }}">Registrar la primera venta →</a>
        </p>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th style="text-align:center;">Cantidad</th>
                    <th style="text-align:right;">Precio Unit.</th>
                    <th style="text-align:right;">Total (Bs.)</th>
                    <th>Vendedor</th>
                    <th>Hora</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                <tr>
                    <td style="color:#9ca3af; font-size:.8rem;">{{ $venta->id }}</td>
                    <td>
                        <strong>{{ $venta->producto->nombre }}</strong><br>
                        <small style="color:#6b7280;">{{ $venta->producto->codigo }}</small>
                    </td>
                    <td style="text-align:center; font-weight:700;">{{ $venta->cantidad }}</td>
                    <td style="text-align:right;">{{ number_format($venta->producto->precio, 2) }}</td>
                    <td style="text-align:right; font-weight:800; color:#16a34a; font-size:1rem;">
                        {{ number_format($venta->total, 2) }}
                    </td>
                    <td style="font-size:.82rem;">{{ $venta->user->name }}</td>
                    <td style="font-size:.8rem; color:#6b7280;">{{ $venta->created_at->format('H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top:1rem;">
            {{ $ventas->links() }}
        </div>
    @endif
</div>

@endsection