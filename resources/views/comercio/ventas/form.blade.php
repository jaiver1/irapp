@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('css/addons/bootstrap-material-datetimepicker.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('css/addons/datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-responsive-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-buttons-datatables.min.css') }}" type="text/css">
@endsection
@section('crud_form')

@if($editar)
<form id="venta_form" method="POST" action="{{ route('ventas.update', $venta->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="PUT">
    @else
    <form id="venta_form" method="POST" action="{{ route('ventas.store') }}" accept-charset="UTF-8">
@endif

 {{ csrf_field() }}


<!-- Grid row -->
<div class="form-row">

     
  <!-- Grid column -->
  <div class="col-md-6">
    <!-- Material input -->
    <div class="md-form">
<i class="prefix far fa-calendar-alt"></i>
<input type="text" required id="fecha" value="{{ old('fecha') ? old('fecha') : $venta->fecha}}" name="fecha" class="form-control validate" maxlength="50">
<label for="fecha" data-error="Error" data-success="Correcto">Fecha *</label>
</div>
@if ($errors->has('fecha'))
                                    <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                   {{ $errors->first('fecha') }}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
                        
                        @endif
</div>

<!-- Grid column -->

        </div>
    <!-- Grid row -->

    {{--
    @if ($editar)
     <!-- Grid row -->
     <div class="form-row">
        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <i class="prefix far fa-calendar-alt"></i>
    <input type="text" required id="fecha" value="{{ old('fecha') ? old('fecha') : $venta->fecha}}" name="fecha" class="form-control validate" maxlength="50">
    <label for="fecha" data-error="Error" data-success="Correcto">Fecha</label>
</div>
@if ($errors->has('fecha'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('fecha') }}
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
    <i class="prefix far fa-calendar-check"></i>
    <input type="text" id="fecha_fin" value="{{ old('fecha_fin') ? old('fecha_fin') : $venta->fecha_fin}}" name="fecha_fin" class="form-control validate" maxlength="50">
    <label for="fecha" data-error="Error" data-success="Correcto">Fecha fin *</label>
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
    --}}
<!-- Grid row -->

    <a onclick="validar()" class="mt-4 waves-effect btn {{($editar) ? 'btn-warning' : 'btn-success'}} btn-md hoverable">
    <i class="fas fa-2x {{($editar) ? 'fa-pencil-alt' : 'fa-plus'}}"></i> {{($editar) ? 'Editar' : 'Registrar'}}
    </a>
</form>
@endsection
@section('js_links')

<!-- DataTables core JavaScript -->

<script type="text/javascript" src="{{ asset('js/addons/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/bt4-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/responsive-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/bt4-responsive-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/buttons-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/bt4-buttons-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/buttons.html5.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/jszip.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/pdfmake.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/vfs_fonts.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/buttons.print.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/buttons.colVis.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/addons/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/i18n/es.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/addons/bootstrap-material-datetimepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/validation/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/validation/messages_es.js') }}"></script>
<script type="text/javascript">
$(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
function validar(){
  if($("#venta_form").validate({
    lang: 'es',
    errorPlacement: function(error, element){
      $(element).parent().after(error);
		}})){
    $("#venta_form").submit();
  }
  }

   $(document).ready(function() {
 

$('#fecha').bootstrapMaterialDatePicker({

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
}); 
    </script>
@endsection