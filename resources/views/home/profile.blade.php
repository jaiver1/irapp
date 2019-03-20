@extends('layouts.dashboard.main')
@section('template_title')
Perfil de "{{ (Auth::user()->getPersona()->primer_nombre && Auth::user()->getPersona()->primer_apellido) ? Auth::user()->getPersona()->primer_nombre .' '. Auth::user()->getPersona()->primer_apellido : Auth::user()->name }}" | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/dashboard/profile-img.css') }}" type="text/css">
<style type="text/css">
.profile-bg-img{
  background-image: url("{{ asset('img/dashboard/sidebar/bg1.jpg')}}");
}
</style>
@endsection
@include('include.root.usuarios.img', array('usuario'=>Auth::user()))
@include('include.root.usuarios.password', array('usuario'=>Auth::user()))
@section('content')
        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="far fa-user-circle mr-1 fa-lg"></i></span>
                        <a href="{{ route('home') }}">Página principal</a>
                        <span>/</span>
                        <span>Perfil de "{{ (Auth::user()->getPersona()->primer_nombre && Auth::user()->getPersona()->primer_apellido) ? Auth::user()->getPersona()->primer_nombre .' '. Auth::user()->getPersona()->primer_apellido : Auth::user()->name }}"</span>
                    </h4>

                </div>

            </div>
            <!-- Heading -->

         
            <!--Grid row-->
            <div class="row wow fadeIn">

                <!--Grid column-->
                <div class="col-12 col-sm-10 offset-sm-1">

                     <!--Card-->

   <div class="card wow fadeIn hoverable profile-card mb-4 text-center profile-div">
    <div class="z-depth-1-half profile-bg-img ">
        <div class="profile-header">
      <img id="profile-avatar" class="profile-avatar hoverable"
                src="{{ (Auth::user()->imagen) ? asset(Auth::user()->imagen) : asset('img/dashboard/sidebar/user.jpg') }}" 
                alt="{{ (Auth::user()->getPersona()->primer_nombre && Auth::user()->getPersona()->primer_apellido) ? Auth::user()->getPersona()->primer_nombre .' '. Auth::user()->getPersona()->primer_apellido : Auth::user()->name }}" 
                onerror="this.src='{{ asset('img/dashboard/sidebar/user.jpg') }}'"/>
              </div></div>
    <!--Card content-->
    <div class="card-body">
      <!--Title-->
      <h2 class="card-title"><strong>{{ (Auth::user()->getPersona()->primer_nombre && Auth::user()->getPersona()->primer_apellido) ? Auth::user()->getPersona()->primer_nombre .' '. Auth::user()->getPersona()->primer_apellido : Auth::user()->name }}</strong></h2>
      <h4> 
          @if(Auth::user()->roles->count() > 0)
        <span class="hoverable badge
  @switch(Auth::user()->roles->first()->name)
      @case('ROLE_ROOT')
          red
      @break
      @case('ROLE_ADMINISTRADOR')
          indigo
      @break
      @case('ROLE_COLABORADOR')
          teal
      @break
      @default
          blue-grey
      @endswitch
          ">
          <i class="mr-1 fas
          @switch(Auth::user()->roles->first()->name)
      @case('ROLE_ROOT')
          fa-user-secret
      @break
      @case('ROLE_ADMINISTRADOR')
      fa-user-shield  
      @break
      @case('ROLE_COLABORADOR')
      fa-user-cog 
      @break
      @default
      fa-user-tie 
      @endswitch
          "></i>{{Auth::user()->roles->first()->display_name}}</span>
          @else
          <span class="hoverable badge black">
              <i class="mr-1 fas fa-user-times"></i>Sin rol 
        </span>
          @endif
        </h4>
    </div>

    </div>
    <!--/.Card-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->
   
            @yield('password_form')

            @yield('img_form')

            

        </div>

@endsection
@section('js_links')
<script type="text/javascript" src="{{ asset('js/irapp.js') }}"></script>
@yield('img_script')
<script type="text/javascript">
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
@endsection