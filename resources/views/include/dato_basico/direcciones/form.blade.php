@section('direccion_form')
       <!-- Grid row -->
  <div class="form-row">

      <div class="col-md-12">
          <!-- Material input -->
          
          <div class="md-form">
          <i class="fas fa-city"></i>
          <small for="ciudad_id">Ciudad *</small>   
          @include('include.dato_basico.ciudades.select', array('ciudad_selected'=>$direccion->ciudad))
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

    </div>
    <!-- Grid row -->

      <!-- Grid row -->
      <div class="form-row">

    <!-- Grid column -->
    <div class="col-md-6">
        <!-- Material input -->
        <div class="md-form">
  <i class="prefix fas fa-map-marked-alt"></i>
  <input type="text" required id="barrio" value="{{ old('barrio') ? old('barrio') : $direccion->barrio}}" name="barrio" class="form-control validate" maxlength="50">
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
  
      <!-- Grid column -->
      <div class="col-md-6">
        <!-- Material input -->
        <div class="md-form">
  <i class="prefix fas fa-home"></i>
  <input type="text" required id="direccion" value="{{ old('direccion') ? old('direccion') : $direccion->direccion}}" name="direccion" class="form-control validate" maxlength="50">
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
@endsection