<?php
// ARCHIVO: app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;

class DashboardController extends Controller
{
    public function index()
    {

        $productosStockBajo = Producto::stockBajo()->orderBy('stock')->get();

        $totalVentasDia = Venta::whereDate('created_at', today())->sum('total');

        $cantidadVentasDia = Venta::whereDate('created_at', today())->count();

        $totalProductos = Producto::count();

        $ultimasVentas = Venta::with(['producto', 'user'])
                               ->whereDate('created_at', today())
                               ->orderByDesc('created_at')
                               ->take(5)
                               ->get();

        return view('dashboard', compact(
            'productosStockBajo',
            'totalVentasDia',
            'cantidadVentasDia',
            'totalProductos',
            'ultimasVentas'
        ));
    }
}