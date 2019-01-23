@extends('layouts.dashboard.main')
@section('template_title')
Información del producto "{{ $producto->nombre }}" | {{ config('app.name', 'Laravel') }}
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
                    <span><i class="fas fa-boxes mr-1 fa-lg"></i></span>
                        <a href="{{ route('productos.index') }}">Lista de productos</a>
                        <span>/</span>
                        <span>Información del producto "{{ $producto->nombre }}"</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de productos">
                      <i class="fas fa-2x fa-boxes"></i>
                            </a>

                             <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-outline-warning btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Editar el producto "{{ $producto->nombre }}"'>
                      <i class="fas fa-2x fa-pencil-alt"></i>
                            </a>

                                    <a onclick="eliminar_producto({{ $producto->id }},'{{ $producto->nombre }}')"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar el producto "{{ $producto->nombre }}"'>
                      <i class="fas fa-2x fa-trash-alt"></i>
                            </a>
                            <form id="eliminar{{ $producto->id }}" method="POST" action="{{ route('productos.destroy', $producto->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="DELETE">
    {{ csrf_field() }}
</form>
                    </div>

                </div>

            </div>
            <!-- Heading -->

         
            <!--Grid row-->
            <div class="mb-4 row wow fadeIn">

                <!--Grid column-->
                <div class="col-12">

                    <!--Card-->
                    <div class="card wow fadeIn hoverable">

                        <!--Card content-->
                        <div class="card-body">

<div class="list-group hoverable">
  <a class="list-group-item active z-depth-2 white-text waves-light hoverable">
      <i class="fas fa-boxes  mr-2"></i><strong>Producto #{{ $producto->id }}</strong>
    </a>
  <a class="list-group-item waves-effect hoverable"><strong>Nombre: </strong>{{ $producto->nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Referencia: </strong>{{ $producto->referencia }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Valor unitario: </strong> <span class="h5"><span class="badge badge-success hoverable">@money($producto->valor_unitario)</span></span></a>
  <a class="list-group-item waves-effect hoverable"><strong>Descripción: </strong>{{ $producto->descripcion }}</a>
  <a href ="{{ route('categorias.show', $producto->categoria->id) }}" class="list-group-item waves-effect hoverable item-link"><strong><i class="fas fa-sitemap mr-2"></i>Categoria: </strong>{{ $producto->categoria->nombre }}</a>
  <a href ="{{ route('medidas.show', $producto->medida->id) }}" class="list-group-item waves-effect hoverable item-link"><strong><i class="fas fa-ruler mr-2"></i>Medida: </strong>{{ $producto->medida->nombre }}</a>
  <a href ="{{ route('marcas.show', $producto->marca->id) }}" class="list-group-item waves-effect hoverable item-link"><strong><i class="fas fa-trademark mr-2"></i>Marca: </strong>{{ $producto->marca->nombre }}</a>
</div>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

          
  <!--Grid row-->
  <div class="mb-4 row wow fadeIn">

      <!--Grid column-->
      <div class="col-12">

          <!--Card-->
          <div class="card wow fadeIn hoverable">

              <!--Card content-->
              <div class="card-body">
                    <h4><i class="fas fa-images mr-2"></i>
            Imagenes de "{{ $producto->nombre }}"
        </h4>
        <hr/>

        <div class="mb-4 row wow fadeIn">
            <div class="col-12">
       <form accept-charset="UTF-8" action="{{ route('productos.uploadImagenes', $producto->id) }}" method="POST" enctype="multipart/form-data" class="dropzone hoverable" id="producto_dropzone">
         <input type="hidden" id="url_imagenes" name="url_imagenes" value="{{ route('productos.loadRowImagenes', $producto->id) }}"/>
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


  <!--Grid row-->
  <div class="mb-4 row wow fadeIn">

    <!--Grid column-->
    <div class="col-12">

        <!--Card-->
        <div class="card wow fadeIn hoverable">

            <!--Card content-->
            <div class="card-body">
                  <h4><i class="fas fa-box-open mr-2"></i>
          Referencias de "{{ $producto->nombre }}"
      </h4>
      <hr/>

<!--Carousel Wrapper-->
<div id="carousel_referencias" class="carousel slide carousel-fade hoverable div-border" data-ride="carousel">
  <!--Indicators-->
  <ol class="carousel-indicators">
    <li data-target="#carousel_referencias" data-slide-to="0" class="active"></li>
    @for ($i = 1; $i < count($tipos_referencias); $i++)
    <li data-target="#carousel_referencias" data-slide-to="{{$i}}"></li>
    @endfor
  </ol>
  <!--/.Indicators-->
  <!--Slides-->

  <div class="carousel-item referencia-carousel-item active">
        <!--Mask color-->
        <div class="view referencia-carousel-img">
               
              <img src="{{ 'data:image/png;base64,' .DNS1D::getBarcodePNG($producto->referencia, $tipos_referencias[0]->nombre,3,33,array(58,77,86)) }}" class="img-fluid rounded img-thumbnail" alt="{{ $tipos_referencias[0]->nombre }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
             
              <div class="mask rgba-white-slight"></div>
        </div>
        <div class="carousel-caption imagen-carousel-caption">
          <h3 class="h3-responsive">{{ $tipos_referencias[0]->dimension }}</h3>
          <p>{{ $tipos_referencias[0]->nombre }}</p>
        </div>
      </div>
  @for ($i = 1; $i < count($tipos_referencias); $i++)

  <div class="carousel-item referencia-carousel-item">
    <!--Mask color-->
    <div class="view referencia-carousel-img">
            @if($tipos_referencias[$i]->dimension == "1D")
            <img src="{{ 'data:image/png;base64,' .DNS1D::getBarcodePNG($producto->referencia, $tipos_referencias[$i]->nombre,3,33,array(58,77,86)) }}" class="img-fluid rounded img-thumbnail"  alt="{{ $tipos_referencias[$i]->nombre }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
            @endif
            @if($tipos_referencias[$i]->dimension == "2D")
          <img src="{{ 'data:image/png;base64,' .DNS2D::getBarcodePNG($producto->referencia, $tipos_referencias[$i]->nombre,3,3,array(58,77,86)) }}" class="img-fluid rounded img-thumbnail"  alt="{{ $tipos_referencias[$i]->nombre }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
          @endif
          <div class="mask rgba-white-slight"></div>
    </div>
    <div class="carousel-caption referencia-carousel-caption">
      <h3 class="h3-responsive">{{ $tipos_referencias[$i]->dimension }}</h3>
      <p>{{ $tipos_referencias[$i]->nombre }}</p>
    </div>
  </div>

  @endfor
  <!--/.Slides-->
  <!--Controls-->
  <a class="carousel-control-prev" href="#carousel_referencias" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Anterior</span>
  </a>
  <a class="carousel-control-next" href="#carousel_referencias" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Siguiente</span>
  </a>
  <!--/.Controls-->
</div>
<!--/.Carousel Wrapper-->

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
            var myDropzone = new Dropzone("#producto_dropzone" , {
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
                                if(response.message == "OK"){
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
    data: { _method : 'DELETE',
    _token: '{{csrf_token()}}'}
  })
    .done(function(response) {
      try{
        console.log(response);
      
    if(response.message == "OK"){
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

function eliminar_producto(id,nombre){
    swal({
  title: 'Eliminar el producto',
  text: '¿Desea eliminar el producto "'+nombre+'"?',
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