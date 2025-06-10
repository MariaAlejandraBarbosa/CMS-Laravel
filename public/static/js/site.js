const base = location.protocol+'//'+location.host;
const route =document.getElementsByName('routeName')[0].getAttribute('content');
const http =new XMLHttpRequest();
const csrfToken =document.getElementsByName('csrf-token')[0].getAttribute('content');
const currency =document.getElementsByName('currency')[0].getAttribute('content');
const auth =document.getElementsByName('auth')[0].getAttribute('content');
var page=1;
var page_section = "";
var products_list_ids_temp = [];

$(document).ready(function(){
    $('.slick-slider').slick({dots: true,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 2000});
})

window.onload = function(){
    loader.style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function(){
    var page_route_name = document.getElementsByClassName('lk-'+route)[0];
    if(page_route_name){
        page_route_name.classList.add("active");
    }
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    var loader = document.getElementById('loader');
    var slider = new  MDSlider;
    var form_avatar_change = document.getElementById('form_avatar_change');
    var btn_avatar_edit = document.getElementById('btn_avatar_edit');
    var avatar_change_overlay = document.getElementById('avatar_change_overlay');
    var input_file_avatar = document.getElementById('input_file_avatar');
    var products_list = document.getElementById('products_list');
    var load_more_products =document.getElementById('load_more_products');
    let btn_deleted = document.getElementsByClassName('btn-deleted');
    if(btn_avatar_edit){
        btn_avatar_edit.addEventListener('click', function(e){
            e.preventDefault();
            input_file_avatar.click();
        });
    }

    if(load_more_products){
        load_more_products.addEventListener('click', function(e){
            e.preventDefault();
            load_products();
        });
    }

    if(input_file_avatar){
        input_file_avatar.addEventListener('change', function(){
            var load_img = '<img src="'+base+'/static/images/loader_white.svg"/>';
            avatar_change_overlay.innerHTML = load_img;
            avatar_change_overlay.style.display = 'flex';
            form_avatar_change.submit();
        });
    }

    slider.show();

    if(route == "home"){
        load_products('home');
    }

    if(route == "store"){
        load_products('store');
    }

    if(route == "store_category"){
        load_products('store_category');
    }

    if(route == "search"){
        mark_user_favorites([document.getElementsByName('product_id')[0].getAttribute('content')]);
    }

    if(route == "account_address"){
        var state = document.getElementById('states');
        if(state){
            state.addEventListener('change', load_cities);
        }
        load_cities();
    }

    if(route == "product_single"){
        var stock = document.getElementsByClassName('stock');
        for(i=0; i < stock.length; i++){
            stock[i].addEventListener('click', load_product_variants); 
        }
    }
    var amount_action = document.getElementsByClassName('amount_action');
    for(i=0; i < amount_action.length; i++){    
        amount_action[i].addEventListener('click', function(e){
            e.preventDefault();
            product_single_amount(this.getAttribute('data-action'));
        }); 
    }

    //btn_deleted = document.getElementsByClassName('btn-deleted');
    for(i=0; i < btn_deleted.length; i++){
        btn_deleted[i].addEventListener('click', function(e) {
            console.log('Click detectado'); // <-- Esto debe verse en la consola
            delete_object.call(this, e);
        });
        //btn_deleted[i].addEventListener('click', delete_object); 
    }
    console.log(btn_deleted.length);
});

function load_products(section){
    loader.style.display = 'flex';
    page_section = section;
    if(section == "store_category"){
        var object_id = document.getElementsByName('category_id')[0].getAttribute('content');
        var url = base + '/md/api/load/products/'+page_section+'?page='+page+'&object_id='+object_id;
    }else{
        var url = base + '/md/api/load/products/'+page_section+'?page='+page;
    }
    //console.log(url);
    http.open('GET', url, true);
    http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState ==4 && this.status == 200){
            loader.style.display = 'none';
            page = page +1;
            var data=this.responseText;
            //console.log(data);
            data = JSON.parse(data);

            if(data.data.length == 0){
                load_more_products.style.display ="none";
            }

            //console.log(data.data);
            data.data.forEach(function(product, index){
                products_list_ids_temp.push(product.id);

                var div = "";
                div += "<div class=\"product\">";
                    //div += "<img src=\""+base+"/uploads/"+product.file_path+"/t_"+product.image+"\">"
                    div += "<div class=\"image\">";
                        div += "<div class=\"overlay\">";
                            div += "<div class=\"btns\">";
                                div += "<a href=\""+base+"/product/"+product.id+"/"+product.slug+"\"><i class=\"fa-solid fa-eye\"></i></a>";
                                div += "<a href=\"\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" data-bs-title=\"Tooltip on top\"><i class=\"fa-solid fa-cart-plus\"></i></a>";
                                if(auth == "1"){
                                    div += "<a href=\"\" id=\"favorite_1_"+product.id+"\" onclick=\"add_to_favorites('"+product.id+"', '1'); return false;\"><i class=\"fa-solid fa-heart\"></i></a>";
                                }else{
                                    div += "<a href=\"\" id=\"favorite_1_"+product.id+"\" onclick=\" Swal.fire({title: 'Oops...', text: 'Hola invitado, para agregar a favoritos, ingresar a tu cuenta', icon: 'warning'}); return false;\"><i class=\"fa-solid fa-heart\"></i></a>";
                                }
                            div += "</div>";
                        div +="</div>"
                        div += "<img src=\""+base+"/uploads/"+product.file_path+"/t_"+product.image+"\" title=\""+product.name+"\">";
                    div += "</div>";
                    div += "<a href=\""+base+"/product/"+product.id+"/"+product.slug+"\">";
                        div += "<div class=\"title\">"+product.name+"</div>";
                        div += "<div class=\"price\">"+currency+product.price+"</div>";
                        div += "<div class=\"options\"></div>";
                    div += "</a>"
                div += "</div>";
                products_list.innerHTML +=div;
            });
            if(auth == "1"){
                mark_user_favorites(products_list_ids_temp);
                products_list_ids_temp = [];
            }
        }else{
            //Mensaje de error
        }

       
    }
}

