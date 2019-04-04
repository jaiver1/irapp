<!-- Central Modal Medium Info -->
<div class="modal fade" id="modal_search_proveedor" tabindex="-1" role="dialog" aria-labelledby="modal_search_cli"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-secondary modal-lg" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead"><i class="fas fa-search"></i> Buscar proveedor</p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <div class="text-center">
          <i class="fas fa-user-tag fa-4x mb-3 animated rotateIn text-secondary"></i>
          <h4>  @if ($proveedores->count() === 1)
            Un proveedor
        @elseif ($proveedores->count() > 1)
            {{ $proveedores->count() }} proveedores
        @else
           No hay proveedores
        @endif </h4>
          </div>
          <hr/>
        <div class="table-responsive">
          <!-- Table  -->
          <table id="dtproveedores" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
<thead class="th-color white-text">
<tr class="z-depth-2">
<th class="th-sm">#
</th>
<th class="th-sm">Cedula
</th>   
<th class="th-sm">Primer nombre
</th>
<th class="th-sm">Segundo nombre
</th>
<th class="th-sm">Primer apellido
</th>
<th class="th-sm">Segundo apellido
</th>
<th class="th-sm">Telefono móvil
</th>
<th class="th-sm">Telefono fijo
</th>
<th class="th-sm">Email
</th>
<th class="th-sm">Ciudad
</th>
<th class="th-sm">Barrio
</th>
<th class="th-sm">Dirección
</th>
<th class="th-sm">Cuenta banco
</th>
<th class="th-sm">Acciones
</th>


</tr>
</thead>
<tbody>
@foreach($proveedores as $key => $proveedor)
<tr class="hoverable">
<td>{{$proveedor->id}}</td>
<td>{{$proveedor->cedula}}</td>
<td>{{$proveedor->primer_nombre}}</td>
<td>{{$proveedor->segundo_nombre}}</td>
<td>{{$proveedor->primer_apellido}}</td>
<td>{{$proveedor->segundo_apellido}}</td>
<td>{{$proveedor->telefono_movil}}</td>
<td>{{$proveedor->telefono_fijo}}</td>
<td>{{$proveedor->email}}</td>
<td>{{$proveedor->ciudad}}</td>
<td>{{$proveedor->barrio}}</td>
<td>{{$proveedor->direccion}}</td>
<td>{{$proveedor->cuenta_banco}}</td>
<td>
  <a href="javascript:void(0)" onclick="seleccionar_proveedor({{$proveedor->id}},'{{$proveedor->primer_nombre}} {{$proveedor->primer_apellido}}','{{$proveedor->primer_nombre}} {{$proveedor->segundo_nombre}} {{$proveedor->primer_apellido}} {{$proveedor->segundo_apellido}}','{{$prefix}}')" class="text-success m-1" 
    data-toggle="tooltip" data-placement="bottom" title='Seleccionar proveedor "{{$proveedor->primer_nombre}} {{$proveedor->primer_apellido}}"'>
      <i class="fas fa-2x fa-check-circle"></i>
            </a>
</td>
</tr>
@endforeach
</tbody>
</table>
          <!-- Table  -->
          </div>
      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- Central Modal Medium Info-->

<script type="text/javascript">
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
  $(document).ready(function() {
    var currentdate = new Date(); 
    moment.locale('es');
  var datetime =  moment().format('DD MMMM YYYY, h-mm-ss a'); 
    var titulo_archivo = "Lista de proveedores ("+datetime+")";
     $('#dtproveedores').DataTable( {
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
            
        });
      </script>
  