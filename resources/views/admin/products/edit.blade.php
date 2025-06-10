@extends('admin.master')

@section('title', 'Editar Producto')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ url('/admin/products') }}"><i class="fa-solid fa-box-open"></i>Productos</a>
</li>

@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-pencil"></i>Editar Producto</h2>
                </div>
                <div class="inside">
                    {!! Form::open(['url' => '/admin/product/'.$p->id.'/edit', 'files' => true]) !!}
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name">Nombre del producto</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-regular fa-keyboard"></i>
                                </span>
                                {!! Form::text('name', $p->name, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="category">Categoría</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-regular fa-keyboard"></i>
                                </span>
                                {!! Form::select('category', $cats, $p->category_id, ['class' => 'form-select']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="name">Imagen Destacada</label>
                            <div class="custom-file">
                                {!! Form::file('img', ['class' => 'form-control form-control-sm', 'id' => 'formFileSm', 'accept' => "image/*"]) !!}
                            </div>
                        </div>
                    </div>
        
                    <div class="row mtop16">        
                        <div class="col-md-3" id="2">
                            <label for="indiscount">¿En descuento?:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-regular fa-keyboard"></i>
                                </span>
                                {!! Form::select('indiscount', ['0' => 'No', '1' => 'Si'], $p->in_discount, ['class' => 'form-select']) !!}
                            </div>
                        </div>
        
                        <div class="col-md-3">
                            <label for="discount">Descuento</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-regular fa-keyboard"></i>
                                </span>
                                {!! Form::number('discount', $p->discount, ['class' => 'form-control', 'min' => '0.00', 'step' => 'any']) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="discount_until_date">Fecha limite de descuento:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-regular fa-keyboard"></i>
                                </span>
                                {!! Form::date('discount_until_date', $p->discount_until_date, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        
                        <div class="col-md-3" id="2">
                            <label for="indiscount">Estado:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-regular fa-keyboard"></i>
                                </span>
                                {!! Form::select('status', ['0' => 'Borrador', '1' => 'Publico'], $p->status, ['class' => 'form-select']) !!}
                            </div>
                        </div>
        
                    </div>

                    <div class="row mtop16">
                        <div class="col-md-3">
                            <label for="code">Codígo de sistema</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-regular fa-keyboard"></i>
                                </span>
                                {!! Form::text('code', $p->code, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>  
        
                    <div class="row mtop16">
                        <div class="col-md-12">
                            <label for="content">Descripción</label>
                            {!! Form::textarea('content', $p->content, ['class' =>'form-control', 'id' => 'editor1']) !!}
                        </div>
                    </div>
                    <div class="row mtop16">
                        <div class="col-md-12">
                            {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-regular fa-image"></i>&nbsp;&nbsp;Imagen Destacada</h2>
                    <div class="inside">
                        <img src="{{ url('/uploads/'.$p->file_path.'/'.$p->image) }}" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="panel shadow mtop16">
                <div class="header">
                    <h2 class="title"><i class="fa-regular fa-image"></i>&nbsp;&nbsp;Galeria</h2>
                </div>
                <div class="inside product_gallery">
                    @if(kvfj(Auth::user()->permissions, 'product_gallery_app'))
                    {!! Form::open(['url' => '/admin/product/'.$p->id.'/gallery/add', 'files' => true, 'id' => 'form_product_gallery']) !!}
                    {!! Form::file('file_image', ['id' => 'product_file_image', 'accept' => 'image/*', 'style' => 'display: none;', 'required']) !!}
                    {!! Form::close() !!}

                    <div class="btn-submit">
                        <a href="#" id="btn_product_file_image"><i class="fa-solid fa-plus"></i></a>
                    </div>
                    @endif
                    <div class="tumbs">
                        @foreach($p->getGallery as $img)
                        <div class="tumb">
                            @if(kvfj(Auth::user()->permissions, 'product_gallery_delete'))
                            <a href="{{ url('/admin/product/'.$p->id.'/gallery/'.$img->id.'/delete') }}" data-toggle="tooltip" data-bs-placement="top" data-bs-title="Eliminar">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                            @endif
                            <img src="{{ url('/uploads/'.$img->file_path.'/t_'.$img->file_name) }}">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    Fancybox.bind("[data-fancybox]", {
        Carousel: {
            infinite: false,
        },
    });
    document.addEventListener('DOMContentLoaded', function(){
        var btn_product_file_image = document.getElementById("btn_product_file_image");
        var product_file_image = document.getElementById("product_file_image");
        btn_product_file_image.addEventListener('click', function(){
            product_file_image.click();
        }, false);

        product_file_image.addEventListener('change', function(){
            document.getElementById('form_product_gallery').submit();
        });
    });
</script>
@endsection