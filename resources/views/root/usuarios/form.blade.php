@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css"/>
@endsection
@section('crud_form')

@if($editar)
<form id="usuario_form" method="POST" action="{{ route('usuarios.update',$usuario->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="PUT">
    @else
    <form id="usuario_form" method="POST" action="{{ route('usuarios.store') }}" accept-charset="UTF-8">
@endif

 {{ csrf_field() }}
    <!-- Grid row -->
    <div class="form-row">
        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <i class="fas fa-user prefix"></i>
    <input type="text" required id="name" value="{{ old('name') ? old('name') : $usuario->name}}" name="name" class="form-control validate" maxlength="50">
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
            <i class="fas fa-user-tie"></i>
            <small for="rol">Rol *</small>
    <select class="form-control" required id="role_id" name="role_id">
    <option value="" disabled selected>Selecciona una opción</option>
    
    @if ($default_role)
    <option selected value="{{$default_role->id}}">{{$default_role->display_name}}</option>
    @else
        @if ($usuario->roles->count() > 0)
            @foreach($roles as $key => $role)
                <option {{ old('role_id') ?  ((old('role__id') == $role->id) ? 'selected' : '') : (($editar && $usuario->roles->first()->id == $role->id) ? 'selected' : '') }} value="{{$role->id}}">{{$role->display_name}}</option>
            @endforeach
        @endif
    @endif
</select>
</div> @if ($errors->has('role_id'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('role_id') }}
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
<i class="far fa-envelope prefix"></i>
<input type="email" required id="email" value="{{ old('email') ? old('email') : $usuario->email}}" name="email" class="form-control validate" maxlength="100">
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
<!-- Grid column -->
<div class="col-md-6">
<!-- Material input -->

<input {{ (old('edit_password')) ? 'checked' : "" }} type="checkbox" id="edit_password" name="edit_password" class="switch-input">
<label for="edit_password" class="switch-label">Modificar contraseña: <span class="toggle--on">Si</span><span class="toggle--off">No</span></label>
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
    <input type="password" pattern=".{8,50}" title="Se requiere entre 8 y 50 caracteres" required id="password" value="{{ old('password') }}" name="password" class="form-control validate" maxlength="50">
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
    <input type="password" pattern=".{8,50}" title="Se requiere entre 8 y 50 caracteres" required id="password_confirmation" value="{{ old('password_confirmation') }}" name="password_confirmation" class="form-control validate" maxlength="50">
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
    
   

  
    <a onclick="validar()" class="waves-effect btn {{($editar) ? 'btn-warning' : 'btn-success'}} btn-md hoverable">
    <i class="fas fa-2x {{($editar) ? 'fa-pencil-alt' : 'fa-plus'}}"></i> {{($editar) ? 'Editar' : 'Registrar'}}
    </a>
</form>
@endsection

@section('js_links')
<script type="text/javascript" src="{{ asset('js/addons/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/i18n/es.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/addons/validation/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/validation/messages_es.js') }}"></script>
<script type="text/javascript">

function validar(){
  if($("#usuario_form").validate({
    lang: 'es',
    errorPlacement: function(error, element){
      $(element).parent().after(error);
		}})){
    $("#usuario_form").submit();
  }
  }

  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
$(document).ready(function() {
    $('#role_id').select2({
        placeholder: "Roles",
        theme: "material",
        language: "es"
    });
    $(".select2-selection__arrow")
        .addClass("fas fa-chevron-down");
        
    if($("#edit_password").prop("checked") == true) {
        $('#password').attr( 'required', true );	
        $('#password_confirmation').attr( 'required', true );
        $("#password_div").slideDown('fast');     
    }else{
		$('#password').attr( 'required', false );	
        $('#password_confirmation').attr( 'required', false ); 
        $("#password_div").slideUp('fast');
	}
});


$("#edit_password").change(function() {
    if(this.checked) {
		$('#password').attr( 'required', true );	
        $('#password_confirmation').attr( 'required', true );
        $("#password_div").slideDown('fast');
    }else{
		$('#password').attr( 'required', false );	
        $('#password_confirmation').attr( 'required', false ); 
        $("#password_div").slideUp('fast');
	}
});
</script>
@endsection