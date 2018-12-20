
@include('include.addons.gmaps.form', array('ubicacion'=>$orden->ubicacion))

@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('css/addons/bootstrap-material-datetimepicker.css') }}" type="text/css"/>
@endsection
@section('crud_form')

@if($editar)
<form method="POST" action="{{ route('ordenes.update', $orden->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="PUT">
    @else
    <form method="POST" action="{{ route('ordenes.store') }}" accept-charset="UTF-8">
@endif

 {{ csrf_field() }}


    <!-- Grid row -->
    <div class="form-row">
        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <i class="fas fa-business-time prefix"></i>
    <input type="text" required id="nombre" value="{{ old('nombre') ? old('nombre') : $orden->nombre}}" name="nombre" class="form-control validate" maxlength="50">
    <label for="nombre" data-error="Error" data-success="Correcto">Nombre</label>
</div>
@if ($errors->has('nombre'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('nombre') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
                                
                                @endif
        </div>
    
        <!-- Grid column -->
        @if (!$editar)
  <!-- Grid column -->
  <div class="col-md-6">
    <!-- Material input -->
    <div class="md-form">
<i class="prefix fas fa-calendar-alt"></i>
<input type="text" required id="fecha_inicio" value="{{ old('fecha_inicio') ? old('fecha_inicio') : $orden->fecha_inicio}}" name="fecha_inicio" class="form-control validate" maxlength="50">
<label for="fecha_inicio" data-error="Error" data-success="Correcto">Fecha inicio</label>
</div>
@if ($errors->has('fecha_inicio'))
                                    <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                   {{ $errors->first('fecha_inicio') }}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
                        
                        @endif
</div>

<!-- Grid column -->
@endif

@if ($editar)

<!-- Grid column -->
<div class="col-md-6">
  <!-- Material input -->
  
  <div class="md-form">
  <i class="fas {{($orden->estado == 'Abierta' ) ? 'fa-tools' : (($orden->estado == 'Cerrada' ) ? 'fa-check-circle' : (($orden->estado == 'Cancelada' ) ? 'fa-times-circle' : (($orden->estado == 'Pendiente' ) ? 'fa-stopwatch' : 'fa-asterisk')))}} "></i>
  <small for="estado">Estado *</small>   
<select class="form-control" required id="estado" name="estado">
<option value="" disabled selected>Selecciona una opción</option>
@foreach($estados as $key => $estado)
<option {{ old('estado') ?  ((old('estado') == $estado) ? 'selected' : '') : ( ($orden->estado == $estado) ? 'selected' : '') }} value="{{ $estado}}">{{$estado}}</option>
@endforeach
</select>
</div> @if ($errors->has('estado'))
                                  <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                 {{ $errors->first('estado') }}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
                      
                      @endif
</div>
<!-- Grid column -->
@endif
        </div>
    <!-- Grid row -->
    @if ($editar)
     <!-- Grid row -->
     <div class="form-row">
        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <i class="prefix fas fa-calendar-alt"></i>
    <input type="text" required id="fecha_inicio" value="{{ old('fecha_inicio') ? old('fecha_inicio') : $orden->fecha_inicio}}" name="fecha_inicio" class="form-control validate" maxlength="50">
    <label for="fecha_inicio" data-error="Error" data-success="Correcto">Fecha inicio</label>
</div>
@if ($errors->has('fecha_inicio'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('fecha_inicio') }}
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
    <i class="prefix fas fa-calendar-check"></i>
    <input type="text" id="fecha_fin" value="{{ old('fecha_fin') ? old('fecha_fin') : $orden->fecha_fin}}" name="fecha_fin" class="form-control validate" maxlength="50">
    <label for="fecha_inicio" data-error="Error" data-success="Correcto">Fecha fin</label>
</div>
@if ($errors->has('fecha_fin'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('fecha_fin') }}
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
    <div class="col-md-6">
      <!-- Material input -->
      
      <div class="md-form">
      <i class="fas fa-user-tie"></i>
      <small for="cliente_id">Cliente *</small>   
  <select class="form-control" required id="cliente_id" name="cliente_id">
  <option value="" disabled selected>Selecciona una opción</option>
    @foreach($clientes as $key => $cliente)
    <option {{ old('cliente_id') ?  ((old('cliente_id') == $cliente->id) ? 'selected' : '') : ( ($orden->cliente->id == $cliente->id) ? 'selected' : '') }} value="{{ $cliente->id }}">{{$cliente->primer_nombre}} {{$cliente->segundo_nombre}} {{$cliente->primer_apellido}} {{$cliente->segundo_apellido}}</option>
    @endforeach
  </select>
  </div> @if ($errors->has('cliente_id'))
                                      <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                     {{ $errors->first('cliente_id') }}
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
      <i class="fas fa-city"></i>
      <small for="ciudad_id">Ciudad *</small>   
      @include('include.dato_basico.ciudades.select', array('ciudad_selected'=>$orden->ciudad))
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
  <input type="text" required id="barrio" value="{{ old('barrio') ? old('barrio') : $orden->barrio}}" name="barrio" class="form-control validate" maxlength="50">
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
  <input type="text" required id="direccion" value="{{ old('direccion') ? old('direccion') : $orden->direccion}}" name="direccion" class="form-control validate" maxlength="50">
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

    <button type="submit" class="mt-4 waves-effect btn {{($editar) ? 'btn-warning' : 'btn-success'}} btn-md hoverable">
    <i class="fas fa-2x {{($editar) ? 'fa-pencil-alt' : 'fa-plus'}}"></i> {{($editar) ? 'Editar' : 'Registrar'}}
    </button>
</form>
@endsection
@section('js_links')

<script type="text/javascript" src="{{ asset('js/addons/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/i18n/es.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/addons/bootstrap-material-datetimepicker.js') }}"></script>
<script type="text/javascript">
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
$('#estado').select2({
        placeholder: "Estados",
        theme: "material",
        language: "es"
    });

    $('#ciudad_id').select2({
        placeholder: "Ciudades",
        theme: "material",
        language: "es"
    });

    $('#cliente_id').select2({
        placeholder: "Clientes",
        theme: "material",
        language: "es"
    });
    $(".select2-selection__arrow")
        .addClass("fas fa-chevron-down");

$('#fecha_inicio').bootstrapMaterialDatePicker({

// enable date picker
date : true, 

// enable time picker
time : true, 

// custom date format
format : 'YYYY-MM-DD HH:mm', 

// min / max date
minDate : null, 
maxDate : null, 

// current date
currentDate : null, 

// Localization
lang : 'es', 

// week starts at
weekStart : 1, 

// short time format
shortTime : false, 

// text for cancel button
'cancelText' : '<i class="fas fa-times fa-2x"></i>', 

// text for ok button
'okText' : '<i class="fas fa-check fa-2x"></i>' 

}).on('change', function(e, date)
{
$('#fecha_fin').bootstrapMaterialDatePicker('setMinDate', date);
$('#fecha_fin').bootstrapMaterialDatePicker('setDate', date);
}); 

$('#fecha_fin').bootstrapMaterialDatePicker({

// enable date picker
date : true, 

// enable time picker
time : true, 

// custom date format
format : 'YYYY-MM-DD HH:mm', 

// min / max date
minDate : null, 
maxDate : null, 

// current date
currentDate : null, 

// Localization
lang : 'es', 

// week starts at
weekStart : 1, 

// short time format
shortTime : false, 

// text for cancel button
'cancelText' : '<i class="fas fa-times fa-2x"></i>', 

// text for ok button
'okText' : '<i class="fas fa-check fa-2x"></i>' 

});

    </script>

@yield('gmaps_links')
@endsection