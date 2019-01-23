@include('include.contacto.personas.form', array('persona'=>$colaborador->persona))
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css"/>
@endsection
@section('crud_form')

@if($editar)
<form method="POST" action="{{ route('colaboradores.update', $colaborador->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="PUT">
    @else
    <form method="POST" action="{{ route('colaboradores.store') }}" accept-charset="UTF-8">
@endif

 {{ csrf_field() }}
@if(!$editar)
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
        <input type="password" required id="password" value="{{ old('password') }}" name="password" class="form-control validate" maxlength="50">
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
        <input type="password" required id="password_confirmation" value="{{ old('password_confirmation') }}" name="password_confirmation" class="form-control validate" maxlength="50">
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
        @endif
    <!-- Grid row -->
    <div class="form-row">
        <!-- Grid column -->
        <div class="col-md-12">

            <!-- Material input -->
            @yield('persona_form')
        </div>
        <!-- Grid column -->
        </div>
    <!-- Grid row -->


    <button type="submit" class="mt-4 waves-effect btn {{($editar) ? 'btn-warning' : 'btn-success'}} btn-md hoverable">
    <i class="fas fa-2x {{($editar) ? 'fa-pencil-alt' : 'fa-plus'}}"></i> {{($editar) ? 'Editar' : 'Registrar'}}
    </button>
</form>
@endsection

@section('js_links')
<script type="text/javascript" src="{{ asset('js/addons/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/i18n/es.js')}}"></script>
<script type="text/javascript">
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