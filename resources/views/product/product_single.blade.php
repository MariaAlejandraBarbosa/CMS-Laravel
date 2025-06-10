@extends('master')

@section('title', $product->name)

@section('custom_meta')
<meta name="product_id" content="{{ $product->id }}">
@stop

@section('content')
    <div class="product_single shadow">
        <div class="row">
            <!--img-->
            <div class="col-md-4 pleft0">
                <div class="slick-slider">
                    <div>
                        <a href="{{ url('/uploads/'.$product->file_path.'/'.$product->image) }}" data-fancybox="gallery">
                            <img src="{{ url('/uploads/'.$product->file_path.'/'.$product->image) }}" class="img-fluid">
                        </a>
                    </div>
                    @if(count($product->getGallery) > 0)
                        @foreach ($product->getGallery as $gallery)
                        <div>
                            <a href="{{ url('/uploads/'.$gallery->file_path.'/t_'.$gallery->file_name) }}">
                                <img src="{{ url('/uploads/'.$gallery->file_path.'/t_'.$gallery->file_name) }}" class="img-fluid">
                            </a>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-md-8">
                <h2 class="title">{{ $product->name }}</h2>
                <div class="category">
                    <ul>
                        <li><a href="{{ url('/') }}"><i class="fa-solid fa-house-user"></i> Inicio</a></li>
                        <li><span class="next"><i class="fa-solid fa-chevron-right"></i></span></li>
                        <li><a href="{{ url('/store') }}"><i class="fa-solid fa-store"></i> Tienda</a></li>
                        <li><span class="next"><i class="fa-solid fa-chevron-right"></i></span></li>
                        <li><a href="{{ url('/store') }}"><i class="fa-solid fa-folder"></i> {{ $product->cat->name }}</a></li>
                        @if($product->subcategory_id != "0")
                        <li><span class="next"><i class="fa-solid fa-chevron-right"></i></span></li>
                       
                        @endif
                    </ul>
                </div>
                <div class="add_cart">
                    {!! Form::open(['url' => '/cart/product/'.$product->id.'/add']) !!}
                    {!! Form::hidden('stock', null, ['id' => 'field_stock']) !!}
                    {!! Form::hidden('variant', null, ['id' => 'field_variant']) !!}
                    <div class="row">
                        <div class="col-md-12 mtop16">
                            <div class="variants">
                                <ul id="stock">
                                    @foreach($product->getStock as $stock)
                                    <li>
                                        <a href="#" class="stock" data-stock-id="{{ $stock->id }}">
                                            {{ $stock->name }} - <span class="price">{{ Config::get('cms.currency').number_format($stock->price, 2, '.',',') }}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="variants hidden btop1 ptop16 mtop16" id="variants_div">
                                <ul id="variantes"></ul>
                            </div>

                        </div>
                    </div>
                    <div class="before_quantity">
                        <h5 class="tittle">¿Qué cantidad deseas comprar?</h5>
                        <div class="row">
                            <div class="col-md-4  col-12">
                                <div class="quantity">
                                    <a href="#" class="amount_action" data-action="minus">
                                        <i class="fas fa-minus"></i>
                                    </a>
                                    {{ Form::number('quantity', 1, ['class' => 'form-control', 'id' => 'add_to_cart_quantity']) }}
                                    <a href="#" class="amount_action" data-action="plus">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <button type="submit" class="btn btn-success"><i class="fa-solid fa-cart-plus"></i> Agregar al carrito</button>
                            </div>
                            <div class="col-md-4 col-12">
                                <a href="#" id="favorite_1_{{ $product->id }}" onclick="add_to_favorites({{ $product->id }}, '1'); return false;" class="btn btn-favorite">
                                    <i class="fa-solid fa-heart"></i> Agregar a favoritos
                                </a>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection