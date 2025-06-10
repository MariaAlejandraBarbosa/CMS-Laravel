@extends('admin.master')

@section('title', 'Inventario de Producto')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ url('/admin/products/1') }}"><i class="fa-solid fa-box-open"></i>Productos</a>
</li>

<li class="breadcrumb-item">
    <a href="{{ url('/admin/product/'.$stock->getProduct->id.'/edit') }}"><i class="fa-solid fa-box-open"></i> {{ $stock->getProduct->name }}</a>
</li>

<li class="breadcrumb-item">
    <a href="{{ url('/admin/product/'.$stock->product_id.'/stock') }}"><i class="fa-solid fa-box"></i> Inventario</a>
</li>

<li class="breadcrumb-item">
    <a href="{{ url('/admin/product/stock/'.$stock->id.'/edit') }}"><i class="fa-solid fa-box"></i> {{ $stock->name }}</a>
</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!--Columna 1-->
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-box"></i> Editar Inventario</h2>
                </div>
                <div class="inside">
                    {!! Form::open(['url' => '/admin/product/stock/'.$stock->id.'/edit']) !!}
                    <label for="name">Nombre:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-regular fa-keyboard"></i>
                        </span>
                        {!! Form::text('name', $stock->name, ['class' => 'form-control']) !!}
                    </div>

                    <label for="stock" class="mtop16">Cantidad en Inventario:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-regular fa-keyboard"></i>
                        </span>
                        {!! Form::number('stock', $stock->quantity, ['class' => 'form-control', 'min' => '1']) !!}
                    </div>

                    <label for="stock" class="mtop16">Precio:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            {{ config('cms.currency') }}
                        </span>
                        {!! Form::number('price', $stock->price, ['class' => 'form-control', 'min' => '1', 'step' => 'any']) !!}
                    </div>

                    <label for="limited" class="mtop16">Limite de inventario:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-regular fa-keyboard"></i>
                        </span>
                        {!! Form::select('limited', ['0' => 'Limitado', '1' => 'Ilimitado'], $stock->limited, ['class' => 'form-select']) !!}
                    </div>

                    <label for="minimun" class="mtop16">Inventario minimo:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-regular fa-keyboard"></i>
                        </span>
                        {!! Form::number('minimun', $stock->minimun, ['class' => 'form-control', 'min' => '1']) !!}
                    </div>

                    {!! Form::submit('Guardar', ['class' => 'btn btn-success mtop16']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <!--Columna 2-->
        <div class="col-md-9">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-box"></i> Variantes</h2>
                </div>
                <div class="inside">
                    {!! Form::open(['url' => '/admin/product/stock/'.$stock->id.'/variant']) !!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-regular fa-keyboard"></i>
                                </span>
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la variante']) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <hr>
                    <table class="table">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Nombre</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stock->getVariants as $variant)
                            <tr>
                                <td width="30">{{ $variant->id }}</td>
                                <td>{{ $variant->name }}</td>
                                <td>
                                    <div class="opts">
                                        <a href="#" data-path="admin/product/variant" data-action="delete" data-object="{{ $variant->id }}" data-toggle="tooltip" data-bs-placement="top" data-bs-title="Eliminar" class="btn-deleted">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a> 
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="sweetalert2/dist/sweetalert2.min.js"></script>
@endsection