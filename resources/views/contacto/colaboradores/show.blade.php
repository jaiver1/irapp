@extends('layouts.dashboard.main')
@section('template_title')
Información del colaborador "{{$colaborador->persona->primer_nombre}} {{$colaborador->persona->primer_apellido}}" | {{ config('app.name', 'Laravel') }}
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
                    <span><i class="fas fa-user-tie mr-1 fa-lg"></i></span>
                        <a href="{{ route('colaboradores.index') }}">Lista de colaboradores</a>
                        <span>/</span>
                        <span>Información del colaborador "{{$colaborador->persona->primer_nombre}} {{$colaborador->persona->primer_apellido}}"</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('colaboradores.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de colaboradores">
                      <i class="fas fa-2x fa-user-tie"></i>
                            </a>

                             <a href="{{ route('colaboradores.edit', $colaborador->id) }}" class="btn btn-outline-warning btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Editar el colaborador "{{ $colaborador->nombre }}"'>
                      <i class="fas fa-2x fa-pencil-alt"></i>
                            </a>

                                    <a onclick="eliminar_colaborador({{ $colaborador->id }},'{{ $colaborador->nombre }}')"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar el colaborador "{{ $colaborador->nombre }}"'>
                      <i class="fas fa-2x fa-trash-alt"></i>
                            </a>
                            <form id="eliminar{{ $colaborador->id }}" method="POST" action="{{ route('colaboradores.destroy', $colaborador->id) }}" accept-charset="UTF-8">
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
      <i class="fas fa-user-tie  mr-2"></i><strong>Colaborador #{{ $colaborador->id }}</strong>
    </a>
    <a class="list-group-item waves-effect hoverable"><strong>Cedula: </strong>{{ $colaborador->persona->cedula }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Primer nombre: </strong>{{ $colaborador->persona->primer_nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Segundo nombre: </strong>{{ $colaborador->persona->segundo_nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Primer apellido: </strong>{{ $colaborador->persona->primer_apellido }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Segundo apellido: </strong>{{ $colaborador->persona->segundo_apellido }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Telefono movil: </strong>{{ $colaborador->persona->telefono_movil }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Telefono fijo: </strong>{{ $colaborador->persona->telefono_fijo }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Ciudad: </strong>{{ $colaborador->persona->ciudad->nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Barrio: </strong>{{ $colaborador->persona->barrio }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Direccion: </strong>{{ $colaborador->persona->direccion }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Cuenta banco: </strong>{{ $colaborador->persona->cuenta_banco }}</a>
  <a href ="{{ route('usuarios.show' , $colaborador->persona->usuario->id) }}" class="list-group-item waves-effect hoverable item-link"><strong><i class="fas fa-user mr-2"></i>Usuario: </strong>{{ $colaborador->persona->usuario->name }}</a>

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
                                @if ($colaborador->servicios->count() === 1)
                    Un servicio de "{{$colaborador->persona->primer_nombre}} {{$colaborador->persona->primer_apellido}}"
                @elseif ($colaborador->servicios->count() > 1)
                    {{ $colaborador->servicios->count() }} servicios de "{{$colaborador->persona->primer_nombre}} {{$colaborador->persona->primer_apellido}}"
                @else
                   No hay servicios de "{{$colaborador->persona->primer_nombre}} {{$colaborador->persona->primer_apellido}}"
                @endif
                </h4>
                <div class="d-flex justify-content-center">
                  <a data-toggle="modal" data-target="#modal_search_servicio" href="#" class="btn btn-outline-success btn-circle waves-effect hoverable" 
                  data-toggle="tooltip" data-placement="bottom" title="Registrar un servicio">
                    <i class="fas fa-2x fa-plus"></i>
                          </a>                     
                  </div>
                </div>
                <hr/>
                            <div class="table-responsive">
                                <!-- Table  -->
                            <table id="dtservicios" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
                              <thead class="th-color white-text">
                                <tr class="z-depth-2">
                                  <th class="th-sm">#
                                  </th>
                                  <th class="th-sm">Nombre
                                  </th>
                                  <th class="th-sm">Valor unitario
                                    </th>
                                    <th class="th-sm">Descripcion
                                  </th>
                                  <th class="th-sm">Categoria
                                  </th>
                                  <th class="th-sm">Medida
                                  </th>
                                  <th class="th-sm">Acciones
                                  </th>
                               
                                </tr>
                              </thead>
                              <tbody>
                              @foreach($colaborador->servicios as $key => $servicio)
                                <tr class="hoverable">
                                  <td>{{$servicio->id}}</td>
                                  <td>{{$servicio->nombre}}</td>  
                                  <td> <h5><span class="badge badge-success hoverable">
                                        @money($servicio->valor_unitario)
                                        </span>
                                        </h5>
                                      </td>
                                    <td>{{$servicio->descripcion}}</td>
                                    
                                  <td>
                            
                            <a href="{{ route('servicios.show', $servicio->id) }}" class="text-primary m-1" 
                                                data-toggle="tooltip" data-placement="bottom" title='Información del servicio "{{ $servicio->nombre }}"'>
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
          
        </div>
        @include('include.actividad.servicios.modal_search')
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
function eliminar_colaborador(id,nombre){
    swal({
  title: 'Eliminar el colaborador',
  text: '¿Desea eliminar el colaborador "'+nombre+'"?',
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
    var colaborador =  "{{$colaborador->persona->primer_nombre}}"; 
    var currentdate = new Date(); 
    moment.locale('es');
var datetime =  moment().format('DD MMMM YYYY, h-mm-ss a'); 
    var titulo_archivo = 'Lista de servicios de "'+colaborador+'" ('+datetime+')';
     $('#dtservicios').DataTable( {
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
                        return '<i class="fas fa-sitemap"></i>  Datos de la servicio "'+ data[1]+'"';
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