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
                    {!! Form::open(['url' => '/admin/coverage/state/add/', 'files' => true]) !!}
                    <label for="name">Nombre:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-regular fa-keyboard"></i>
                        </span>
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
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

        <div class="col-md-9">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-truck-fast"></i> Listado de estados</h2>
                </div>
                <div class="inside">
                    <table class="table mtop16">
                        <thead>
                            <tr>
                                <td><strong>Estado</strong></td>
                                <td><strong>Estado / departamento</strong></td>
                                <td><strong>Valor del envió</strong></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($states as $state)
                            <tr>
                                <td>{{ $state->status }}</td>
                                <td>{{ $state->name }}</td>
                                <td>{{ config('cms.currency') }} {{ $state->price }}</td>
                                <td>
                                    <div class="opts">
                                        @if(kvfj(Auth::user()->permissions, 'coverage_edit'))
                                        <a href="{{ url('/admin/coverage/'.$state->id.'/edit') }}" data-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar">
                                            <i class="fa-solid fa-pen-nib"></i>
                                        </a>
    
                                        <a href="{{ url('/admin/coverage/'.$state->id.'/cities') }}" data-toggle="tooltip" data-bs-placement="top" data-bs-title="Ciudades">
                                            <i class="fa-solid fa-list-ul"></i>
                                        </a>
                                        @endif
                                        @if(kvfj(Auth::user()->permissions, 'coverage_delete'))
                                        <a href="{{ url('/admin/coverage/'.$state->id.'/restore') }}" data-action="delete" data-path="admin/coverage" data-object="{{ $state->id }}" data-toggle="tooltip" data-bs-placement="top" data-bs-title="Eliminar" class="btn-deleted">
                                            <i class="fa-solid fa-trash-alt"></i>
                                        </a>
                                        @endif
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
@endsection