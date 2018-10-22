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