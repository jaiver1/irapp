@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css"/>
@endsection
@section('crud_form')

@if($editar)
<form id="categoria_form" method="POST" action="{{ route('categorias.update',$categoria->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="PUT">
    @else
    <form id="categoria_form" method="POST" action="{{ route('categorias.store') }}" accept-charset="UTF-8">
@endif

 {{ csrf_field() }}
    <!-- Grid row -->
    <div class="form-row">
        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <i class="fas fa-sitemap prefix"></i>
    <input type="text" required id="nombre" value="{{ old('nombre') ? old('nombre') : $categoria->nombre}}" name="nombre" class="form-control validate" maxlength="50">
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
<div class="md-form">
<i class="fas fa-sitemap"></i>
<small for="categoria_id">Categorias *</small>   
@include('include.clasificacion.categorias_parent.select', array('categoria_selected'=>$categoria))
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
  if($("#categoria_form").validate({
    lang: 'es',
    errorPlacement: function(error, element){
      $(element).parent().after(error);
		}})){
    $("#categoria_form").submit();
  }
  }

  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

    $('#categoria_id').select2({
        placeholder: "Categorias",
        theme: "material",
        language: "es"
    });
    $(".select2-selection__arrow")
        .addClass("fas fa-chevron-down");

    

</script>
@endsection
