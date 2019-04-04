<div class="d-sm-flex justify-content-between">
    <h4><i class="fas fa-tasks mr-2"></i>
    @if ($compra->detalles->count() === 1)
Un detalle de compra #{{$compra->id}}
@elseif ($compra->detalles->count() > 1)
{{ $compra->detalles->count() }} detalles de compra #{{$compra->id}}
@else
No hay detalles de compra #{{$compra->id}}
@endif
</h4>
</div>
<hr/>
<div class="table-responsive">
    <!-- Table  -->
<table id="dtdetalles_compras" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
        <thead class="th-color white-text">
                <tr class="z-depth-2">
                  <th class="th-sm">#
                  </th>
             
                <th class="th-sm">Fecha
                </th>

                <th class="th-sm">Producto
                </th>

                <th class="th-sm">Proveedor
                </th>

                <th class="th-sm">Valor unitario
                </th>

                <th class="th-sm">Cantidad
                </th>

                <th class="th-sm">Total
                </th>
                  <th class="th-sm">Acciones
                  </th>
               
                </tr>
              </thead>
              <tbody>
              @foreach($compra->detalles as $key => $detalle)
                <tr class="hoverable">
                  <td>{{$detalle->id}}</td>
               
                <td> 
             
                   <span class="h5"><span class="badge blue darken-3 hoverable"><i class="far fa-calendar-alt mr-1"></i>{{ Carbon\Carbon::parse($detalle->fecha)->format('d/m/Y -:- h:i A') }}</span></span>
                 
                </td> 

                <td>{{$detalle->producto->nombre}}</td> 

                <td>@if($detalle->proveedor)
                    {{$detalle->proveedor->persona->primer_nombre}} {{$detalle->proveedor->persona->segundo_nombre}}
                  @else
                  <span class="h5"> <span class="hoverable badge black">
                      <i class="mr-1 fas fa-user-times"></i>Proveedor no asignado 
                </span> </span>
                  @endif
                </td> 

                <td> <h5><span class="badge badge-success hoverable">
                    @money($detalle->valor_unitario)
                    </span>
                    </h5>
                  </td>

                  <td> <h5><span class="badge badge-secondary hoverable">
                    @cantidad($detalle->cantidad) {{$detalle->producto->medida->nombre}}
                    </span>
                    </h5>
                  </td>

                  <td> <h5><span class="badge teal hoverable">
                    @money($detalle->valor_unitario * $detalle->cantidad)
                    </span>
                    </h5>
                  </td>
                <td>

                   

                        <a onclick="mostrar_modal('{{ route('compras.formDetalles',array($detalle->id,1)) }}','edit_detalles');" class="text-warning m-1" 
                                data-toggle="tooltip" data-placement="bottom" title='Editar el detalle #{{ $detalle->id }}'>
                                  <i class="fas fa-2x fa-pencil-alt"></i>
                                        </a>
                                                    <a onclick="desvincular_detalle({{ $detalle->id }}" class="text-danger m-1" 
                                                            data-toggle="tooltip" data-placement="bottom" title='Desvincular el detalle #{{ $detalle->id }}'>
                                                              <i class="fas fa-2x fa-times-circle"></i>
                                                                    </a>
                                                                    
                            
                              </td>
                              
                </tr>
                @endforeach
              </tbody>
</table>
                            <!-- Table  -->
    </div>

    <script type="text/javascript">

    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
    $(document).ready(function() {
 

var array_responsive = [ 1,3,4,5,6 ];
var id_priority = 7;

        
    var compra =  "compra #{{$compra->id}}"; 
    var currentdate = new Date(); 
    moment.locale('es');
var datetime =  moment().format('DD MMMM YYYY, h-mm-ss a'); 
    var titulo_archivo = 'Lista de detalles de '+compra+' ('+datetime+')';
     $('#dtdetalles_compras').DataTable( {
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
</script>