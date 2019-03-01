

@if($editar)


<!-- Central Modal Medium Info -->
<div class="modal fade" id="modal_edit_detalles" tabindex="-1" role="dialog" aria-labelledby="modal_search_cli"
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
          <i class="fas fa-pencil-alt fa-4x mb-3 animated rotateIn text-secondary"></i>
          <h4> 
            Editar detalle "{{ $detalle->nombre }}"
        </h4>
          </div>
          <hr/>
<form id="edit_detailForm" method="POST" action="{{ route('ordenes.updateDetalles',array($detalle->id)) }}" accept-charset="UTF-8">
        <input id="edit_url_form" name="edit_url_form" type="hidden" value="{{ route('ordenes.updateDetalles',array($detalle->id)) }}" >
        <input name="_method" type="hidden" value="PUT">
        @else
<h4><i class="far fa-calendar-plus mr-2"></i> Agregar detalle</h4>
<hr/>
<form id="detailForm" method="POST" action="{{ route('ordenes.addDetalles') }}" accept-charset="UTF-8">
<input id="orden_id" name="orden_id" type="hidden" value="{{ $orden->id }}" >
<input id="url_form" name="url_form" type="hidden" value="{{ route('ordenes.addDetalles') }}" >
@endif
{{ csrf_field() }}


<!-- Grid row -->
<div class="form-row">

<!-- Grid column -->
<div class="col-md-6">

<!-- Material input -->
<div class="md-form">
<i class="fas fa-tasks prefix"></i>
<input type="text" value="{{($editar) ? $detalle->nombre : ''}}" required id="{{$prefix}}nombre"  name="{{$prefix}}nombre" class="form-control validate" maxlength="50">
<label for="{{$prefix}}nombre" data-error="Error" data-success="Correcto">Nombre *</label>
</div>

</div>

<!-- Grid column -->


<!-- Grid column -->
<div class="col-md-6">
<!-- Material input -->
@if($editar)
<div class="md-form">
<i class="fas {{($detalle->estado == 'Abierta' ) ? 'fa-tools' : (($detalle->estado == 'Cerrada' ) ? 'fa-check-circle' : (($detalle->estado == 'Cancelada' ) ? 'fa-times-circle' : (($detalle->estado == 'Pendiente' ) ? 'fa-stopwatch' : 'fa-asterisk')))}} "></i>
<small for="estado">Estado *</small>   
<select class="form-control" required id="edit_estado" name="edit_estado">
<option value="" disabled selected>Selecciona una opción</option>
@foreach($estados as $key => $estado)
<option {{  ($detalle->estado == $estado) ? 'selected' : '' }} value="{{ $estado}}">{{$estado}}</option>
@endforeach
</select>
</div> 
                  @else
              
  <!-- Material input -->
  <div class="md-form">
  <i class="prefix far fa-calendar-alt"></i>
  <input type="text" required id="fecha_inicio" value="{{ ($editar) ? $detalle->fecha_inicio : $orden->fecha_inicio }}" name="fecha_inicio" class="form-control validate" maxlength="50">
  <label for="fecha_inicio" data-error="Error" data-success="Correcto">Fecha inicio *</label>
  </div>

                  @endif
</div>
<!-- Grid column -->

    </div>
<!-- Grid row -->



@if ($editar)
<!-- Grid row -->
<div class="form-row">
<!-- Grid column -->
<div class="col-md-6">
<!-- Material input -->
<div class="md-form">
<i class="prefix far fa-calendar-alt"></i>
<input type="text" required id="edit_fecha_inicio" value="{{ ($editar) ? $detalle->fecha_inicio : $orden->fecha_inicio }}" name="edit_fecha_inicio" class="form-control validate" maxlength="50">
<label for="edit_fecha_inicio" data-error="Error" data-success="Correcto">Fecha inicio</label>
</div>

</div>

<!-- Grid column -->

