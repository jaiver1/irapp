@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css"/>
@endsection
@section('crud_form')

@if($editar)
<form method="POST" action="{{ route('usuarios.update',$usuario->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="PUT">
    @else
    <form method="POST" action="{{ route('usuarios.store') }}" accept-charset="UTF-8">
@endif

 {{ csrf_field() }}
    <!-- Grid row -->
    <div class="form-row">
        <!-- Grid column -->
        <div class="col-md-12">
            <!-- Material input -->
            <div class="md-form">
    <i class="fa fa-user prefix"></i>
    <input type="text" required id="name" value="{{ $usuario->name}}" name="name" class="form-control validate" maxlength="50">
    <label for="name" data-error="Error" data-success="Correcto">Usuario</label>
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
        </div>
    <!-- Grid row -->

<!-- Grid row -->
<div class="form-row">
        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <i class="fa fa-unlock-alt prefix"></i>
    <input type="password" required id="password" value="" name="password" class="form-control validate" maxlength="50">
    <label for="pass" data-error="Error" data-success="Correcto">Contraseña</label>
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
    <i class="fa fa-lock prefix"></i>
    <input type="password" required id="password_confirmation" value="" name="password_confirmation" class="form-control validate" maxlength="50">
    <label for="password_confirmation" data-error="Error" data-success="Correcto">Confirmar Contraseña</label>
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
  <div class="form-row">
        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <i class="fa fa-envelope prefix"></i>
    <input type="email" required id="email" value="{{ $usuario->email}}" name="email" class="form-control validate" maxlength="100">
    <label for="email" data-error="Error" data-success="Correcto">Email</label>
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

        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
            <i class="fa fa-user-tie"></i>
            <small for="rol">Rol</small>
    <select class="form-control" required id="rol" name="rol">
    <option value="" disabled selected>Selecciona una opción</option>
    @foreach($roles as $key => $rol)
    <option value="{{$rol->id}}">{{$rol->display_name}}</option>
    @endforeach
</select>
</div> @if ($errors->has('rol'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('rol') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
                                
                                @endif
        </div>
        <!-- Grid column -->
    </div>
    <!-- Grid row -->
    <button type="submit" class="waves-effect btn {{($editar) ? 'btn-warning' : 'btn-success'}} btn-md hoverable">
    <i class="fa fa-2x {{($editar) ? 'fa-pencil-alt' : 'fa-plus'}}"></i> {{($editar) ? 'Editar' : 'Registrar'}}
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
$(document).ready(function() {
    $('#rol').select2({
        placeholder: "Roles",
        theme: "material",
        language: "es"
    });
    $(".select2-selection__arrow")
        .addClass("fa fa-chevron-down");
});
</script>
@endsection