@extends('layouts.dashboard.main')
@section('template_title')
Información de la venta #{{ $venta->id }} | {{ config('app.name', 'Laravel') }}
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
            <div class="card mb-4 hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fas fa-receipt mr-1"></i></span>
                    @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE))
                        <a href="{{ route('ventas.index',array('Abierta')) }}">Lista de ventas</a>
                        <span>/</span>
                        @elseif(Auth::user()->authorizeRoles('ROLE_CLIENTE',FALSE))
                        <a href="{{ route('home',array('Pendiente')) }}">Página principal</a>
                        <span>/</span>
                        @endif
                        <span>Información de la venta #{{ $venta->id }}</span>
                    </h4>
                    @php
                    $pay = 0
                    @endphp  
                @foreach($venta->detalles as $key => $detalle)
                @php
                    $pay += ($detalle->cantidad * $detalle->producto->valor_unitario)
                    @endphp  
                    @endforeach  
                    @if($venta->estado == "Pendiente" && false)
                    <div class="d-flex justify-content-center">
                      <a onclick="pagar_venta({{ $venta->id }})"  class="btn btn-outline-success btn-circle waves-effect hoverable" 
                        data-toggle="tooltip" data-placement="bottom" title='Pagar la venta #{{ $venta->id }}'>
                          <i class="fas fa-2x fa-file-invoice-dollar"></i>
                                </a>      
                          
                            <a onclick="cancelar_venta({{ $venta->id }})"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                              data-toggle="tooltip" data-placement="bottom" title='Cancelar la venta #{{ $venta->id }}'>
                                <i class="fas fa-2x fa-calendar-times"></i>
                                      </a>
                            <form method="POST" id="pagar{{ $venta->id }}" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/">
                              <input name="merchantId"    type="hidden"  value="508029">
                              <input name="accountId"     type="hidden"  value="512321">
                              <input name="description"   type="hidden"  value="Compra de productos en IRAPP">
                              <input name="referenceCode" type="hidden"  value="IRAPP_{{$venta->id}}">
                              <input name="amount"        type="hidden"  value="{{$pay}}">
                              <input name="tax"           type="hidden"  value="0">
                              <input name="taxReturnBase" type="hidden"  value="0">
                              <input name="currency"      type="hidden"  value="COP">
                              <input name="signature"     type="hidden"  value="{{md5('4Vj8eK4rloUd272L48hsrarnUA~508029~IRAPP_'.$venta->id.'~'.$pay.'~COP')}}">
                              <input name="test"          type="hidden"  value="1">
                              <input name="buyerEmail"    type="hidden"  value="{{$venta->cliente->persona->usuario->email}}">
                              <input name="buyerFullName"    type="hidden"  value="{{$venta->cliente->persona->primer_nombre}} {{$venta->cliente->persona->segundo_nombre}} {{$venta->cliente->persona->primer_apellido}} {{$venta->cliente->persona->segundo_apellido}}">
                              <input name="responseUrl"    type="hidden"  value="{{ route('ventas.pay') }}">
                              <input name="confirmationUrl"    type="hidden"  value="{{ route('ventas.pay') }}">
                            </form>
                            <form id="cancelar{{ $venta->id }}" method="POST" action="{{ route('ventas.cancel', $venta->id) }}" accept-charset="UTF-8">
                              <input name="_method" type="hidden" value="PUT">
                              {{ csrf_field() }}
                          </form>
                    </div>
@endif
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

                         
<div class="list-group hoverable">
  <a class="list-group-item active z-depth-2 white-text waves-light hoverable">
      <i class="fas fa-receipt  mr-2"></i><strong>Compra #{{ $venta->id }}</strong>
    </a>
  <a class="list-group-item waves-effect hoverable"><strong>Estado: </strong>
    <span class="h5"><span class="hoverable badge
      @switch($venta->estado)
          @case('Abierta')
              teal darken-1
          @break
          @case('Cancelada')
              red darken-3 
          @break
          @case('Entregado')
          indigo
          @break
          @case('Enviado')
          cyan darken-2
          @break
          @default
              amber darken-3
          @endswitch
              ">
              <i class="mr-1 fas
              @switch($venta->estado)
          @case('Abierta')
              fa-calendar-check 
          @break
          @case('Cancelada')
              fa-calendar-times  
          @break
          @case('Entregado')
          fa-handshake
          @break
          @case('Enviado')
          fa-truck-loading
          @break
          @default
              fa-stopwatch 
          @endswitch
              "></i>{{ ($venta->estado == "Abierta") ? "Aprobado" : $venta->estado }}</span></span>
