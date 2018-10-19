@extends('layouts.dashboard.main')
@section('template_title')
Información de la especialidad "{{ $especialidad->nombre }}" | {{ config('app.name', 'Laravel') }}
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
                    <span><i class="fa fa-object-group mr-1"></i></span>
                        <a href="{{ route('especialidades.index') }}">Lista de especialidades</a>
                        <span>/</span>
                        <span>Información de la especialidad "{{ $especialidad->nombre }}"</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('especialidades.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de especialidades">
                      <i class="fa fa-2x fa-object-group"></i>
                            </a>

                             <a href="{{ route('especialidades.edit', $especialidad->id) }}" class="btn btn-outline-warning btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Editar la especialidad "{{ $especialidad->nombre }}"'>
                      <i class="fa fa-2x fa-pencil-alt"></i>
                            </a>

                                    <a onclick="eliminar_especialidad({{ $especialidad->id }},'{{ $especialidad->nombre }}')"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar la especialidad "{{ $especialidad->nombre }}"'>
                      <i class="fa fa-2x fa-trash-alt"></i>
                            </a>
                            <form id="eliminar{{ $especialidad->id }}" method="POST" action="{{ route('especialidades.destroy', $especialidad->id) }}" accept-charset="UTF-8">
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
      <i class="fa fa-object-group  mr-2"></i><strong>Especialidad #{{ $especialidad->id }}</strong>
    </a>
  <a class="list-group-item waves-effect hoverable"><strong><i class="fa mr-4"></i>Nombre: </strong>{{ $especialidad->nombre }}</a>
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
                              <h4><i class="fa fa-sitemap mr-2"></i>
                              @if ($especialidad->categorias->count() === 1)
                  Una categoria de "{{ $especialidad->nombre }}"
              @elseif ($especialidad->categorias->count() > 1)
                  {{ $especialidad->categorias->count() }} categorias de "{{ $especialidad->nombre }}"
              @else
                 No hay categorias de "{{ $especialidad->nombre }}"
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
        <th class="th-sm">Especialidad
        </th>
        <th class="th-sm">Categoria padre
        </th>
        <th class="th-sm">Acciones
        </th>
     
      </tr>
    </thead>
    <tbody>
    @foreach($especialidad->categorias as $key => $categoria)
      <tr class="hoverable">
        <td>{{$categoria->id}}</td>
        <td>{{$categoria->nombre}}</td>
        <td><i class="fa fa-object-group"></i> {{$categoria->especialidad->nombre}}</td>
        <td>
          @if($categoria->categoria == NULL)
         <h5> <span class="badge badge-secondary"><i class="fa fa-sitemap"></i> Categoria raiz</span><h5>
          @else
              <a href="{{ route('categorias.show',$categoria->categoria->id) }}" class="link-text"
                            data-toggle="tooltip" data-placement="bottom" title='Información de la categoria padre "{{ $categoria->categoria->nombre }}"'>
                              <i class="fa fa-sitemap"></i> {{$categoria->categoria->nombre}}
                                    </a>    
          @endif
      </td>
      <td>

        <a href="{{ route('categorias.show',$categoria->id) }}" class="text-primary m-1" 
                            data-toggle="tooltip" data-placement="bottom" title='Información de la categoria "{{ $categoria->nombre }}"'>
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
<script type="text/javascript" src="{{ asset('js/addons/moment.js') }}"></script>
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
function eliminar_especialidad(id,nombre){
    swal({
  title: 'Eliminar la especialidad',
  text: '¿Desea eliminar la especialidad "'+nombre+'"?',
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

$(document).ready(function() {
    var especialidad =  "{{$especialidad->nombre}}"; 
    var currentdate = new Date(); 
    moment.locale('es');
var datetime =  moment().format('DD MMMM YYYY, h-mm-ss a'); 
    var titulo_archivo = 'Lista de categorias de "'+especialidad+'" ('+datetime+')';
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
                        return '<i class="fa fa-sitemap"></i>  Datos de la categoria "'+ data[1]+'"';
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