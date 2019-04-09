@extends('layouts.guest.main')
@section('template_title')
Iniciar sesión | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/guest/auth/style.css') }}" type="text/css">
<style type="text/css">
body {
    background: url("{{ asset('img/guest/login/background.jpg') }}")no-repeat center center;
    background-size: cover;
}
table{
    color:white !important;
}
thead{
    background-color: rgba(0, 0, 0, 0.8) !important;
}
tbody{
    background-color: rgba(0, 0, 0, 0.4) !important;
}
.center-div-link{
    background-color: rgba(0, 0, 0, 0.3) !important;
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
                                                <h3 class="white-text"><i class="fas fa-door-closed mr-2"></i>Iniciar sesión</h3>
                                                <hr class="hr-light">
                                            </div>
                                            <form id="login_form" method="POST" action="{{ route('login') }}">
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

                                            <div class="text-center mt-4">
                                                <a onclick="validar()" class="btn btn-outline-white hoverable waves-light" data-wow-delay="0.4s" role="button">
                                                    <i class="fas fa-door-closed mr-2"></i>Iniciar sesión</a>
                                                    <a  href="{{ route('password.reset',array(null)) }}" class="btn waves-light white-text" data-wow-delay="0.4s" role="button">
                                                    <i class="fas fa-key mr-2"></i>¿Olvido la contraseña?</a>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!--/.Form-->
                                    
                                </div>
                                           <div class="center-div-link text-center text-md-left  col-md-6 col-xl-5 offset-xl-1">
                                                <div class="text-center">
                                                        <h3 class="white-text"><i class="fas fa-users mr-2"></i>Usuarios</h3>
                                                        <hr class="hr-light">
                                                    </div>
                                            <div class="table-responsive">
                                                        <!-- Table  -->
                                                        <table id="usuariosdt" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
                              <thead class="th-color white-text">
                                <tr class="z-depth-2">
                                  <th class="th-sm">Correo
                                  </th>
                                  <th class="th-sm">Contraseña
                                  </th>
                               
                                </tr>
                              </thead>
                              <tbody>
                                <tr class="hoverable">
                                  <td>root@example.com</td>
                                  <td>root1234</td>
                                </tr>
                                <tr class="hoverable">
                                        <td>administrador@example.com</td>
                                        <td>administrador</td>
                                      </tr>
                              </tbody>
                            </table>
                                                        <!-- Table  -->
                                                        </div>
                                  {{-- <div class="white-text">
                                        <h1 class="h1-responsive font-weight-bold wow fadeInRight" data-wow-delay="0.3s">¡Regístrate ahora! </h1>
                                        <hr class="hr-light wow fadeInRight" data-wow-delay="0.3s">
                                        <h6 class="wow fadeInRight text-intro" data-wow-delay="0.3s">¿Aún no tienes cuenta?, regístrate en simples pasos y empieza a disfrutar de los servicios ofrecidos por IRAPP.</h6>
                                        <br>
                                        <a href="{{ route('register') }}" class="btn btn-outline-white wow fadeInRight" data-wow-delay="0.3s"><i class="fas fa-user-plus mr-2"></i>Registrarse</a>
                                    </div>--}} 
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
  if($("#login_form").validate({
    lang: 'es',
    errorPlacement: function(error, element){
      $(element).parent().after(error);
		}})){
    $("#login_form").submit();
  }
  }

</script>
@endsection