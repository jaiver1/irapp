@section('persona_form')

    <!-- Grid row -->
    <div class="form-row">
        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <i class="fa fa-user-tie prefix"></i>
    <input type="text" required id="cedula" value="{{ $cliente->persona->cedula}}" name="cedula" class="form-control validate" maxlength="50">
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
    <input type="text" required id="cuenta_banco" value="{{ $cliente->persona->cuenta_banco}}" name="cuenta_banco" class="form-control validate" maxlength="50">
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
    <input type="text" required id="primer_nombre" value="{{ $cliente->persona->primer_nombre}}" name="primer_nombre" class="form-control validate" maxlength="50">
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
    <input type="text" required id="segundo_nombre" value="{{ $cliente->persona->segundo_nombre}}" name="segundo_nombre" class="form-control validate" maxlength="50">
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
    <input type="text" required id="primer_apellido" value="{{ $cliente->persona->primer_apellido}}" name="primer_apellido" class="form-control validate" maxlength="50">
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
    <input type="text" required id="segundo_apellido" value="{{ $cliente->persona->segundo_apellido}}" name="segundo_apellido" class="form-control validate" maxlength="50">
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
    <i class="prefix"></i>
    <input type="tel" required id="telefono_fijo" value="{{ $cliente->persona->primer_nombre}}" name="primer_nombre" class="form-control validate" maxlength="50">
    <label for="primer_nombre" data-error="Error" data-success="Correcto">Teefono movil</label>
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
    <input type="tel" required id="telefono_fijo" value="{{ $cliente->persona->segundo_nombre}}" name="segundo_nombre" class="form-control validate" maxlength="50">
    <label for="telefono_fijo" data-error="Error" data-success="Correcto">Telefono fijo</label>
</div>
@if ($errors->has('telefono_fijo'))
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
        <i class="fa fa-location-arrow prefix"></i>
        <input type="text" readonly required id="latitud" value="{{ ($cliente->persona->latitud) ? $cliente->persona->latitud : 0}}" name="latitud" class="form-control validate" maxlength="50">
        <label for="latitud" data-error="Error" data-success="Correcto">Latitud</label>
    </div>
    @if ($errors->has('latitud'))
                                                <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                               {{ $errors->first('latitud') }}
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
        <i class="fa fa-map-marker-alt prefix"></i>
        <input type="text" readonly required id="longitud" value="{{($cliente->persona->longitud) ? $cliente->persona->longitud : 0}}" name="longitud" class="form-control validate" maxlength="50">
        <label for="longitud" data-error="Error" data-success="Correcto">Longitud</label>
    </div>
    @if ($errors->has('longitud'))
                                                <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                               {{ $errors->first('longitud') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
                                    
                                    @endif
            </div>
        
            <!-- Grid column -->
            </div>
        <!-- Grid row -->

        <div class="form-row">
            <!-- Grid column -->
            <div class="col-md-12">
                    <input id="pac-input" class="controls" type="text" placeholder="Buscar">
                    <div id="map" class="z-depth-1 hoverable div-border" style="height: 300px"></div>

 </div>
        
            <!-- Grid column -->
            </div>
        <!-- Grid row -->

@endsection