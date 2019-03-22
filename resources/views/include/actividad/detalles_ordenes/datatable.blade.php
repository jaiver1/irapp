<div class="d-sm-flex justify-content-between">
    <h4><i class="fas fa-tasks mr-2"></i>
    @if ($orden->detalles->count() === 1)
Un detalle de "{{$orden->nombre}}"
@elseif ($orden->detalles->count() > 1)
{{ $orden->detalles->count() }} detalles de "{{$orden->nombre}}"
@else
No hay detalles de "{{$orden->nombre}}"
@endif
</h4>
</div>
<hr/>
<div class="table-responsive">
    <!-- Table  -->
<table id="dtdetalles_ordenes" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
        <thead class="th-color white-text">
                <tr class="z-depth-2">
                  <th class="th-sm">#
                  </th>
                  <th class="th-sm">Nombre
                  </th>
                  @if(Auth::user()->authorizeRoles('ROLE_CLIENTE',FALSE))
                  <th class="th-sm">Estado
                </th>
@endif
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
                @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR','ROLE_COLABORADOR'],FALSE))
                  <th class="th-sm">Acciones
                  </th>
               @endif
                </tr>
              </thead>
              <tbody>
              @foreach($orden->detalles as $key => $detalle)
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

                <td>{{$detalle->colaborador->persona->primer_nombre}} {{$detalle->colaborador->persona->segundo_nombre}}</td> 
                
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
                  @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR','ROLE_COLABORADOR'],FALSE))
                <td>

                    @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE))

                        <a onclick="mostrar_modal('{{ route('ordenes.formDetalles',array($detalle->id,1)) }}','edit_detalles');" class="text-warning m-1" 
                                data-toggle="tooltip" data-placement="bottom" title='Editar el detalle "{{ $detalle->nombre }}"'>
                                  <i class="fas fa-2x fa-pencil-alt"></i>
                                        </a>
                                                    <a onclick="desvincular_detalle({{ $detalle->id }},'{{ $detalle->nombre }}')" class="text-danger m-1" 
                                                            data-toggle="tooltip" data-placement="bottom" title='Desvincular el detalle "{{ $detalle->nombre }}"'>
                                                              <i class="fas fa-2x fa-times-circle"></i>
                                                                    </a>
                                                                    @endif

                                                                    @if(Auth::user()->authorizeRoles('ROLE_COLABORADOR',FALSE))

                                                @if(Auth::user()->getColaborador()->id == $detalle->colaborador->id)
                          
                                                                 
                                                                    <div class="btn-group">
                                                                        <button type="button" data-toggle="dropdown" aria-haspopup="true"
                                                                          aria-expanded="false"
                                                                          class="btn dropdown-toggle  waves-effect hoverable  @switch($detalle->estado)
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
                                                                                @endswitch">
                                                                         
                              <i class="mr-1 fas fa-lg
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
                              "></i>{{ $detalle->estado }}
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                                @foreach($estados as $key => $estado)
                                                                                <button onclick="estado_detalle({{ $detalle->id }},'{{ $detalle->nombre }}','{{ $estado }}')"
                                                                                class="dropdown-item waves-effect hoverable {{($detalle->estado == $estado) ? 'ocultr' : ''}}" type="button">
                                                                                        <i class="mr-1 fas fa-lg
                                                                                        @switch($estado)
                                                                                    @case('Abierta')
                                                                                        fa-business-time indigo-text
                                                                                    @break
                                                                                    @case('Cerrada')
                                                                                        fa-flag-checkered teal-text 
                                                                                    @break
                                                                                    @case('Cancelada')
                                                                                        fa-times  red-text
                                                                                    @break
                                                                                    @default
                                                                                        fa-stopwatch orange-text
                                                                                    @endswitch
                                                                                        "></i>
                                                                                    {{$estado}}</button>
                                                                                @endforeach
                                                                        </div>
                                                                      </div>
                                                                    @else
                                                                      <span class="banned" data-toggle="tooltip" data-placement="bottom" title=' Responsable: "{{ $detalle->colaborador->persona->primer_nombre }} {{ $detalle->colaborador->persona->primer_apellido }}"'>
                                                                        <i class="fas fa-2x fa-user-cog"></i>
                                                                    </span>
                                                                    @endif
                                                                    @endif
                              </td>
                              @endif
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
        var es_cliente =  "{{Auth::user()->authorizeRoles('ROLE_CLIENTE',FALSE)}}"; 
        var es_colaborador =  "{{Auth::user()->authorizeRoles('ROLE_COLABORADOR',FALSE)}}"; 
if(es_cliente){
var array_responsive = [ 1,3,4,5,6,7,8 ];
var id_priority = 8;
}else if(es_colaborador){
var array_responsive = [ 2,3,4,5,6,7 ];
var id_priority = 8;
}else{
var array_responsive = [ 2,3,4,5,6,7 ];
var id_priority = 7;
}
        
    var orden =  "{{$orden->nombre}}"; 
    var currentdate = new Date(); 
    moment.locale('es');
var datetime =  moment().format('DD MMMM YYYY, h-mm-ss a'); 
    var titulo_archivo = 'Lista de detalles de "'+orden+'" ('+datetime+')';
     $('#dtdetalles_ordenes').DataTable( {
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