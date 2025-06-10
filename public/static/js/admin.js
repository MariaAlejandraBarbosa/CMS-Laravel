var base = location.protocol+'//'+location.host;
var route =document.getElementsByName('routeName')[0].getAttribute('content');

document.addEventListener('DOMContentLoaded', function(){
    var btn_search = document.getElementById('btn_search');
    var form_search = document.getElementById('form_search');
    if(btn_search){
        btn_search.addEventListener('click', function(e){
            e.preventDefault();
            if(form_search.style.display === 'block'){
                form_search.style.display = 'none';
            }else{
                form_search.style.display = 'block';
            }
        });
    }
    if(route == "product_edit"){
        var btn_product_file_image = document.getElementById("btn_product_file_image");
        var product_file_image = document.getElementById("product_file_image");
        btn_product_file_image.addEventListener('click', function(){
            product_file_image.click();
        }, false);
    
        product_file_image.addEventListener('change', function(){
            document.getElementById('form_product_gallery').submit();
        });
    }
    route_active = document.getElementsByClassName('lk-'+route)[0].classList.add("active");

    btn_deleted = document.getElementsByClassName('btn-deleted');
    for(i=0; i < btn_deleted.length; i++){
        btn_deleted[i].addEventListener('click', delete_object); 
    }
    console.log(btn_deleted.length);
});

$(document).ready(function(){
    editor_init('editor');
})

function editor_init(field) {
    CKEDITOR.replace(field, {
        skin: 'moono-lisa',
        toolbar: [
            { name: 'clipboard', items: ['cut', 'Copy', 'Paste', 'PasteText', '-', 'Undo', 'Redo'] },
            { name: 'basicstyles', items: ['Bold', 'Italic', 'BulletedList', 'Strike', 'Image', 'Link', 'Inlink', 'Blockquote'] },
            { name: 'document', items: ['CodeSnippet', 'EmojiPanel', 'Preview', 'Source'] }
        ]
    });
}

function delete_object(e){
    e.preventDefault();
    var object = this.getAttribute('data-object');
    var action = this.getAttribute('data-action');
    var path = this.getAttribute('data-path');
    var url = base + '/' + path + '/' + object + '/' + action;
    var title, text, icon;
    if(action == "delete"){
        title= "¿Estas seguro de eliminar este objeto?";
        text = "Recuerda que este acción enviara este elemento a la papelera o lo eliminara de forma definitiva.";
        icon = "warning";
    }
    if(action == "restore"){
        title= "¿Quieres restaurar este objeto?";
        text = "Esta acción restaurará este elemento y estará activo en la base de datos.";
        icon = "info";
    }
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, do it!"
      }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
      });
}