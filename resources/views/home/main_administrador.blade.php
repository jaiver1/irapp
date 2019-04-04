@section('template_title')
Página principal | {{ config('app.name', 'Laravel') }}
@endsection
@section('css_links')
<script type="text/javascript" src="{{ asset('js/highcharts/highcharts.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/highcharts/highcharts-3d.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/highcharts/modules/exporting.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/highcharts/modules/export-data.js') }}"></script>
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
        <div class="card mb-4 hoverable" style="height: 95%;">

            {{--
            <!-- Card header -->
            <div class="card-header text-center hoverable">
                Alertas
            </div>
        --}}

            <!--Card content-->
            <div class="card-body">

               

            </div>

        </div>
        <!--/.Card-->

        
    </div>
    <!--Grid column-->
                <!--Grid column-->
                <div class="col-md-6 mb-4">

                    <!--Card-->
                    <div class="card mb-4 hoverable">

                        {{--
                        <!-- Card header -->
                        <div class="card-header text-center hoverable">
                            Alertas
                        </div>
                    --}}

                        <!--Card content-->
                        <div class="card-body">

                            <div id="ventas-container"></div>

                        </div>

                    </div>
                    <!--/.Card-->

                    
                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

                <!--Grid row-->
                <div class="row wow fadeIn">
                    <!--Grid column-->
                    <div class="col-md-6 mb-4">
   
                       <!--Card-->
                       <div class="card mb-4 hoverable">
   
                           <!--Card content-->
                           <div class="card-body">
   
                               <div id="ordenes-container"></div>
   
                           </div>
   
                       </div>
                       <!--/.Card-->
   
                       
                   </div>
                   <!--Grid column-->     
  <!--Grid column-->
  <div class="col-md-6 mb-4">

    <!--Card-->
    <div class="card mb-4 hoverable">

        <!--Card content-->
        <div class="card-body">

            <div id="solicitudes-container"></div>

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

array_ordenes = @json($JSON_ordenes);
array_solicitudes = @json($JSON_solicitudes);
array_ventas = @json($JSON_ventas);

Highcharts.chart('ordenes-container', {

chart: {

    type: 'pie',

    options3d: {

        enabled: true,

        alpha: 45

    }

},

title: {

text: 'Ordenes'

},

subtitle: {

    text: 'Cantidad de ordenes registradas'

},

tooltip: {

pointFormat: '<small>{point.y} ordenes</small>'

},

plotOptions: {

    pie: {

        innerSize: 100,

        depth: 45,

        allowPointSelect: true,

  cursor: 'pointer',

  dataLabels: {

    enabled: false

  },

  showInLegend: true

    }

},

series: [{

    name: 'Ordenes',

    colorByPoint: true,

    data:  array_ordenes 

}]

});


Highcharts.chart('solicitudes-container', {

    chart: {

        type: 'pie',

        options3d: {

            enabled: true,

            alpha: 45

        }

    },

    title: {

    text: 'Solicitudes'

  },

  subtitle: {

        text: 'Cantidad de solicitudes registradas'

    },

  tooltip: {

    pointFormat: '<small>{point.y} solicitudes</small>'

  },

    plotOptions: {

        pie: {

            innerSize: 100,

            depth: 45,

            allowPointSelect: true,

      cursor: 'pointer',

      dataLabels: {

        enabled: false

      },

      showInLegend: true

        }

    },

    series: [{

        name: 'Solicitudes',

        colorByPoint: true,

        data:  array_solicitudes 

    }]

});

Highcharts.chart('ventas-container', {

chart: {

    type: 'pie',

    options3d: {

        enabled: true,

        alpha: 45

    }

},

title: {

text: 'Ventas'

},

subtitle: {

    text: 'Cantidad de ventas registradas'

},

tooltip: {

pointFormat: '<small>{point.y} ventas</small>'

},

plotOptions: {

    pie: {

        innerSize: 100,

        depth: 45,

        allowPointSelect: true,

  cursor: 'pointer',

  dataLabels: {

    enabled: false

  },

  showInLegend: true

    }

},

series: [{

    name: 'Ventas',

    colorByPoint: true,

    data:  array_ventas 

}]

});

    </script>


@endsection