@extends('layouts.dashboard.main')
@include('root.usuarios.form')
@section('template_title')
Editar un usuario "{{ $usuario->name }}" | {{ config('app.name', 'Laravel') }}
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
                        <span>Editar un usuario "{{ $usuario->name }}"</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de usuarios">
                      <i class="fa fa-2x fa-users"></i>
                            </a>

                            <a href="{{ route('usuarios.show',$usuario->id) }}" class="btn btn-outline-primary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Informacion del usuario "{{ $usuario->name }}"'>
                      <i class="fa fa-2x fa-info"></i>
                            </a>
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

                          <!-- Extended material form grid -->
@yield('crud_form')
<!-- Extended material form grid -->

                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

          
        </div>

@endsection

