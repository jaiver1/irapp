@extends('layouts.dashboard.main')
@section('template_title')
Información del usuario "{{ $usuario->name }}" | {{ config('app.name', 'Laravel') }}
@endsection
@section('footer_title')
Información del usuario "{{ $usuario->name }}" | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')

        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fa fa-users mr-1"></i></span>
                        <a href="{{ route('usuarios.index') }}">Lista de usuarios</a>
                        <span>/</span>
                        <span>Información del usuario "{{ $usuario->name }}"</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de usuarios">
                      <i class="fa fa-2x fa-users"></i>
                            </a>

                             <a href="{{ route('usuarios.edit',$usuario->id) }}" class="btn btn-outline-warning btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Editar el usuario "{{ $usuario->name }}"'>
                      <i class="fa fa-2x fa-pencil-alt"></i>
                            </a>

                                    <a onclick="eliminar_usuario({{ $usuario->id }},'{{ $usuario->name }}')"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar el usuario "{{ $usuario->name }}"'>
                      <i class="fa fa-2x fa-trash-alt"></i>
                            </a>
                            <form id="eliminar{{ $usuario->id }}" method="POST" action="{{ route('usuarios.destroy',$usuario->id) }}" accept-charset="UTF-8">
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
      <i class="fa fa-user mr-2"></i><strong>Usuario #{{ $usuario->id }}</strong>
    </a>
  <a class="list-group-item waves-effect hoverable"><strong>Nombre: </strong>{{ $usuario->name }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Email: </strong>{{ $usuario->email }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Rol: </strong>{{$usuario->roles[0]->display_name}}</a>
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

function eliminar_usuario(id,nombre){
    swal({
  title: 'Eliminar el usuario',
  text: '¿Desea eliminar el usuario "'+nombre+'"?',
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