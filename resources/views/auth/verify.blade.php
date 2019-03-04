@extends('layouts.guest.main')
@section('template_title')
Bienvenido | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<style type="text/css">
body {
    background: url("{{ asset('img/guest/register/background.jpg') }}")no-repeat center center;
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
                                    <h1 class="h1-reponsive white-text text-uppercase font-weight-bold mb-1 wow fadeIn" data-wow-delay="0.3s"><strong><i class="fas fa-user-lock  mr-2"></i>
                                        Usuario Inactivo
                                    </strong></h1>
                                    <hr class="hr-light mt-4 wow fadeIn" data-wow-delay="0.4s">
                                    <p class=" mb-3 white-text wow fadeIn" data-wow-delay="0.4s"><strong>
                                            Antes de continuar, consulte su correo electrónico para buscar el enlace de verificación.
                                            Si no recibió el correo electrónico, haga clic en el siguiente botón para enviar otro correo electrónico.
                                        </strong></p>
                                        <a href="{{ route('verification.resend') }}" class="btn btn-outline-white wow fadeInRight" data-wow-delay="0.3s"><i class="fas fa-paper-plane fa-lg"></i>
                                            Enviar</a>
                                    @if (session('resent'))
                        <div class="hoverable waves-light alert alert-success alert-dismissible fade show" role="alert">
                                Se ha enviado un nuevo enlace de verificación a su correo electrónico.
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
                    @endif               
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
@endsection
