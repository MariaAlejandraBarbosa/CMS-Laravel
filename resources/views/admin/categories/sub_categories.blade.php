@extends('admin.master')

@section('title', 'Categorias')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ url('/admin/categories') }}"><i class="fa-solid fa-folder-open"></i>Categorias</a>
</li>

<li class="breadcrumb-item">
    <a href="#"><i class="fa-solid fa-folder-open"></i> Categoría {{ $category->name }}</a>
</li>

<li class="breadcrumb-item">
    <a href="#"><i class="fa-solid fa-folder-open"></i> Subcategorías</a>
</li>
@endsection

@section('content')
<div class="div container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-folder-open"></i>Subcategorías de <strong>{{ $category->name }}</strong></h2>
                </div>
                <div class="inside">
                    <table class="table mtop16">
                     <thead>
                         <tr>
                             <td width="64"></td>
                             <td>Nombre</td>
                             <td width="140"></td>
                         </tr>
                     </thead>
                     <tbody>
                        @foreach($category->getSubcategories as $cat)
                        <tr>
                            <td>
                               @if(!is_null($cat->icono))
                                   <img src="{{ url('/uploads/'.$cat->file_path.'/'.$cat->icono) }}" class="img-fluid">
                               @endif
                            </td>
                            <td>{{ $cat->name }}</td>
                            <td>
                               <div class="opts">
                                   @if(kvfj(Auth::user()->permissions, 'category_edit'))
                                   <a href="{{ url('/admin/category/'.$cat->id.'/edit') }}" data-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar">
                                       <i class="fa-solid fa-pen-nib"></i>
                                   </a>

                                   @endif
                                   @if(kvfj(Auth::user()->permissions, 'category_delete'))
                                   <a href="{{ url('/admin/category/'.$cat->id.'/delete') }}" data-toggle="tooltip" data-bs-placement="top" data-bs-title="Eliminar">
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
    </div>
</div>
@endsection