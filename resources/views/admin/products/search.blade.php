@extends('admin.master')

@section('title', 'Productos')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ url('/admin/products') }}"><i class="fa-solid fa-box-open"></i>Productos</a>
</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="panel shadow">
        <div class="header">
            <h2 class="title">
                <i class="fa-solid fa-box-open"></i>Productos
            </h2>
            <ul>
                @if(kvfj(Auth::user()->permissions, 'product_add'))
                <li>
                    <a href="{{ url('/admin/products/add') }}" >
                        <i class="fa-solid fa-plus"></i>Agregar Producto
                    </a>
                </li>
                @endif
                <li>
                    <a href="">Filtrar <i class="fa-solid fa-arrow-down"></i></a>
                    <ul class="shadow">
                        <li>
                            <a href="{{ url('/admin/products/1') }}"><i class="fa-solid fa-globe"></i>Públicos</a>
                            <a href="{{ url('/admin/products/0') }}"><i class="fa-solid fa-eraser"></i>Borrador</a>
                            <a href="{{ url('/admin/products/trash') }}"><i class="fa-solid fa-trash"></i>Papalera</a>
                            <a href="{{ url('/admin/products/0') }}"><i class="fa-solid fa-list"></i>Todos</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" id="btn_search">
                        <i class="fa-solid fa-magnifying-glass"></i>Buscar
                    </a>
                    
                </li>
            </ul>
        </div>

        <div class="inside">
            <div class="form_search" id="form_search">
                {!! Form::open(['url' => '/admin/product/search']) !!}
                <div class="row">
                    <div class="col-md-4">
                        {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Ingrese su busqueda','required']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::select('filter', ['0' => 'Nombre del producto', '1' => 'Código'], 0, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::select('status', ['0' => 'Borrador', '1' => 'Público'], 0, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td></td>
                        <td>Nombre</td>
                        <td>Categoria</td>
                        <td>Precio</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $p)
                    <tr>
                        <td width="50">{{ $p->id }}</td>
                        <td width="60">
                            <a href="{{ url('/uploads/'.$p->file_path.'/'.$p->image) }}" data-fancybox="gallery">
                                <img src="{{ url('/uploads/'.$p->file_path.'/'.$p->image) }}" width="60">
                            </a>
                        </td>
                        <td>{{ $p->name }} @if($p->status == "0") <i class="fa-solid fa-eraser" data-toggle="tooltip" data-bs-placement="top" data-bs-title="Estado: Borrador"></i> @endif</td>
                        <td>{{ $p->cat->name }}</td>
                        <td>{{ $p->price }}</td>
                        <td>
                            <div class="opts">
                                @if(kvfj(Auth::user()->permissions, 'product_edit'))
                                <a href="{{ url('/admin/product/'.$p->id.'/edit') }}" data-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar">
                                    <i class="fa-solid fa-pen-nib"></i>
                                </a>
                                @endif
                                @if(kvfj(Auth::user()->permissions, 'product_delete'))
                                <a href="{{ url('/admin/product/'.$p->id.'/delete') }}" data-toggle="tooltip" data-bs-placement="top" data-bs-title="Eliminar">
                                    <i class="fa-solid fa-trash-can"></i>
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
<script type="text/javascript">
    Fancybox.bind("[data-fancybox]", {
        Carousel: {
            infinite: false,
        },
    });
</script>
@endsection