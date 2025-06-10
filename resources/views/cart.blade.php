@extends('master')
@section('title', 'Carrito de compras')

@section('content')
<div class="cart mtop32">
    <div class="container">
        @if(count(collect($items)) == "0")
        <div class="no_items shadow">
            <div class="inside">
                <p><img src="{{ url('/static/images/carrito-de-compras.png') }}" alt=""></p>
                <p> <strong>Hola {{ Auth::user()->name }}</strong>, aun no hay nada en tu carrito de compras</p>
                <p>
                    <a href="{{ url('/store') }}">Ir a la tienda</a>
                </p>
            </div>
        </div>
        @else
        <div class="items mtop32">
                <div class="row">
                    <div class="col-md-9">
                        <div class="panel">
                            <div class="header">
                                <h2 class="title">
                                    <i class="fa-solid fa-cart-shopping"></i>&nbsp; Carrito de compras
                                </h2>
                            </div>
                            <div class="inside">
                                <table class="table table-striped align-middle table-hover">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <td width="80"></td>
                                            <td><strong>Producto</strong></td>
                                            <td width="160"><strong>Cantidad</strong></td>
                                            <td width="160"><strong>Subtotal</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($items as $item)
                                        <tr>
                                            <td>
                                                <a href="{{ url('/cart/item/'.$item->id.'/delete') }}" class="btn-delete">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <img src="{{ url('/uploads/'.$item->getProduct->file_path.'/t_'.$item->getProduct->image) }}" class="img-fluid rounded">
                                            </td>
                                            <td>
                                                <a href="{{ url('/product/'.$item->getProduct->id.'/t_'.$item->getProduct->slug) }}">
                                                    {{ $item->label_item }}
                                                    @if($item->discount_status == "1")
                                                    <div class="price_discount">
                                                        <span>{{ $item->price_initial }}</span> - <span>{{ $item->precie_unit }} ({{ $item->discount }}% de descuento)</span>
                                                    </div>
                                                    @endif
                                                </a>
                                            </td>
                                            <td>
                                                <div class="form_quantity">
                                                    {!! Form::open(['url' => '/cart/item/'.$item->id.'/update/']) !!}
                                                    {!! Form::number('quantity', $item->quantity, ['min' => '1', 'class' => 'form-control']) !!}
                                                    <button type="submit"><i class="fa-solid fa-floppy-disk"></i></button>
                                                    {!! Form::close() !!}
                                                </div>
                                            </td>
                                            <td><strong>{{ config('cms.currency').' '.number_format($item->total, 2, ',', '.' )}}</strong></td>
                                        </tr>
                                        @endforeach

                                        <tr>
                                            <td colspan="3"></td>
                                            <td><strong>Subtotal:</strong></td>
                                            <td><strong>{{ config('cms.currency').number_format($order->getSubtotal(), 2, '.', ',') }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td><strong>Precio de envió:</strong></td>
                                            <td><strong>{{ config('cms.currency').number_format('0.00', 2, '.', ',') }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td><strong>Total de la orden:</strong></td>
                                            <td><strong>{{ config('cms.currency').number_format('0.00', 2, '.', ',') }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        {!! Form::open(['url' => '/cart']) !!}
                        <div class="panel">
                            <div class="header">
                                <h2 class="title">
                                    <i class="fa-solid fa-location-dot"></i>&nbsp; Dirección de envió
                                </h2>
                            </div>
                            <div class="inside">
                                {{ Auth::user()->getAddressDefault }}
                            </div>
                        </div>

                        <div class="panel mtop16">
                            <div class="header">
                                <h2 class="title">
                                    <i class="fa-solid fa-envelope-open"></i>&nbsp; Más
                                </h2>
                            </div>
                            <div class="inside">
                                <label for="order_msg">Enviar Comentario</label>
                                {!! Form::textarea('order_msg', null, ['class' => 'form-control', 'rows' => 3]) !!}
                            </div>
                        </div>

                        <div class="panel mtop16">
                            <div class="inside">
                                {!! Form::submit('Completar orden', ['class' => 'btn btn-success']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
        </div>
        @endif
    </div>
</div>
@stop