@extends('layouts.store.main')
@section('template_title')
Lista de productos | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css"/>
<style type="text/css">
    body {
        background: url("{{ asset('img/guest/store/producto/background.jpg') }}")no-repeat center center;
        background-size: cover;
    }
    </style>
@endsection
@section('content')
<section class="view intro-2">
        <div class="mask pattern-6 flex-center"></div>
<!-- Main Container -->
<div class="container mt-5 pt-3">
    <!--Navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark unique-color-dark mt-4 mb-4 z-depth-5 hoverable" >

        <!-- Navbar brand -->
        <a class="font-weight-bold white-text mr-4 d-none d-md-block" href="{{ route('store.productos') }}">Lista de productos</a>
        @if(Auth::user()->authorizeRoles('ROLE_CLIENTE',FALSE))
                        <a href="{{ route('store.productos.cart') }}" class="font-weight-bold white-text mr-4 d-md-block"><i class="fas fa-shopping-cart mr-2"
                            data-toggle="tooltip" data-placement="bottom" title="Carrito de compras"></i><span class="badge badge-pill pink darken-1 notification" style="margin-left:-15px; position: absolute;top: 0;">3</span></a>
@endif
        <ul class="navbar-nav mr-auto d-none d-md-block">
        </ul>
        <form id="form-query" class="search-form" role="search">
            <div class="form-group md-form my-0">
                    <i onclick="filtrar('{{$filter->order}}')" class="fas fa-search prefix white-text btn-icon-search hoverable"
                        data-toggle="tooltip" data-placement="bottom" title="Buscar"></i>
                <input id="query" type="text" value="{{$filter->query}}" class="ml-5 form-control white-text" placeholder="Buscar">
            </div>
        </form>
 {{--
        <!-- Collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1"
            aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>



        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent1">

            <!-- Links -->
           
            <ul class="navbar-nav mr-auto">
                
                <li class="nav-item dropdown mega-dropdown active">
                    <a class="nav-link dropdown-toggle no-caret" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Clasificación</a>
                    <div class="dropdown-menu mega-menu v-2 row z-depth-1 white" aria-labelledby="navbarDropdownMenuLink1">
                        <div class="row mx-md-4 mx-1">
                            <div class="col-md-12 col-lg-4 sub-menu my-lg-5 mt-5 mb-4">
                                <h6 class="sub-title text-uppercase font-weight-bold red-text">Destacado</h6>
                                <!--Featured image-->
                                <div class="view overlay mb-3 z-depth-1 hoverable waves-effect zoom">
                                    <img src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Products/9.jpg" class="img-fluid hoverable rounded img-thumbnail" alt="First sample image">

                                    <div class="mask flex-center rgba-white-slight">
                                        <p></p>
                                    </div>
                                </div>
                                <h4 class="mb-2"><a class="news-title-2 pl-0" href="">Lorem ipsum dolor sit</a></h4>
                            </div>
                            <div class="col-md-6 col-lg-4 sub-menu my-lg-5 my-4">
                                <h6 class="sub-title text-uppercase font-weight-bold red-text">Marcas</h6>
                                <ul class="caret-style pl-0">
                                    <li class=""><a class="menu-item" href="">Canon</a></li>
                                    <li class=""><a class="menu-item" href="">Nikon</a></li>
                                    <li class=""><a class="menu-item" href="">Sony</a></li>
                                    <li class=""><a class="menu-item" href="">GoPro</a></li>
                                    <li class=""><a class="menu-item" href="">Samsung</a></li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-lg-4 sub-menu my-lg-5 my-4">
                                <h6 class="sub-title text-uppercase font-weight-bold red-text">Categorias</h6>
                                <ul class="caret-style pl-0">
                                    <li class=""><a class="menu-item" href="">Excepteur sint</a></li>
                                    <li class=""><a class="menu-item" href="">Sunt in culpa</a></li>
                                    <li class=""><a class="menu-item" href="">Sed ut perspiciatis</a></li>
                                    <li class=""><a class="menu-item" href="">Mollit anim id est</a></li>
                                    <li class=""><a class="menu-item" href="">Accusantium doloremque</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            
            <!-- Links -->

            <!-- Search form -->
            
        </div>
        <!-- Collapsible content -->
--}}
    </nav>
    <!--/.Navbar-->
    <div class="card mb-4 z-depth-5 hoverable">
            <div class="card-body">

    <div class="row pl-4 pt-4">

        <!-- Sidebar -->
        <div class="col-md-4 col-lg-3">

            <div class="">
                <!-- Grid row -->
                <div class="row">
                    <div class="col-6 col-md-12 mb-5" >
                        <!-- Panel -->
                        <h5 class="font-weight-bold navy-text"><i class="fas fa-sort mr-2"></i><em>Ordenar</em></h5>
                        <p onclick="filtrar('latest')" class="order-txt {{($filter->order == 'latest' ) ? 'active': ''}}"><a><i class="fas fa-history mr-2"></i><em>Mas reciente</em></a></p>
                        <p onclick="filtrar('a-z')" class="order-txt {{($filter->order == 'a-z' ) ? 'active': ''}}"><a><i class="fas fa-sort-alpha-down mr-2"></i><em>Nombre: A-Z</em></a></p>
                        <p onclick="filtrar('z-a')"class="order-txt {{($filter->order == 'z-a' ) ? 'active': ''}}"><a><i class="fas fa-sort-alpha-up mr-2"></i><em>Nombre: Z-A</em></a></p>
                        <p onclick="filtrar('min_price')"class="order-txt {{($filter->order == 'min_price' ) ? 'active': ''}}"><a><i class="fas fa-sort-numeric-down mr-2"></i><em>Precio: mas bajo</em></a></p>
                        <p onclick="filtrar('max_price')" class="order-txt {{($filter->order == 'max_price' ) ? 'active': ''}}"><a><i class="fas fa-sort-numeric-up mr-2"></i><em>Precio: mas alto</em></a></p>
                    </div>

  <!-- Filter by price  -->
  <div class="col-6 col-md-12 mb-5">
        <h5 class="font-weight-bold navy-text"><i class="fas fa-money-bill-alt mr-2"></i><em>Precio</em></h5>

            <small class="font-weight-bold blue-grey-text"><strong>Menor precio</strong></small>

            <form class="range-field mt-0">
                <input oninput="cambiar_min()" id="min" class="no-border" type="range" value="{{$filter->min}}" min="0" max="{{$filter->limit}}" />
            </form>

            <!-- Grid row -->
            <div class="row justify-content-center mb-3">
