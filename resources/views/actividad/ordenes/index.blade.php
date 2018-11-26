@extends('layouts.dashboard.main')
@section('template_title')
Lista de ordenes | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-responsive-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-buttons-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/fullcalendar.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/fullcalendar.print.css') }}" type="text/css" media="print"
@endsection
@section('content')
        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fa fa-business-time fa-lg mr-1"></i></span> <span> @if ($ordenes->count() === 1)
                Una orden
            @elseif ($ordenes->count() > 1)
                {{ $ordenes->count() }} ordenes
            @else
               No hay ordenes
            @endif
            </span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('ordenes.create') }}" class="btn btn-outline-success btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Registrar una orden">
                      <i class="fa fa-2x fa-plus"></i>
                            </a>
                            <a href="{{ route('ordenes.deleted.index') }}" class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Ordenes eliminadas">
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
                                <ul class="nav nav-pills mb-3" id="views-tab" role="tablist">
                                        <li class="nav-item hoverable waves-effect">
                                          <a class="nav-link active z-depth-5" id="pills-list-tab" data-toggle="pill" href="#pills-list" role="tab" aria-controls="pills-list" aria-selected="true">
                                            <h5> <i class="fa fa-clipboard-list mr-2"></i>Lista</h5></a>
                                        </li>
                                        <li class="nav-item hoverable waves-effect">
                                          <a class="nav-link z-depth-5" id="pills-calendar-tab" data-toggle="pill" href="#pills-calendar" role="tab" aria-controls="pills-calendar" aria-selected="false">
                                              <h5> <i class="fa fa-calendar-alt mr-2"></i>Calendario</h5></a>
                                        </li>
                                      </ul>
                                <div class="tab-content" id="pills-tab-views">
                                        <div class="tab-pane fade show active" id="pills-list" role="tabpanel" aria-labelledby="pills-list-tab">
                                                <div class="table-responsive">
                                                        <!-- Table  -->
                                                        <table id="dtordenes" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
                              <thead class="th-color white-text">
                                <tr class="z-depth-2">
                                  <th class="th-sm">#
                                  </th>
                                  <th class="th-sm">Nombre
                                  </th>
                                  <th class="th-sm">Acciones
                                  </th>
                               
                                </tr>
                              </thead>
                              <tbody>
                              @foreach($ordenes as $key => $orden)
                                <tr class="hoverable">
                                  <td>{{$orden->id}}</td>
                                  <td>{{$orden->nombre}}</td>          
                                  <td>
                            
                            <a href="{{ route('ordenes.show', $orden->id) }}" class="text-primary m-1" 
                                                data-toggle="tooltip" data-placement="bottom" title='Información de la orden "{{ $orden->nombre }}"'>
                                                  <i class="fa fa-2x fa-info-circle"></i>
                                                        </a>
                            
                                  <a href="{{ route('ordenes.edit', $orden->id) }}" class="text-warning m-1" 
                                                data-toggle="tooltip" data-placement="bottom" title='Editar la orden "{{ $orden->nombre }}"'>
                                                  <i class="fa fa-2x fa-pencil-alt"></i>
                                                        </a>
                            
                                                        <a onclick="eliminar_orden({{ $orden->id }},'{{ $orden->nombre }}')" class="text-danger m-1" 
                                                data-toggle="tooltip" data-placement="bottom" title='Eliminar la orden "{{ $orden->nombre }}"'>
                                                  <i class="fa fa-2x fa-trash-alt"></i>
                                                        </a>
                                                        <form id="eliminar{{ $orden->id }}" method="POST" action="{{ route('ordenes.destroy', $orden->id) }}" accept-charset="UTF-8">
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
                                        <div class="tab-pane fade" id="pills-calendar" role="tabpanel" aria-labelledby="pills-calendar-tab">
                                            <div class='fc-right'>
                                                
  <!-- Basic dropdown -->
  
  <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
    <div class="btn-group btn-group-sm" role="group" aria-label="First group">
  <a class="btn btn-secondary  btn-sm dropdown-toggle mr-4" type="button" data-toggle="dropdown" aria-haspopup="true"
  aria-expanded="false"><i class="fa fa-eye mr-1"></i>Ver</a>

