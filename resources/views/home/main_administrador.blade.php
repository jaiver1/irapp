@section('template_title')
Página principal | {{ config('app.name', 'Laravel') }}
@endsection
@section('content')

        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fas fa-home mr-1 fa-lg"></i></span>
                        <a href="{{ route('home') }}">Página principal</a>
                        <span>/</span>
                        <span>Dashboard</span>
                    </h4>
                </div>

            </div>
            <!-- Heading -->

            <!--Grid row-->
            <div class="row wow fadeIn">

                <!--Grid column-->
                <div class="col-md-6 mb-4">

                    <!--Card-->
                    <div class="card mb-4 hoverable">

                        <!-- Card header -->
                        <div class="card-header text-center hoverable">
                            Ordenes
                        </div>

                        <!--Card content-->
                        <div class="card-body">

                            <canvas id="pieChart"></canvas>

                        </div>

                    </div>
                    <!--/.Card-->

                    
                </div>
                <!--Grid column-->

                 <!--Grid column-->
                 <div class="col-md-6 mb-4">

                    <!--Card-->
                    <div class="card mb-4 hoverable">

                        <!-- Card header -->
                        <div class="card-header text-center hoverable">
                            Solicitudes
                        </div>

                        <!--Card content-->
                        <div class="card-body">

                            <canvas id="pieChart"></canvas>

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
<script type="text/javascript" src="{{ asset('js/addons/buttons.colVis.min.js') }}"></script>
<script type="text/javascript">

</script>

@endsection