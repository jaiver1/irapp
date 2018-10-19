@extends('layouts.dashboard.main')
@include('dato_basico.tipos_medidas.form')
@section('template_title')
Editar un tipo de medida "{{ $tipo_medida->nombre }}" | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')

        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fa fa-balance-scale mr-1"></i></span>
                        <a href="{{ route('tipos_medidas.index') }}">Lista de tipos de medidas</a>
                        <span>/</span>
                        <span>Editar un tipo de medida "{{ $tipo_medida->nombre }}"</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('tipos_medidas.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de tipos de medidas">
                      <i class="fa fa-2x fa-balance-scale"></i>
                            </a>

                            <a href="{{ route('tipos_medidas.show', $tipo_medida->id) }}" class="btn btn-outline-primary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Informacion del tipo de medida "{{ $tipo_medida->nombre }}"'>
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

