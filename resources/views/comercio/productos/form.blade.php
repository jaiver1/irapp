@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css"/>
@endsection
@section('crud_form')

@if($editar)
<form id="producto_form" method="POST" action="{{ route('productos.update',$producto->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="PUT">
    @else
    <form id="producto_form" method="POST" action="{{ route('productos.store') }}" accept-charset="UTF-8">
@endif

 {{ csrf_field() }}
    <!-- Grid row -->
    <div class="form-row">
        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <i class="fas fa-boxes prefix"></i>
    <input type="text" required id="nombre" value="{{ old('nombre') ? old('nombre') : $producto->nombre}}" name="nombre" class="form-control validate" maxlength="50">
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
   <div class="col-md-6">
       
        <!-- Material input -->

 <!-- Material input -->
 <div class="md-form">
        <i class="fas fa-money-bill-alt prefix"></i>
        <input type="hidden" required id="valor_unitario" value="{{ old('valor_unitario') ? old('valor_unitario') : $producto->valor_unitario}}" name="valor_unitario" class="form-control validate" maxlength="12">
        <input type="text" required id="valor_unitario-mask" value="{{ old('valor_unitario') ? old('valor_unitario') : $producto->valor_unitario}}" name="valor_unitario-mask" class="form-control validate" maxlength="50">
        <label for="valor_unitario-mask" data-error="Error" data-success="Correcto">Valor unitario *</label>
    </div>
    @if ($errors->has('valor_unitario'))
                                                <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                               {{ $errors->first('valor_unitario') }}
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
    <i class="fas fa-box-open prefix"></i>
    <input type="text" pattern="^[0-9]+.*$" title="El codigo debe empezar con numeros." 
    required id="referencia" onchange="test_referencias('{{ route("productos.testReferencias") }}')" value="{{ old('referencia') ? old('referencia') : $producto->referencia}}" name="referencia" class="form-control validate" maxlength="50">
    <label for="referencia" data-error="Error" data-success="Correcto">Referencia *</label>
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
<i class="fas fa-barcode"></i>
<small for="tipo_referencia_id">Tipo de referencia *</small>   
<select class="form-control" required id="tipo_referencia_id" name="tipo_referencia_id">
        <option value="" disabled selected>Selecciona una opción</option>
        @foreach($grupos as $key => $grupo)
        <optgroup label="{{ $grupo[0] }}">
                @foreach($grupo[1] as $tipo_referencia)
        <option {{ old('tipo_referencia_id') ?  ((old('tipo_referencia__id') == $tipo_referencia->id) ? 'selected' : '') : (($producto->tipo_referencia->id == $tipo_referencia->id ) ? 'selected' : '') }} value="{{$tipo_referencia->id}}">{{$tipo_referencia->nombre}}</option>
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
<i class="fas fa-ruler"></i>
<small for="medida_id">Medida *</small>   
@include('include.dato_basico.medidas.select', array('medida_selected'=>$producto->medida))

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
<i class="fas fa-sitemap"></i>
<small for="categoria_id">Categoria *</small>   
 @include('include.clasificacion.categorias.select', array('categoria_selected'=>$producto->categoria))
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
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
                    <i class="fas fa-trademark"></i>
                    <small for="marca_id">Marca *</small>   
                     @include('include.comercio.marcas.select', array('marca_selected'=>$producto->marca))
                    </div> 
                     @if ($errors->has('marca_id'))
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
        <div class="col-md-12">
            <!-- Material input -->
            <div class="md-form">
    <i class="fas fa-comment-dots prefix"></i>
    <textarea type="text" required id="descripcion" name="descripcion" class="md-textarea form-control validate" maxlength="1000">{{ old('descripcion') ? old('descripcion') : $producto->descripcion}}</textarea>
    <label for="descripcion" data-error="Error" data-success="Correcto">Descripción *</label>
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

    <a onclick="validar()" class="waves-effect btn {{($editar) ? 'btn-warning' : 'btn-success'}} btn-md hoverable">
    <i class="fas fa-2x {{($editar) ? 'fa-pencil-alt' : 'fa-plus'}}"></i> {{($editar) ? 'Editar' : 'Registrar'}}
    </a>
</form>
@endsection
@section('js_links')
<script type="text/javascript" src="{{ asset('js/addons/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/i18n/es.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/addons/imask/imask.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/irapp.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/validation/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/validation/messages_es.js') }}"></script>
<script type="text/javascript">

function validar(){
  if($("#producto_form").validate({
    lang: 'es',
    errorPlacement: function(error, element){
      $(element).parent().after(error);
		}})){
    $("#producto_form").submit();
  }
  }

    function test_referencias(url_send){
      inicio_carga()
      var referencia = $("#referencia").val();
      $.ajax({
        method: "GET",
        url: url_send,
        async:true,
        data: {content: referencia}
      })
        .done(function(grupos) {
            try {
            $("#tipo_referencia_id").empty().append('<option value="" disabled selected>Selecciona una opción</option>');
            for(var i in grupos) {
                $("#tipo_referencia_id").append('<optgroup label="'+grupos[i][0]+'">');  
                for(var j in grupos[i][1]) {
                    $("#tipo_referencia_id").append('<option  value="'+grupos[i][1][j].id+'">'+grupos[i][1][j].nombre+'</option>');
                }
                }
            }
    catch(err) {
        console.log(err.message);
    }
        })
        .fail(function(response) {
          console.log(response.responseJSON);
          swal({
            title: 'Error '+response.status,
            text: response.statusText,
            type: 'error',
            confirmButtonText: '<i class="fas fa-check"></i> Continuar',
            showCloseButton: true,
            confirmButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            animation: false,
            customClass: 'animated zoomIn',
          });
        })
        .always(function() {
          fin_carga()
        });
    }
    
      $(function () {
        var numberMask = new IMask(document.getElementById('valor_unitario-mask'), {
          mask: Number,
          min: 0,
          max: 999999999999,
          thousandsSeparator: ','
        }).on('accept', function() {
          document.getElementById('valor_unitario').value = numberMask.masked.number;
        });
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
            .addClass("fas fa-chevron-down");
    
    </script>
@endsection
