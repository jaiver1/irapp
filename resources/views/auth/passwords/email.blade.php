@extends('layouts.guest.main')
@section('template_title')
Mensaje recuperación | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/guest/auth/style.css') }}" type="text/css">
<style type="text/css">
body {
    background: url("{{ asset('img/guest/password/email/background.jpg') }}")no-repeat center center;
    background-size: cover;
}
</style>
@endsection
@section('content')
  <!--Intro Section-->
  <section class="view intro-2">
        <div class="mask pattern-6 flex-center"></div>
                <div class="full-bg-img">
                    <div class="container flex-center">
                        <div class="d-flex align-items-center content-height">
                            <div class="row flex-center pt-5 mt-3">
                     
                                <div class="col-md-6 mb-5">
                                    <!--Form-->
                                    <div class="card z-depth-5 hoverable  wow fadeInLeft" data-wow-delay="0.3s">
                                        <div class="card-body">
                                            <!--Header-->
                                            <div class="text-center">
                                                <h3 class="white-text"><i class="fas fa-mail-bulk mr-2"></i>Mensaje recuperación</h3>
                                                <hr class="hr-light">
                                            </div>
                                            <form id="email_form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                                            <div class="md-form">
                                                <i class="far fa-envelope prefix white-text"></i>
                                                <input id="email" type="email" class="form-control validate white-text" name="email" value="{{ old('email') }}" required autofocus>
                                                <label for="email" data-error="Error" data-success="Correcto">Email</label>
                                            </div>
                                            @if ($errors->has('email'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('email') }}
                                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
                                
                                @endif

                                @if (session('status'))
                                <div class="hoverable waves-light alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>                        
                            @endif


                                            <div class="text-center">
                                                <a onclick="validar()" class="btn btn-outline-white hoverable waves-light" data-wow-delay="0.4s" role="button">
                                                    <i class="fas fa-paper-plane mr-2"></i>Enviar</a>
                                                   
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!--/.Form-->
                                    
                                </div>
                                <div class="center-div-link text-center text-md-left  col-md-6 col-xl-5 offset-xl-1">
                                    <div class="white-text">
                                        <h1 class="h1-responsive font-weight-bold wow fadeInRight" data-wow-delay="0.3s">¡Inicia Sesion! </h1>
                                        <hr class="hr-light wow fadeInRight" data-wow-delay="0.3s">
                                        <h6 class="wow fadeInRight" data-wow-delay="0.3s">¿Ya tienes una cuenta?, inicia sesion con tu email y contraseña y empieza a disfrutar de los servicios ofrecidos por IRAPP.</h6>
                                        <br>
                                        <a href="{{ route('login') }}" class="btn btn-outline-white wow fadeInRight" data-wow-delay="0.3s"><i class="fas fa-door-closed mr-2"></i>Iniciar sesión</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
@endsection
@section('js_links')
<script type="text/javascript" src="{{ asset('js/addons/validation/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/validation/messages_es.js') }}"></script>
<script type="text/javascript">

function validar(){
  if($("#email_form").validate({
    lang: 'es',
    errorPlacement: function(error, element){
      $(element).parent().after(error);
		}})){
    $("#email_form").submit();
  }
  }

</script>
@endsection