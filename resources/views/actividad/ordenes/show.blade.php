@extends('layouts.dashboard.main')
@section('template_title')
Información de la orden "{{ $orden->nombre }}" | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('css/addons/bootstrap-material-datetimepicker.css') }}" type="text/css"/>
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
                    <span><i class="fas fa-business-time mr-1"></i></span>
                    @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE))
                        <a href="{{ route('ordenes.index') }}">Lista de ordenes</a>
                        <span>/</span>
                        @endif
                        <span>Información de la orden "{{ $orden->nombre }}"</span>
                    </h4>
                    @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE))
                    <div class="d-flex justify-content-center">
                    <a href="{{ route('ordenes.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de ordenes">
                      <i class="fas fa-2x fa-business-time"></i>
                            </a>

                             <a href="{{ route('ordenes.edit', $orden->id) }}" class="btn btn-outline-warning btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Editar la orden "{{ $orden->nombre }}"'>
                      <i class="fas fa-2x fa-pencil-alt"></i>
                            </a>

                                    <a onclick="eliminar_orden({{ $orden->id }},'{{ $orden->nombre }}')"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar la orden "{{ $orden->nombre }}"'>
                      <i class="fas fa-2x fa-trash-alt"></i>
                            </a>
                            <form id="eliminar{{ $orden->id }}" method="POST" action="{{ route('ordenes.destroy', $orden->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="DELETE">
    {{ csrf_field() }}
</form>
                    </div>
@endif
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
      <i class="fas fa-business-time  mr-2"></i><strong>Orden #{{ $orden->id }}</strong>
    </a>
  <a class="list-group-item waves-effect hoverable"><strong>Nombre: </strong>{{ $orden->nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Estado: </strong>
    <span class="h5"><span class="hoverable badge
@switch($orden->estado)
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
        @switch($orden->estado)
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
        "></i>{{ $orden->estado }}</span></span>
</a>
  <a class="list-group-item waves-effect hoverable">
    
    @if($orden->fecha_fin &&  $orden->estado == "Cerrada")
    <strong>Fecha:</strong>
    <br/>
    @else
    <strong>Fecha</strong>
    @endif
    <span class="h5"><span class="badge blue darken-3 hoverable"><i class="far fa-calendar-alt mr-1"></i>{{ Carbon\Carbon::parse($orden->fecha_inicio)->format('d/m/Y -:- h:i A') }}</span></span>
@if($orden->fecha_fin &&  $orden->estado == "Cerrada")
<br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<span class="h5"><span class="badge teal darken-3 hoverable"><i class="far fa-calendar-check mr-1"></i>{{ Carbon\Carbon::parse($orden->fecha_fin)->format('d/m/Y -:- h:i A') }}</span></span>
@endif
</a>
  <a class="list-group-item waves-effect hoverable"><strong>Cliente: </strong>{{$orden->cliente->persona->primer_nombre}} {{$orden->cliente->persona->segundo_nombre}} {{$orden->cliente->persona->primer_apellido}} {{$orden->cliente->persona->segundo_apellido}}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Ciudad: </strong>{{ $orden->ciudad->nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Barrio: </strong>{{ $orden->barrio }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Direccion: </strong>{{ $orden->direccion }}</a>
</div>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

            
            @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE))
              <!--Grid row-->
              <div class="row mt-5">

                <!--Grid column-->
                <div class="col-12">

                    <!--Card-->
                    <div class="card hoverable"> 
                        <!--Card content-->
                        <div id="container_form_detalles" class="card-body">

                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->
            @endif

               <!--Grid row-->
               <div class="row mt-5">

                <!--Grid column-->
                <div class="col-12">

                    <!--Card-->
                    <div class="card hoverable"> 
                        <!--Card content-->
                          <div id="container_datatable_detalle" class="card-body">
                              
                              </div>
                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->
          
        </div>
        @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE))
        <div id="container_edit_detalles">
        </div>
        <div id="container_search_servicio">
            </div>
            <div id="container_search_colaborador">
            </div>
            @endif
@endsection
@section('js_links')

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

<script type="text/javascript" src="{{ asset('js/addons/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/i18n/es.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/addons/bootstrap-material-datetimepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/imask/imask.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/irapp.js') }}"></script>

@if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE))
<script type="text/javascript">

function reload_datatable(){
    var url_send = "{{ route('ordenes.getDetalles',array($orden->id)) }}";
    cargar_div(url_send,"GET",{},"datatable_detalle",true,false);
}

function eliminar_orden(id,nombre){
    swal({
  title: 'Eliminar la orden',
  text: '¿Desea eliminar la orden "'+nombre+'"?',
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

$(document).ready(function() {
    reload_datatable();
    var url_send = "{{ route('ordenes.formDetalles',array($orden->id,0)) }}";
    cargar_div(url_send,"GET",{},"form_detalles",true,false);
        });

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

 $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })


function seleccionar_servicio(id,nombre,valor_unitario,prefix){
    swal({
  title: 'Seleccionar servicio',
  text: '¿Desea seleccionar el servicio "'+nombre+'"?',
  type: 'question',
  confirmButtonText: '<i class="fas fa-check"></i> Seleccionar',
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
    $("#"+prefix+"servicio_id").html('<option selected value="'+id+'">'+nombre+'</option>');
    $("#"+prefix+"valor_unitario").val(valor_unitario);
    $("#"+prefix+"valor_unitario").attr("placeholder", valor_unitario);
    $("#"+prefix+"valor_unitario-mask").val(addCommas(valor_unitario));
    $("#"+prefix+"valor_unitario-mask").attr("placeholder", addCommas(valor_unitario));
    
    $('#modal_search_servicio').modal('hide');
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

  function seleccionar_colaborador(id,nombre,nombre_completo,prefix){
    swal({
  title: 'Seleccionar colaborador',
  text: '¿Desea seleccionar el colaborador "'+nombre+'"?',
  type: 'question',
  confirmButtonText: '<i class="fas fa-check"></i> Seleccionar',
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
    $( "#"+prefix+"colaborador_id").html('<option selected value="'+id+'">'+nombre_completo+'</option>');
    $('#modal_search_colaborador').modal('hide');
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
    </script>
@endif
@if(Auth::user()->authorizeRoles(['ROLE_COLABORADOR','ROLE_CLIENTE'],FALSE))
<script type="text/javascript">
$(document).ready(function() {
    var url_send = "{{ route('ordenes.getDetalles',array($orden->id)) }}";
        cargar_div(url_send,"GET",{},"datatable_detalle",true,false);
        });
</script>
@endif
@endsection