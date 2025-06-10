<div class="col-md-4 d-flex">
    <div class="panel shadow">
        <div class="header">
            <h2 class="title">
                <i class="fa-solid fa-box-open"></i>Modulo Productos
            </h2>
        </div>

        <div class="inside">
            <div class="form-check">
                <input type="checkbox" value="true" name="products" @if(kvfj($u->permissions, 'products')) checked @endif> 
                <label for="products">Puede ver el listado de productos.</label>
            </div>

            <div class="form-check">
                <input type="checkbox" value="true" name="product_add" @if(kvfj($u->permissions, 'product_add')) checked @endif> 
                <label for="product_add">Puede agregar nuevos productos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" value="true" name="product_edit" @if(kvfj($u->permissions, 'product_edit')) checked @endif> 
                <label for="product_edit">Puede editar productos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" value="true" name="product_search" @if(kvfj($u->permissions, 'product_search')) checked @endif> 
                <label for="product_search">Puede buscar productos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" value="true" name="product_delete" @if(kvfj($u->permissions, 'product_delete')) checked @endif> 
                <label for="product_delete">Puede eliminar productos.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" value="true" name="product_gallery_app" @if(kvfj($u->permissions, 'product_gallery_app')) checked @endif> 
                <label for="product_gallery_app">Puede agregar imágenes a la galería.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" value="true" name="product_gallery_delete" @if(kvfj($u->permissions, 'product_gallery_delete')) checked @endif> 
                <label for="product_gallery_delete">Puede eliminar imágenes de la galería.</label>
            </div>
            <div class="form-check">
                <input type="checkbox" value="true" name="product_stock" @if(kvfj($u->permissions, 'product_stock')) checked @endif> 
                <label for="product_stock">Puede eliminar imágenes de la galería.</label>
            </div>
        </div>
    </div>
</div>