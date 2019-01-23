@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css"/>
@endsection
@section('crud_form')

@if($editar)
<form method="POST" action="{{ route('servicios.update', $servicio->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="PUT">
    @else
    <form method="POST" action="{{ route('servicios.store') }}" accept-charset="UTF-8">
@endif

 {{ csrf_field() }}
    <!-- Grid row -->
    <div class="form-row">
        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <i class="fas fa-cogs prefix"></i>
    <input type="text" required id="nombre" value="{{ $servicio->nombre}}" name="nombre" class="form-control validate" maxlength="50">
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

<!-- Material input -->
<div class="md-form">
    <i class="fas fa-money-bill-alt prefix"></i>
    <input type="text" required id="valor_unitario-mask" value="{{ old('valor_unitario') ? old('valor_unitario') : $servicio->valor_unitario}}" name="valor_unitario-mask" class="form-control validate" maxlength="50">
    <input type="hidden" required id="valor_unitario" value="{{ old('valor_unitario') ? old('valor_unitario') : $servicio->valor_unitario}}" name="valor_unitario" class="form-control validate" maxlength="12">
    <label for="valor_unitario" data-error="Error" data-success="Correcto">Valor unitario *</label>
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
   <i class="fas fa-ruler"></i>
   <small for="medida_id">Medida *</small>   
   @include('include.dato_basico.medidas.select', array('medida_selected'=>$servicio->medida))
   
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
    @include('include.clasificacion.categorias.select', array('categoria_selected'=>$servicio->categoria))
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
<i class="fas fa-comment-dots prefix"></i>
<textarea type="text" required id="descripcion" name="descripcion" class="md-textarea form-control validate" maxlength="1000">{{ old('descripcion') ? old('descripcion') : $servicio->descripcion}}</textarea>
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

    <button type="submit" class="waves-effect btn {{($editar) ? 'btn-warning' : 'btn-success'}} btn-md hoverable">
    <i class="fas fa-2x {{($editar) ? 'fa-pencil-alt' : 'fa-plus'}}"></i> {{($editar) ? 'Editar' : 'Registrar'}}
    </button>
</form>
@endsection
@section('js_links')
<script type="text/javascript" src="{{ asset('js/addons/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/i18n/es.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/addons/imask/imask.js')}}"></script>
<script type="text/javascript">
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
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