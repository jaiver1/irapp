@extends('layouts.dashboard.main')
@section('template_title')
Lista de servicios | {{ config('app.name', 'Laravel') }}
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
                    <span><i class="fas fa-cogs fa-lg mr-1"></i></span> <span> @if ($servicios->count() === 1)
                Un servicio
            @elseif ($servicios->count() > 1)
                {{ $servicios->count() }} servicios
            @else
               No hay servicios
            @endif
            </span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('servicios.create') }}" class="btn btn-outline-success btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Registrar un servicio">
                      <i class="fas fa-2x fa-plus"></i>
                            </a>
                            <a href="{{ route('servicios.deleted.index') }}" class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Servicios eliminados">
                      <i class="fas fa-2x fa-recycle"></i>
                            </a>
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
                        <div class="table-responsive">
                            <!-- Table  -->
                            <table id="dtservicios" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
  <thead class="th-color white-text">
    <tr class="z-depth-2">
      <th class="th-sm">#
      </th>
      <th class="th-sm">Nombre
      </th>
      <th class="th-sm">Imagen
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
  @foreach($servicios as $key => $servicio)
    <tr class="hoverable">
      <td>{{$servicio->id}}</td>
      <td>{{$servicio->nombre}}</td>  
      <td>
        <center>
            <div class="cursor-zoom view overlay hoverable zoom img-border" onclick="mostrar_modal('{{ route("servicios.loadImagenes",$servicio->id) }}','img')">
                @if($servicio->imagenes->count())
                                    <img src="{{ asset($servicio->imagenes->first()->ruta)  }}" class="img-zoom img-fluid rounded img-thumbnail" alt="{{ $servicio->imagenes->first()->nombre  }}" onerror=this.src="{{ asset('img/dashboard/servicios/404.png')  }}">
                                    @else
                                    <img src="{{ asset('img/dashboard/servicios/404.png')  }}" class="img-zoom img-fluid rounded img-thumbnail" alt="404">
                                    @endif
                                  </div>

                </center>
           
      </td>
      <td> <h5><span class="badge badge-success hoverable">
            @money($servicio->valor_unitario)
            </span>
            </h5>
          </td>
        <td>{{$servicio->descripcion}}</td>
        <td>
        <a href="{{ route('categorias.show',$servicio->categoria->id) }}" class="link-text"
                      data-toggle="tooltip" data-placement="bottom" title='Información de la categoria "{{ $servicio->categoria->nombre }}"'>
                        <i class="fas fa-sitemap"></i> {{$servicio->categoria->nombre}}
                              </a>    
                          </td>
  
              <td>
                  <a href="{{ route('medidas.show',$servicio->medida->id) }}" class="link-text"
                      data-toggle="tooltip" data-placement="bottom" title='Información de la medida "{{ $servicio->medida->nombre }}"'>
                        <i class="fas fa-ruler"></i> {{$servicio->medida->nombre}}
                              </a> 
              </td>
      <td>

<a href="{{ route('servicios.show', $servicio->id) }}" class="text-primary m-1" 
                    data-toggle="tooltip" data-placement="bottom" title='Información del servicio "{{ $servicio->nombre }}"'>
                      <i class="fas fa-2x fa-info-circle"></i>
                            </a>

      <a href="{{ route('servicios.edit', $servicio->id) }}" class="text-warning m-1" 
                    data-toggle="tooltip" data-placement="bottom" title='Editar el servicio "{{ $servicio->nombre }}"'>
                      <i class="fas fa-2x fa-pencil-alt"></i>
                            </a>

                            <a onclick="eliminar_servicio({{ $servicio->id }},'{{ $servicio->nombre }}')" class="text-danger m-1" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar el servicio "{{ $servicio->nombre }}"'>
                      <i class="fas fa-2x fa-trash-alt"></i>
                            </a>
                            <form id="eliminar{{ $servicio->id }}" method="POST" action="{{ route('servicios.destroy', $servicio->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="DELETE">
    {{ csrf_field() }}
</form>
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
        <div id="container_img">
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
<script type="text/javascript" src="{{ asset('js/irapp.js') }}"></script>
<script type="text/javascript">

function eliminar_servicio(id,nombre){
    swal({
  title: 'Eliminar el servicio',
  text: '¿Desea eliminar el servicio "'+nombre+'"?',
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

  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
$(document).ready(function() {
    var currentdate = new Date(); 
    moment.locale('es');
var datetime =  moment().format('DD MMMM YYYY, h-mm-ss a'); 
    var titulo_archivo = "Lista de servicios ("+datetime+")";
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
</script>

@yield('js_links')
@endsection