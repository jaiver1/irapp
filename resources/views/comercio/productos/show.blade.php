@extends('layouts.dashboard.main')
@section('template_title')
Información del producto "{{ $producto->nombre }}" | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/dropzone.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/basic.css') }}" type="text/css">
@endsection
@section('content')
        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fa fa-boxes mr-1"></i></span>
                        <a href="{{ route('productos.index') }}">Lista de productos</a>
                        <span>/</span>
                        <span>Información del producto "{{ $producto->nombre }}"</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de productos">
                      <i class="fa fa-2x fa-boxes"></i>
                            </a>

                             <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-outline-warning btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Editar el producto "{{ $producto->nombre }}"'>
                      <i class="fa fa-2x fa-pencil-alt"></i>
                            </a>

                                    <a onclick="eliminar_producto({{ $producto->id }},'{{ $producto->nombre }}')"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar el producto "{{ $producto->nombre }}"'>
                      <i class="fa fa-2x fa-trash-alt"></i>
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
      <i class="fa fa-boxes  mr-2"></i><strong>Producto #{{ $producto->id }}</strong>
    </a>
  <a class="list-group-item waves-effect hoverable"><strong><i class="fa mr-4"></i>Nombre: </strong>{{ $producto->nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong><i class="fa mr-4"></i>Referencia: </strong>{{ $producto->referencia }}</a>
  <a class="list-group-item waves-effect hoverable"><strong><i class="fa mr-4"></i>Valor: </strong>@money($producto->valor)</a>
  <a href ="{{ route('categorias.show', $producto->categoria->id) }}" class="list-group-item waves-effect hoverable item-link"><strong><i class="fa fa-sitemap mr-2"></i>Categoria: </strong>{{ $producto->categoria->nombre }}</a>
  <a href ="{{ route('medidas.show', $producto->medida->id) }}" class="list-group-item waves-effect hoverable item-link"><strong><i class="fa fa-ruler mr-2"></i>Medida: </strong>{{ $producto->medida->nombre }}</a>
  <a href ="{{ route('marcas.show', $producto->marca->id) }}" class="list-group-item waves-effect hoverable item-link"><strong><i class="fa fa-trademark mr-2"></i>Marca: </strong>{{ $producto->marca->nombre }}</a>
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
                    <h4><i class="fa fa-images mr-2"></i>
            Imagenes de "{{ $producto->nombre }}"
        </h4>
        <hr/>


       <form action="casa" method="POST" enctype="multipart/form-data" class="dropzone hoverable" id="producto_dropzone">
                </form>
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
                  <h4><i class="fa fa-box-open mr-2"></i>
          Referencias de "{{ $producto->nombre }}"
      </h4>
      <hr/>

<!--Carousel Wrapper-->
<div id="carousel_referencias" class="carousel slide carousel-fade hoverable img-border" data-ride="carousel">
  <!--Indicators-->
  <ol class="carousel-indicators">
    <li data-target="#carousel_referencias" data-slide-to="0" class="active"></li>
    @for ($i = 1; $i < $tipos_referencias->count(); $i++)
    <li data-target="#carousel_referencias" data-slide-to="{{$i}}"></li>
    @endfor
  </ol>
  <!--/.Indicators-->
  <!--Slides-->

  <div class="carousel-item referencia-carousel-item active">
        <!--Mask color-->
        <div class="view referencia-carousel-img">
               
              <img src="{{ 'data:image/png;base64,' .DNS1D::getBarcodePNG($producto->referencia, $tipos_referencias[0]->nombre,3,33,array(58,77,86)) }}" class="img-fluid rounded img-thumbnail" alt="{{ $tipos_referencias[0]->nombre }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
             
              <div class="mask rgba-black-slight"></div>
        </div>
        <div class="carousel-caption">
          <h3 class="h3-responsive">{{ $tipos_referencias[0]->dimension }}</h3>
          <p>{{ $tipos_referencias[0]->nombre }}</p>
        </div>
      </div>
  @for ($i = 1; $i < $tipos_referencias->count(); $i++)

  <div class="carousel-item referencia-carousel-item">
    <!--Mask color-->
    <div class="view referencia-carousel-img">
            @if($tipos_referencias[$i]->dimension == "1D")
            <img src="{{ 'data:image/png;base64,' .DNS1D::getBarcodePNG($producto->referencia, $tipos_referencias[$i]->nombre,3,33,array(58,77,86)) }}" class="img-fluid rounded img-thumbnail"  alt="{{ $tipos_referencias[$i]->nombre }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
            @endif
            @if($tipos_referencias[$i]->dimension == "2D")
          <img src="{{ 'data:image/png;base64,' .DNS2D::getBarcodePNG($producto->referencia, $tipos_referencias[$i]->nombre,3,3,array(58,77,86)) }}" class="img-fluid rounded img-thumbnail"  alt="{{ $tipos_referencias[$i]->nombre }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
          @endif
          <div class="mask rgba-black-slight"></div>
    </div>
    <div class="carousel-caption">
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
<script type="text/javascript">
function eliminar_producto(id,nombre){
    swal({
  title: 'Eliminar el producto',
  text: '¿Desea eliminar el producto "'+nombre+'"?',
  type: 'question',
  confirmButtonText: '<i class="fa fa-trash-alt"></i> Eliminar',
  cancelButtonText: '<i class="fa fa-times"></i> Cancelar',
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