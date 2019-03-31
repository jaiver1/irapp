@extends('layouts.dashboard.main')
@section('template_title')
Información del servicio "{{ $servicio->nombre }}" | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/dropzone.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/dropzone-component.css') }}" type="text/css">
@endsection
@section('content')
        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fas fa-cogs mr-1 fa-lg"></i></span>
                        <a href="{{ route('servicios.index') }}">Lista de servicios</a>
                        <span>/</span>
                        <span>Información del servicio "{{ $servicio->nombre }}"</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('servicios.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de servicios">
                      <i class="fas fa-2x fa-cogs"></i>
                            </a>

                             <a href="{{ route('servicios.edit', $servicio->id) }}" class="btn btn-outline-warning btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Editar el servicio "{{ $servicio->nombre }}"'>
                      <i class="fas fa-2x fa-pencil-alt"></i>
                            </a>

                                    <a onclick="eliminar_servicio({{ $servicio->id }},'{{ $servicio->nombre }}')"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar el servicio "{{ $servicio->nombre }}"'>
                      <i class="fas fa-2x fa-trash-alt"></i>
                            </a>
                            <form id="eliminar{{ $servicio->id }}" method="POST" action="{{ route('servicios.destroy', $servicio->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="DELETE">
    {{ csrf_field() }}
</form>
                    </div>

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
      <i class="fas fa-cogs  mr-2"></i><strong>Servicio #{{ $servicio->id }}</strong>
    </a>
  <a class="list-group-item waves-effect hoverable"><strong>Nombre: </strong>{{ $servicio->nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Valor unitario: </strong> <span class="h5"><span class="badge badge-success hoverable">@money($servicio->valor_unitario)</span></span></a>
  <a class="list-group-item waves-effect hoverable"><strong>Descripción: </strong>{{ $servicio->descripcion }}</a>
  <a href ="{{ route('categorias.show', $servicio->categoria->id) }}" class="list-group-item waves-effect hoverable item-link"><strong><i class="fas fa-sitemap mr-2"></i>Categoria: </strong>{{ $servicio->categoria->nombre }}</a>
  <a href ="{{ route('medidas.show', $servicio->medida->id) }}" class="list-group-item waves-effect hoverable item-link"><strong><i class="fas fa-ruler mr-2"></i>Medida: </strong>{{ $servicio->medida->nombre }}</a>

</div>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

              <!--Grid row-->
  <div class="mt-4 row wow fadeIn">

    <!--Grid column-->
    <div class="col-12">

        <!--Card-->
        <div class="card wow fadeIn hoverable">

            <!--Card content-->
            <div class="card-body">
                  <h4><i class="fas fa-images mr-2"></i>
          Imagenes de "{{ $servicio->nombre }}"
      </h4>
      <hr/>

      <div class="mb-4 row wow fadeIn">
          <div class="col-12">
     <form accept-charset="UTF-8" action="{{ route('servicios.uploadImagenes', $servicio->id) }}" method="POST" enctype="multipart/form-data" class="dropzone hoverable" id="servicio_dropzone">
       <input type="hidden" id="url_imagenes" name="url_imagenes" value="{{ route('servicios.loadRowImagenes', $servicio->id) }}"/>
      {{ csrf_field() }}
    </form>
  </div>
</div>
    
    <div class="mb-4 row wow fadeIn">
        <div class="col-12">
    <div id="container_img">
      </div>
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
<script type="text/javascript" src="{{ asset('js/addons/dropzone.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/irapp.js') }}"></script>
<script type="text/javascript">

  Dropzone.autoDiscover = false;
  Dropzone.prototype.defaultOptions.dictDefaultMessage = "Arrastra los archivos aquí para subirlos";
Dropzone.prototype.defaultOptions.dictFallbackMessage = "Su navegador no admite la carga de archivos con arrastrar y soltar.";
Dropzone.prototype.defaultOptions.dictFallbackText = "Utilice el formulario de respaldo a continuación para cargar sus archivos como en los viejos tiempos.";
Dropzone.prototype.defaultOptions.dictFileTooBig = "El archivo es demasiado grande (@{{filesize}}MiB). Tamaño máximo de archivo: @{{maxFilesize}}MiB.";
Dropzone.prototype.defaultOptions.dictInvalidFileType = "No puedes subir archivos de este tipo.";
Dropzone.prototype.defaultOptions.dictResponseError = "Servidor respondió con código @{{statusCode}}.";
Dropzone.prototype.defaultOptions.dictCancelUpload = "<i class='fas fa-times-circle'></i> Cancelar";
Dropzone.prototype.defaultOptions.dictCancelUploadConfirmation = "¿Estás seguro de que quieres cancelar esta carga?";
Dropzone.prototype.defaultOptions.dictRemoveFile = "<i class='fas fa-trash-alt'></i> Eliminar";
Dropzone.prototype.defaultOptions.dictMaxFilesExceeded = "No puedes subir más archivos.";

jQuery(document).ready(function() {
  try {
  cargar_imagenes(); 
}catch(err) {
          console.log(err.message);
            swal({
        title: 'Error',
        text: err.message,
        type: 'error',
        confirmButtonText: '<i class="fas fa-check"></i> Continuar',
        showCloseButton: true,
        confirmButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        animation: false,
        customClass: 'animated zoomIn',
      });
        }
        try {
            var myDropzone = new Dropzone("#servicio_dropzone" , {
                paramName: "imagen", // The name that will be used to transfer the file
                maxFilesize: 2, // MB
                addRemoveLinks : true,
    acceptedFiles: '.png,.jpg,.jpeg',
    timeout: 5000,
        parallelUploads: 10,
                init: function() {
                            this.on("addedfile", function(file) {
                            });
                      
                            this.on("error", function(file, response) {
                              console.log(response);
                              $(file.previewElement).find('.dz-error-message').text(response.message);
                            });

this.on("sending", function(file, xhr, formData) {
  /*Called just before each file is sent*/
        xhr.ontimeout = (() => {
          /*Execute on case of timeout only*/
            console.log('Server Timeout');
            this.removeFile(file);

        });
});

                            this.on("success", function(file, response) {
                              console.log(response);  
                              this.removeFile(file);  
                                if(response.status == 200){
                                  cargar_imagenes(); 
                                }
                                /*else{
                                  var markEl = $(file.previewElement).find('.dz-error-mark');
                                    markEl.show();
                                    markEl.css("opacity", 1);
                                  var barEl = $(file.previewElement).find('.dz-progress');
                                    barEl.hide();
                                    barEl.css("opacity", 0);
                                  var msgEl = $(file.previewElement).find('.dz-error-message');
                                    msgEl.text(response.message);
                                    msgEl.show();
                                    msgEl.css("opacity", 1);
               
                                }*/
                                      
                          });
                          }
                         });
        }catch(err) {
          console.log(err.message);
            swal({
        title: 'Error',
        text: "Dropzone no es compatible con este navegador.",
        type: 'error',
        confirmButtonText: '<i class="fas fa-check"></i> Continuar',
        showCloseButton: true,
        confirmButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        animation: false,
        customClass: 'animated zoomIn',
      });
        }
      });
  
      function cargar_imagenes(){
        var url_imagenes = $("#url_imagenes").val();
        cargar_div(url_imagenes,"GET",{},"img",true,true);
      }

function confirmar_eliminar(id,url_deleted){
 inicio_carga();
  $.ajax({
    method: "POST",
    url: url_deleted,
    async:true,
    headers: {
        'X-CSRF-TOKEN': _token
    },
    data: { _method : 'DELETE'}
  })
    .done(function(response) {
      try{
        console.log(response);
      
    if(response.status == 200){
                                  cargar_imagenes(); 
                                }else{
                                  swal({
        title: 'Error 500',
        text: response.message,
        type: 'error',
        confirmButtonText: '<i class="fas fa-check"></i> Continuar',
        showCloseButton: true,
        confirmButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        animation: false,
        customClass: 'animated zoomIn',
      });
                                }
    }catch(err) {
        console.log(err.message);
    }
    })
    .fail(function(response) {
      console.log(response.responseJSON);
      swal({
        title: 'Error '+response.status,
        text: response.statusText,
        type: 'error',
        confirmButtonText: '<i class="fas fa-check"></i> Continuar',
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

function eliminar_imagen(id,nombre,url_deleted){
    swal({
  title: 'Eliminar la imagen',
  text: '¿Desea eliminar la imagen "'+nombre+'"?',
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
    confirmar_eliminar(id,url_deleted);
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
function eliminar_servicio(id,nombre){
    swal({
  title: 'Eliminar el servicio',
  text: '¿Desea eliminar el servicio "'+nombre+'"?',
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

  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
@endsection