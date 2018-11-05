@extends('layouts.dashboard.main')
@section('template_title')
Información del cliente "{{ $cliente->nombre }}" | {{ config('app.name', 'Laravel') }}
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
                    <span><i class="fa fa-user-tie mr-1"></i></span> <a href="{{ route('clientes.index') }}">Lista de clientes</a>
                        <span>/</span>
                        <span>Información del cliente "{{ $cliente->nombre }}"</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de clientes">
                      <i class="fa fa-2x fa-user-tie"></i>
                            </a>

                             <a href="{{ route('clientes.edit',$cliente->id) }}" class="btn btn-outline-warning btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Editar el cliente "{{ $cliente->nombre }}"'>
                      <i class="fa fa-2x fa-pencil-alt"></i>
                            </a>

                                       <a onclick="eliminar_cliente({{ $cliente->id }},'{{ $cliente->nombre }}')"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar el cliente "{{ $cliente->nombre }}"'>
                      <i class="fa fa-2x fa-trash-alt"></i>
                            </a>
                            <form id="eliminar{{ $cliente->id }}" method="POST" action="{{ route('clientes.destroy',$cliente->id) }}" accept-charset="UTF-8">
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
      <i class="fa fa-user-tie mr-2"></i><strong>Tipo de medida #{{ $cliente->id }}</strong>
    </a>
  <a class="list-group-item waves-effect hoverable"><strong>Nombre: </strong>{{ $cliente->nombre }}</a>
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
                            <h4><i class="fa fa-ruler mr-2"></i>
                            @if ($cliente->medidas->count() === 1)
                Una medida de "{{ $cliente->nombre }}"
            @elseif ($cliente->medidas->count() > 1)
                {{ $cliente->medidas->count() }} medidas de "{{ $cliente->nombre }}"
            @else
               No hay medidas de "{{ $cliente->nombre }}"
            @endif
            </h4>
            <hr/>
                        <div class="table-responsive">
                            <!-- Table  -->
                            <table id="dtmedidas" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
  <thead class="th-color white-text">
    <tr class="z-depth-2">
      <th class="th-sm">#
      </th>
      <th class="th-sm">Nombre
      </th>
      <th class="th-sm">Etiqueta
      </th>
      <th class="th-sm">Tipo de medida
      </th>
      <th class="th-sm">Acciones
      </th>
   
    </tr>
  </thead>
  <tbody>
  @foreach($cliente->medidas as $key => $medida)
    <tr class="hoverable">
      <td>{{$medida->id}}</td>
      <td>{{$medida->nombre}}</td>
      <td>{{$medida->etiqueta}}</td>
      <td><i class="fa fa-user-tie"></i> {{$medida->cliente->nombre}}</td>
      <td>

<a href="{{ route('medidas.show',$medida->id) }}" class="text-primary m-1" 
                    data-toggle="tooltip" data-placement="bottom" title='Información de la medida "{{ $medida->nombre }}"'>
                      <i class="fa fa-2x fa-info-circle"></i>
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
<script type="text/javascript">

function eliminar_cliente(id,nombre){
    swal({
  title: 'Eliminar el cliente',
  text: '¿Desea eliminar el cliente "'+nombre+'"?',
  type: 'question',
  confirmButtonText: '<i class="fa fa-trash-alt"></i> Eliminar',
  cancelButtonText: '<i class="fa fa-times"></i> Cancelar',
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
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$(document).ready(function() {
    var cliente =  "{{$cliente->nombre}}"; 
    var currentdate = new Date(); 
    moment.locale('es');
var datetime =  moment().format('DD MMMM YYYY, h-mm-ss a'); 
    var titulo_archivo = 'Lista de medidas de "'+cliente+'" ('+datetime+')';
     $('#dtmedidas').DataTable( {
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
                text:      '<i class="fa fa-2x fa-cog fa-spin"></i>',
                titleAttr: 'Opciones',
                buttons: [
                    {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-copy"></i> Copiar',
                titleAttr: 'Copiar',
                title: titulo_archivo
            },
            {
                extend:    'print',
                text:      '<i class="fa fa-print"></i> Imprimir',
                titleAttr: 'Imprimir',
                title: titulo_archivo
            },
            {
                extend: 'collection',
                text:      '<i class="fa fa-cloud-download-alt"></i> Exportar',
                titleAttr: 'Exportar',
                buttons: [         
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-alt"></i> Csv',
                titleAttr: 'Csv',
                title: titulo_archivo
            }, 
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
                title: titulo_archivo
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf"></i> Pdf',
                titleAttr: 'Pdf',
                title: titulo_archivo
            }
        ]
    },
           
            {
                extend:    'colvis',
                text:      '<i class="fa fa-low-vision"></i> Ver/Ocultar',
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
                        return '<i class="fa fa-ruler"></i> Datos de medida "'+ data[1]+'"';
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
</script>
@endsection