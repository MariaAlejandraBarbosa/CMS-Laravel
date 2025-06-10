@extends('admin.master')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    @if(kvfj(Auth::user()->permissions, 'dashboard_small_stats'))
    <div class="panel shadow">
        <div class="header">
            <h2 class="title">
                <i class="fa-solid fa-chart-line"></i>&nbsp;Estadísticas rápidas.
            </h2>
        </div>
    </div>
    
    <div class="row mtop16">
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title">
                        <i class="fa-solid fa-users"></i>&nbsp;Usuarios registrados.
                    </h2>
                </div>
                <div class="inside">
                    <div class="big_count">{{ $users }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title">
                        <i class="fa-solid fa-boxes-stacked"></i>&nbsp;Productos en la BD.
                    </h2>
                </div>
                <div class="inside">
                    <div class="big_count">{{ $products }}</div>
                </div>
            </div>
        </div>

        @if(kvfj(Auth::user()->permissions, 'dashboard_sell_today'))
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title">
                        <i class="fa-solid fa-basket-shopping"></i>&nbsp;Ordenes hoy.
                    </h2>
                </div>
                <div class="inside">
                    <div class="big_count">0</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title">
                        <i class="fa-regular fa-credit-card"></i>&nbsp;Facturado hoy.
                    </h2>
                </div>
                <div class="inside">
                    <div class="big_count">0</div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif
</div>
@endsection