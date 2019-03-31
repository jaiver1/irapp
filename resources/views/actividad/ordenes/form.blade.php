
@include('include.addons.gmaps.form', array('ubicacion'=>$orden->direccion->ubicacion,'infowindow'=>$orden->cliente->persona->primer_nombre." ".$orden->cliente->persona->segundo_nombre." ".$orden->cliente->persona->primer_apellido." ".$orden->cliente->persona->segundo_apellido))
@include('include.dato_basico.direcciones.form', array('direccion'=>$orden->direccion))

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
<form id="orden_form" method="POST" action="{{ route('ordenes.update', $orden->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="PUT">
    @else
    <form id="orden_form" method="POST" action="{{ route('ordenes.store') }}" accept-charset="UTF-8">
@endif

 {{ csrf_field() }}


    <!-- Grid row -->
    <div class="form-row">


        @if ($editar)

        <!-- Grid column -->
        <div class="col-md-6">
          <!-- Material input -->
          
          <div class="md-form">
          <i class="fas {{($orden->estado == 'Abierta' ) ? 'fa-tools' : (($orden->estado == 'Cerrada' ) ? 'fa-check-circle' : (($orden->estado == 'Cancelada' ) ? 'fa-times-circle' : (($orden->estado == 'Pendiente' ) ? 'fa-stopwatch' : 'fa-asterisk')))}} "></i>
          <small for="estado">Estado *</small>   
        <select class="form-control" required id="estado" name="estado">
        <option value="" disabled selected>Selecciona una opción</option>
        @foreach($estados_ordenes as $key => $estado)
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

<!-- Grid row -->
<div class="form-row">

        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <i class="fas fa-toolbox prefix"></i>
    <input type="text" required id="nombre" value="{{ old('nombre') ? old('nombre') : $orden->nombre}}" name="nombre" class="form-control validate" maxlength="50">
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
<i class="prefix far fa-calendar-alt"></i>
<input type="text" required id="fecha_inicio" value="{{ old('fecha_inicio') ? old('fecha_inicio') : $orden->fecha_inicio}}" name="fecha_inicio" class="form-control validate" maxlength="50">
<label for="fecha_inicio" data-error="Error" data-success="Correcto">Fecha inicio *</label>
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
    <i class="prefix far fa-calendar-check"></i>
    <input type="text" id="fecha_fin" value="{{ old('fecha_fin') ? old('fecha_fin') : $orden->fecha_fin}}" name="fecha_fin" class="form-control validate" maxlength="50">
    <label for="fecha_inicio" data-error="Error" data-success="Correcto">Fecha fin *</label>
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
<div class="form-row">
    <!-- Grid column -->
    <div class="col-md-12">
      <!-- Material input -->
      
      <div class="md-form">
      <i class="fas fa-user-tie"></i>
      <small for="cliente_id">Cliente *</small>   
  <select class="form-control" required id="cliente_id" name="cliente_id">
  <option value="" disabled selected>Selecciona una opción</option>
  @if($editar)
    <option selected value="{{ $orden->cliente->id }}">{{$orden->cliente->persona->primer_nombre}} {{$orden->cliente->persona->segundo_nombre}} {{$orden->cliente->persona->primer_apellido}} {{$orden->cliente->persona->segundo_apellido}}</option>
    @endif
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
  
    </div>
  <!-- Grid row -->
  
  @yield('direccion_form')

  @yield('gmaps_form')

    <a onclick="validar()" class="mt-4 waves-effect btn {{($editar) ? 'btn-warning' : 'btn-success'}} btn-md hoverable">
    <i class="fas fa-2x {{($editar) ? 'fa-pencil-alt' : 'fa-plus'}}"></i> {{($editar) ? 'Editar' : 'Registrar'}}
    </a>
</form>
@include('include.contacto.clientes.modal_search')
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

