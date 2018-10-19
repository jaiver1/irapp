@extends('layouts.dashboard.main')
@section('template_title')
Información de la categoria "{{ $categoria->nombre }}" | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')
        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fa fa-sitemap mr-1"></i></span>
                        <a href="{{ route('categorias.index') }}">Lista de categorias</a>
                        <span>/</span>
                        <span>Información de la categoria "{{ $categoria->nombre }}"</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de categorias">
                      <i class="fa fa-2x fa-sitemap"></i>
                            </a>

                             <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-outline-warning btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Editar la categoria "{{ $categoria->nombre }}"'>
                      <i class="fa fa-2x fa-pencil-alt"></i>
                            </a>

                                    <a onclick="eliminar_categoria({{ $categoria->id }},'{{ $categoria->nombre }}')"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar la categoria "{{ $categoria->nombre }}"'>
                      <i class="fa fa-2x fa-trash-alt"></i>
                            </a>
                            <form id="eliminar{{ $categoria->id }}" method="POST" action="{{ route('categorias.destroy', $categoria->id) }}" accept-charset="UTF-8">
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
      <i class="fa fa-sitemap  mr-2"></i><strong>Categoria #{{ $categoria->id }}</strong>
    </a>
  <a class="list-group-item waves-effect hoverable"><strong><i class="fa mr-4"></i>Nombre: </strong>{{ $categoria->nombre }}</a>
  <a href ="{{ route('especialidades.show', $categoria->especialidad->id) }}" class="list-group-item waves-effect hoverable item-link"><strong><i class="fa fa-object-group mr-2"></i>Especialidad: </strong>{{ $categoria->especialidad->nombre }}</a>
  @if($categoria->categoria == NULL)
  <a class="list-group-item waves-effect hoverable"><span class="h5"><span class="badge badge-secondary"><i class="fa fa-network-wired mr-1"></i>Categoria raiz</span></a>

   @else
  <a href ="{{ route('categorias.show', $categoria->categoria->id) }}" class="list-group-item waves-effect hoverable item-link"><strong><i class="fa fa-sitemap mr-2"></i>Categoria padre: </strong>{{ $categoria->categoria->nombre }}</a>
@endif
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
<script type="text/javascript">
function eliminar_categoria(id,nombre){
    swal({
  title: 'Eliminar la categoria',
  text: '¿Desea eliminar la categoria "'+nombre+'"?',
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