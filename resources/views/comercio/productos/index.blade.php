@extends('layouts.dashboard.main')
@section('template_title')
Lista de productos | {{ config('app.name', 'Laravel') }}
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
                    <span><i class="fa fa-boxes mr-1"></i></span> <span> @if ($productos->count() === 1)
                Un producto
            @elseif ($productos->count() > 1)
                {{ $productos->count() }} productos
            @else
               No hay productos
            @endif
            </span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('productos.create') }}" class="btn btn-outline-success btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Registrar un producto">
                      <i class="fa fa-2x fa-plus"></i>
                            </a>
                            <a href="{{ route('productos.deleted.index') }}" class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Categorias eliminadas">
                      <i class="fa fa-2x fa-recycle"></i>
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
                            <table id="dtproductos" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
  <thead class="th-color white-text">
    <tr class="z-depth-2">
      <th class="th-sm">#
      </th>
      <th class="th-sm">Nombre
      </th>
      <th class="th-sm">Referencia
    </th>
    <th class="th-sm">Imagen
        </th>
      <th class="th-sm">Valor
      </th>
      <th class="th-sm">Descripcion
    </th>
    <th class="th-sm">Categoria
    </th>
    <th class="th-sm">Medida
    </th>
      <th class="th-sm">Marca
      </th>
      <th class="th-sm">Acciones
      </th>
   
    </tr>
  </thead>
  <tbody>
  @foreach($productos as $key => $producto)
    <tr class="hoverable">
      <td>{{ $producto->id }}</td>
      <td>{{ $producto->nombre }}
    </td>
    <td>
            <center>
                    <div onclick="mostrar_modal('{{ route("productos.info",$producto->id) }}','ref')" class="cursor-zoom view overlay hoverable zoom img-border">
                        @if($producto->tipo_referencia->dimension == "1D")
                                            <img src="{{ asset(DNS1D::getBarcodePNGPath($producto->referencia, $producto->tipo_referencia->nombre)) }}" class="img-zoom img-fluid rounded img-thumbnail" alt="{{ $producto->referencia }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
                                            @elseif($producto->tipo_referencia->dimension == "2D")
                                            <img src="{{ asset(DNS2D::getBarcodePNGPath($producto->referencia, $producto->tipo_referencia->nombre)) }}" class="img-zoom img-fluid rounded img-thumbnail" alt="{{ $producto->referencia }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
                                            @endif
                                          </div>
                                      
                                            <h5><span class="mt-2 badge badge-secondary hoverable"><i class="fa fa-box-open mr-1"></i>{{ $producto->referencia }}</span><h5>
                        </center>
        
    </td>
      <td>
            <center>
                    <div class="view overlay hoverable zoom img-border">
                        @if($producto->tipo_referencia->dimension == "1D")
                                            <img  data-toggle="modal" data-target="#img{{$producto->id}}" src="{{ DNS1D::getBarcodePNGPath($producto->referencia, $producto->tipo_referencia->nombre) }}" class="img-zoom img-fluid rounded img-thumbnail" alt="{{ $producto->referencia }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
                                            @elseif($producto->tipo_referencia->dimension == "2D")
                                            <img data-toggle="modal" data-target="#img{{$producto->id}}" src="{{ DNS2D::getBarcodePNGPath($producto->referencia, $producto->tipo_referencia->nombre) }}" class="img-zoom img-fluid rounded img-thumbnail" alt="{{ $producto->referencia }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
                                            @endif
                                          </div>
                                          
                        </center>
           
      </td>
      <td>{{$producto->valor}}</td>
      <td>{{$producto->descripcion}}</td>
      <td>
      <a href="{{ route('categorias.show',$producto->categoria->id) }}" class="link-text"
                    data-toggle="tooltip" data-placement="bottom" title='Información de la categoria "{{ $producto->categoria->nombre }}"'>
                      <i class="fa fa-sitemap"></i> {{$producto->categoria->nombre}}
                            </a>    
                        </td>

            <td>
                <a href="{{ route('medidas.show',$producto->medida->id) }}" class="link-text"
                    data-toggle="tooltip" data-placement="bottom" title='Información de la medida "{{ $producto->medida->nombre }}"'>
                      <i class="fa fa-ruler"></i> {{$producto->medida->nombre}}
                            </a> 
            </td>

            <td>
                <a href="{{ route('marcas.show',$producto->marca->id) }}" class="link-text"
                    data-toggle="tooltip" data-placement="bottom" title='Información de la marca "{{ $producto->marca->nombre }}"'>
                      <i class="fa fa-trademark"></i> {{$producto->marca->nombre}}
                            </a> 
            </td>

            
                    <td>

<a href="{{ route('productos.show',$producto->id) }}" class="text-primary m-1" 
                    data-toggle="tooltip" data-placement="bottom" title='Información del producto "{{ $producto->nombre }}"'>
                      <i class="fa fa-2x fa-info-circle"></i>
                            </a>

      <a href="{{ route('productos.edit',$producto->id) }}" class="text-warning m-1" 
                    data-toggle="tooltip" data-placement="bottom" title='Editar el producto "{{ $producto->nombre }}"'>
                      <i class="fa fa-2x fa-pencil-alt"></i>
                            </a>

                            <a onclick="eliminar_producto({{ $producto->id }},'{{ $producto->nombre }}')" class="text-danger m-1" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar el producto "{{ $producto->nombre }}"'>
                      <i class="fa fa-2x fa-trash-alt"></i>
                            </a>
                            <form id="eliminar{{ $producto->id }}" method="POST" action="{{ route('productos.destroy', $producto->id) }}" accept-charset="UTF-8">
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
    <div id="container_ref">
    </div>
    <div id="container_img">
        </div>

@endsection
@section('js_links')
<!-- DataTables core JavaScript -->
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
<script type="text/javascript" src="{{ asset('js/irapp.js') }}"></script>
<script type="text/javascript">

function mostrar_modal(url_send,div_target) {
    cargar_modal(url_send,"GET",{},div_target,true)
	}

function eliminar_producto(id,nombre){
    swal({
  title: 'Eliminar el producto',
  text: '¿Desea eliminar el producto "'+nombre+'"?',
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
    var currentdate = new Date(); 
    moment.locale('es');
var datetime =  moment().format('DD MMMM YYYY, h-mm-ss a'); 
    var titulo_archivo = "Lista de productos ("+datetime+")";
     $('#dtproductos').DataTable( {
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
                text:      '<i class="fa fa-file-csv"></i> Csv',
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
                        return '<i class="fa fa-boxes"></i>  Datos del producto "'+ data[1]+'"';
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