function validar(){
  if($("#orden_form").validate({
    lang: 'es',
    errorPlacement: function(error, element){
      $(element).parent().after(error);
		}})){
    $("#orden_form").submit();
  }
  }

   $(document).ready(function() {
    var currentdate = new Date(); 
    moment.locale('es');
var datetime =  moment().format('DD MMMM YYYY, h-mm-ss a'); 
    var titulo_archivo = "Lista de clientes ("+datetime+")";
     $('#dtclientes').DataTable( {
        dom: 'Bfrtip',
    lengthMenu: [
        [ 2, 5, 10, 20, 30, 50, 100, -1 ],
        [ '2 registros', '5 registros', '10 registros', '20 registros','30 registros', '50 registros', '100 registros', 'Mostrar todo' ]
    ],oLanguage:{
	sProcessing:     'Procesando...',
	sLengthMenu:     'Mostrar _MENU_ registros',
	sZeroRecords:    'No se encontraron resultados',
	sEmptyTable:     'Ningún dato disponible en esta tabla',
	sInfo:           'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
	sInfoEmpty:      'Mostrando registros del 0 al 0 de un total de 0 registros',
	sInfoFiltered:   '(filtrado de un total de _MAX_ registros)',
	sInfoPostFix:    '',
	sSearch:         'Buscar:',
	sUrl:            '',
	sInfoThousands:  ',',
	sLoadingRecords: 'Cargando...',
	oPaginate: {
		sFirst:    'Primero',
		sLast:     'Último',
		sNext:     'Siguiente',
		sPrevious: 'Anterior'
	},
	oAria: {
		sSortAscending:  ': Activar para ordenar la columna de manera ascendente',
		sSortDescending: ': Activar para ordenar la columna de manera descendente'
	}
},
        buttons: [

            {
                extend: 'collection',
                text:      '<i class="fas fa-2x fa-cog fa-spin"></i>',
                titleAttr: 'Opciones',
                buttons: [
                    {
                extend:    'copyHtml5',
                text:      '<i class="fas fa-copy"></i> Copiar',
                titleAttr: 'Copiar',
                title: titulo_archivo
            },
            {
                extend:    'print',
                text:      '<i class="fas fa-print"></i> Imprimir',
                titleAttr: 'Imprimir',
                title: titulo_archivo
            },
            {
                extend: 'collection',
                text:      '<i class="fas fa-cloud-download-alt"></i> Exportar',
                titleAttr: 'Exportar',
                buttons: [         
            {
                extend:    'csvHtml5',
                text:      '<i class="fas fa-file-csv"></i> Csv',
                titleAttr: 'Csv',
                title: titulo_archivo
            }, 
            {
                extend:    'excelHtml5',
                text:      '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
                title: titulo_archivo
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fas fa-file-pdf"></i> Pdf',
                titleAttr: 'Pdf',
                title: titulo_archivo
            }
        ]
    },
           
            {
                extend:    'colvis',
                text:      '<i class="fas fa-low-vision"></i> Ver/Ocultar',
                titleAttr: 'Ver/Ocultar',
            }
           
                ]
            },
            'pageLength'
        ],   
        responsive: true,
        columnDefs: [ {
    targets: [ 3,5,6,7,8,9,10,11,12 ],
    className: 'none'
  } ,
  { responsivePriority: 13, targets: -1 }
]
    } );


            $('.dataTables_length').addClass('bs-select');
        })


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


$('#cliente_id').on('select2:open', function (e) {
  $('#cliente_id').select2("close");
  $('#modal_search_cliente').modal('show');
});

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

  function seleccionar_cliente(id,nombre,nombre_completo){
    swal({
  title: 'Seleccionar cliente',
  text: '¿Desea seleccionar el cliente "'+nombre+'"?',
  type: 'question',
  confirmButtonText: '<i class="fas fa-check"></i> Seleccionar',
  cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
  showCancelButton: true,
  showCloseButton: true,
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: false,
  animation: false,
  customClass: 'animated zoomIn',
}).then((result) => {
  if (result.value) {
    $( "#cliente_id").html('<option selected value="'+id+'">'+nombre_completo+'</option>');
    $('#infowindow').val(nombre_completo);
    $('#modal_search_cliente').modal('hide');
  }else{
    swal({
  position: 'top-end',
  type: 'error',
  title: 'Operación cancelada por el usuario',
  showConfirmButton: false,
  toast: true,
  animation: false,
  customClass: 'animated lightSpeedIn',
  timer: 3000
})
  }
})
}

    </script>

@yield('gmaps_links')
@endsection