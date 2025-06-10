@extends('master')

@section('title', 'Mis direcciones de entrega')

@section('content')
<div class="row mtop32">
    <div class="col-md-3">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title">
                    <i class="fa-solid fa-location-dot"></i>&nbsp; Agregar dirección
                </h2>
            </div>
            <div class="inside">
               {!! Form::open(['url' => '/account/address/add']) !!}
                <label for="name">Nombre:</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-regular fa-keyboard"></i>
                    </span>
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>

                <label for="state" class="mtop16">Ciudad:</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-regular fa-keyboard"></i>
                    </span>
                    {!! Form::select('state', $states, null, ['class' => 'form-select', 'id' => 'states']) !!}
                </div>

                <label for="add1" class="mtop16">Barrio:</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-regular fa-keyboard"></i>
                    </span>
                    {!! Form::text('add1', null, ['class' => 'form-control']) !!}
                </div>

                <label for="add2" class="mtop16">Calle / Avenida:</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-regular fa-keyboard"></i>
                    </span>
                    {!! Form::text('add2', null, ['class' => 'form-control']) !!}
                </div>

                <label for="add3" class="mtop16">Casa / Apartamento:</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-regular fa-keyboard"></i>
                    </span>
                    {!! Form::text('add3', null, ['class' => 'form-control']) !!}
                </div>

                <label for="add4" class="mtop16">Referencia</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-regular fa-keyboard"></i>
                    </span>
                    {!! Form::text('add4', null, ['class' => 'form-control']) !!}
                </div>

               <div class="row mtop16">
                    <div class="col-md-12">
                        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                    </div>
               </div>
               {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title">
                    <i class="fa-solid fa-location-dot"></i>&nbsp; Mis direcciones de entrega
                </h2>
            </div>
            <div class="inside">
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <td><strong>Nombre</strong></td>
                            <td><strong>Ciudad</strong></td>
                            <td><strong>Dirección</strong></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(Auth::user()->getAddress as $address)
                        <tr>
                            <td>
                                <p>{{ $address->name }}</p>
                            </td>
                            <td>
                                <p>
                                    {{ $address->getState->name }}
                                </p>
                                @if($address->default == "0") 
                                    <p><a href="{{ url('account/address/'.$address->id.'/setdefault') }}">Convertir en principal</a> </p>
                                @else
                                <p>
                                    <small>Dirección de entrega principal</small>
                                </p>
                                @endif
                            </td>
                            <td>
                                <p>
                                    <strong>Ciudad: </strong>{{ kvfj($address->addr_info, 'add1') }}
                                </p>

                                <p>
                                    <strong>Calle / Avenida: </strong>{{ kvfj($address->addr_info, 'add2') }}
                                </p>

                                <p>
                                    <strong>Casa / Apartamento: </strong>{{ kvfj($address->addr_info, 'add3') }}
                                </p>

                                <p>
                                    <strong>Referencia: </strong>{{ kvfj($address->addr_info, 'add4') }}
                                </p>
                            </td>
                            <td>
                                @if($address->default == "0")
                                    <a href="{{ url('/account/address/'.$address->id .'/delete') }}" class="btn-deleted" data-path="account/address" data-action="delete" data-object="{{ $address->id }}" data-bs-title="Eliminar">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection