@extends('admin.master')

@section('title', 'Inventario de Producto')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ url('/admin/products/1') }}"><i class="fa-solid fa-box-open"></i>Productos</a>
</li>

<li class="breadcrumb-item">
    <a href="{{ url('/admin/product/'.$product->id.'/edit') }}"><i class="fa-solid fa-box-open"></i> {{ $product->name }}</a>
</li>

<li class="breadcrumb-item">
    <a href="{{ url('/admin/product/'.$product->id.'/stock') }}"><i class="fa-solid fa-box"></i> Inventario</a>
</li>

@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!--Columna 1-->
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-box"></i> Crear Inventario</h2>
                </div>
                <div class="inside">
                    {!! Form::open(['url' => '/admin/product/'.$product->id.'/stock']) !!}
                    <label for="name">Nombre:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-regular fa-keyboard"></i>
                        </span>
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>

                    <label for="stock" class="mtop16">Cantidad en Inventario:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-regular fa-keyboard"></i>
                        </span>
                        {!! Form::number('stock', 1.00, ['class' => 'form-control', 'min' => '1']) !!}
                    </div>

                    <label for="stock" class="mtop16">Precio:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            {{ config('cms.currency') }}
                        </span>
                        {!! Form::number('price', 1.00, ['class' => 'form-control', 'min' => '1', 'step' => 'any']) !!}
                    </div>

                    <label for="limited" class="mtop16">Limite de inventario:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-regular fa-keyboard"></i>
                        </span>
                        {!! Form::select('limited', ['0' => 'Limitado', '1' => 'Ilimitado'], 0, ['class' => 'form-select']) !!}
                    </div>

                    <label for="minimun" class="mtop16">Inventario minimo:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-regular fa-keyboard"></i>
                        </span>
                        {!! Form::number('minimun', 1, ['class' => 'form-control', 'min' => '1']) !!}
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
                    <h2 class="title"><i class="fa-solid fa-box"></i> Inventarios</h2>
                </div>
                <div class="inside">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Nombre</td>
                                <td>Existencias</td>
                                <td>Minimo</td>
                                <td>Precio</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product->getStock as $stock)
                            <tr>
                                <td>{{ $stock->id }}</td>
                                <td>{{ $stock->name }}</td>
                                <td>
                                    @if($stock->limited == "1")
                                    Ilimitada
                                    @else
                                    {{ $stock->quantity }}
                                    @endif
                                </td>
                                <td>
                                    @if($stock->limited == "1")
                                    Ilimitada
                                    @else
                                    {{ $stock->minimun }}
                                    @endif
                                </td>
                                <td>{{ config('cms.currency') }} {{ $stock->price }}</td>
                                <td width="160">
                                    <div class="opts">
                                        <a href="{{ url('/admin/product/stock/'.$stock->id.'/edit') }}" data-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar">
                                            <i class="fa-solid fa-pen-nib"></i>
                                        </a>

                                        <a href="{{ url('/admin/product/stock/'.$stock->id.'/variants') }}" data-toggle="tooltip" data-bs-placement="top" data-bs-title="Variantes">
                                            <i class="fa-solid fa-box"></i>
                                        </a>

                                        <a href="#" data-path="admin/product/stock" data-action="delete" data-object="{{ $stock->id }}" data-toggle="tooltip" data-bs-placement="top" data-bs-title="Eliminar" class="btn-deleted">
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