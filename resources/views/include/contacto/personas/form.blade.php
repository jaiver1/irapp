@include('include.addons.gmaps.form', array('ubicacion'=>$persona->ubicacion,'infowindow'=>$persona->primer_nombre." ".$persona->segundo_nombre." ".$persona->primer_apellido." ".$persona->segundo_apellido))
@section('persona_form')

    <!-- Grid row -->
    <div class="form-row">
        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <i class="fas fa-user-tie prefix"></i>
    <input type="text" required id="cedula" value="{{ old('cedula') ? old('cedula') : $persona->cedula}}" name="cedula" class="form-control validate" maxlength="50">
    <label for="cedula" data-error="Error" data-success="Correcto">Cedula *</label>
</div>
@if ($errors->has('cedula'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('cedula') }}
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
    <i class="fas fa-credit-card prefix"></i>
    <input type="text"  id="cuenta_banco" value="{{ old('cuenta_banco') ? old('cuenta_banco') : $persona->cuenta_banco}}" name="cuenta_banco" class="form-control validate" maxlength="50">
    <label for="cuenta_banco" data-error="Error" data-success="Correcto">Cuenta banco</label>
</div>
@if ($errors->has('cuenta_banco'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('cuenta_banco') }}
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
    <i class="prefix"></i>
    <input onchange="cambiar_info()" type="text" required id="primer_nombre" value="{{ old('primer_nombre') ? old('primer_nombre') : $persona->primer_nombre}}" name="primer_nombre" class="form-control validate" maxlength="50">
    <label for="primer_nombre" data-error="Error" data-success="Correcto">Primer nombre *</label>
</div>
@if ($errors->has('primer_nombre'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('primer_nombre') }}
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
    <i class="prefix"></i>
    <input onchange="cambiar_info()" type="text" id="segundo_nombre" value="{{ old('segundo_nombre') ? old('segundo_nombre') : $persona->segundo_nombre}}" name="segundo_nombre" class="form-control validate" maxlength="50">
    <label for="segundo_nombre" data-error="Error" data-success="Correcto">Segundo nombre</label>
</div>
@if ($errors->has('segundo_nombre'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('segundo_nombre') }}
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
    <i class="prefix"></i>
    <input onchange="cambiar_info()" type="text" required id="primer_apellido" value="{{ old('primer_apellido') ? old('primer_apellido') : $persona->primer_apellido}}" name="primer_apellido" class="form-control validate" maxlength="50">
    <label for="primer_apellido" data-error="Error" data-success="Correcto">Primer apellido *</label>
</div>
@if ($errors->has('primer_apellido'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('primer_apellido') }}
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
    <i class="prefix"></i>
    <input onchange="cambiar_info()" type="text" required id="segundo_apellido" value="{{ old('segundo_apellido') ? old('segundo_apellido') : $persona->segundo_apellido}}" name="segundo_apellido" class="form-control validate" maxlength="50">
    <label for="segundo_apellido" data-error="Error" data-success="Correcto">Segundo apellido *</label>
</div>
@if ($errors->has('segundo_apellido'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('segundo_apellido') }}
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
    <i class="prefix fas fa-mobile-alt"></i>
    <input type="tel" required id="telefono_movil" value="{{ old('telefono_movil') ? old('telefono_movil') : $persona->telefono_movil}}" name="telefono_movil" class="form-control validate" maxlength="50">
    <label for="telefono_movil" data-error="Error" data-success="Correcto">Telefono móvil *</label>
</div>
@if ($errors->has('telefono_movil'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('telefono_movil') }}
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
    <i class="prefix fas fa-phone fa-flip-horizontal"></i>
    <input type="tel" id="telefono_fijo" value="{{ old('telefono_fijo') ? old('telefono_fijo') : $persona->telefono_fijo}}" name="telefono_fijo" class="form-control validate" maxlength="50">
    <label for="telefono_fijo" data-error="Error" data-success="Correcto">Telefono fijo *</label>
</div>
@if ($errors->has('telefono_fijo'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('telefono_fijo') }}
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
  {{-- 
  <!-- Grid column -->
  <div class="col-md-6">
    <!-- Material input -->
    
    <div class="md-form">
    <i class="fas fa-user-circle"></i>
    <small for="usuario_id">Usuario *</small>   
<select class="form-control" required id="usuario_id" name="usuario_id">
    @if ($editar)
    <option value="{{ $persona->usuario->id }}">{{$persona->usuario->name}} -:- {{$persona->usuario->email}}</option>
@else
<option value="" disabled selected>Selecciona una opción</option>
@foreach($usuarios as $key => $usuario)
<option {{ old('usuario_id') ?  ((old('usuario_id') == $usuario->id) ? 'selected' : '') : '' }} value="{{ $usuario->id }}">{{$usuario->name}} -:- {{$usuario->email}}</option>
@endforeach
@endif
</select>
</div> @if ($errors->has('usuario_id'))
                                    <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                   {{ $errors->first('usuario_id') }}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
                        
                        @endif
</div>
<!-- Grid column -->
--}}
  <div class="col-md-6">
    <!-- Material input -->
    
    <div class="md-form">
    <i class="fas fa-city"></i>
    <small for="ciudad_id">Ciudad *</small>   
    @include('include.dato_basico.ciudades.select', array('ciudad_selected'=>$persona->ciudad))

</div> @if ($errors->has('ciudad_id'))
                                    <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                   {{ $errors->first('ciudad_id') }}
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
<i class="prefix fas fa-map-marked-alt"></i>
<input type="text" required id="barrio" value="{{ old('barrio') ? old('barrio') : $persona->barrio}}" name="barrio" class="form-control validate" maxlength="50">
<label for="barrio" data-error="Error" data-success="Correcto">Barrio *</label>
</div>
@if ($errors->has('barrio'))
                                    <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                   {{ $errors->first('barrio') }}
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
<i class="prefix fas fa-home"></i>
<input type="text" required id="direccion" value="{{ old('direccion') ? old('direccion') : $persona->direccion}}" name="direccion" class="form-control validate" maxlength="50">
<label for="direccion" data-error="Error" data-success="Correcto">Dirección *</label>
</div>
@if ($errors->has('direccion'))
                                      <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                     {{ $errors->first('direccion') }}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
                          
                          @endif
  </div>

  <!-- Grid column -->
  </div>
<!-- Grid row -->

    @yield('gmaps_form')

@endsection