<!-- Grid column -->
<div class="col-md-6">
<!-- Material input -->
<div class="md-form">
<i class="prefix far fa-calendar-check"></i>
<input type="text" id="edit_fecha_fin" value="{{ ($detalle->fecha_fin) ? $detalle->fecha_fin : $detalle->fecha_inicio}}" name="edit_fecha_fin" class="form-control validate" maxlength="50">
<label for="edit_fecha_fin" data-error="Error" data-success="Correcto">Fecha fin *</label>
</div>

</div>

<!-- Grid column -->
</div>
<!-- Grid row -->
@endif

<!-- Grid row -->
<div class="form-row">

<!-- Grid column -->
<div class="col-md-6">
<!-- Material input -->

<div class="md-form">
<i class="fas fa-cogs"></i>
<small for="{{$prefix}}servicio_id">Servicio *</small>   
<select class="form-control" required id="{{$prefix}}servicio_id" name="{{$prefix}}servicio_id">
<option value="" disabled selected>Selecciona una opción</option>
@if($editar)
<option selected value="{{ $detalle->servicio->id }}">{{$detalle->servicio->nombre}}</option>
@endif
</select>
</div> 
</div>
<!-- Grid column -->

<!-- Grid column -->
<div class="col-md-6">
<!-- Material input -->

<div class="md-form">
<i class="fas fa-user-cog"></i>
<small for="{{$prefix}}colaborador_id">Colaborador *</small>   
<select class="form-control" required id="{{$prefix}}colaborador_id" name="{{$prefix}}colaborador_id">
<option value="" disabled selected>Selecciona una opción</option>
@if($editar)
<option selected value="{{ $detalle->colaborador->id }}">{{$detalle->colaborador->persona->primer_nombre}} {{$detalle->colaborador->persona->segundo_nombre}} {{$detalle->colaborador->persona->primer_apellido}} {{$detalle->colaborador->persona->segundo_apellido}}</option>
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

    $('#'+prefix+'estado').select2({
        placeholder: "Estados",
        theme: "material",
        language: "es"
    });


    $('#'+prefix+'colaborador_id').select2({
        placeholder: "Colaboradores",
        theme: "material",
        language: "es"
    });

    $('#'+prefix+'servicio_id').select2({
        placeholder: "Servicios",
        theme: "material",
        language: "es"
    });

    $(".select2-selection__arrow")
        .addClass("fas fa-chevron-down");

$(document).ready(function() {
  $('#'+prefix+'valor_unitario-mask').focus();
  $('#'+prefix+'cantidad-mask').focus();
  $('#'+prefix+'nombre').focus();
 });
$('#'+prefix+'servicio_id').on('select2:open', function (e) {
  $('#'+prefix+'servicio_id').select2("close");
  var url_send = "{{ route('ordenes.getServicios',array($orden->id,$editar)) }}";
mostrar_modal(url_send,'search_servicio');
});

$('#'+prefix+'colaborador_id').on('select2:open', function (e) {
  $('#'+prefix+'colaborador_id').select2("close");
  var url_send = "{{ route('ordenes.getColaboradores',array(null,null)) }}";
  var servicio = $('#'+prefix+'servicio_id').val();
  if(servicio){
    mostrar_modal(url_send+"/"+servicio+"/"+edit,'search_colaborador');
  }else{
    swal({
        title: 'Alerta',
        text: 'Seleccione un servicio',
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

$('#'+prefix+'fecha_inicio').bootstrapMaterialDatePicker({

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

}).on('change', function(e, date)
{
$('#'+prefix+'fecha_fin').bootstrapMaterialDatePicker('setMinDate', date);
$('#'+prefix+'fecha_fin').bootstrapMaterialDatePicker('setDate', date);
}); 

$('#'+prefix+'fecha_fin').bootstrapMaterialDatePicker({

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
        $('#'+prefix+"colaborador_id").html('<option value="" disabled selected>Selecciona una opción</option>');   
        $('#'+prefix+"servicio_id").html('<option value="" disabled selected>Selecciona una opción</option>');
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