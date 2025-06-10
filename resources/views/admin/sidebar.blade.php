<div class="sidebar shadow">
    <div class="section-top">
        <div class="logo">
            <img src="{{ url('/static/images/Grupo_Planeta_logo.svg.png') }}" class="img-fluid">
        </div>
        <div class="user">
            <span class="subtitle">Hola:</span>
            <div class="name">
                {{ Auth::user()->name }} {{ Auth::user()->name }}
                <a href="{{ url('/logout') }}" data-toggle="tooltip" data-bs-placement="top" data-bs-title="Salir">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </a>
            </div>
            <div class="email">{{ Auth::user()->email }}</div>
        </div>
    </div>
    <div class="main">
        <ul>
            @if(kvfj(Auth::user()->permissions, 'dashboard'))
            <li>
                <a href="{{ url('/admin') }}" class="lk-dashboard"><i class="fa-solid fa-house"></i>Dashboard</a>
            </li>
            @endif

            @if(kvfj(Auth::user()->permissions, 'products'))
            <li>
                <a href="{{ url('/admin/products/1') }}" class="lk-products lk-products_add lk-product_edit lk-product_gallery_app lk-product_stock"><i class="fa-solid fa-box-open"></i>Productos</a>
            </li>
            @endif

            @if(kvfj(Auth::user()->permissions, 'categories'))
            <li>
                <a href="{{ url('/admin/categories/0') }}" class="lk-categories lk-category_add lk-category_edit lk-category_delete"><i class="fa-solid fa-folder-open"></i>Categorias</a>
            </li>
            @endif

            @if(kvfj(Auth::user()->permissions, 'user_list'))
            <li>
                <a href="{{ url('/admin/users/all') }}" class="lk-user_list lk-user_edit"><i class="fa-solid fa-user"></i>Usuarios</a>
            </li>
            @endif

            @if(kvfj(Auth::user()->permissions, 'settings'))
            <li>
                <a href="{{ url('/admin/settings') }}" class="lk-settings"><i class="fa-solid fa-gears"></i>Configuraciones</a>
            </li>
            @endif

            @if(kvfj(Auth::user()->permissions, 'orders_list'))
            <li>
                <a href="{{ url('/admin/orders/all') }}" class="lk-orders_list"><i class="fa-solid fa-clipboard"></i>Ordenes</a>
            </li>
            @endif

            @if(kvfj(Auth::user()->permissions, 'sliders_list'))
            <li>
                <a href="{{ url('/admin/sliders') }}" class="lk-sliders_list lk-slider-edit"><i class="fa-solid fa-images"></i>Sliders</a>
            </li>
            @endif

            @if(kvfj(Auth::user()->permissions, 'coverage_list'))
            <li>
                <a href="{{ url('/admin/coverage') }}" class="lk-coverage_list lk-coverage_edit"><i class="fa-solid fa-truck-fast"></i>Cobertura de envio</a>
            </li>
            @endif
        </ul>
    </div>
</div>