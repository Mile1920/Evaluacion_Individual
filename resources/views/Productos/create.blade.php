@extends('layouts.app')
@section('titulo', 'Nuevo Producto')

@section('content')

<div style="max-width:600px; margin:0 auto;">

    <div style="display:flex; align-items:center; gap:.75rem; margin-bottom:1.25rem;">
        <a href="{{ route('productos.index') }}" class="btn btn-secondary btn-sm">← Volver</a>
        <h1 style="font-size:1.3rem; font-weight:800; color:#111;">Nuevo Producto</h1>
    </div>

    <div class="card">
        <form action="{{ route('productos.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Código del producto *</label>
                <input type="text" name="codigo" class="form-control" value="{{ old('codigo') }}"
                       placeholder="Ej: FAR-001" required>
                @error('codigo')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Nombre del producto *</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}"
                       placeholder="Ej: Paracetamol 500mg" required>
                @error('nombre')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Precio (Bs.) *</label>
                    <input type="number" name="precio" class="form-control" value="{{ old('precio') }}"
                           placeholder="0.00" step="0.01" min="0" required>
                    @error('precio')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Stock inicial *</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}"
                           placeholder="0" min="0" required>
                    @error('stock')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Laboratorio *</label>
                <input type="text" name="laboratorio" class="form-control" value="{{ old('laboratorio') }}"
                       placeholder="Ej: Inti Pharma" required>
                @error('laboratorio')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div style="display:flex; gap:.75rem; justify-content:flex-end; margin-top:1.5rem;">
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Producto</button>
            </div>
        </form>
    </div>
</div>

@endsection