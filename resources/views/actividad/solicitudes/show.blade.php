@extends('layouts.dashboard.main')
@section('template_title')
Información de la solicitud "{{ $solicitud->nombre }}" | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('css/addons/bootstrap-material-datetimepicker.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('css/addons/datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-responsive-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-buttons-datatables.min.css') }}" type="text/css">
@endsection
@section('content')
        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fas fa-business-time mr-1"></i></span>
                    @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE))
                        <a href="{{ route('solicitudes.index',array('Pendiente')) }}">Lista de solicitudes</a>
                        <span>/</span>
                        @elseif(Auth::user()->authorizeRoles('ROLE_CLIENTE',FALSE))
                        <a href="{{ route('home',array('Pendiente')) }}">Página principal</a>
                        <span>/</span>
                        @endif

                        <span>Información de la solicitud "{{ $solicitud->nombre }}"</span>
                    </h4>
                    <div class="d-flex justify-content-center">
                    @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE))
                    

                                    <a onclick="aprobar_solicitud({{ $solicitud->id }},'{{ $solicitud->nombre }}')"  class="btn btn-outline-success btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Aprobar la solicitud "{{ $solicitud->nombre }}"'>
                      <i class="far fa-2x fa-calendar-check"></i>
                            </a>
                            <form id="aprobar{{ $solicitud->id }}" method="POST" action="{{ route('solicitudes.approve', $solicitud->id) }}" accept-charset="UTF-8">
    {{ csrf_field() }}
</form>

<a onclick="cancelar_solicitud({{ $solicitud->id }},'{{ $solicitud->nombre }}')"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
  data-toggle="tooltip" data-placement="bottom" title='Cancelar la solicitud "{{ $solicitud->nombre }}"'>
    <i class="far fa-2x fa-calendar-times"></i>
          </a>
          <form id="cancelar{{ $solicitud->id }}" method="POST" action="{{ route('solicitudes.cancel', $solicitud->id) }}" accept-charset="UTF-8">
<input name="_method" type="hidden" value="PUT">
{{ csrf_field() }}
</form>
                    
@endif
</div>
                </div>

            </div>
            <!-- Heading -->

         
            <!--Grid row-->
            <div class="row">

                <!--Grid column-->
                <div class="col-12">

                    <!--Card-->
                    <div class="card hoverable">

                        <!--Card content-->
                        <div class="card-body">

