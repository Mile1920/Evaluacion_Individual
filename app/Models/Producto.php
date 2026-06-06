<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'codigo',
        'nombre',
        'precio',
        'stock',
        'laboratorio',
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function scopeStockBajo($query)
    {
        return $query->where('stock', '<', 5);
    }
}
