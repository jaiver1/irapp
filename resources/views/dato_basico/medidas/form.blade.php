@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css"/>
@endsection
@section('crud_form')

@if($editar)
<form id="medida_form" method="POST" action="{{ route('medidas.update', $medida->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="PUT">
    @else
    <form id="medida_form" method="POST" action="{{ route('medidas.store') }}" accept-charset="UTF-8">
@endif

 {{ csrf_field() }}
    <!-- Grid row -->
    <div class="form-row">
        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <i class="fas fa-ruler prefix"></i>
    <input type="text" required id="nombre" value="{{ old('nombre') ? old('nombre') : $medida->nombre}}" name="nombre" class="form-control validate" maxlength="50">
    <label for="nombre" data-error="Error" data-success="Correcto">Nombre *</label>
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
        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <input type="text" required id="etiqueta" value="{{ old('etiqueta') ? old('etiqueta') : $medida->etiqueta}}" name="etiqueta" class="form-control validate" maxlength="5">
    <label for="etiqueta" data-error="Error" data-success="Correcto">Etiqueta *</label>
</div>
@if ($errors->has('etiqueta'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('etiqueta') }}
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
            <i class="fas fa-balance-scale"></i>
            <small for="tipo_medida_id">Tipo de medida *</small>   
    <select class="form-control" required id="tipo_medida_id" name="tipo_medida_id">
    <option value="" disabled selected>Selecciona una opción</option>
    @foreach($tipos_medidas as $key => $tipo_medida)
    <option {{ old('tipo_medida_id') ?  ((old('tipo_medida_id') == $tipo_medida->id) ? 'selected' : '') : ( ($medida->tipo_medida->id == $tipo_medida->id) ? 'selected' : '') }} value="{{ $tipo_medida->id }}">{{$tipo_medida->nombre}}</option>
    @endforeach
</select>
</div> @if ($errors->has('tipo_medida_id'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('tipo_medida_id') }}
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
  if($("#medida_form").validate({
    lang: 'es',
    errorPlacement: function(error, element){
      $(element).parent().after(error);
		}})){
    $("#medida_form").submit();
  }
  }

  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
$('#tipo_medida_id').select2({
        placeholder: "Tipos de medidas",
        theme: "material",
        language: "es"
    });
    $(".select2-selection__arrow")
        .addClass("fas fa-chevron-down");
</script>
@endsection