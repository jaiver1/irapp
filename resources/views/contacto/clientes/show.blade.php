@extends('layouts.dashboard.main')
@include('include.contacto.personas.img', array('persona'=>$cliente->persona->usuario))
@section('template_title')
Información del cliente "{{$cliente->persona->primer_nombre}} {{$cliente->persona->primer_apellido}}" | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/dashboard/profile-img.css') }}" type="text/css">
@endsection

@section('content')
        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fas fa-user-tie mr-1 fa-lg"></i></span>
                        <a href="{{ route('clientes.index') }}">Lista de clientes</a>
                        <span>/</span>
                        <span>Información del cliente "{{$cliente->persona->primer_nombre}} {{$cliente->persona->primer_apellido}}"</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de clientes">
                      <i class="fas fa-2x fa-user-tie"></i>
                            </a>

                             <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-outline-warning btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Editar el cliente "{{ $cliente->nombre }}"'>
                      <i class="fas fa-2x fa-pencil-alt"></i>
                            </a>

                                    <a onclick="eliminar_cliente({{ $cliente->id }},'{{ $cliente->nombre }}')"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar el cliente "{{ $cliente->nombre }}"'>
                      <i class="fas fa-2x fa-trash-alt"></i>
                            </a>
                            <form id="eliminar{{ $cliente->id }}" method="POST" action="{{ route('clientes.destroy', $cliente->id) }}" accept-charset="UTF-8">
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
      <i class="fas fa-user-tie  mr-2"></i><strong>Cliente #{{ $cliente->id }}</strong>
    </a>
    <a class="list-group-item waves-effect hoverable"><strong>Cedula: </strong>{{ $cliente->persona->cedula }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Primer nombre: </strong>{{ $cliente->persona->primer_nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Segundo nombre: </strong>{{ $cliente->persona->segundo_nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Primer apellido: </strong>{{ $cliente->persona->primer_apellido }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Segundo apellido: </strong>{{ $cliente->persona->segundo_apellido }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Telefono movil: </strong>{{ $cliente->persona->telefono_movil }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Telefono fijo: </strong>{{ $cliente->persona->telefono_fijo }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Ciudad: </strong>{{ $cliente->persona->ciudad->nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Barrio: </strong>{{ $cliente->persona->barrio }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Direccion: </strong>{{ $cliente->persona->direccion }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Cuenta banco: </strong>{{ $cliente->persona->cuenta_banco }}</a>
  @if(Auth::user()->authorizeRoles('ROLE_ROOT',FALSE))
  <a href ="{{ route('usuarios.show' , $cliente->persona->usuario->id) }}" class="list-group-item waves-effect hoverable item-link"><strong><i class="fas fa-user mr-2"></i>Usuario: </strong>{{ $cliente->persona->usuario->name }}</a>
  @endif
</div>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

            @yield('img_form')
          
        </div>

@endsection
@section('js_links')

<script type="text/javascript" src="{{ asset('js/irapp.js') }}"></script>


@yield('img_script')

<script type="text/javascript">
function eliminar_cliente(id,nombre){
    swal({
  title: 'Eliminar el cliente',
  text: '¿Desea eliminar el cliente "'+nombre+'"?',
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