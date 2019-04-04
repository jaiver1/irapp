

@if($editar)


<!-- Central Modal Medium Info -->
<div class="modal fade" id="modal_edit_detalles" tabindex="-1" role="dialog" aria-labelledby="modal_search_cli"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-secondary modal-lg" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead"><i class="fas fa-search"></i> Buscar producto</p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <div class="text-center">
          <i class="fas fa-pencil-alt fa-4x mb-3 animated rotateIn text-secondary"></i>
          <h4> 
            Editar detalle #{{ $detalle->id }}
        </h4>
          </div>
          <hr/>
<form id="edit_detailForm" method="POST" action="{{ route('compras.updateDetalles',array($detalle->id)) }}" accept-charset="UTF-8">
        <input id="edit_url_form" name="edit_url_form" type="hidden" value="{{ route('compras.updateDetalles',array($detalle->id)) }}" >
        <input name="_method" type="hidden" value="PUT">
        @else
<h4><i class="far fa-calendar-plus mr-2"></i> Agregar detalle</h4>
<hr/>
<form id="detailForm" method="POST" action="{{ route('compras.addDetalles') }}" accept-charset="UTF-8">
<input id="compra_id" name="compra_id" type="hidden" value="{{ $compra->id }}" >
<input id="url_form" name="url_form" type="hidden" value="{{ route('compras.addDetalles') }}" >
@endif
{{ csrf_field() }}


<!-- Grid row -->
<div class="form-row">

<!-- Grid column -->
<div class="col-md-6">
<!-- Material input -->

<div class="md-form">
<i class="fas fa-box-open"></i>
<small for="{{$prefix}}producto_id">Producto *</small>   
<select class="form-control" required id="{{$prefix}}producto_id" name="{{$prefix}}producto_id">
<option value="" disabled selected>Selecciona una opción</option>
@if($editar)
<option selected value="{{ $detalle->producto->id }}">{{$detalle->producto->nombre}}</option>
@endif
</select>
</div> 
</div>
<!-- Grid column -->

<!-- Grid column -->
<div class="col-md-6">
<!-- Material input -->

<div class="md-form">
<i class="fas fa-user-tag"></i>
<small for="{{$prefix}}proveedor_id">Proveedor *</small>   
<select class="form-control" id="{{$prefix}}proveedor_id" name="{{$prefix}}proveedor_id">
<option value="" disabled selected>Selecciona una opción</option>
@if($editar && $detalle->proveedor)
<option selected value="{{ $detalle->proveedor->id }}">{{$detalle->proveedor->persona->primer_nombre}} {{$detalle->proveedor->persona->segundo_nombre}} {{$detalle->proveedor->persona->primer_apellido}} {{$detalle->proveedor->persona->segundo_apellido}}</option>
@endif
</select>
</div> 
</div>
<!-- Grid column -->

</div>
<!-- Grid row -->

<!-- Grid row -->
<div class="form-row">



     <!-- Grid column -->
<div class="col-md-6">


<!-- Material input -->
<div class="md-form">
<i class="fas fa-money-bill-alt prefix"></i>
<input type="hidden" required id="{{$prefix}}valor_unitario" value="{{($editar) ? $detalle->valor_unitario : '0'}}"  placeholder="{{ ($editar) ? $detalle->valor_unitario : '0' }}" name="{{$prefix}}valor_unitario" class="form-control validate" maxlength="12">
<input type="text" required id="{{$prefix}}valor_unitario-mask" value="{{ ($editar) ? $detalle->valor_unitario : '0' }}" placeholder="{{ ($editar) ? $detalle->valor_unitario : '0' }}" name="{{$prefix}}valor_unitario-mask" class="form-control validate" maxlength="50">
<label for="{{$prefix}}valor_unitario-mask" data-error="Error" data-success="Correcto">Valor unitario *</label>
</div>


</div>
<!-- Grid column -->

<div class="col-md-6">

<!-- Material input -->

<!-- Material input -->
<div class="md-form">
<i class="fas fa-list-ol prefix"></i>
<input type="hidden" required id="{{$prefix}}cantidad" value="{{ ($editar) ? $detalle->cantidad : '1' }}" placeholder="{{ ($editar) ? $detalle->cantidad : '1' }}" name="{{$prefix}}cantidad" class="form-control validate" maxlength="12">
<input type="text" required id="{{$prefix}}cantidad-mask" value="{{ ($editar) ? $detalle->cantidad : '1' }}" placeholder="{{ ($editar) ? $detalle->cantidad : '1' }}" name="{{$prefix}}cantidad-mask" class="form-control validate" maxlength="50">
<label for="{{$prefix}}cantidad-mask" data-error="Error" data-success="Correcto">Cantidad *</label>
</div>

</div>
<!-- Grid column -->

  </div>
<!-- Grid row -->

<!-- Grid row -->
<div class="form-row">





  </div>
<!-- Grid row -->

<button type="submit" class="waves-effect btn {{($editar) ? 'btn-warning' : 'btn-success'}} btn-md hoverable">
  <i class="fas fa-2x {{($editar) ? 'fa-pencil-alt' : 'fa-plus'}}"></i> {{($editar) ? 'Editar' : 'Agregar'}}
  </button>
