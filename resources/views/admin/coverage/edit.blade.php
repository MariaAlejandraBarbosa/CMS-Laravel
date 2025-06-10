@extends('admin.master')
@section('title', 'Cobertura de envios')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ url('/admin/coverage') }}"><i class="fa-solid fa-truck-fast"></i> Cobertura de envios</a>
</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @if(kvfj(Auth::user()->permissions, 'coverage_add'))
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-plus"></i>Agregar cobertura de envió</h2>
                </div>
                <div class="inside">
                    {!! Form::open(['url' => '/admin/coverage/state/'.$coverage->id.'/edit']) !!}
                    <label for="name">Nombre:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-regular fa-keyboard"></i>
                        </span>
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>
    
                    <label for="module" class="mtop16">Estatus:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-regular fa-keyboard"></i>
                        </span>
                        {!! Form::select('status', getCoverageStatus(), null, ['class' => 'form-select']) !!}
                    </div>

                    <label for="name" class="mtop16">Días estimados de entrega:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-regular fa-keyboard"></i>
                        </span>
                        {!! Form::number('days', 1, ['class' => 'form-control', 'min' => '0', 'step' => 'any']) !!}
                    </div>

                    {!! Form::submit('Guardar', ['class' => 'btn btn-success mtop16']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection