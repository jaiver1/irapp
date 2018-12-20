@extends('layouts.dashboard.main')
@section('template_title')
Información de la medida "{{ $medida->nombre }}" | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')
        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fas fa-ruler mr-1"></i></span>
                        <a href="{{ route('medidas.index') }}">Lista de medidas</a>
                        <span>/</span>
                        <span>Información de la medida "{{ $medida->nombre }}"</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('medidas.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de medidas">
                      <i class="fas fa-2x fa-ruler"></i>
                            </a>

                             <a href="{{ route('medidas.edit',$medida->id) }}" class="btn btn-outline-warning btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Editar la medida "{{ $medida->nombre }}"'>
                      <i class="fas fa-2x fa-pencil-alt"></i>
                            </a>

                                    <a onclick="eliminar_medida({{ $medida->id }},'{{ $medida->nombre }}')"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar la medida "{{ $medida->nombre }}"'>
                      <i class="fas fa-2x fa-trash-alt"></i>
                            </a>
                            <form id="eliminar{{ $medida->id }}" method="POST" action="{{ route('medidas.destroy',$medida->id) }}" accept-charset="UTF-8">
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
      <i class="fas fa-ruler mr-2"></i><strong>Medida #{{ $medida->id }}</strong>
    </a>
  <a class="list-group-item waves-effect hoverable"><strong>Nombre: </strong>{{ $medida->nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Etiqueta: </strong>{{ $medida->etiqueta }}</a>
  <a href ="{{ route('tipos_medidas.show' , $medida->tipo_medida->id) }}" class="list-group-item waves-effect hoverable item-link"><strong><i class="fas fa-balance-scale mr-2"></i>Tipo de medida: </strong>{{ $medida->tipo_medida->nombre }}</a>
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
function eliminar_medida(id,nombre){
    swal({
  title: 'Eliminar la medida',
  text: '¿Desea eliminar la medida "'+nombre+'"?',
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