@extends('layouts.store.main')
@section('template_title')
Carrito de productos | {{ config('app.name', 'Laravel') }}
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
        <a class="font-weight-bold white-text mr-4 d-md-block" href="{{ route('store.productos') }}">Lista de productos</a>
     
    
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
   
        <!-- Content -->
        <div class="col-12" >

          

            <!-- Products Grid -->
            <section class="section pt-4" >

                <!-- Grid row -->
                <div class="row">
                        <div class="col-12">
                        <div class="card mb-4 z-depth-5 hoverable">
                                <div class="card-body">

                                    </div>
                                </div>
            </div>
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

<script type="text/javascript">
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

</script>
@endsection