<div class="dropdown-menu">
        <a class="dropdown-item disabled" href="#"><i class="fa fa-calendar-alt mr-1"></i>Calendario</a>
        <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="#" onclick="cambio('agendaDay')">Día</a>
  <a class="dropdown-item" href="#" onclick="cambio('agendaWeek')">Semana</a>
  <a class="dropdown-item" href="#" onclick="cambio('month')">Mes</a>

  <div class="dropdown-divider"></div>
  <a class="dropdown-item disabled" href="#"><i class="fa fa-clipboard-list mr-1"></i>Listas</a>
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="#" onclick="cambio('listDay')">Día</a>
  <a class="dropdown-item" href="#" onclick="cambio('listWeek')">Semana</a>
  <a class="dropdown-item" href="#" onclick="cambio('listMonth')">Mes</a>
  <a class="dropdown-item" href="#" onclick="cambio('listYear')">Año</a>
</div>
<!-- Basic dropdown -->
</div>
</div>

                                            </div>
                                            <div id='calendar'></div>

                                        </div>
    
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
<script type="text/javascript" src="{{ asset('js/addons/calendar/fullcalendar.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/calendar/es.js') }}"></script>
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

function cambio(view){
  $('#calendar').fullCalendar('changeView', view);
}

function eliminar_orden(id,nombre){
    swal({
  title: 'Eliminar la orden',
  text: '¿Desea eliminar la orden "'+nombre+'"?',
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
    var titulo_archivo = "Lista de ordenes ("+datetime+")";
     $('#dtordenes').DataTable( {
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
                        return '<i class="fa fa-business-time fa-lg"></i> Datos de la orden "'+ data[1]+'"';
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
var ahora = moment().local();
var ahora_fecha = ahora.format('YYYY-MM-DD');
var ahora_hora = ahora.format('HH:mm:ss');
console.log(ahora);
var calendar = $('#calendar').fullCalendar({
       header: {
        left: 'prev,next,today,prevYear,nextYear',
        center: 'title',
        right: ''
      },
      buttonText: {
        listMonth: 'Mes',
        listYear: 'Año',
        listWeek: 'Semana',
        listDay: 'Dia'
    },
      defaultDate: ahora_fecha,
      navLinks: true, // can click day/week names to navigate views
      editable: false,
      eventLimit: true, // allow "more" link when too many events
      locale: 'es',
      themeSystem: 'bootstrap4',
      nowIndicator: true,
      now: ahora_fecha+'T'+ahora_hora,
      events: [
        {
          title: 'All Day Event',
          start: '2018-03-01',
        },
        {
          title: 'Long Event',
          start: '2018-03-07',
          end: '2018-03-10'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2018-03-09T16:00:00'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2018-03-16T16:00:00'
        },
        {
          title: 'Conference',
          start: '2018-03-11',
          end: '2018-03-13'
        },
        {
          title: 'Meeting',
          start: '2018-03-12T10:30:00',
          end: '2018-03-12T12:30:00'
        },
        {
          title: 'Lunch',
          start: '2018-03-12T12:00:00'
        },
        {
          title: 'Meeting',
          start: '2018-03-12T14:30:00'
        },
        {
          title: 'Happy Hour',
          start: '2018-03-12T17:30:00'
        },
        {
          title: 'Dinner',
          start: '2018-03-12T20:00:00'
        },
        {
          title: 'Birthday Party',
          start: '2018-03-13T07:00:00'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2018-03-28'
        }
      ],
      businessHours: [
  {
    dow: [ 1, 2, 3, 4, 5 ], // semana
    start: '08:00', // 8am
    end: '18:00' // 6pm
  },
  {
    dow: [ 6 ], // sabado
    start: '08:00', // 8am
    end: '14:00' // 2pm
  }
], eventRender: function(eventObj, $el) {
   
      },
      eventClick: function(calEvent, jsEvent, view) {

alert('Event: ' + calEvent.title);
alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
alert('View: ' + view.name);

// change the border color just for fun
$(this).css('border-color', 'red');

},
      windowResize: function(view) {
  }, 
  dayClick: function(date, jsEvent, view) {

alert('Clicked on: ' + date.format());

alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);

alert('Current view: ' + view.name);

// change the day's background color just for fun
$(this).css('background-color', 'red');

}
});
    });
</script>
@endsection