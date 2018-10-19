@section('css_auth')
<link rel="stylesheet" href="{{ asset('css/dashboard/scroll.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/dashboard/navbar-custom.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/dashboard/navbar-custom-themes.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/dashboard/style.css') }}" type="text/css">
<style type="text/css">
    body{
background-color: #eceff1;
}
.sidebar-bg.bg1 .sidebar-wrapper{
    background-image: url("{{ asset('img/bg1.jpg')}}");
}
</style>
@endsection
@section('js_auth')
<script type="text/javascript" src="{{ asset('js/dashboard/scroll.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dashboard/navbar-custom.js') }}"></script>
<script type="text/javascript">
function salir(){
    swal({
  title: 'Salir',
  text: '¿Desea cerrar la sesion"?',
  type: 'question',
  confirmButtonText: '<i class="fa fa-check"></i> Si',
  cancelButtonText: '<i class="fa fa-times"></i> No',
  showCancelButton: true,
  showCloseButton: true,
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: false,
  animation: false,
  customClass: 'animated zoomIn',
}).then((result) => {
  if (result.value) {
    $("#logout-form").submit();
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
</script>
@endsection
@section('navegation')
<header>

<!-- Navbar -->
<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
        <div class="sidebar-brand waves-light">
            <a href="#"><i class="fa fa-hammer mr-2"></i> IRAPP</a>
            <div id="close-sidebar">
                <i class="fas fa-times-circle"></i>
            </div>
        </div>
        <div class="sidebar-header">
            <div class="user-pic">
                <img class="img-responsive img-rounded" src="{{ asset('img/user.jpg') }}" alt="User picture">
            </div>
            <div class="user-info">
                <span class="user-name">{{ Auth::user()->name }}
                    <strong>Smith</strong>
                </span>
                <span class="user-role">{{ Auth::user()->roles[0]->display_name }}</span>
                <span class="user-status">
                    <i class="fa fa-circle"></i>
                    <span>Online</span>
                </span>
            </div>
        </div>
        <!-- sidebar-header  -->
        <div class="sidebar-search">
            <div>
                <div class="input-group">
                    <input type="text" class="form-control search-menu" placeholder="Search...">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- sidebar-search  -->
        <div class="sidebar-menu">
            <ul>
                    @role(['ROLE_ROOT','ROLE_ADMINISTRADOR','ROLE_COLABORADOR'])
            <li class="header-menu">
                    <span>Inicio</span>
                </li>
                <li class="hoverable waves-light {{ \Request::is('home') ? 'default' : 'simple' }}">
                    <a href="{{route('home')}}">
                        <i class="fa fa-home"></i>
                        <span>Página principal</span>
                    </a>
                </li>
               @endrole
               @role(['ROLE_ROOT'])
                <li class="header-menu">
                    <span>Control de Acceso</span>
                </li>
                <li class="hoverable waves-light {{ (\Request::is('usuarios') || \Request::is('usuarios/*')) ? 'default' : 'simple' }}">
                    <a href="{{route('usuarios.index')}}">
                        <i class="fa fa-users"></i>
                        <span>Usuarios</span>
                    </a>
                </li>
                @endrole
                @role(['ROLE_ROOT','ROLE_ADMINISTRADOR'])
     <li class="header-menu">
                    <span>Administración</span>
                </li>

                <li class="sidebar-dropdown {{ (\Request::is('tipos_medidas') || \Request::is('tipos_medidas/*') || \Request::is('medidas') || \Request::is('medidas/*')) ? 'active default' : 'simple' }}">
                    <a href="#">
                        <i class="fa fa-file-signature"></i>
                        <span>Datos basicos</span>
                    </a>
                    <div class="sidebar-submenu" style="{{ (\Request::is('tipos_medidas') || \Request::is('tipos_medidas/*') || \Request::is('medidas') || \Request::is('medidas/*')) ? 'display: block;' : '' }} ">
                        <ul>
                            <li class="hoverable waves-light {{ (\Request::is('tipos_medidas') || \Request::is('tipos_medidas/*')) ? 'default' : 'simple' }}">
                            <a href="{{route('tipos_medidas.index')}}"> <i class="fa fa-balance-scale"></i><span>Tipos de medidas</span></a>
                            </li>
                            <li class="hoverable waves-light {{ (\Request::is('medidas') || \Request::is('medidas/*')) ? 'default' : 'simple' }}">
                                <a href="{{route('medidas.index')}}"><i class="fa fa-ruler"></i><span>Medidas</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown {{ (\Request::is('especialidades') || \Request::is('especialidades/*') || \Request::is('categorias') || \Request::is('categorias/*')) ? 'active default' : 'simple' }}">
                    <a href="#">
                        <i class="fa fa-project-diagram "></i>
                        <span>Clasificación</span>
                    </a>
                    <div class="sidebar-submenu" style="{{ (\Request::is('especialidades') || \Request::is('especialidades/*') || \Request::is('categorias') || \Request::is('categorias/*')) ? 'display: block;' : '' }} ">
                        <ul>
                            <li class="hoverable waves-light {{ (\Request::is('especialidades') || \Request::is('especialidades/*')) ? 'default' : 'simple' }}">
                            <a href="{{route('especialidades.index')}}"> <i class="fa fa-object-group"></i><span>Especialidades</span></a>
                            </li>
                            <li class="hoverable waves-light {{ (\Request::is('categorias') || \Request::is('categorias/*')) ? 'default' : 'simple' }}">
                                <a href="{{route('categorias.index')}}"><i class="fa fa-sitemap"></i><span>Categorias</span></a>
                            </li>
                        </ul>
                    </div>
                </li>
          
                <li class="sidebar-dropdown {{ (\Request::is('marcas') || \Request::is('marcas/*') || \Request::is('productos') || \Request::is('productos/*')) ? 'active default' : 'simple' }}">
                    <a href="#">
                        <i class="fa fa-handshake"></i>
                        <span>Comercio</span>
                    </a>
                    <div class="sidebar-submenu" style="{{ (\Request::is('marcas') || \Request::is('marcas/*') || \Request::is('productos') || \Request::is('productos/*')) ? 'display: block;' : '' }} ">
                        <ul>
                            <li class="hoverable waves-light {{ (\Request::is('marcas') || \Request::is('marcas/*')) ? 'default' : 'simple' }}">
                            <a href="{{route('marcas.index')}}"> <i class="fa fa-trademark "></i><span>Marcas</span></a>
                            </li>
                            <li class="hoverable waves-light {{ (\Request::is('productos') || \Request::is('productos/*')) ? 'default' : 'simple' }}">
                                <a href="{{route('productos.index')}}"><i class="fa fa-boxes"></i><span>Productos</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="header-menu">
                    <span>Negocios</span>
                </li>

                <li class="sidebar-dropdown {{ (\Request::is('clientes') || \Request::is('clientes/*') || \Request::is('colaboradores') || \Request::is('colaboradores/*')) ? 'active default' : 'simple' }}">
                    <a href="#">
                        <i class="fa fa-address-book"></i>
                        <span>Contactos</span>
                    </a>
                    <div class="sidebar-submenu" style="{{ (\Request::is('clientes') || \Request::is('clientes/*') || \Request::is('colaboradores') || \Request::is('colaboradores/*')) ? 'display: block;' : '' }} ">
                        <ul>
                            <li class="hoverable waves-light {{ (\Request::is('clientes') || \Request::is('clientes/*')) ? 'default' : 'simple' }}">
                            <a href="{{route('clientes.index')}}"> <i class="fa fa-user-tie "></i><span>Clientes</span></a>
                            </li>
                            <li class="hoverable waves-light {{ (\Request::is('colaboradores') || \Request::is('colaboradores/*')) ? 'default' : 'simple' }}">
                                <a href="{{route('colaboradores.index')}}"><i class="fa fa-user-cog"></i><span>Colaboradores</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown {{ (\Request::is('servicios') || \Request::is('servicios/*') || \Request::is('ordenes') || \Request::is('ordenes/*')) ? 'active default' : 'simple' }}">
                    <a href="#">
                        <i class="fa fa-people-carry"></i>
                        <span>Actividades</span>
                    </a>
                    <div class="sidebar-submenu" style="{{ (\Request::is('servicios') || \Request::is('servicios/*') || \Request::is('ordenes') || \Request::is('ordenes/*')) ? 'display: block;' : '' }} ">
                        <ul>
                            <li class="hoverable waves-light {{ (\Request::is('servicios') || \Request::is('servicios/*')) ? 'default' : 'simple' }}">
                            <a href="{{route('servicios.index')}}"> <i class="fa fa-cogs "></i><span>Servicios</span></a>
                            </li>
                            <li class="hoverable waves-light {{ (\Request::is('ordenes') || \Request::is('ordenes/*')) ? 'default' : 'simple' }}">
                                <a href="{{route('ordenes.index')}}"><i class="fa fa-business-time"></i><span>Ordenes</span></a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endrole
            </ul>
        </div>
        <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    <div class="sidebar-footer">
            <div class="dropdown">
                    <a href="#" class="" id="dropdownMenuMessage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-store"></i>
                    </a>
                    <div class="dropdown-menu messages" aria-labelledby="dropdownMenuMessage">
                        <div class="messages-header">
                            <i class="fa fa-store"></i>
                            Tienda
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('store.productos') }}">
                            <div class="message-content">
                                <div class="pic">
                                        <i class="fa fa-2x fa-boxes indigo-text"></i>
                                </div>
                                <div class="content">
                                    <div class="message-title">
                                        <strong> Productos</strong>
                                    </div>
                                    <div class="message-detail">Lista de productos en venta</div>
                                </div>
                            </div>
        
                        </a>
                        <a class="dropdown-item" href="{{ route('store.servicios') }}">
                            <div class="message-content">
                                <div class="pic">
                                        <i class="fa fa-2x fa-cogs indigo-text"></i>
                                </div>
                                <div class="content">
                                    <div class="message-title">
                                        <strong> Servicios</strong>
                                    </div>
                                    <div class="message-detail">Lista de servicios ofrecidos</div>
                                </div>
                            </div>
        
                        </a>
                     
                        <div class="dropdown-divider"></div>
                   
                    </div>
                </div>
        <div class="dropdown">

            <a href="#" class="" id="dropdownMenuNotification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bell"></i>
                <span class="badge badge-pill teal darken-1 notification">3</span>
            </a>
            <div class="dropdown-menu notifications" aria-labelledby="dropdownMenuMessage">
                <div class="notifications-header">
                    <i class="fa fa-bell"></i>
                    Notifications
                </div>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                    <div class="notification-content">
                        <div class="icon">
                            <i class="fas fa-check text-success border border-success"></i>
                        </div>
                        <div class="content">
                            <div class="notification-detail">Lorem ipsum dolor sit amet consectetur adipisicing elit. In totam explicabo</div>
                            <div class="notification-time">
                                6 minutes ago
                            </div>
                        </div>
                    </div>
                </a>
                <a class="dropdown-item" href="#">
                    <div class="notification-content">
                        <div class="icon">
                            <i class="fas fa-exclamation text-info border border-info"></i>
                        </div>
                        <div class="content">
                            <div class="notification-detail">Lorem ipsum dolor sit amet consectetur adipisicing elit. In totam explicabo</div>
                            <div class="notification-time">
                                Today
                            </div>
                        </div>
                    </div>
                </a>
                <a class="dropdown-item" href="#">
                    <div class="notification-content">
                        <div class="icon">
                            <i class="fas fa-exclamation-triangle text-warning border border-warning"></i>
                        </div>
                        <div class="content">
                            <div class="notification-detail">Lorem ipsum dolor sit amet consectetur adipisicing elit. In totam explicabo</div>
                            <div class="notification-time">
                                Yesterday
                            </div>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-center" href="#">View all notifications</a>
            </div>
        </div>
     
        <div class="dropdown">
            <a href="#" class="" id="dropdownMenuMessage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-cog"></i>
                <span class="badge-sonar"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuMessage">
                <a class="dropdown-item" href="#">My profile</a>
                <a class="dropdown-item" href="#">Help</a>
                <a class="dropdown-item" href="#">Setting</a>
            </div>
        </div>
        <div>
            <a onclick="salir()">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                <i class="fa fa-door-open"></i>
            </a>
        </div>
    </div>
</nav>

<!-- sidebar-wrapper  -->

</header>
@endsection
