@extends('layouts.dashboard.main')
@include('include.root.usuarios.img', array('usuario'=>$colaborador->persona->usuario))
@section('template_title')
Información del colaborador "{{$colaborador->persona->primer_nombre}} {{$colaborador->persona->primer_apellido}}" | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/dashboard/profile-img.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-responsive-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-buttons-datatables.min.css') }}" type="text/css">
@endsection
@section('content')
        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fas fa-user-cog mr-1 fa-lg"></i></span>
                        <a href="{{ route('colaboradores.index') }}">Lista de colaboradores</a>
                        <span>/</span>
                        <span>Información del colaborador "{{$colaborador->persona->primer_nombre}} {{$colaborador->persona->primer_apellido}}"</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('colaboradores.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de colaboradores">
                      <i class="fas fa-2x fa-user-cog"></i>
                            </a>

                             <a href="{{ route('colaboradores.edit', $colaborador->id) }}" class="btn btn-outline-warning btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Editar el colaborador "{{$colaborador->persona->primer_nombre}} {{$colaborador->persona->primer_apellido}}"'>
                      <i class="fas fa-2x fa-pencil-alt"></i>
                            </a>

                                    <a onclick="eliminar_colaborador({{ $colaborador->id }},'{{$colaborador->persona->primer_nombre}} {{$colaborador->persona->primer_apellido}}')"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar el colaborador "{{$colaborador->persona->primer_nombre}} {{$colaborador->persona->primer_apellido}}"'>
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
      <i class="fas fa-user-cog  mr-2"></i><strong>Colaborador #{{ $colaborador->id }}</strong>
    </a>
    <a class="list-group-item waves-effect hoverable"><strong>Cedula: </strong>{{ $colaborador->persona->cedula }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Primer nombre: </strong>{{ $colaborador->persona->primer_nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Segundo nombre: </strong>{{ $colaborador->persona->segundo_nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Primer apellido: </strong>{{ $colaborador->persona->primer_apellido }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Segundo apellido: </strong>{{ $colaborador->persona->segundo_apellido }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Telefono movil: </strong>{{ $colaborador->persona->telefono_movil }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Telefono fijo: </strong>{{ $colaborador->persona->telefono_fijo }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Ciudad: </strong>{{ $colaborador->persona->direccion->ciudad->nombre }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Barrio: </strong>{{ $colaborador->persona->direccion->barrio }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Direccion: </strong>{{ $colaborador->persona->direccion->direccion }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Cuenta banco: </strong>{{ $colaborador->persona->cuenta_banco }}</a>
  @if(Auth::user()->authorizeRoles('ROLE_ROOT',FALSE))
  <a href ="{{ route('usuarios.show' , $colaborador->persona->usuario->id) }}" class="list-group-item waves-effect hoverable item-link"><strong><i class="fas fa-user mr-2"></i>Usuario: </strong>{{ $colaborador->persona->usuario->name }}</a>
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

                <!--Grid row-->
                <div class="row mt-5">

                    <!--Grid column-->
                    <div class="col-12">
    
                        <!--Card-->
                        <div class="card hoverable"> 
                            <!--Card content-->
                            <div id="container_datatable_servicio" class="card-body">
                                
                            </div>
    
                        </div>
                        <!--/.Card-->
    
                    </div>
                    <!--Grid column-->
    
                </div>
                <!--Grid row-->
                
        </div>
        <div id="container_search_servicio">
        </div>
@endsection
@section('js_links')

<script type="text/javascript" src="{{ asset('js/addons/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/bt4-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/responsive-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/bt4-responsive-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/buttons-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/bt4-buttons-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/buttons.html5.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/jszip.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/pdfmake.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/vfs_fonts.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/buttons.print.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/buttons.colVis.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/irapp.js') }}"></script>

@yield('img_script')

<script type="text/javascript">

function reload_datatable(){
    var url_send = "{{ route('colaboladores.getServicios',array($colaborador->id,0)) }}";
    cargar_div(url_send,"GET",{},"datatable_servicio",true,false);
}


function desvincular_servicio(id,nombre){
    swal({
  title: 'Desvincular el servicio',
  text: '¿Desea desvincular el servicio "'+nombre+'"?',
  type: 'question',
  confirmButtonText: '<i class="fas fa-user-slash"></i> Desvincular',
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
    delete_servicio(id);
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

function agregar_servicio(id,nombre){
    swal({
  title: 'Agregar servicio',
  text: '¿Desea agregar el servicio "'+nombre+'"?',
  type: 'question',
  confirmButtonText: '<i class="fas fa-plus"></i> Agregar',
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
    $('#modal_search_servicio').modal('hide');
add_servicio(id);
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

function add_servicio(id_servicio){
    var url_send = "{{ route('colaboladores.addServicios') }}";
    var id_colaborador = "{{ $colaborador->id }}";
    var _token = "{{ csrf_token() }}";
    inicio_carga();
  $.ajax({
    method: "POST",
    url: url_send,
    async:true,
    headers: {
        'X-CSRF-TOKEN': _token
    },
    data: {
        colaborador : id_colaborador,
        servicio : id_servicio
    }
  })
    .done(function(response) {
      try{
        console.log(response);
        if(response.status == 200){
          reload_datatable();
        }   
    }
    catch(err) {
        console.log(err.message);
    }
    })
    .fail(function(response) {
      console.log(response.responseJSON);
      swal({
        title: 'Error '+response.status,
        text: response.statusText,
        type: 'error',
        confirmButtonText: '<i class="fa fa-check"></i> Continuar',
        showCloseButton: true,
        confirmButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        animation: false,
        customClass: 'animated zoomIn',
      });
    })
    .always(function() {
      fin_carga();
    });
}

function delete_servicio(id_servicio){
  var url_send = "{{ route('colaboladores.deleteServicios') }}";
    var id_colaborador = "{{ $colaborador->id }}";
    var _token = "{{ csrf_token() }}";
  $.ajax({
    method: "POST",
    url: url_send,
    async:true,
    headers: {
        'X-CSRF-TOKEN': _token
    },
    data: {
        colaborador : id_colaborador,
        servicio : id_servicio,
        _method : 'DELETE'
    }
  })
    .done(function(response) {
      try{
        console.log(response);
        if(response.status == 200){
          reload_datatable();
        }
    }
    catch(err) {
        console.log(err.message);
    }
    })
    .fail(function(response) {
      console.log(response.responseJSON);
      swal({
        title: 'Error '+response.status,
        text: response.statusText,
        type: 'error',
        confirmButtonText: '<i class="fa fa-check"></i> Continuar',
        showCloseButton: true,
        confirmButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        animation: false,
        customClass: 'animated zoomIn',
      });
    })
    .always(function() {
      fin_carga();
    });
}


$(document).ready(function() {
    reload_datatable();
        });
      </script>
      <script type="text/javascript">

        function eliminar_colaborador(id,nombre){
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