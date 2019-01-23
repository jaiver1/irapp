@extends('layouts.dashboard.main')
@section('template_title')
Información del colaborador "{{ $colaborador->nombre }}" | {{ config('app.name', 'Laravel') }}
@endsection

@section('content')
        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fas fa-user-tie mr-1 fa-lg"></i></span>
                        <a href="{{ route('colaboradores.index') }}">Lista de colaboradores</a>
                        <span>/</span>
                        <span>Información del colaborador "{{ $colaborador->nombre }}"</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('colaboradores.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de colaboradores">
                      <i class="fas fa-2x fa-user-tie"></i>
                            </a>

                             <a href="{{ route('colaboradores.edit', $colaborador->id) }}" class="btn btn-outline-warning btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Editar el colaborador "{{ $colaborador->nombre }}"'>
                      <i class="fas fa-2x fa-pencil-alt"></i>
                            </a>

                                    <a onclick="eliminar_cliente({{ $colaborador->id }},'{{ $colaborador->nombre }}')"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar el colaborador "{{ $colaborador->nombre }}"'>
                      <i class="fas fa-2x fa-trash-alt"></i>
                            </a>
                            <form id="eliminar{{ $colaborador->id }}" method="POST" action="{{ route('colaboradores.destroy', $colaborador->id) }}" accept-charset="UTF-8">
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
      <i class="fas fa-user-tie  mr-2"></i><strong>Cliente #{{ $colaborador->id }}</strong>
    </a>
    <a class="list-group-item waves-effect hoverable"><strong>Cedula: </strong>{{ $colaborador->persona->cedula }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Primer nombre: </strong>{{ $colaborador->persona->primer_nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Segundo nombre: </strong>{{ $colaborador->persona->segundo_nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Primer apellido: </strong>{{ $colaborador->persona->primer_apellido }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Segundo apellido: </strong>{{ $colaborador->persona->segundo_apellido }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Telefono movil: </strong>{{ $colaborador->persona->telefono_movil }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Telefono fijo: </strong>{{ $colaborador->persona->telefono_fijo }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Ciudad: </strong>{{ $colaborador->persona->ciudad->nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Barrio: </strong>{{ $colaborador->persona->barrio }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Direccion: </strong>{{ $colaborador->persona->direccion }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Cuenta banco: </strong>{{ $colaborador->persona->cuenta_banco }}</a>
  <a href ="{{ route('usuarios.show' , $colaborador->persona->usuario->id) }}" class="list-group-item waves-effect hoverable item-link"><strong><i class="fas fa-user mr-2"></i>Usuario: </strong>{{ $colaborador->persona->usuario->name }}</a>

</div>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

                <!--Grid row-->
                <div class="row mt-5">

                    <!--Grid column-->
                    <div class="col-12">
    
                        <!--Card-->
                        <div class="card hoverable"> 
                            <!--Card content-->
                            <div class="card-body">
                                <h4><i class="fas fa-tasks mr-2"></i>
                                @if ($colaborador->servicios->count() === 1)
                    Un servicio de "{{$colaborador->persona->primer_nombre}} {{$colaborador->persona->primer_apellido}}"
                @elseif ($colaborador->servicios->count() > 1)
                    {{ $colaborador->servicios->count() }} servicios de "{{$colaborador->persona->primer_nombre}} {{$colaborador->persona->primer_apellido}}"
                @else
                   No hay servicios de "{{$colaborador->persona->primer_nombre}} {{$colaborador->persona->primer_apellido}}"
                @endif
                </h4>
                <hr/>
                            <div class="table-responsive">
                                <!-- Table  -->
                                <table id="dtcategorias" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
      <thead class="th-color white-text">
        <tr class="z-depth-2">
          <th class="th-sm">#
          </th>
          <th class="th-sm">Nombre
          </th>
          <th class="th-sm">Orden
          </th>
          <th class="th-sm">Categoria padre
          </th>
          <th class="th-sm">Acciones
          </th>
       
        </tr>
      </thead>
      <tbody>
      @foreach($colaborador->servicios as $key => $servicio)
        <tr class="hoverable">
          <td>{{$servicio->id}}</td>
          <td>{{$servicio->nombre}}</td>
          <td><i class="fas fa-business-time"></i> {{$servicio->colaborador->nombre}}</td>
          <td>
            @if($servicio->servicio == NULL)
           <h5> <span class="badge badge-secondary"><i class="fas fa-tasks"></i> Categoria raiz</span><h5>
            @else
                <a href="{{ route('servicios.show',$servicio->servicio->id) }}" class="link-text"
                              data-toggle="tooltip" data-placement="bottom" title='Información del servicio padre "{{ $servicio->servicio->nombre }}"'>
                                <i class="fas fa-tasks"></i> {{$servicio->servicio->nombre}}
                                      </a>    
            @endif
        </td>
        <td>
  
          <a href="{{ route('servicios.show',$servicio->id) }}" class="text-primary m-1" 
                              data-toggle="tooltip" data-placement="bottom" title='Información del servicio "{{ $servicio->nombre }}"'>
                                <i class="fas fa-2x fa-info-circle"></i>
                                      </a>
                </td>
        </tr>
        @endforeach
      </tbody>
    </table>
                                <!-- Table  -->
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
function eliminar_cliente(id,nombre){
    swal({
  title: 'Eliminar el colaborador',
  text: '¿Desea eliminar el colaborador "'+nombre+'"?',
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