<?php

function kvfj($json, $key){
    if($json == null):
        return null;
    else:
        $json = $json;
        $json = json_decode($json, true);
        if(array_key_exists($key, $json)):
            return $json[$key];
        else:
            return null;
        endif;
    endif;
}

function getModulesArray(){
    $a = [
        '0' => 'Productos',
        '1' => 'Blog'
    ];

    return $a;
}

function getRoleUserArray($mode, $id){
    $roles = ['0' => 'Usuario Normal', '1' => 'Administrador'];
    if(!is_null($mode)):
        return $roles;
    else:
        return $roles[$id];
    endif;
}

function getUserStatusArray($mode, $id){
    $status = ['0' => 'Registrado', '1' => 'Verificado', '100' => 'Baneado'];
    if(!is_null($mode)):
        return $status;
    else:
        return $status[$id];
    endif;
}

function user_permissions(){
    $p =[
        'dashboard' => [
            'icon' => '<i class="fa-solid fa-house"></i>',
            'title' => 'Modulo Dashboard',
            'keys' => [
                'dashboard' => 'Puede ver el dashboard.',
                'dashboard_small_stats' => 'Puede ver las estadísticas rápidas.',
                'dashboard_sell_today' => 'Puede ver lo facturado hoy.',

            ]
        ],
        'products' =>[
            'icon' => '<i class="fa-solid fa-box-open"></i>',
            'title' => 'Modulo Productos',
            'keys' => [
                'products' => 'Puede ver el listado de productos.',
                'product_add' => 'Puede ver el listado de productos.',
                'product_edit' => 'Puede editar productos.',
                'product_search' => 'Puede buscar productos.',
                'product_delete' => 'Puede eliminar productos.',
                'product_gallery_app' => 'Puede agregar imágenes a la galería.',
                'product_gallery_delete' => 'Puede eliminar imágenes de la galería.',
                'product_stock' => 'Puede ver el inventario.',
            ]
        ],
        'categories' => [
            'icon' => '<i class="fa-solid fa-folder-open"></i>',
            'title' => 'Modulo Categorias',
            'keys' => [
                'categories' => 'Puede ver la lista de categorías.',
                'category_add' => 'Puede crear nuevas categorías.',
                'category_edit' => 'Puede editar categorías.',
                'category_delete' => 'Puede eliminar categorías.',
            ]
        ],
        'users' => [
            'icon' => '<i class="fa-solid fa-user"></i>',
            'title' => 'Modulo Usuarios',
            'keys' => [
                'user_list' => 'Puede ver la lista de usuarios.',
                'user_edit' => 'Puede editar.',
                'user_banned' => 'Puede banear usuarios.',
                'user_permissions' => 'Puede administrar permisos de usuarios.',
            ]
        ],
        'settings' => [
            'icon' => '<i class="fa-solid fa-gears"></i>',
            'title' => 'Modulo de Configuraciones',
            'keys' => [
                'settings' => 'Puede modificar la configuración.',
            ]
        ],
        'orders' => [
            'icon' => '<i class="fa-solid fa-clipboard"></i>',
            'title' => 'Modulo de Ordenes',
            'keys' => [
                'orders_list' => 'Puede ver el listado de ordenes.',
            ]
        ],
        'sliders' => [
            'icon' => '<i class="fa-solid fa-images"></i>',
            'title' => 'Modulo de Sliders',
            'keys' => [
                'sliders_list' => 'Puede ver la lista de Sliders.',
                'slider_add' => 'Puede agregar Sliders',
                'slider_edit' => 'Puede editar los Sliders',
                'slider_delete' => 'Puede eliminar los Sliders',
            ]
        ],
        'coverage' => [
            'icon' => '<i class="fa-solid fa-truck-fast"></i>',
            'title' => 'Cobertura de envios',
            'keys' => [
                'coverage_list' => 'Puede ver la lista de cobertura de envios.',
                'coverage_add' => 'Puede crear zonas de envió',
                'coverage_edit' => 'Puede editar zonas de envió',
                'coverage_delete' => 'Puede eliminar zonas de envió'
            ]

        ]

    ];

    return $p;
}

function getUserYears(){
    $ya = date('Y');
    $ym = $ya - 18;
    $yo = $ym - 62;

    return [$ym,$yo];
}

function getMonths($mode, $key){
    $m = [
        '1' => 'Enero',
        '2' => 'Febrero',
        '3' => 'Marzo',
        '4' => 'Abril',
        '5' => 'Mayo',
        '6' => 'Junio',
        '7' => 'Julio',
        '8' => 'Agosto',
        '9' => 'Septiembre',
        '10' => 'Octubre',
        '11' => 'Noviembre',
        '12' => 'Diciembre'
    ];
    if($mode == "list"){
        return $m;
    }else{
        return $m[$key];
    }
}

function getShippingMethod($method = null){
    $status = ['0' => 'Gratis', '1' => 'Valor fijo', '2' => 'Valor variable por ubicación', '3' => 'Valor fijo por producto'];
    if(is_null($method)):
        return $status;
    else:
        return $status[$method];
    endif;
}

function getCoverageType($type = null){
    $status = ['0' => 'Estado', '1' => 'Ciudad'];
    if(is_null($type)):
        return $status;
    else:
        return $status[$type];
    endif;
}

function getCoverageStatus($status = null){
    $list = ['0' => 'No activo', '1' => 'Activo'];
    if(is_null($status)):
        return $list;
    else:
        return $list[$status];
    endif;
}
?>