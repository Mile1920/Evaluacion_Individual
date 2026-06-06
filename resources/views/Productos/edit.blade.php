@extends('layouts.app')
@section('titulo', 'Editar Producto')

@section('content')

<div style="max-width:600px; margin:0 auto;">

    <div style="display:flex; align-items:center; gap:.75rem; margin-bottom:1.25rem;">
        <a href="{{ route('productos.index') }}" class="btn btn-secondary btn-sm">← Volver</a>
        <h1 style="font-size:1.3rem; font-weight:800; color:#111;">Editar: {{ $producto->nombre }}</h1>
    </div>

    <div class="card">
        <form action="{{ route('productos.update', $producto) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Código del producto *</label>
                <input type="text" name="codigo" class="form-control"
                       value="{{ old('codigo', $producto->codigo) }}" required>
                @error('codigo')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Nombre del producto *</label>
                <input type="text" name="nombre" class="form-control"
                       value="{{ old('nombre', $producto->nombre) }}" required>
                @error('nombre')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Precio (Bs.) *</label>
                    <input type="number" name="precio" class="form-control" step="0.01" min="0"
                           value="{{ old('precio', $producto->precio) }}" required>
                    @error('precio')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Stock *</label>
                    <input type="number" name="stock" class="form-control" min="0"
                           value="{{ old('stock', $producto->stock) }}" required>
                    @error('stock')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Laboratorio *</label>
                <input type="text" name="laboratorio" class="form-control"
                       value="{{ old('laboratorio', $producto->laboratorio) }}" required>
                @error('laboratorio')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div style="display:flex; gap:.75rem; justify-content:flex-end; margin-top:1.5rem;">
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Producto</button>
            </div>
        </form>
    </div>
</div>

@endsection