@include('include.addons.gmaps.form', array('ubicacion'=>$persona->ubicacion))
@section('persona_form')

    <!-- Grid row -->
    <div class="form-row">
        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <i class="fa fa-user-tie prefix"></i>
    <input type="text" required id="cedula" value="{{ $persona->cedula}}" name="cedula" class="form-control validate" maxlength="50">
    <label for="cedula" data-error="Error" data-success="Correcto">Cedula</label>
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
    <i class="fa fa-credit-card prefix"></i>
    <input type="text" required id="cuenta_banco" value="{{ $persona->cuenta_banco}}" name="cuenta_banco" class="form-control validate" maxlength="50">
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
    <input type="text" required id="primer_nombre" value="{{ $persona->primer_nombre}}" name="primer_nombre" class="form-control validate" maxlength="50">
    <label for="primer_nombre" data-error="Error" data-success="Correcto">Primer nombre</label>
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
    <input type="text" required id="segundo_nombre" value="{{ $persona->segundo_nombre}}" name="segundo_nombre" class="form-control validate" maxlength="50">
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
    <input type="text" required id="primer_apellido" value="{{ $persona->primer_apellido}}" name="primer_apellido" class="form-control validate" maxlength="50">
    <label for="primer_apellido" data-error="Error" data-success="Correcto">Primer apellido</label>
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
    <input type="text" required id="segundo_apellido" value="{{ $persona->segundo_apellido}}" name="segundo_apellido" class="form-control validate" maxlength="50">
    <label for="segundo_apellido" data-error="Error" data-success="Correcto">Segundo apellido</label>
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
    <i class="prefix fa fa-mobile-alt"></i>
    <input type="tel" required id="telefono_movil" value="{{ $persona->telefono_movil}}" name="telefono_movil" class="form-control validate" maxlength="50">
    <label for="telefono_movil" data-error="Error" data-success="Correcto">Telefono movil</label>
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
    <i class="prefix fa fa-phone-volume"></i>
    <input type="tel" required id="telefono_fijo" value="{{ $persona->telefono_fijo}}" name="telefono_fijo" class="form-control validate" maxlength="50">
    <label for="telefono_fijo" data-error="Error" data-success="Correcto">Telefono fijo</label>
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

    @yield('gmaps_form')

@endsection