@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css"/>
@endsection
@section('crud_form')

@if($editar)
<form method="POST" action="{{ route('productos.update',$producto->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="PUT">
    @else
    <form method="POST" action="{{ route('productos.store') }}" accept-charset="UTF-8">
@endif

 {{ csrf_field() }}
    <!-- Grid row -->
    <div class="form-row">
        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <i class="fa fa-boxes prefix"></i>
    <input type="text" required id="nombre" value="{{ $producto->nombre}}" name="nombre" class="form-control validate" maxlength="50">
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
   <div class="col-md-6">
       
        <!-- Material input -->

<div class="md-form">
<i class="fa fa-trademark"></i>
<small for="marca_id">Marca</small>   
<select class="form-control" required id="marca_id" name="marca_id">
        <option value="" disabled selected>Selecciona una opción</option>
        @foreach($marcas as $key => $marca)
        <option {{($producto->marca->id == $marca->id ) ? 'selected' : '' }} value="{{$marca->id}}">{{$marca->nombre}}</option>
        @endforeach
    </select>
</div> @if ($errors->has('marca_id'))
                          <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                         {{ $errors->first('marca_id') }}
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
    <i class="fa fa-box-open prefix"></i>
    <input type="text" required id="referencia" value="{{ $producto->referencia}}" name="referencia" class="form-control validate" maxlength="50">
    <label for="referencia" data-error="Error" data-success="Correcto">Referencia</label>
</div>
@if ($errors->has('referencia'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('referencia') }}
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
<i class="fa fa-barcode"></i>
<small for="tipo_referencia_id">Tipo de referencia</small>   
<select class="form-control" required id="tipo_referencia_id" name="tipo_referencia_id">
        <option value="" disabled selected>Selecciona una opción</option>
        @foreach($grupos as $key => $grupo)
        <optgroup label="{{ $grupo[0] }}">
                @foreach($grupo[1] as $tipo_referencia)
        <option {{($producto->tipo_referencia->id == $tipo_referencia->id ) ? 'selected' : '' }} value="{{$tipo_referencia->id}}">{{$tipo_referencia->nombre}}</option>
        @endforeach
        @endforeach
    </select>
</div> @if ($errors->has('tipo_referencia_id'))
                          <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                         {{ $errors->first('tipo_referencia_id') }}
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
<i class="fa fa-ruler"></i>
<small for="medida_id">Medida</small>   

<select class="form-control" required id="medida_id" name="medida_id">
        <option value="" disabled selected>Selecciona una opción</option>
        @foreach($tipos_medidas as $key => $tipo_medida)
        <optgroup label="{{ $tipo_medida->nombre }}">
        @foreach($tipo_medida->medidas as $medida)
        <option {{($producto->medida->id == $medida->id ) ? 'selected' : '' }} value="{{$medida->id}}">{{$medida->nombre}}</option>
        @endforeach
        @endforeach
    </select>
</div> @if ($errors->has('medida_id'))
                          <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                         {{ $errors->first('medida_id') }}
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
<i class="fa fa-sitemap"></i>
<small for="categoria_id">Categoria</small>   
 @include('clasificacion.categorias.sub_categorias_select', array('categoria_selected'=>$producto->categoria))
</div> @if ($errors->has('categoria_id'))
                          <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                         {{ $errors->first('categoria_id') }}
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
        <div class="col-md-12">
            <!-- Material input -->
            <div class="md-form">
    <i class="fa fa-comment-dots prefix"></i>
    <textarea type="text" required id="descripcion" value="{{ $producto->descripcion}}" name="descripcion" class="md-textarea form-control validate" maxlength="50"></textarea>
    <label for="descripcion" data-error="Error" data-success="Correcto">Descripción</label>
</div> @if ($errors->has('descripcion'))
                          <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                         {{ $errors->first('descripcion') }}
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
$('#marca_id').select2({
        placeholder: "Marcas",
        theme: "material",
        language: "es"
    });

    $('#tipo_referencia_id').select2({
        placeholder: "Tipos de Referencias",
        theme: "material",
        language: "es"
    });

    $('#medida_id').select2({
        placeholder: "Medidas",
        theme: "material",
        language: "es"
    });

    $('#categoria_id').select2({
        placeholder: "Categorias",
        theme: "material",
        language: "es"
    });
    $(".select2-selection__arrow")
        .addClass("fa fa-chevron-down");

</script>
@endsection