</a>
  <a class="list-group-item waves-effect hoverable">
    
    @if($venta->fecha_fin &&  $venta->estado == "Cerrada")
    <strong>Fecha:</strong>
    <br/>
    @else
    <strong>Fecha</strong>
    @endif
    <span class="h5"><span class="badge blue darken-3 hoverable"><i class="far fa-calendar-alt mr-1"></i>{{ Carbon\Carbon::parse($venta->fecha_inicio)->format('d/m/Y -:- h:i A') }}</span></span>
@if($venta->fecha_fin &&  $venta->estado == "Cerrada")
<br/> {{--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--}}
<span class="h5"><span class="badge teal darken-1 hoverable"><i class="far fa-calendar-check mr-1"></i>{{ Carbon\Carbon::parse($venta->fecha_fin)->format('d/m/Y -:- h:i A') }}</span></span>
@endif
</a>
  <a class="list-group-item waves-effect hoverable"><strong>Cliente: </strong>{{$venta->cliente->persona->primer_nombre}} {{$venta->cliente->persona->segundo_nombre}} {{$venta->cliente->persona->primer_apellido}} {{$venta->cliente->persona->segundo_apellido}}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Ciudad: </strong>{{ $venta->direccion->ciudad->nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Barrio: </strong>{{ $venta->direccion->barrio }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Direccion: </strong>{{ $venta->direccion->direccion }}</a>
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
                            <div class="d-sm-flex justify-content-between">
                            <h4><i class="fas fa-tasks mr-2"></i>
                            @if ($venta->detalles->count() === 1)
                        Un detalle de venta #{{$venta->id}}
                        @elseif ($venta->detalles->count() > 1)
                        {{ $venta->detalles->count() }} detalles de venta #{{$venta->id}}
                        @else
                        No hay detalles de venta #{{$venta->id}}
                        @endif
                        </h4>
                        </div>
                        <hr/>
                        <div class="table-responsive">
                            <!-- Table  -->
                        <table id="dtdetalles_ventas" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
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
                                         
                                       
                                        </tr>
                                      </thead>
                                      <tbody>
                                      @foreach($venta->detalles as $key => $detalle)
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
                                   
                                                      
                                        </tr>
                                        @endforeach
                                      </tbody>
                        </table>
                                                    <!-- Table  -->
                            </div>

   <div class="row">
<hr>
    <div class="col-12 text-center">
                            <h2><span class="badge teal hoverable mt-4">
                              @money($pay)
                              </span>
                              </h2>
                            </div></div>  
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

alert();
function pagar_venta(id,pay){
        swal({
      title: 'Pagar la venta',
      text: '¿Desea pagar la venta #'+id+' ($'+addCommas(pay)+')?',
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
        $( "#pagar"+id ).submit();
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

    function cancelar_venta(id){
        swal({
      title: 'Cancelar la venta',
      text: '¿Desea cancelar la venta #'+id+'?',
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

 $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })

    $(document).ready(function() {
 

 var array_responsive = [ 1,3,4,5,6 ];
 var id_priority = 7;
 
         
     var venta =  "venta #{{$venta->id}}"; 
     var currentdate = new Date(); 
     moment.locale('es');
 var datetime =  moment().format('DD MMMM YYYY, h-mm-ss a'); 
     var titulo_archivo = 'Lista de detalles de '+venta+' ('+datetime+')';
      $('#dtdetalles_ventas').DataTable( {
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

@endsection