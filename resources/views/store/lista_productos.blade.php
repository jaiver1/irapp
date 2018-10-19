@extends('layouts.store.main')
@section('template_title')
Lista de productos | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css"/>
@endsection
@section('content')
<!-- Main Container -->
<div class="container-fluid mt-5 pt-3">


    <!--Navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark unique-color-dark mt-5 mb-5">

        <!-- Navbar brand -->
        <a class="font-weight-bold white-text mr-4" href="#">Lista de Productos</a>

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
                                <div class="view overlay mb-3 z-depth-1">
                                    <img src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Products/9.jpg" class="img-fluid" alt="First sample image">
                                    <div class="mask flex-center rgba-stylish-slight">
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
            <form class="search-form" role="search">
                <div class="form-group md-form my-0 waves-light">
                    <input type="text" class="form-control" placeholder="Buscar">
                </div>
            </form>
        </div>
        <!-- Collapsible content -->

    </nav>
    <!--/.Navbar-->


    <div class="row pl-4 pt-4">

        <!-- Sidebar -->
        <div class="col-lg-3">

            <div class="">
                <!-- Grid row -->
                <div class="row">
                    <div class="col-sm-6 col-lg-12 mb-5">
                        <!-- Panel -->
                        <h5 class="font-weight-bold brown-text"><strong>Ordenar</strong></h5>
                            <p class="red-text"><a>Nombre: A-Z</a></p>
                            <p class="blue-grey-text"><a>Nombre: Z-A</a></p>
                            <p class="blue-grey-text"><a>Precio: mas bajo</a></p>
                            <p class="blue-grey-text"><a>Precio: mas alto</a></p>
                    </div>

  <!-- Filter by price  -->
  <div class="col-sm-6 col-lg-12 mb-5">
        <h5 class="font-weight-bold brown-text"><strong>Precio</strong></h5>

            <small class="font-weight-bold blue-grey-text"><strong>Menor precio</strong></small>

            <form class="range-field mt-0">
                <input id="calculatorSlider" class="no-border" type="range" value="0" min="0" max="30" />
            </form>

            <!-- Grid row -->
            <div class="row justify-content-center mb-3">

                <!-- Grid column -->
                <div class="col-md-6 text-left">
                    <p class="dark-grey-text"><strong id="resellerEarnings">0$</strong></p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-6 text-right">
                    <p class="dark-grey-text"><strong id="clientPrice">319$</strong></p>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->

            <small class="font-weight-bold blue-grey-text"><strong>Mayor precio</strong></small>

            <form class="range-field mt-0">
                <input id="calculatorSlider" class="no-border" type="range" value="30" min="0" max="30" />
            </form>

            <!-- Grid row -->
            <div class="row justify-content-center">

                <!-- Grid column -->
                <div class="col-md-6 text-left">
                    <p class="dark-grey-text"><strong id="resellerEarnings">0$</strong></p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-6 text-right">
                    <p class="dark-grey-text"><strong id="clientPrice">319$</strong></p>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->

    </div>
    <!-- /Filter by price -->

<!-- Filter by brand-->
<div class="col-sm-6 col-lg-12 mb-5">
        <h5 class="font-weight-bold brown-text"><strong>Marcas</strong></h5>
        
      
    </div>
    <!-- /Filter by brand-->
                    <!-- Filter by category-->
                    <div class="col-sm-6 col-lg-12 mb-5">
                        <h5 class="font-weight-bold brown-text"><strong>Categoria</strong></h5>
                        @include('clasificacion.categorias.sub_categorias_select', array('categoria_selected'=>$categoria))

                    </div>
                    <!-- /Filter by category-->

                </div>
                <!-- /Grid row -->
            </div>

        </div>
        <!-- /.Sidebar -->

        <!-- Content -->
        <div class="col-lg-9">

          

            <!-- Products Grid -->
            <section class="section pt-4">

                <!-- Grid row -->
                <div class="row">

                    <!--Grid column-->
                    <div class="col-lg-4 col-md-12 mb-4">

                        <!--Card-->
                        <div class="card card-ecommerce">

                            <!--Card image-->
                            <div class="view overlay">
                                <img src="https://mdbootstrap.com/img/Photos/Horizontal/E-commerce/Products/1.jpg" class="img-fluid" alt="">
                                <a>
                                    <div class="mask rgba-stylish-slight"></div>
                                </a>
                            </div>
                            <!--Card image-->

                            <!--Card content-->
                            <div class="card-body">
                                <!--Category & Title-->

                                <h5 class="card-title mb-1"><strong><a href="" class="dark-grey-text">iPad</a></strong></h5><span class="badge badge-danger mb-2">bestseller</span>
                                <!-- Rating -->
                                <ul class="rating">
                                    <li><i class="fa fa-star blue-text"></i></li>
                                    <li><i class="fa fa-star blue-text"></i></li>
                                    <li><i class="fa fa-star blue-text"></i></li>
                                    <li><i class="fa fa-star blue-text"></i></li>
                                    <li><i class="fa fa-star blue-text"></i></li>
                                </ul>

                                <!--Card footer-->
                                <div class="card-footer pb-0">
                                    <div class="row mb-0">
                                        <span class="float-left"><strong>1439$</strong></span>
                                        <span class="float-right">

                                    <a class="" data-toggle="tooltip" data-placement="top" title="Add to Cart"><i class="fa fa-shopping-cart ml-3"></i></a>
                                    </span>
                                    </div>
                                </div>

                            </div>
                            <!--Card content-->

                        </div>
                        <!--Card-->

                    </div>
                    <!--Grid column-->


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
<!-- /.Main Container -->
@endsection

@section('js_links')
<script type="text/javascript" src="{{ asset('js/addons/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/i18n/es.js')}}"></script>
<script type="text/javascript">
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
$(document).ready(function() {
    $('#categoria_id').select2({
        placeholder: "Categorias",
        theme: "material"
    });
    $(".select2-selection__arrow")
        .addClass("fa fa-chevron-down");
});
</script>
@endsection
