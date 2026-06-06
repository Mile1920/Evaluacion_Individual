@extends('layouts.app')
@section('titulo', 'Registrar Venta')

@section('content')

<div style="max-width:580px; margin:0 auto;">

    <div style="display:flex; align-items:center; gap:.75rem; margin-bottom:1.25rem;">
        <a href="{{ route('ventas.index') }}" class="btn btn-secondary btn-sm">← Volver</a>
        <h1 style="font-size:1.3rem; font-weight:800; color:#111;">Registrar Nueva Venta</h1>
    </div>

    <div class="card">
        <form action="{{ route('ventas.store') }}" method="POST" id="formVenta">
            @csrf

            <div class="form-group">
                <label class="form-label">Producto *</label>
                <select name="producto_id" id="selectProducto" class="form-control" required>
                    <option value="">— Seleccionar producto —</option>
                    @foreach($productos as $p)
                        <option value="{{ $p->id }}"
                                data-precio="{{ $p->precio }}"
                                data-stock="{{ $p->stock }}"
                                {{ old('producto_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nombre }} — Stock: {{ $p->stock }} uds. — Bs. {{ number_format($p->precio,2) }}
                        </option>
                    @endforeach
                </select>
                @error('producto_id')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            {{-- Info del producto seleccionado --}}
            <div id="infoProducto" style="display:none; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:.85rem 1rem; margin-bottom:1rem; font-size:.875rem;">
                <div><strong>Precio unitario:</strong> Bs. <span id="precioUnitario">0.00</span></div>
                <div><strong>Stock disponible:</strong> <span id="stockDisponible">0</span> unidades</div>
            </div>

            <div class="form-group">
                <label class="form-label">Cantidad *</label>
                <input type="number" name="cantidad" id="inputCantidad" class="form-control"
                       value="{{ old('cantidad', 1) }}" min="1" required>
                @error('cantidad')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            {{-- Total calculado --}}
            <div id="resumenVenta" style="display:none; background:#16a34a; color:#fff; border-radius:10px; padding:1rem 1.25rem; margin-bottom:1.25rem; text-align:center;">
                <div style="font-size:.85rem; opacity:.85;">TOTAL A COBRAR</div>
                <div style="font-size:2rem; font-weight:900;">Bs. <span id="totalCalculado">0.00</span></div>
            </div>

            <div style="display:flex; gap:.75rem; justify-content:flex-end;">
                <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">✅ Confirmar Venta</button>
            </div>
        </form>
    </div>
</div>

<script>
    const select   = document.getElementById('selectProducto');
    const cantidad = document.getElementById('inputCantidad');
    const infoBox  = document.getElementById('infoProducto');
    const resumen  = document.getElementById('resumenVenta');

    function recalcular() {
        const opt = select.options[select.selectedIndex];
        if (!opt || !opt.value) {
            infoBox.style.display = 'none';
            resumen.style.display = 'none';
            return;
        }

        const precio = parseFloat(opt.dataset.precio) || 0;
        const stock  = parseInt(opt.dataset.stock)    || 0;
        const cant   = parseInt(cantidad.value)       || 0;

        document.getElementById('precioUnitario').textContent = precio.toFixed(2);
        document.getElementById('stockDisponible').textContent = stock;
        infoBox.style.display = 'block';

        // Limitar cantidad al stock disponible
        cantidad.max = stock;

        if (cant > 0 && precio > 0) {
            document.getElementById('totalCalculado').textContent = (precio * cant).toFixed(2);
            resumen.style.display = 'block';
        } else {
            resumen.style.display = 'none';
        }
    }

    select.addEventListener('change', recalcular);
    cantidad.addEventListener('input', recalcular);
    recalcular(); // Ejecutar al cargar (si hay valor old)
</script>

@endsection