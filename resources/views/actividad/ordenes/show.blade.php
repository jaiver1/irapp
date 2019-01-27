@extends('layouts.dashboard.main')
@section('template_title')
Información de la orden "{{ $orden->nombre }}" | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-responsive-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-buttons-datatables.min.css') }}" type="text/css">
@endsection
@section('content')
        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fas fa-business-time mr-1"></i></span>
                        <a href="{{ route('ordenes.index') }}">Lista de ordenes</a>
                        <span>/</span>
                        <span>Información del orden "{{ $orden->nombre }}"</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('ordenes.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de ordenes">
                      <i class="fas fa-2x fa-business-time"></i>
                            </a>

                             <a href="{{ route('ordenes.edit', $orden->id) }}" class="btn btn-outline-warning btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Editar la orden "{{ $orden->nombre }}"'>
                      <i class="fas fa-2x fa-pencil-alt"></i>
                            </a>

                                    <a onclick="eliminar_orden({{ $orden->id }},'{{ $orden->nombre }}')"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar la orden "{{ $orden->nombre }}"'>
                      <i class="fas fa-2x fa-trash-alt"></i>
                            </a>
                            <form id="eliminar{{ $orden->id }}" method="POST" action="{{ route('ordenes.destroy', $orden->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="DELETE">
    {{ csrf_field() }}
</form>
                    </div>

                </div>

            </div>
            <!-- Heading -->

         
            <!--Grid row-->
            <div class="row wow fadeIn">

                <!--Grid column-->
                <div class="col-12">

                    <!--Card-->
                    <div class="card wow fadeIn hoverable">

                        <!--Card content-->
                        <div class="card-body">

<div class="list-group hoverable">
  <a class="list-group-item active z-depth-2 white-text waves-light hoverable">
      <i class="fas fa-business-time  mr-2"></i><strong>Orden #{{ $orden->id }}</strong>
    </a>
  <a class="list-group-item waves-effect hoverable"><strong>Nombre: </strong>{{ $orden->nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Estado: </strong>
    <span class="h5"><span class="hoverable badge
@switch($orden->estado)
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
        @switch($orden->estado)
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
        "></i>{{ $orden->estado }}</span></span>
</a>
  <a class="list-group-item waves-effect hoverable">
    <strong>Fecha:&nbsp;</strong>
    <span class="h5"><span class="badge blue darken-3 hoverable"><i class="far fa-calendar-alt mr-1"></i>{{ Carbon\Carbon::parse($orden->fecha_inicio)->format('d/m/Y -:- h:i A') }}</span></span>
@if($orden->fecha_fin &&  $orden->estado == "Cerrada")
<br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<span class="h5"><span class="badge teal darken-3 hoverable"><i class="far fa-calendar-check mr-1"></i>{{ Carbon\Carbon::parse($orden->fecha_fin)->format('d/m/Y -:- h:i A') }}</span></span>
@endif
</a>
  <a class="list-group-item waves-effect hoverable"><strong>Cliente: </strong>{{$orden->cliente->persona->primer_nombre}} {{$orden->cliente->persona->segundo_nombre}} {{$orden->cliente->persona->primer_apellido}} {{$orden->cliente->persona->segundo_apellido}}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Ciudad: </strong>{{ $orden->ciudad->nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Barrio: </strong>{{ $orden->barrio }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Direccion: </strong>{{ $orden->direccion }}</a>
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
                              <h4><i class="fas fa-tasks mr-2"></i>
                              @if ($orden->detalles->count() === 1)
                  Un detalle de "{{ $orden->nombre }}"
              @elseif ($orden->detalles->count() > 1)
                  {{ $orden->detalles->count() }} detalles de "{{ $orden->nombre }}"
              @else
                 No hay detalles de "{{ $orden->nombre }}"
              @endif
              </h4>
              <hr/>
                          <div class="table-responsive">
                              <!-- Table  -->
                              <table id="dtcategorias" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
    <thead class="th-color white-text">
      <tr class="z-depth-2">
        <th class="th-sm">#
        </th>
        <th class="th-sm">Nombre
        </th>
        <th class="th-sm">Orden
        </th>
        <th class="th-sm">Categoria padre
        </th>
        <th class="th-sm">Acciones
        </th>
     
      </tr>
    </thead>
    <tbody>
    @foreach($orden->detalles as $key => $detalle)
      <tr class="hoverable">
        <td>{{$detalle->id}}</td>
        <td>{{$detalle->nombre}}</td>
        <td><i class="fas fa-business-time"></i> {{$detalle->orden->nombre}}</td>
        <td>
          @if($detalle->detalle == NULL)
         <h5> <span class="badge badge-secondary"><i class="fas fa-tasks"></i> Categoria raiz</span><h5>
          @else
              <a href="{{ route('detalles.show',$detalle->detalle->id) }}" class="link-text"
                            data-toggle="tooltip" data-placement="bottom" title='Información del detalle padre "{{ $detalle->detalle->nombre }}"'>
                              <i class="fas fa-tasks"></i> {{$detalle->detalle->nombre}}
                                    </a>    
          @endif
      </td>
      <td>

        <a href="{{ route('detalles.show',$detalle->id) }}" class="text-primary m-1" 
                            data-toggle="tooltip" data-placement="bottom" title='Información del detalle "{{ $detalle->nombre }}"'>
                              <i class="fas fa-2x fa-info-circle"></i>
                                    </a>
              </td>
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

              <!--Grid row-->
              <div class="row mt-5">

                <!--Grid column-->
                <div class="col-12">

                    <!--Card-->
                    <div class="card hoverable"> 
                        <!--Card content-->
                        <div class="card-body">
                            <h4><i class="far fa-calendar-plus mr-2"></i> Agregar detalle</h4>
            <hr/>
            <form method="POST" action="{{ route('ordenes.store') }}" accept-charset="UTF-8">
                    
                    
                     {{ csrf_field() }}
                    
                    
                        <!-- Grid row -->
                        <div class="form-row">
                    
                    
                          
                    
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
                          
                                    </div>
                                <!-- Grid row -->
                    
                    <!-- Grid row -->
                    <div class="form-row">
                    
                            <!-- Grid column -->
                            <div class="col-md-6">
                                <!-- Material input -->
                                <div class="md-form">
                        <i class="fas fa-business-time prefix"></i>
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
                        <div class="col-md-6">
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
                      
                     
                
                    
                        <button type="submit" class="mt-4 waves-effect btn btn-success btn-md hoverable">
                        <i class="fas fa-2x fa-plus"></i> Registrar
                        </button>
                    </form>
                    @include('include.contacto.clientes.modal_search')
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
<script type="text/javascript">
function eliminar_orden(id,nombre){
    swal({
  title: 'Eliminar la orden',
  text: '¿Desea eliminar la orden "'+nombre+'"?',
  type: 'question',
  confirmButtonText: '<i class="fas fa-trash-alt"></i> Eliminar',
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
    $( "#eliminar"+id ).submit();
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

$(document).ready(function() {
    var orden =  "{{$orden->nombre}}"; 
    var currentdate = new Date(); 
    moment.locale('es');
var datetime =  moment().format('DD MMMM YYYY, h-mm-ss a'); 
    var titulo_archivo = 'Lista de detalles de "'+orden+'" ('+datetime+')';
     $('#dtcategorias').DataTable( {
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
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return '<i class="fas fa-tasks"></i>  Datos del detalle "'+ data[1]+'"';
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'
                } )
            }
        }
    } );


            $('.dataTables_length').addClass('bs-select');
        });

$(document).ready(function() {
    var currentdate = new Date(); 
    moment.locale('es');
var datetime =  moment().format('DD MMMM YYYY, h-mm-ss a'); 
    var titulo_archivo = "Lista de servicios ("+datetime+")";
     $('#dtservicios_modal').DataTable( {
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
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return '<i class="fas fa-cogs fa-lg"></i> Datos del servicio "'+ data[1]+'"';
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'
                } )
            }
        }
    } );


            $('.dataTables_length').addClass('bs-select');
        });


  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
@endsection