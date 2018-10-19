@extends('layouts.dashboard.main')
@section('template_title')
Información del producto "{{ $producto->nombre }}" | {{ config('app.name', 'Laravel') }}
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

                                    <a onclick="eliminar_categoria({{ $producto->id }},'{{ $producto->nombre }}')"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
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
            <div class="row wow fadeIn">

                <!--Grid column-->
                <div class="col-12">

                    <!--Card-->
                    <div class="card wow fadeIn hoverable">

                        <!--Card content-->
                        <div class="card-body">

<div class="list-group hoverable">
  <a class="list-group-item active z-depth-2 white-text waves-light hoverable">
      <i class="fa fa-boxes  mr-2"></i><strong>Categoria #{{ $producto->id }}</strong>
    </a>
  <a class="list-group-item waves-effect hoverable"><strong><i class="fa mr-4"></i>Nombre: </strong>{{ $producto->nombre }}</a>
  <a href ="{{ route('especialidades.show', $producto->especialidad->id) }}" class="list-group-item waves-effect hoverable item-link"><strong><i class="fa fa-object-group mr-2"></i>Especialidad: </strong>{{ $producto->especialidad->nombre }}</a>
  @if($producto->producto == NULL)
  <a class="list-group-item waves-effect hoverable"><strong><i class="fa fa-boxes mr-2"></i>Categoria padre: </strong><span class="h5"><span class="badge badge-secondary">Categoria raiz</span></a>

   @else
  <a href ="{{ route('productos.show', $producto->producto->id) }}" class="list-group-item waves-effect hoverable item-link"><strong><i class="fa fa-boxes mr-2"></i>Categoria padre: </strong>{{ $producto->producto->nombre }}</a>
@endif
</div>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

          
  <!--Grid row-->
  <div class="row wow fadeIn">

      <!--Grid column-->
      <div class="col-12">

          <!--Card-->
          <div class="card wow fadeIn hoverable">

              <!--Card content-->
              <div class="card-body">

              </div>

          </div>
          <!--/.Card-->

      </div>
      <!--Grid column-->

  </div>
  <!--Grid row-->

    <!--Grid row-->
    <div class="row wow fadeIn">

        <!--Grid column-->
        <div class="col-12">

            <!--Card-->
            <div class="card wow fadeIn hoverable">


    <!-- Card image -->
    <div class="view overlay">
      <img class="card-img-top" src="https://mdbootstrap.com/img/Mockups/Lightbox/Thumbnail/img%20(67).jpg" alt="Card image cap">
      <a href="#!">
        <div class="mask rgba-stylish-slight"></div>
      </a>
    </div>
  
    <!-- Card content -->
    <div class="card-body">
  
      <!-- Title -->
      <h4 class="card-title">Referencia</h4>
      <!-- Text -->
      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  
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
<script type="text/javascript">
function eliminar_categoria(id,nombre){
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