</form>

@if ($editar)
</div>

<!--Footer-->
<div class="modal-footer justify-content-center">
</div>
</div>
<!--/.Content-->
</div>
</div>
<!-- Central Modal Medium Info-->
  @endif
<script type="text/javascript">
var prefix = "{{$prefix}}";
var edit = "{{$editar}}";

$(function () {
        var numberMask = new IMask(document.getElementById(prefix+'valor_unitario-mask'), {
          mask: Number,
          min: 0,
          max: 999999999999,
          thousandsSeparator: ','
        }).on('accept', function() {
          document.getElementById(prefix+'valor_unitario').value = numberMask.masked.number;
        });

         var numberMask2 = new IMask(document.getElementById(prefix+'cantidad-mask'), {
          mask: Number,
          min: 1,
          max: 999999999999,
          thousandsSeparator: ','
        }).on('accept', function() {
          document.getElementById(prefix+'cantidad').value = numberMask2.masked.number;
        });
    })


    $('#'+prefix+'proveedor_id').select2({
        placeholder: "Proveedores",
        theme: "material",
        language: "es"
    });

    $('#'+prefix+'producto_id').select2({
        placeholder: "Productos",
        theme: "material",
        language: "es"
    });

    $(".select2-selection__arrow")
        .addClass("fas fa-chevron-down");

$(document).ready(function() {
  $('#'+prefix+'valor_unitario-mask').focus();
  $('#'+prefix+'cantidad-mask').focus();
 });
$('#'+prefix+'producto_id').on('select2:open', function (e) {
  $('#'+prefix+'producto_id').select2("close");
  var url_send = "{{ route('compras.getProductos',array($compra->id,$editar)) }}";
mostrar_modal(url_send,'search_producto');
});

$('#'+prefix+'proveedor_id').on('select2:open', function (e) {
  $('#'+prefix+'proveedor_id').select2("close");
  var url_send = "{{ route('compras.getProveedores',array(null,null)) }}";
  var producto = $('#'+prefix+'producto_id').val();
  if(producto){
    mostrar_modal(url_send+"/"+producto+"/"+edit,'search_proveedor');
  }else{
    swal({
        title: 'Alerta',
        text: 'Seleccione un producto',
        type: 'warning',
        confirmButtonText: '<i class="fa fa-check"></i> Continuar',
        showCloseButton: true,
        confirmButtonClass: 'btn btn-warning',
        buttonsStyling: false,
        animation: false,
        customClass: 'animated zoomIn',
      });
 
  }

});

$('#'+prefix+'fecha').bootstrapMaterialDatePicker({

// enable date picker
date : true, 

// enable time picker
time : true, 

// custom date format
format : 'YYYY-MM-DD HH:mm', 

// min / max date
minDate : null, 
maxDate : null, 

// current date
currentDate : null, 

// Localization
lang : 'es', 

// week starts at
weekStart : 1, 

// short time format
shortTime : false, 

// text for cancel button
'cancelText' : '<i class="fas fa-times fa-2x"></i>', 

// text for ok button
'okText' : '<i class="fas fa-check fa-2x"></i>' 

}); 



$('#'+prefix+"detailForm").on('submit',(function(e) {
        e.preventDefault();
      var url_send = $('#'+prefix+"url_form").val();
      var _token = "{{ csrf_token() }}";
    inicio_carga();
  $.ajax({
    method: "POST",
    url: url_send,
    async:true,
    contentType:false, 
    processData:false,
    headers: {
        'X-CSRF-TOKEN': _token
    },
    data:  new FormData(this),
  })
    .done(function(response) {
      try{
        console.log(response);
        if(response.status == 200){            
            swal({
        title: 'Éxito',
        text: response.message,
        type: 'success',
        confirmButtonText: '<i class="fa fa-check"></i> Continuar',
        showCloseButton: true,
        confirmButtonClass: 'btn btn-success',
        buttonsStyling: false,
        animation: false,
        customClass: 'animated zoomIn',
      });
      if(prefix==""){
        $('#'+prefix+"nombre").html('');
        $('#'+prefix+"proveedor_id").html('<option value="" disabled selected>Selecciona una opción</option>');   
        $('#'+prefix+"producto_id").html('<option value="" disabled selected>Selecciona una opción</option>');
      }else{  
        $('#modal_edit_detalles').modal('hide');
      }
        reload_datatable();
                }else{
                    swal({
        title: 'Error '+response.status,
        text: response.message,
        type: 'error',
        confirmButtonText: '<i class="fa fa-check"></i> Continuar',
        showCloseButton: true,
        confirmButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        animation: false,
        customClass: 'animated zoomIn',
      });
                }

    }
    catch(err) {
        console.log(err.message);
    }
    })
    .fail(function(response) {
      console.log(response.responseJSON);
      swal({
        title: 'Error '+response.status,
        text: response.statusText,
        type: 'error',
        confirmButtonText: '<i class="fa fa-check"></i> Continuar',
        showCloseButton: true,
        confirmButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        animation: false,
        customClass: 'animated zoomIn',
      });
    })
    .always(function() {
      fin_carga();
    });

    }));
  </script>