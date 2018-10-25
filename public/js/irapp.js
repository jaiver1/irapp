function cargar_modal(url_send,method_send,data_send,div_target,asincronico){
  inicio_carga()
  $.ajax({
    method: method_send,
    url: url_send,
    async:asincronico,
    data: data_send
  })
    .done(function(response) {
      $("#container_"+div_target).html(response);
      $("#modal_"+div_target).modal("show");
    })
    .fail(function(response) {
      swal({
        title: 'Error',
        text: response,
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
      fin_carga()
    });
}
function inicio_carga(){
  $(".se-pre-con").fadeIn("slow");
}
function fin_carga(){
  $(".se-pre-con").fadeOut("slow");
}