<!-- Grid column -->
<div class="col-4 text-left">
    <small class="dark-grey-text"><strong id="init-txt">@money(0)</strong></small>
</div>
<!-- Grid column -->
                <!-- Grid column -->
                <div class="col-4 text-center">
                    <small class="order-txt active"><strong id="min-txt">@money($filter->min)</strong></small>
                </div>
                <!-- Grid column -->
                 <!-- Grid column -->
                 <div class="col-4 text-right">
                    <small class="dark-grey-text"><strong id="limit-txt">@money($filter->limit)</strong></small>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->

            <small class="font-weight-bold blue-grey-text"><strong>Mayor precio</strong></small>

            <form class="range-field mt-0">
            <input oninput="cambiar_max()" id="max" class="no-border" type="range" value="@if($filter->max == $filter->limit){{$filter->limit}}@else{{$filter->max}}@endif" min="0" max="{{$filter->limit}}" />
            </form>

            <!-- Grid row -->
            <div class="row justify-content-center">
<!-- Grid column -->
<div class="col-4 text-left">
    <small class="dark-grey-text"><strong id="init-txt">@money(0)</strong></small>
</div>
<!-- Grid column -->
 <!-- Grid column -->
 <div class="col-4 text-center">
    <small class="order-txt active"><strong id="max-txt">@money($filter->max)</strong></small>
</div>
<!-- Grid column -->

                <!-- Grid column -->
                <div class="col-4 text-right">
                    <small class="dark-grey-text"><strong id="limit-txt">@money($filter->limit)</strong></small>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->

            <!-- Grid row -->
            <div class="mt-2 row justify-content-center">
                <!-- Grid column -->
                <div class="col-12 text-center">
            <button onclick="filtrar('{{$filter->order}}')" class="btn btn-outline-success btn-circle waves-effect hoverable"
                data-toggle="tooltip" data-placement="bottom" title="Aplicar filtro">
              <i class="fas fa-2x fa-check"></i>
                    </button>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
    </div>
    <!-- /Filter by price -->

                    <!-- Filter by category-->
                    <div class="col-12 col-md-12 mb-5" >
                        <h5 class="font-weight-bold navy-text"><i class="fas fa-sitemap mr-2"></i><em>Categoria</em></h5>
                        @include('include.clasificacion.categorias.select', array('categoria_selected'=>$filter->category))

                    </div>
                    <!-- /Filter by category-->

                </div>
                <!-- /Grid row -->
            </div>

        </div>
        <!-- /.Sidebar -->

        <!-- Content -->
        <div class="col-md-8 col-lg-9" >

          

            <!-- Products Grid -->
            <section class="section pt-4" >

                <!-- Grid row -->
                <div class="row">

                    @if($productos->count() > 0)

                    @foreach($productos as $key => $producto)
                    <!--Grid column-->
                    <div class="col-6 col-lg-4 mb-4">

                        <!--Card-->
                        <div class="card card-ecommerce card-producto-img-store hoverable h-100 z-depth-1 list-card">

                            <!--Card image-->
                            <div class="view overlay hoverable waves-effect z-depth-1 zoom div img-list-card">
                                @if($producto->imagenes->count())
                                <img src="{{ asset($producto->imagenes->first()->ruta) }}" class="img-fluid rounded img-thumbnail img-store"  alt="{{ $producto->imagenes->first()->nombre }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
                                @else
                                <img src="{{ asset('img/dashboard/productos/404.png')  }}" class="img-fluid rounded img-thumbnail img-store" alt="404">
                                @endif
                                <a>
                                    <div class="mask rgba-white-slight"></div>
                                </a>
                            </div>
                            <!--Card image-->

                            <!--Card content-->
                            <div class="card-body">
                                <!--Category & Title-->

                                <h5 class="card-title mb-1 h5-responsive"><strong><a href="" class="navy-text">{{ $producto->nombre }}</a></strong>
                                <span class="badge store-color ml-1 hoverable">Nuevo</span></h5>
                                <!-- Rating -->
                                <ul class="rating">
                                    <li><i class="fas fa-star orange-text"></i></li>
                                    <li><i class="fas fa-star orange-text"></i></li>
                                    <li><i class="fas fa-star orange-text"></i></li>
                                    <li><i class="fas fa-star orange-text"></i></li>
                                    <li><i class="fas fa-star blue-grey-text"></i></li>
                                </ul>

                                <!--Card footer-->
                                <div class="card-footer pb-0">
                                    <div class="row mb-0">
                                        <span class="float-left">
                                            <h5 class="h5-responsive"><span class="badge badge-success hoverable">
                                            @money($producto->valor_unitario)
                                            </span></h5>
                                        </span>
                                        @if(Auth::user()->authorizeRoles('ROLE_CLIENTE',FALSE))
                                        <span class="float-left">
                                    <a class="float-right" data-toggle="tooltip" data-placement="top" title="Agregar al carrito"><i class="fas fa-2x fa-cart-plus ml-3"></i></a>
                                    </span>
                                    @endif
                                    </div>
                                </div>

                            </div>
                            <!--Card content-->

                        </div>
                        <!--Card-->

                    </div>
                    <!--Grid column-->

                @endforeach
                @else
                <div class="col-12">
                <div class="d-flex justify-content-center">
                <h1 class="h1-responsive error-display hoverable">
                        No se encontraron productos
                </h1>
            </div> </div>
                @endif
            </div>
            <!--Grid row-->
              
                <!--Grid row-->
                <div class="row justify-content-center mb-4">
                        {{ $productos->links() }}
                </div>
                <!--Grid row-->
            </section>
            <!-- /.Products Grid -->

        </div>
        <!-- /.Content -->

    </div>