function mark_user_favorites(objects){
    var url = base + '/md/api/load/user/favorites';    
    var params = 'module=1&objects='+objects;
    console.log(objects);
    http.open('POST', url, true);
    http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send(params);
    http.onreadystatechange = function(){
        if(this.readyState ==4 && this.status == 200){
            var data=this.responseText;
            data = JSON.parse(data);
            if(data.count > "0"){
                data.objects.forEach(function(favorite, index){
                    document.getElementById('favorite_1_'+favorite).removeAttribute('onclick');
                    document.getElementById('favorite_1_'+favorite).classList.add('favorite_active');
                });
            }
        }
    }
}

function add_to_favorites(object, module){
    url= base+'/md/api/favorites/add/'+object+'/'+module;
    http.open('POST', url, true);
    http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState ==4 && this.status == 200){
            var data = this.responseText;
            data = JSON.parse(data);
            if(data.status == "success"){
                document.getElementById('favorite_'+module+'_'+object).removeAttribute('onclick');
                document.getElementById('favorite_'+module+'_'+object).classList.add('favorite_active');
            }
        }}
}

function load_product_variants(){
    document.getElementById('variants_div').style.display = 'none';
    document.getElementById('variantes').innerHTML ="";
    document.getElementById('field_variant').value = null;
    loader.style.display = 'flex';
    var stock = document.getElementsByClassName('stock');
    for(i=0; i < stock.length; i++){
        stock[i].classList.remove('active'); 
    }
    var product_id = document.getElementsByName('product_id')[0].getAttribute('content');
    var stc = this.getAttribute('data-stock-id');
    document.getElementById('field_stock').value = stc;
    this.classList.add('active');

    var url = base + '/md/api/load/product/stock/'+stc+'/variants';    
    //var params = 'module=1&objects='+objects;
    http.open('POST', url, true);
    http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    //http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send();
    http.onreadystatechange = function(){
        if(this.readyState ==4 && this.status == 200){
            loader.style.display = 'none';
            var data=this.responseText;
            data = JSON.parse(data);
            if(data,length > 0){
                document.getElementById('variants_div').style.display = 'block';
                data.objects.forEach(function(element, index){
                    variant = '';
                    variant +='<li>';
                        variant +='<a href="#" onclick="document.getElementById(\'field_variant\').value = '+element.id+'; this.classList.add(\'active\') return false;">';
                            variant += element.name;
                        variant +="</a>";
                    variant +='</li>';
                    document.getElementById('variantes').innerHTML += variant;
                });
            }
            console.log(data.length);
        }
    }
    //console.log('Producto:'+product_id, 'Inventario:'+stc);
}

function product_single_amount(action){
    var quantity = document.getElementById('add_to_cart_quantity');
    var new_quantity;
    
    if(action == "plus"){
        new_quantity = parseInt(quantity.value) + parseInt(1);
        quantity.value = parseInt(new_quantity);
    }
    if(action == "minus"){
        if(parseInt(quantity.value) > 1){
            new_quantity = parseInt(quantity.value) - parseInt(1);
            quantity.value = parseInt(new_quantity);
        }
    }
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

function load_cities(){
    loader.style.display = 'flex';
    state_id = document.getElementById('states');
    var cities_select = document.getElementById('address_city');
    cities_select.innerHTML = "";
    var url = base + '/md/api/load/cities/'+state_id.value;    
    http.open('POST', url, true);
    http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    //http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function(){
        if(this.readyState ==4 && this.status == 200){
            loader.style.display = 'none';
            var data=this.responseText;
            data = JSON.parse(data);
            console.log(data.length);
            if(data.length > 0){
                data.forEach(function(element, index){
                    cities_select.innerHTML += '<option value="'+element.id+'">'+element.name+'</option>';
                })
            }
        }
    }
    http.send();
}

