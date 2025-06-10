@extends('admin.master')

@section('title', 'Categorias')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ url('/admin/categories/0') }}"><i class="fa-solid fa-folder-open"></i>Categorias</a>
</li>
@if($cat->parent != "0")
<li class="breadcrumb-item">
    <a href="{{ url('/admin/category/'.$cat->parent.'/subs') }}"><i class="fa-solid fa-folder-open"></i>{{ $cat->getParent->name }}</a>
</li>

<li class="breadcrumb-item">
    <a href="{{ url('/admin/category/'.$cat->id.'/edit') }}"><i class="fa-solid fa-folder-open"></i> Editando {{ $cat->name }}</a>
</li>
@endif
<li class="breadcrumb-item">
    <a href="{{ url('/admin/category/'.$cat->id.'/edit') }}"><i class="fa-solid fa-folder-open"></i> Editando {{ $cat->name }}</a>
</li>
@endsection

@section('content')
<div class="div container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-pen-nib"></i>&nbsp;Editar Categoria</h2>
                </div>
                <div class="inside">
                    {!! Form::open(['url' => '/admin/category/'.$cat->id.'/edit', 'files' => true]) !!}
                    <label for="name">Nombre:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-regular fa-keyboard"></i>
                        </span>
                        {!! Form::text('name', $cat->name, ['class' => 'form-control']) !!}
                    </div>

                    <label for="module" class="mtop16">Módulo:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-regular fa-keyboard"></i>
                        </span>
                        {!! Form::select('module', getModulesArray(), $cat->module, ['class' => 'form-select']) !!}
                    </div>

                    <label for="icon" class="mtop16">Icono:</label>
                    <div class="custom-file">
                        {!! Form::file('icon', ['class' => 'form-control form-control-sm', 'id' => 'formFileSm', 'accept' => "image/*"]) !!}
                    </div>

                    <label for="name" class="mtop16">Orden:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-regular fa-keyboard"></i>
                        </span>
                        {!! Form::text('order', $cat->order, ['class' => 'form-control']) !!}
                    </div>

                    {!! Form::submit('Guardar', ['class' => 'btn btn-success mtop16']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        @if(!is_null($cat->icono))
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-pen-nib"></i>&nbsp;Icono</h2>
                </div>
                <div class="inside">
                    <img src="{{ url('/uploads/'.$cat->file_path.'/'.$cat->icono) }}" class="img-fluid">
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection