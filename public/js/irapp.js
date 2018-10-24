function cargar_div(url_send,method_send,data_send,div_target,asincronico){
  inicio_carga()
  $.ajax({
    method: method_send,
    url: url_send,
    async:asincronico,
    data: data_send
  })
    .done(function( response ) {
      alert( "Data Saved: " + response );
    })
    .fail(function(response) {
      alert( response );
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