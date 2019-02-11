
<!-- Central Modal Medium Info -->
<div class="modal fade" id="modal_search_servicio" tabindex="-1" role="dialog" aria-labelledby="modal_search_cli"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-secondary modal-lg" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead"><i class="fas fa-search"></i> Buscar servicio</p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <div class="text-center">
          <i class="fas fa-cogs fa-4x mb-3 animated rotateIn text-secondary"></i>
          <h4>  @if ($servicios->count() === 1)
            Un servicio
        @elseif ($servicios->count() > 1)
            {{ $servicios->count() }} servicios
        @else
           No hay servicios
        @endif </h4>
          </div>
          <hr/>
        <div class="table-responsive">
          <!-- Table  -->
          <table id="dtservicios_modal" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
<thead class="th-color white-text">
<tr class="z-depth-2">
    <th class="th-sm">#
    </th>
    <th class="th-sm">Nombre
    </th>
    <th class="th-sm">Valor unitario
      </th>
      {{--
      <th class="th-sm">Descripcion
    </th>
    <th class="th-sm">Categoria
    </th>
    <th class="th-sm">Medida
        </th>
        --}}
    <th class="th-sm">Acciones
    </th>
</tr>
</thead>
<tbody>
@foreach($servicios as $key => $servicio)
<tr class="hoverable">
    <td>{{$servicio->id}}</td>
    <td>{{$servicio->nombre}}</td>  
    <td> <h5><span class="badge badge-success hoverable">
          @money($servicio->valor_unitario)
          </span>
          </h5>
        </td>
        {{--
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
      --}}
<td>
  <a href="#" onclick="agregar_servicio({{$servicio->id}},'{{$servicio->nombre}}')" class="text-success m-1" 
    data-toggle="tooltip" data-placement="bottom" title='Agregar servicio "{{$servicio->nombre}}"'>
      <i class="fas fa-2x fa-plus-circle"></i>
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
    </script>
