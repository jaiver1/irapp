@extends('layouts.guest.main')
@section('template_title')
Bienvenido | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<style type="text/css">
body {
    background: url("{{ asset('img/guest/welcome/background.jpg') }}")no-repeat center center;
    background-size: cover;
}
</style>
@endsection
@section('content')
<div class="view  jarallax" data-jarallax='{"speed": 0.2}'>
    <div class="mask pattern-6 flex-center"></div>
    <div class="full-bg-img">
                    <div class="container flex-center">
                        <div class="row pt-5 mt-3  center-div">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <h1 class="h1-reponsive white-text text-uppercase font-weight-bold mb-3 wow fadeIn" data-wow-delay="0.3s"><strong><i class="fa fa-hammer mr-2"></i>IRAPP</strong></h1>
                                    <hr class="hr-light mt-4 wow fadeIn" data-wow-delay="0.4s">
                                    <h5 class="text-uppercase mb-5 white-text wow fadeIn" data-wow-delay="0.4s"><strong>Instalaciones, Remodelaciones y Acabados</strong></h5>
                                    @if (Auth::guest())                     

            <a href="{{ route('login') }}" class="btn btn-outline-white hoverable waves-light wow fadeIn" data-wow-delay="0.4s" role="button" >
            <i class="fa fa-door-closed mr-2"></i>Iniciar sesión
            </a>

            <a href="{{ route('register') }}" class="btn btn-outline-white hoverable waves-light wow fadeIn" data-wow-delay="0.4s" role="button" >
            <i class="fa fa-user-plus mr-2"></i>Registrarse
            </a>
            @else

             <a href="{{ route('home') }}" class="btn btn-outline-white hoverable waves-light wow fadeInDown" data-wow-delay="0.4s" role="button">
            <i class="fa fa-home mr-2"></i>Página principal
            </a>

            <a class="btn btn-outline-white hoverable waves-light wow fadeInDown" data-wow-delay="0.4s" role="button" 
            onclick="salir();">
                           <form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                        <i class="fa fa-door-open mr-2"></i> Cerrar sesión
                                      </a>     
            </a>


          
          @endif

                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
@endsection