</div>
</div>
</div>
<!-- /.Main Container -->
</section>
@endsection

@section('js_links')
<script type="text/javascript" src="{{ asset('js/addons/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/i18n/es.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/store.js')}}"></script>
<script type="text/javascript">
function agregar_producto(id,nombre){
    swal({
  title: 'Agregar el producto',
  text: '¿Desea agregar el producto "'+nombre+'"?',
  type: 'question',
  confirmButtonText: '<i class="fas shopping-cart"></i> Agregar',
  cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
  showCancelButton: true,
  showCloseButton: true,
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: false,
  animation: false,
  customClass: 'animated zoomIn',
}).then((result) => {
  if (result.value) {
    $( "#agregar"+id ).submit();
  }else{
    swal({
  position: 'top-end',
  type: 'error',
  title: 'Operación cancelada por el usuario',
  showConfirmButton: false,
  toast: true,
  animation: false,
  customClass: 'animated lightSpeedIn',
  timer: 3000
})
  }
})
}
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
$(document).ready(function() {
    $('#categoria_id').select2({
        placeholder: "Categorias",
        theme: "material"
    });
    $('#marca_id').select2({
        placeholder: "Marcas",
        theme: "material"
    });
    $(".select2-selection__arrow")
        .addClass("fas fa-chevron-down");
});

$( "#categoria_id" ).change(function() {
    var order = "{{$filter->order}}";
 filtrar(order);
});

$("#form-query").submit(function(e) {
    e.preventDefault();
    var order = "{{$filter->order}}";
 filtrar(order);
});

function filtrar(order){
    var url = document.location.href;
    var value = "";

    if(!contains_string(url,"?")){
        url += "?";
    }

    option = "min";
    value = $("#"+option).val();
    if(contains_string(url, option+"=")){
        url = url.replace(/min=.*/g,"min="+value)+"&";
    }else{
        url += option+"="+value+"&";
    }
    
    option = "max";
    value = $("#"+option).val();
    if(contains_string(url, option+"=")){
        url = url.replace(/max=.*/g,"max="+value)+"&";
    }else{
        url += option+"="+value+"&";
    }

    option = "query";
    value = $("#"+option).val();
    if(contains_string(url, option+"=")){
        url = url.replace(/query=.*/g,"query="+value)+"&";
    }else{
        url += option+"="+value+"&";
    }

    option = "categoria_id";
    value = $("#"+option).val();
    if(contains_string(url, option+"=")){
        url = url.replace(/categoria_id=.*/g,"categoria_id="+value)+"&";
    }else{
        url += option+"="+value+"&";
    }

    if(contains_string(url, "order=")){
        url = url.replace(/order=.*/g,"order="+order);
    }else{
        url += "order="+order+"&";
    }
    
    url = url.replace("null","");
    url = url.replace("null","");
    if(last_string(url) == "&"){
url = url.substr(0, url.length-1);
    }

    //alert(url);
    document.location.href = url;
}

</script>
@endsection
