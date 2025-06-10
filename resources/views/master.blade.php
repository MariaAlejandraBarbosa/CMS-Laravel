<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - MADECMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="routeName" content="{{ Route::currentRouteName() }}">
    <meta name="currency" content="{{ Config::get('cms.currency') }}">
    <meta name="auth" content="{{ Auth::check() }}">

    @yield('custom_meta')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ url('/static/css/style.css?v='.time()) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" href="{{ url('/static/css/fancybox.css') }}"/>

    <script src="https://kit.fontawesome.com/cb50ed82ae.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="{{ url('/static/libs/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ url('/static/js/fancybox.umd.js') }}"></script>
    <script src="{{ url('/static/js/mdslider.js?v='.time()) }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ url('/static/js/site.js?v='.time()) }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            //const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            //const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
            $('[data-toggle="tooltip"]').tooltip()
        });
        Fancybox.bind("[data-fancybox]", {
            Carousel: {
                infinite: false,
            },
        });
    </script>
</head>
<body>
    <div class="loader" id="loader">
        <div class="box">
            <div class="cart">
                <img src="{{ url('/static/images/loader_car.png') }}" alt="">
            </div>
            <div class="load">
                <div class="spinner-border text-secondary" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>
            </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg shadow">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ url('/static/images/Grupo_Planeta_logo.svg.png') }}"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navigationMain" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navigationMain">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link lk-home"><i class="fa-solid fa-house-chimney"></i> <span>Inicio</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/store') }}" class="nav-link lk-store lk-store_category lk-product_single"><i class="fa-solid fa-store"></i> <span>Tienda</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link"><i class="fa-solid fa-building"></i> <span>Sobre Nosotros</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link"><i class="fa-regular fa-id-card"></i> <span>Contactos</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/cart') }}" class="nav-link lk-cart"><i class="fa-solid fa-cart-shopping"></i> 
                            <span class="carnumber">
                                0
                            </span></a>
                    </li>
                    @if(Auth::guest())
                        <li class="nav-item link-acc">
                            <a href="{{ url('/login') }}" class="nav-link btn"><i class="fa-solid fa-fingerprint"></i> Ingresar</a>
                            <a href="{{ url('/register') }}" class="nav-link btn"><i class="fa-solid fa-user"></i> Crear Cuenta</a>
                        </li>
                    @else
                    <li class="nav-item link-acc link-user dropdown">
                        <a href="{{ url('/login') }}" class="nav-link btn dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(is_null(Auth::user()->avatar)) 
                                <img src="{{ url('/static/images/default-avatar.png') }}"> 
                            @else
                                <img src="{{ url('/uploads_users/'.Auth::id().'/av_'.Auth::user()->avatar) }}" class="circle">
                            @endif Hola: {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu shadow">
                            @if(Auth::user()->role =="1")
                            <li>
                                <a class="dropdown-item" href="{{ url('/admin') }}">
                                    <i class="fa-solid fa-chalkboard-user"></i> Administración
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <a class="dropdown-item" href="{{ url('/account/address') }}">
                                    <i class="fa-solid fa-location-dot"></i> Mis direcciones de entrega
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/account/favorites') }}">
                                    <i class="fa-solid fa-heart"></i> Favoritos
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/account/edit') }}">
                                    <i class="fa-regular fa-id-card"></i> Editar Información
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/logout') }}">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Salir
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @if(Session::has('message'))
        <div class="container">
            <div class="alert alert-{{ Session::get('typealert') }} mtop16" style="display: block; margin-bottom: 16px;">
                {{ Session::get('message') }}
                @if ($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
                <script>
                    $('.alert').slideDown();
                    setTimeout(function(){ $('.alert').slideUp(); }, 10000  )
                </script>
            </div>
        </div>
    @endif
    <div class="wrapper">
        <div class="container">
            @yield('content')
        </div>
    </div>
</body>
</html>