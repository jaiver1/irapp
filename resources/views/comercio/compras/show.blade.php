@extends('layouts.dashboard.main')
@section('template_title')
Información de la compra #{{ $compra->id }} | {{ config('app.name', 'Laravel') }}
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
            <div class="card mb-4 hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fas fa-tags mr-1"></i></span>
                        <a href="{{ route('compras.index') }}">Lista de compras</a>
                        <span>/</span>
                        <span>Información de la compra #{{ $compra->id }}</span>
                    </h4>
                    
                    <div class="d-flex justify-content-center">
                    <a href="{{ route('compras.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de compras">
                      <i class="fas fa-2x fa-tags"></i>
                            </a>

                             <a href="{{ route('compras.edit', $compra->id) }}" class="btn btn-outline-warning btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Editar la compra #{{ $compra->id }}'>
                      <i class="fas fa-2x fa-pencil-alt"></i>
                            </a>

                                    <a onclick="eliminar_compra({{ $compra->id }})"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar la compra #{{ $compra->id }}'>
                      <i class="fas fa-2x fa-trash-alt"></i>
                            </a>
                            <form id="eliminar{{ $compra->id }}" method="POST" action="{{ route('compras.destroy', $compra->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="DELETE">
    {{ csrf_field() }}
</form>
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

<div class="list-group hoverable">
  <a class="list-group-item active z-depth-2 white-text waves-light hoverable">
      <i class="fas fa-tags  mr-2"></i><strong>Orden #{{ $compra->id }}</strong>
    </a>
    <a class="list-group-item waves-effect hoverable">
    <strong>Fecha:</strong>
    <span class="h5"><span class="badge blue darken-3 hoverable"><i class="far fa-calendar-alt mr-1"></i>{{ Carbon\Carbon::parse($compra->fecha)->format('d/m/Y -:- h:i A') }}</span></span>
</a>
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
                        <div id="container_form_detalles" class="card-body">

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
                          <div id="container_datatable_detalle" class="card-body">
                              
                              </div>
                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->
          
        </div>
     
        <div id="container_edit_detalles">
        </div>
        <div id="container_search_producto">
            </div>
            <div id="container_search_proveedor">
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

<script type="text/javascript" src="{{ asset('js/addons/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/i18n/es.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/addons/bootstrap-material-datetimepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/imask/imask.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/irapp.js') }}"></script>


<script type="text/javascript">

function reload_datatable(){
    var url_send = "{{ route('compras.getDetalles',array($compra->id)) }}";
    cargar_div(url_send,"GET",{},"datatable_detalle",true,false);
}

function eliminar_compra(id){
    swal({
  title: 'Eliminar la compra',
  text: '¿Desea eliminar la compra #'+id+'?',
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
    var url_send = "{{ route('compras.formDetalles',array($compra->id,0)) }}";
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


function seleccionar_producto(id,nombre,valor_unitario,prefix){
    swal({
  title: 'Seleccionar producto',
  text: '¿Desea seleccionar el producto "'+nombre+'"?',
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
    $("#"+prefix+"producto_id").html('<option selected value="'+id+'">'+nombre+'</option>');
    $("#"+prefix+"valor_unitario").val(valor_unitario);
    $("#"+prefix+"valor_unitario").attr("placeholder", valor_unitario);
    $("#"+prefix+"valor_unitario-mask").val(addCommas(valor_unitario));
    $("#"+prefix+"valor_unitario-mask").attr("placeholder", addCommas(valor_unitario));
    
    $('#modal_search_producto').modal('hide');
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

  function seleccionar_proveedor(id,nombre,nombre_completo,prefix){
    swal({
  title: 'Seleccionar proveedor',
  text: '¿Desea seleccionar el proveedor "'+nombre+'"?',
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
    $( "#"+prefix+"proveedor_id").html('<option selected value="'+id+'">'+nombre_completo+'</option>');
    $('#modal_search_proveedor').modal('hide');
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
@endsection