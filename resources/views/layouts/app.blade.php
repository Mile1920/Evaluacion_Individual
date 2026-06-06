<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FARMABOL – @yield('titulo', 'Sistema de Inventario')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --verde:      #16a34a;
            --verde-dark: #15803d;
            --verde-light:#dcfce7;
            --rojo:       #dc2626;
            --amarillo:   #fbbf24;
            --gris-claro: #f9fafb;
            --gris:       #6b7280;
        }
        body { font-family: 'Segoe UI', sans-serif; background: var(--gris-claro); }

        /* NAV */
        .navbar {
            background: var(--verde-dark);
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 56px;
            box-shadow: 0 2px 8px rgba(0,0,0,.25);
        }
        .navbar-brand {
            color: #fff;
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-decoration: none;
        }
        .navbar-brand span { color: var(--amarillo); }
        .nav-links { display: flex; gap: .25rem; align-items: center; }
        .nav-links a {
            color: #d1fae5;
            padding: .4rem .85rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: .875rem;
            transition: background .15s;
        }
        .nav-links a:hover, .nav-links a.active { background: rgba(255,255,255,.18); color: #fff; }
        .nav-user {
            display: flex;
            align-items: center;
            gap: .75rem;
            color: #d1fae5;
            font-size: .825rem;
        }
        .badge-rol {
            background: var(--amarillo);
            color: #78350f;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .5px;
        }
        .btn-logout {
            background: rgba(255,255,255,.15);
            border: none;
            color: #fff;
            padding: .35rem .75rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: .8rem;
            transition: background .15s;
        }
        .btn-logout:hover { background: rgba(255,255,255,.3); }

        /* CONTENIDO */
        .content-wrapper { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }

        /* ALERTAS */
        .alert {
            padding: .85rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: .9rem;
            border-left: 4px solid;
        }
        .alert-success { background: #f0fdf4; border-color: var(--verde); color: #166534; }
        .alert-error   { background: #fef2f2; border-color: var(--rojo);  color: #991b1b; }

        /* TARJETA */
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 6px rgba(0,0,0,.08);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 1rem;
            padding-bottom: .6rem;
            border-bottom: 2px solid var(--verde-light);
        }

        /* TABLA */
        table { width: 100%; border-collapse: collapse; font-size: .875rem; }
        th {
            background: var(--verde-dark);
            color: #fff;
            padding: .65rem 1rem;
            text-align: left;
            font-weight: 600;
        }
        td { padding: .6rem 1rem; border-bottom: 1px solid #f0f0f0; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f0fdf4; }

        /* BOTONES */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .5rem 1.1rem;
            border-radius: 7px;
            font-size: .875rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: opacity .15s, transform .1s;
        }
        .btn:hover { opacity: .88; transform: translateY(-1px); }
        .btn-primary  { background: var(--verde);  color: #fff; }
        .btn-warning  { background: var(--amarillo); color: #78350f; }
        .btn-danger   { background: var(--rojo);   color: #fff; }
        .btn-secondary{ background: #e5e7eb; color: #374151; }
        .btn-sm { padding: .3rem .7rem; font-size: .78rem; }

        /* FORMULARIOS */
        .form-group { margin-bottom: 1rem; }
        .form-label { display: block; font-weight: 600; font-size: .875rem; color: #374151; margin-bottom: .35rem; }
        .form-control {
            width: 100%;
            padding: .55rem .85rem;
            border: 1.5px solid #d1d5db;
            border-radius: 7px;
            font-size: .9rem;
            transition: border-color .15s;
            box-sizing: border-box;
        }
        .form-control:focus { outline: none; border-color: var(--verde); box-shadow: 0 0 0 3px #bbf7d0; }
        .form-error { color: var(--rojo); font-size: .8rem; margin-top: .3rem; }

        /* ESTADÍSTICAS */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.25rem;
            box-shadow: 0 1px 6px rgba(0,0,0,.08);
            border-left: 4px solid var(--verde);
        }
        .stat-label { font-size: .8rem; color: var(--gris); font-weight: 600; text-transform: uppercase; letter-spacing: .5px; }
        .stat-value { font-size: 1.75rem; font-weight: 800; color: #111; margin-top: .25rem; }
        .stat-card.danger { border-color: var(--rojo); }
        .stat-card.warning { border-color: var(--amarillo); }

        /* BADGE STOCK */
        .stock-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: .75rem;
            font-weight: 700;
        }
        .stock-ok   { background: #dcfce7; color: #15803d; }
        .stock-low  { background: #fef9c3; color: #854d0e; }
        .stock-out  { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>

{{-- ─── NAVBAR ─── --}}
<nav class="navbar">
    <a href="{{ route('dashboard') }}" class="navbar-brand"> FARMA<span>BOL</span></a>

    <div class="nav-links">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('productos.index') }}" class="{{ request()->routeIs('productos.*') ? 'active' : '' }}">Productos</a>
        <a href="{{ route('ventas.index') }}" class="{{ request()->routeIs('ventas.*') ? 'active' : '' }}">Ventas</a>
    </div>

    <div class="nav-user">
        <span>{{ auth()->user()->name }}</span>
        <span class="badge-rol">{{ auth()->user()->rol }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">Salir</button>
        </form>
    </div>
</nav>

{{-- ─── CONTENIDO ─── --}}
<div class="content-wrapper">

    {{-- Alertas flash --}}
    @if(session('success'))
        <div class="alert alert-success"> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error"> {{ session('error') }}</div>
    @endif

    @yield('content')
</div>

</body>
</html>