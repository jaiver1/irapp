@include('include.contacto.personas.form', array('persona'=>$cliente->persona))
@extends('layouts.store.main')
@section('template_title')
Registrarse | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/guest/auth/style.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css"/>
<style type="text/css">
body {
    background: url("{{ asset('img/guest/register/background.jpg') }}")no-repeat center center;
    background-size: cover;
}
.card{
    background-color: rgba(0, 0, 0, 0.7) !important;
}
input,.md-form > small,.select2-selection__rendered{
    color:  white !important;
    }

</style>
@endsection

@section('content')
<section class="view intro-2">
        <div class="mask pattern-6 flex-center"></div>
<!-- Main Container -->
<div class="container mt-5 pt-3">
   
    <div class="row">
        <!-- Content -->
        <div class="col-md-6 mb-5">

          

           <!-- Products Grid -->
           <section class="section pt-4" >

                <!-- Grid row -->
                <div class="row">
                        <div class="col-12">
                        <div class="card z-depth-5 hoverable">
                            <div class="card-body">
                                <!--Header-->
                                <div class="text-center">
                                    <h3 class="white-text"><i class="fas fa-user-plus mr-2"></i>Registrarse</h3>
                                    <hr class="hr-light">
                                </div>
                                <form id="register_form" method="POST" action="{{ route('register_cliente') }}" accept-charset="UTF-8">
                                  
                                    
                                     {{ csrf_field() }}
                                    
                                      <!-- Grid row -->
                                      <div class="form-row">
                                            <!-- Grid column -->
                                            <div class="col-md-6">
                                                <!-- Material input -->
                                                <div class="md-form">
                                        <i class="fas fa-user prefix"></i>
                                        <input type="text" required id="name" value="{{ old('name') ? old('name') : ''}}" name="name" class="form-control validate" maxlength="50">
                                        <label for="name" data-error="Error" data-success="Correcto">Usuario *</label>
                                    </div>
                                    @if ($errors->has('name'))
                                                                                <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                                                               {{ $errors->first('name') }}
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                                                    
                                                                    @endif
                                            </div>
                                            <!-- Grid column -->
                                    
                                             <!-- Grid column -->
                                        <div class="col-md-6">
                                                <!-- Material input -->
                                                <div class="md-form">
                                        <i class="far fa-envelope prefix"></i>
                                        <input type="email" required id="email" value="{{ old('email') ? old('email') : ''}}" name="email" class="form-control validate" maxlength="100">
                                        <label for="email" data-error="Error" data-success="Correcto">Email *</label>
                                        </div> @if ($errors->has('email'))
                                                                                <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                                                               {{ $errors->first('email') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                                                    
                                                                    @endif
                                            </div>
                                            <!-- Grid column -->
                                          
                                        </div>
                                        <!-- Grid row -->
                                        
                                        <!-- Grid row -->
                                        <div id="password_div" class="form-row">
                                                <!-- Grid column -->
                                                <div class="col-md-6">
                                                    <!-- Material input -->
                                                    <div class="md-form">
                                            <i class="fas fa-unlock-alt prefix"></i>
                                            <input pattern=".{8,50}" title="Se requiere entre 8 y 50 caracteres" type="password" required id="password" value="{{ old('password') }}" name="password" class="form-control validate" maxlength="50">
                                            <label for="pass" data-error="Error" data-success="Correcto">Contraseña *</label>
                                        </div>
                                        @if ($errors->has('password'))
                                                                                    <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                                                                   {{ $errors->first('password') }}
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                                                        
                                                                        @endif
                                                </div>
                                                <!-- Grid column -->
                                                <div class="col-md-6">
                                                    <!-- Material input -->
                                                    <div class="md-form">
                                            <i class="fas fa-lock prefix"></i>
                                            <input pattern=".{8,50}" title="Se requiere entre 8 y 50 caracteres" type="password" required id="password_confirmation" value="{{ old('password_confirmation') }}" name="password_confirmation" class="form-control validate" maxlength="50">
                                            <label for="password_confirmation" data-error="Error" data-success="Correcto">Confirmar Contraseña *</label>
                                        </div>
                                        @if ($errors->has('password_confirmation'))
                                                                                    <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                                                                   {{ $errors->first('password_confirmation') }}
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                                                        
                                                                        @endif
                                                </div>
                                                <!-- Grid column -->
                                                </div>
                                            <!-- Grid row -->
                                          
                                        <!-- Grid row -->
                                        <div class="form-row mb-4">
                                            <!-- Grid column -->
                                            <div class="col-md-12">
                                    
                                                <!-- Material input -->
                                                @yield('persona_form')
                                            </div>
                                            <!-- Grid column -->
                                            </div>
                                        <!-- Grid row -->
                                    
                                    
                                        <a onclick="validar()" class="btn btn-outline-white hoverable waves-light mt-5" data-wow-delay="0.4s" role="button">
                                            <i class="fas fa-user-plus mr-2"></i>Registrarse</a>
                                    </form>
                            </div>
                                </div>
            </div>
        </div>
            <!--Grid row-->
       
            </section>
            <!-- /.Products Grid -->
        </div>
        <!-- /.Content -->

        <div class="mt-5 center-div-link text-center text-md-left  col-md-6 col-xl-5 offset-xl-1">
         
            <div class="card mb-4 z-depth-5 hoverable">
                <div class="card-body">
                       <div class="mask pattern-6 flex-center"></div>
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
<!-- /.Main Container -->
</section>
@endsection
@section('js_links')
<script type="text/javascript" src="{{ asset('js/addons/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/i18n/es.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/addons/validation/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/validation/messages_es.js') }}"></script>
<script type="text/javascript">

$("i").addClass("white-text");
function validar(){
  if($("#register_form").validate({
    lang: 'es',
    errorPlacement: function(error, element){
      $(element).parent().after(error);
		}})){
    $("#register_form").submit();
  }
  }
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

  $('#usuario_id').select2({
            placeholder: "Usuarios",
            theme: "material",
            language: "es"
        });
    
        $('#ciudad_id').select2({
            placeholder: "Ciudades",
            theme: "material",
            language: "es"
        });
        $(".select2-selection__arrow")
            .addClass("fas fa-chevron-down");
            
            function cambiar_info(){
                var primer_nombre = $('#primer_nombre').val();
                var segundo_nombre = $('#segundo_nombre').val();
                var primer_apellido = $('#primer_apellido').val();
                var segundo_apellido = $('#segundo_apellido').val();
                var nombre_completo = primer_nombre+" "+segundo_nombre+" "+primer_apellido+" "+segundo_apellido;
                $('#infowindow').val(nombre_completo);
            }
</script>

@yield('gmaps_links')

@endsection