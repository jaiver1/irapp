@extends('layouts.dashboard.main')
@include('actividad.ordenes.form')
@section('template_title')
Editar la orden "{{ $orden->nombre }}" | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')

        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fa fa-object-group mr-1"></i></span> 
                        <a href="{{ route('ordenes.index') }}">Lista de ordenes</a>
                        <span>/</span>
                        <span>Editar la orden "{{ $orden->nombre }}"</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('ordenes.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de ordenes">
                      <i class="fa fa-2x fa-object-group "></i>
                            </a>

                            <a href="{{ route('ordenes.show', $orden->id) }}" class="btn btn-outline-primary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Informacion de la orden "{{ $orden->nombre }}"'>
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