<div class="list-group hoverable">
  <a class="list-group-item active z-depth-2 white-text waves-light hoverable">
      <i class="fas fa-business-time  mr-2"></i><strong>Orden #{{ $solicitud->id }}</strong>
    </a>
  <a class="list-group-item waves-effect hoverable"><strong>Nombre: </strong>{{ $solicitud->nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Estado: </strong>
    <span class="h5"><span class="hoverable badge
@switch($solicitud->estado)
    @case('Abierta')
        teal darken-1
    @break
    @case('Cancelada')
        red darken-3
    @break
    @default
        amber darken-3
    @endswitch
        ">
        <i class="mr-1 fas
        @switch($solicitud->estado)
    @case('Abierta')
        fa-calendar-check 
    @break
    @case('Cancelada')
        fa-calendar-times  
    @break
    @default
        fa-stopwatch 
    @endswitch
        "></i>{{ ($solicitud->estado == "Abierta") ? "Aprobado" : $solicitud->estado }}</span></span>
</a>
  <a class="list-group-item waves-effect hoverable">  
    <strong>Fecha: </strong>
    <span class="h5"><span class="badge blue darken-3 hoverable"><i class="far fa-calendar-alt mr-1"></i>{{ Carbon\Carbon::parse($solicitud->fecha_inicio)->format('d/m/Y -:- h:i A') }}</span></span>
</a>
  <a class="list-group-item waves-effect hoverable"><strong>Cliente: </strong>{{$solicitud->cliente->persona->primer_nombre}} {{$solicitud->cliente->persona->segundo_nombre}} {{$solicitud->cliente->persona->primer_apellido}} {{$solicitud->cliente->persona->segundo_apellido}}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Ciudad: </strong>{{ $solicitud->direccion->ciudad->nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Barrio: </strong>{{ $solicitud->direccion->barrio }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Direccion: </strong>{{ $solicitud->direccion->direccion }}</a>
</div>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

               <!--Grid row-->
               <div class="row mt-5">

                <!--Grid column-->
                <div class="col-12">

                    <!--Card-->
                    <div class="card hoverable"> 
                        <!--Card content-->
                          <div class="card-body">
                            <div class="d-sm-flex justify-content-between">
                              <h4><i class="fas fa-tasks mr-2"></i>
                              @if ($solicitud->detalles->count() === 1)
                          Un detalle de "{{$solicitud->nombre}}"
                          @elseif ($solicitud->detalles->count() > 1)
                          {{ $solicitud->detalles->count() }} detalles de "{{$solicitud->nombre}}"
                          @else
                          No hay detalles de "{{$solicitud->nombre}}"
                          @endif
                          </h4>
                          </div>
                          <hr/>
                          <div class="table-responsive">
                              <!-- Table  -->
                          <table id="dtdetalles_solicitudes" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
                                  <thead class="th-color white-text">
                                          <tr class="z-depth-2">
                                            <th class="th-sm">#
                                            </th>
                                            <th class="th-sm">Nombre
                                            </th>
                                       
                                            <th class="th-sm">Estado
                                          </th>

                                          <th class="th-sm">Fecha
                                          </th>
                          
                                          <th class="th-sm">Servicio
                                          </th>
                          
                                          <th class="th-sm">Colaborador
                                          </th>
                          
                                          <th class="th-sm">Valor unitario
                                          </th>
                          
                                          <th class="th-sm">Cantidad
                                          </th>
                          
                                          <th class="th-sm">Total
                                          </th>
                                          @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE))
                                            <th class="th-sm">Acciones
                                            </th>
                                         @endif
                                          </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($solicitud->detalles as $key => $detalle)
                                          <tr class="hoverable">
                                            <td>{{$detalle->id}}</td>
                                            <td>{{$detalle->nombre}}</td>
                                            @if(Auth::user()->authorizeRoles('ROLE_CLIENTE',FALSE))
                                            <td> 
                                              <span class="h5"><span class="hoverable badge
                                                @switch($detalle->estado)
                                                    @case('Abierta')
                                                        blue darken-3
                                                    @break
                                                    @case('Cerrada')
                                                        teal darken-3
                                                    @break
                                                    @case('Cancelada')
                                                        red darken-3 
                                                    @break
                                                    @default
                                                        amber darken-3
                                                    @endswitch
                                                        ">
                                                        <i class="mr-1 fas
                                                        @switch($detalle->estado)
                                                    @case('Abierta')
                                                        fa-business-time
                                                    @break
                                                    @case('Cerrada')
                                                        fa-flag-checkered  
                                                    @break
                                                    @case('Cancelada')
                                                        fa-times  
                                                    @break
                                                    @default
                                                        fa-stopwatch 
                                                    @endswitch
                                                        "></i>{{ $detalle->estado }}</span></span>
                                           </td> 
                                           @endif
                                          <td> 
                                              @if($detalle->fecha_fin &&  $detalle->estado == "Cerrada")
                                                  <br/>
                                                  @endif
                                             <span class="h5"><span class="badge blue darken-3 hoverable"><i class="far fa-calendar-alt mr-1"></i>{{ Carbon\Carbon::parse($detalle->fecha_inicio)->format('d/m/Y -:- h:i A') }}</span></span>
                                            @if($detalle->fecha_fin &&  $detalle->estado == "Cerrada")
                                               <br/> <span class="h5"><span class="badge teal darken-3 hoverable"><i class="far fa-calendar-check mr-1"></i>{{ Carbon\Carbon::parse($detalle->fecha_fin)->format('d/m/Y -:- h:i A') }}</span></span>
                                            @endif
                                          </td> 
                          
                                          <td>{{$detalle->servicio->nombre}}</td> 
                          
                                          <td>@if($detalle->colaborador)
                                            {{$detalle->colaborador->persona->primer_nombre}} {{$detalle->colaborador->persona->segundo_nombre}}</td> 
                                          @else
                                          <span class="h5"> <span class="hoverable badge black">
                                              <i class="mr-1 fas fa-user-times"></i>Colaborador no asignado 
                                        </span> </span>
                                          @endif
                                          <td> <h5><span class="badge badge-success hoverable">
                                              @money($detalle->valor_unitario)
                                              </span>
                                              </h5>
                                            </td>
                          
                                            <td> <h5><span class="badge badge-secondary hoverable">
                                              @cantidad($detalle->cantidad) {{$detalle->servicio->medida->nombre}}
                                              </span>
                                              </h5>
                                            </td>
                          
                                            <td> <h5><span class="badge teal hoverable">
                                              @money($detalle->valor_unitario * $detalle->cantidad)
                                              </span>
                                              </h5>
                                            </td>
                                          
                          
                                              @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE))
                                              <td>
                                                        </td>
                                                        @endif
                                          </tr>
                                          @endforeach
                                        </tbody>
                          </table>
                                                      <!-- Table  -->
                              </div>
                              </div>
                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->
          
        </div>
     
@endsection
@section('js_links')

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

<script type="text/javascript" src="{{ asset('js/addons/i18n/es.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/irapp.js') }}"></script>

<script type="text/javascript">
 $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
$(document).ready(function() {
        var es_cliente =  "{{Auth::user()->authorizeRoles('ROLE_CLIENTE',FALSE)}}"; 
if(!es_cliente){
var array_responsive = [ 1,3,4,5,6,7,8 ];
var id_priority = 8;
}else{
var array_responsive = [ 2,3,4,5,6,7 ];
var id_priority = 7;
}
        
    var solicitud =  "{{$solicitud->nombre}}"; 
    var currentdate = new Date(); 
    moment.locale('es');
var datetime =  moment().format('DD MMMM YYYY, h-mm-ss a'); 
    var titulo_archivo = 'Lista de detalles de "'+solicitud+'" ('+datetime+')';
     $('#dtdetalles_solicitudes').DataTable( {
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
                text:      '<i class="fas fa-file-alt"></i> Csv',
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
    targets: array_responsive,
    className: 'none'
  } ,
  { responsivePriority: id_priority, targets: -1 }
]
    } );


            $('.dataTables_length').addClass('bs-select');
        });



function cancelar_solicitud(id,nombre){
    swal({
  title: 'Cancelar la solicitud',
  text: '¿Desea cancelar la solicitud "'+nombre+'"?',
  type: 'error',
  confirmButtonText: '<i class="fas fa-check"></i> Si',
  cancelButtonText: '<i class="fas fa-times"></i> No',
  showCancelButton: true,
  showCloseButton: true,
  confirmButtonClass: 'btn btn-danger',
  cancelButtonClass: 'btn btn-secondary',
  buttonsStyling: false,
  animation: false,
  customClass: 'animated zoomIn',
}).then((result) => {
  if (result.value) {
    $( "#cancelar"+id ).submit();
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

function aprobar_solicitud(id,nombre){
    swal({
  title: 'Aprobar la solicitud',
  text: '¿Desea aprobar la solicitud "'+nombre+'"?',
  type: 'success',
  confirmButtonText: '<i class="fas fa-check"></i> Si',
  cancelButtonText: '<i class="fas fa-times"></i> No',
  showCancelButton: true,
  showCloseButton: true,
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-secondary',
  buttonsStyling: false,
  animation: false,
  customClass: 'animated zoomIn',
}).then((result) => {
  if (result.value) {
    $( "#aprobar"+id ).submit();
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
@endsection