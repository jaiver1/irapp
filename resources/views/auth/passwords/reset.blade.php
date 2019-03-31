@extends('layouts.guest.main')
@section('template_title')
Reestablecer contraseña | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/guest/auth/style.css') }}" type="text/css">
<style type="text/css">
body {
    background: url("{{ asset('img/guest/password/reset/background.jpg') }}")no-repeat center center;
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
                     
                                <div class="col-md-12 mb-12">
                                    <!--Form-->
                                    <div class="card z-depth-5 hoverable  wow fadeInLeft" data-wow-delay="0.3s">
                                        <div class="card-body">
                                            <!--Header-->
                                            <div class="text-center">
                                                <h3 class="white-text"><i class="fas fa-lock-open mr-2"></i>Reestablecer contraseña</h3>
                                                <hr class="hr-light">
                                            </div>
                                            <form id="reset_form" method="POST" action="{{ route('password.request') }}">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="token" value="{{ $token }}">
                        

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

                                            <div class="md-form">
                                                <i class="fas fa-lock prefix white-text"></i>
                                                <input id="password" type="password" class="form-control validate white-text" name="password" required>
                                                <label for="password" data-error="Error" data-success="Correcto">Contraseña</label>
                                            </div>
                                            @if ($errors->has('password'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ $errors->first('password') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

<div class="md-form">
    <i class="fas fa-unlock-alt prefix white-text"></i>
    <input id="password-confirm" type="password" class="form-control validate white-text" name="password_confirmation" required>
    <label for="password-confirm" data-error="Error" data-success="Correcto">Confirmar contraseña</label>
</div>
@if ($errors->has('password_confirmation'))
<div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
{{ $errors->first('password_confirmation') }}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
@endif

                                            <div class="text-center">
                                                <a onclick="validar()" class="btn btn-outline-white hoverable waves-light" data-wow-delay="0.4s" role="button">
                                                    <i class="fas fa-key mr-2"></i>Reestablecer</a>
                                                   
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!--/.Form-->
                                    
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
  if($("#reset_form").validate({
    lang: 'es',
    errorPlacement: function(error, element){
      $(element).parent().after(error);
		}})){
    $("#reset_form").submit();
  }
  }

</script>
@endsection