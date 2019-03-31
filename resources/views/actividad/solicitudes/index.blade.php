@extends('layouts.dashboard.main')
@include('include.actividad.solicitudes.div_solicitudes', array('solicitudes'=>$solicitudes))
@section('template_title')
Lista de solicitudes | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-responsive-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-buttons-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/fullcalendar.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/fullcalendar.print.css') }}" type="text/css" media="print">
@endsection
@section('content')
        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fas fa-business-time fa-lg mr-1"></i></span> <span> @if ($solicitudes->count() === 1)
                Una solicitud
            @elseif ($solicitudes->count() > 1)
                {{ $solicitudes->count() }} solicitudes
            @else
               No hay solicitudes
            @endif
            </span>
                    </h4>

                </div>

            </div>
            <!-- Heading -->

         
            @yield('div_solicitudes')

          
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
@yield('gmaps_links')
<script type="text/javascript">

function cancelar_solicitud(id,nombre){
    swal({
  title: 'Cancelar la solicitud',
  text: '¿Desea cancelar la solicitud "'+nombre+'"?',
  type: 'error',
  confirmButtonText: '<i class="fas fa-check"></i> Si',
  cancelButtonText: '<i class="fas fa-times"></i> No',
  showCancelButton: true,
  showCloseButton: true,
  confirmButtonClass: 'btn btn-danger',
  cancelButtonClass: 'btn btn-secondary',
  buttonsStyling: false,
  animation: false,
  customClass: 'animated zoomIn',
}).then((result) => {
  if (result.value) {
    $( "#cancelar"+id ).submit();
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

function aprobar_solicitud(id,nombre){
    swal({
  title: 'Aprobar la solicitud',
  text: '¿Desea aprobar la solicitud "'+nombre+'"?',
  type: 'success',
  confirmButtonText: '<i class="fas fa-check"></i> Si',
  cancelButtonText: '<i class="fas fa-times"></i> No',
  showCancelButton: true,
  showCloseButton: true,
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-secondary',
  buttonsStyling: false,
  animation: false,
  customClass: 'animated zoomIn',
}).then((result) => {
  if (result.value) {
    $( "#aprobar"+id ).submit();
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
    var titulo_archivo = "Lista de solicitudes ("+datetime+")";
     $('#dtsolicitudes').DataTable( {
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
		sSortAscending:  ': Activar para solicitudar la columna de manera ascendente',
		sSortDescending: ': Activar para solicitudar la columna de manera descendente'
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
                        return '<i class="fas fa-business-time fa-lg"></i> Datos de la solicitud "'+ data[1]+'"';
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
var calendar = $('#calendar_solicitudes').fullCalendar({
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
    height: "auto",
      defaultDate: ahora_fecha,
      navLinks: true, // can click day/week names to navigate views
      editable: false,
      eventLimit: true, // allow "more" link when too many events
      locale: 'es',
      themeSystem: 'bootstrap4',
      nowIndicator: true,
      now: ahora_fecha+'T'+ahora_hora,
      events: @json($JSON_solicitudes) ,
      timeFormat: 'HH:mm',
      businessHours: [
  {
    dow: [ 1, 2, 3, 4, 5 ], // semana
    start: '04:00', // 4am
    end: '23:00' // 11pm
  },
  {
    dow: [ 6, 7 ], // sabado
    start: '04:00', // 8am
    end: '23:00' // 2pm
  }
], eventRender: function(eventObj, element) {
    if(eventObj.icon){          
        element.find(".fc-title").prepend("<i class='fas "+eventObj.icon+"'></i> &nbsp;");
     }
      },
      eventClick: function(calEvent, jsEvent, view) {
        var ruta_info = "{{ route('solicitudes.show',array(null)) }}";
var is_admin = "{{ Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE) }}";
//alert('Event: ' + calEvent.title);
//alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
//alert('View: ' + view.name);

// change the border color just for fun
$('.fc-day').removeClass('day-active');
$('.fc-event').removeClass('event-active');
$(this).addClass('event-active');
var texto_info = "<hr/><strong style='font-weight:900;'>Nombre:</strong> <em style='font-weight:400;'>"+calEvent.title+"</em>";
      texto_info += "<br/><strong style='font-weight:900;'>Estado:</strong> <span class='h5'><span class='badge hoverable' style='background-color:"+calEvent.color+";'><i class='mr-1 fas "+calEvent.icon+"'></i>"+calEvent.estado+"</span></span>";
      texto_info += "<br/><strong style='font-weight:900;'>Cliente:</strong> <em style='font-weight:400;'>"+calEvent.primer_nombre+" "+calEvent.segundo_nombre+" "+calEvent.primer_apellido+" "+calEvent.segundo_apellido+"</em>";
      texto_info += "<br/><strong style='font-weight:900;'>Dirección:</strong> <em style='font-weight:400;'>"+calEvent.direccion+" ("+calEvent.barrio+")</em>"; 
      texto_info += "<br/><strong style='font-weight:900;'>Ciudad:</strong> <em style='font-weight:400;'>"+calEvent.ciudad+" - "+calEvent.departamento+" ("+calEvent.pais+")</em>";  
      texto_info += "<br/><strong style='font-weight:900;'>Fecha inicio:</strong> <em style='font-weight:400;'>"+calEvent.fecha_inicio+"</em>";  
     
      texto_info += "<hr/><a class='text-primary m-1' target='_blank' href='"+ruta_info+"/"+calEvent.id+"'><strong style='font-weight:900;'><i class='fas fa-info-circle'></i>Mas información</strong></a>";
      if(is_admin){
texto_info += "<a class='teal-text m-1' target='_blank' onclick='aprobar_solicitud("+calEvent.id+",\""+calEvent.title+"\")'><strong style='font-weight:900;'><i class='far fa-calendar-check'></i> Aprobar</strong></a>";
texto_info += "<a class='text-danger m-1' target='_blank' onclick='cancelar_solicitud("+calEvent.id+",\""+calEvent.title+"\")'><strong style='font-weight:900;'><i class='far fa-calendar-times'></i> Cancelar</strong></a>";
      }
      texto_info = texto_info.replace('null','');
  swal({
  title: 'Detalles de la solicitud',
 html: texto_info,
  showCloseButton: true,
  showCancelButton: false,
  showConfirmButton: false,
  animation: false,
  customClass: 'animated zoomIn',
})
},
      windowResize: function(view) {
  }, 
  dayClick: function(date, jsEvent, view) {

$('.fc-event').removeClass('event-active');
$('.fc-day').removeClass('day-active');
$(this).addClass('day-active');

if(view.name == 'month') {
    $('#calendar_solicitudes').fullCalendar('changeView', 'agendaDay');
    $('#calendar_solicitudes').fullCalendar('gotoDate', date);      
  }

}
});

var id = "{{Auth::user()->id}}";
var vista = localStorage.getItem("USER_SOLICITUD_"+id);
  if(vista) {
if(vista == 'table'){
    $('a[href="#pills-list-solicitud"]').tab('show');
}else if(vista == 'map'){
    $('a[href="#pills-map-solicitud"]').tab('show');
}else{
$('#calendar_solicitudes').fullCalendar('changeView', vista);
$('a[href="#pills-calendar-solicitud"]').tab('show');
}
}
    });

    $('a[href="#pills-calendar-solicitud"]').on('shown.bs.tab', function (e) {
        $('#calendar_solicitudes').fullCalendar('render');
})

    function cambio_Solicitud(view){
    localDB_Solicitud(view);
  $('#calendar_solicitudes').fullCalendar('changeView', view);
}

function localDB_Solicitud(view){
    var id = "{{Auth::user()->id}}";
  if(view == "calendar"){
    var fc_vista = $('#calendar_solicitudes').fullCalendar('getView');
    view = fc_vista.type;
  }
    localStorage.setItem("USER_SOLICITUD_"+id,view);
}
</script>
@endsection