@include('include.addons.gmaps.sale', array('JSON_ventas'=>$JSON_ventas,
'infowindow'=> ((Auth::user()->getPersona()->primer_nombre && Auth::user()->getPersona()->primer_apellido) ? Auth::user()->getPersona()->primer_nombre .' '. Auth::user()->getPersona()->primer_apellido : Auth::user()->name) ))
 
 
 @section('div_ventas')
 <!--Grid row-->
 <div class="row">

    <!--Grid column-->
    <div class="col-12">

        <!--Card-->
        <div class="card hoverable"> 
            <!--Card content-->
            <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="views-tab" role="tablist">
                        <li class="nav-item hoverable waves-effect mr-2 mt-2"  onclick="localDB_Venta('table');">
                            <a class="nav-link active z-depth-5" id="pills-list-venta-tab" data-toggle="pill" href="#pills-list-venta" role="tab" aria-controls="pills-list-venta" aria-selected="true">
                              <h5> <i class="fas fa-clipboard-list mr-2"></i>Lista</h5></a>
                          </li>
                          <li class="nav-item hoverable waves-effect mr-2 mt-2" onclick="localDB_Venta('calendar');">
                            <a class="nav-link z-depth-5" id="pills-calendar-venta-tab" data-toggle="pill" href="#pills-calendar-venta" role="tab" aria-controls="pills-calendar-venta" aria-selected="false">
                                <h5> <i class="fas fa-calendar-alt mr-2"></i>Calendario</h5></a>
                          </li>
                          <li class="nav-item hoverable waves-effect mr-2 mt-2" onclick="localDB_Venta('map');">
                            <a class="nav-link z-depth-5" id="pills-map-venta-tab" data-toggle="pill" href="#pills-map-venta" role="tab" aria-controls="pills-map-venta" aria-selected="false">
                                <h5> <i class="fas fa-map-marked-alt mr-2"></i>Mapa</h5></a>
                          </li>
                                  <div class="btn-group ">
                                        <button type="button" data-toggle="dropdown" aria-haspopup="true"
                                          aria-expanded="false"
                                          class="btn dropdown-toggle right mr-2 mt-2 waves-effect hoverable  @switch($estado)
                                                @case('Abierta')
                                                    indigo
                                                @break
                                                @case('Cancelada')
                                                    red darken-3 
                                                @break
                                                @case('Pendiente')
                                                    amber darken-3
                                                @break
                                                @case('Entregado')
teal darken-1
@break
@case('Enviado')
cyan darken-2
@break
                                                @default
                                                    btn-secondary
                                                @endswitch">
                                         
<i class="mr-1 fas fa-lg
@switch($estado)
@case('Abierta')
fa-calendar-check 
@break
@case('Cancelada')
fa-calendar-times  
@break
@case('Pendiente')
fa-stopwatch
@break
@case('Entregado')
fa-people-carry
@break
@case('Enviado')
fa-dolly 
@break
@default
{{ ($estado) ? 'fa-ban' : 'fa-tasks' }}
@endswitch
"></i>{{  (!$estado || $estado == 'Abierta' || $estado == 'Cerrada' || $estado == 'Cancelada' ||$estado == 'Pendiente' ||$estado == 'Enviado' ||$estado == 'Entregado') ?  (($estado) ? (($estado == 'Abierta') ? 'Aprobado' : $estado) : 'Mostrar todo') : 'El estado no es valido' }}
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                                <button onclick="document.location.href='{{route($route)}}'" class="dropdown-item waves-effect hoverable {{(!$estado) ? 'ocultar' : ''}}" type="button">
                                                        <i class="mr-1 fas fa-lg  fa-tasks danger-text"></i>
                                                        Mostrar todo</button>
                                                @foreach($estados_ventas as $key => $item)
                                                <button onclick="document.location.href='{{route($route,array($item))}}'" class="dropdown-item waves-effect hoverable {{($estado == $item) ? 'ocultar' : ''}}" type="button">
                                                        <i class="mr-1 fa-lg
                                                        @switch($item)
                                                    @case('Abierta')
                                                        far fa-calendar-check indigo-text
                                                    @break
                                                    @case('Cancelada')
                                                       far fa-calendar-times  red-text
                                                    @break
                                                    @case('Entregado')
fas fa-people-carry teal-text
@break
@case('Enviado')
fas fa-dolly cyan-text-d
@break
                                                    @default
                                                       fas fa-stopwatch orange-text
                                                    @endswitch
                                                        "></i>
                                                    {{($item == 'Abierta') ? 'Aprobado' : $item }}</button>
                                                @endforeach
                                               
                                        </div>
                                      </div>

                          </ul>
                          <div class="tab-content" id="pills-tab-views">
                            <div class="tab-pane fade show active" id="pills-list-venta" role="tabpanel" aria-labelledby="pills-list-venta-tab">
                                   
                         <div class="table-responsive">
                                            <!-- Table  -->
                                            <table id="dtventas" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
                  <thead class="th-color white-text">
                    <tr class="z-depth-2">
                      <th class="th-sm">#
                      </th>
                    
                      <th class="th-sm">Estado
                      </th>
                      <th class="th-sm">Fecha
                      </th>
                      <th class="th-sm">Total
                    </th>
                      <th class="th-sm">Cliente
                      </th>
                      <th class="th-sm">Ciudad
                        </th>
                        <th class="th-sm">Barrio
                        </th>
                        <th class="th-sm">Direccion
                        </th>
                      <th class="th-sm">Acciones
                      </th>
                   
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($ventas as $key => $venta)

                  @php
                  $pay = 0
                  @endphp  
              @foreach($venta->detalles as $key => $detalle)
              @php
                  $pay += ($detalle->cantidad * $detalle->producto->valor_unitario)
                  @endphp  
                  @endforeach  
                    <tr class="hoverable">
                      <td>{{$venta->id}}</td>
                     
                      <td> 
                          <span class="h5"><span class="hoverable badge
                            @switch($venta->estado)
                                @case('Abierta')
                                    indigo
                                @break
                                @case('Cancelada')
                                    red darken-3 
                                @break
                                @case('Entregado')
                                teal darken-1
                                @break
                                @case('Enviado')
                                cyan darken-2
                                @break
                                @default
                                    amber darken-3
                                @endswitch
                                    ">
                                    <i class="mr-1 fas
                                    @switch($venta->estado)
                                @case('Abierta')
                                    fa-calendar-check 
                                @break
                                @case('Cancelada')
                                    fa-calendar-times  
                                @break
                                @case('Entregado')
                                fa-people-carry
                                @break
                                @case('Enviado')
                                fa-dolly
                                @break
                                @default
                                    fa-stopwatch 
                                @endswitch
                                    "></i>{{ ($venta->estado == "Abierta") ? "Aprobado" : $venta->estado }}</span></span>
                       </td> 
                      <td> 
                         
                         <span class="h5"><span class="badge blue darken-3 hoverable"><i class="far fa-calendar-alt mr-1"></i>{{ Carbon\Carbon::parse($venta->fecha)->format('d/m/Y -:- h:i A') }}</span></span>
                      
                      </td> 
                      <td> <h5><span class="badge badge-success hoverable">
                        @money($pay)
                        </span>
                        </h5>
                      </td>
                      <td>
                          {{$venta->cliente->persona->primer_nombre}} {{$venta->cliente->persona->segundo_nombre}} {{$venta->cliente->persona->primer_apellido}} {{$venta->cliente->persona->segundo_apellido}}
                      </td>     
                      <td>{{$venta->direccion->ciudad->nombre}}</td>  
                      <td>{{$venta->direccion->barrio}}</td>
                      <td>{{$venta->direccion->direccion}}</td>       
                      <td>
                
                <a target="_blank" href="{{ route('ventas.show', $venta->id) }}" class="text-primary m-1" 
                                    data-toggle="tooltip" data-placement="bottom" title='Información de la venta #{{ $venta->id }}'>
                                      <i class="fas fa-2x fa-info-circle"></i>
                                            </a>
                  @if($venta->estado == 'Pendiente')
               
                                            <a onclick="cancelar_venta({{ $venta->id }})" class="text-danger m-1" 
                                    data-toggle="tooltip" data-placement="bottom" title='Cancelar la venta #{{ $venta->id }}'>
                                      <i class="far fa-2x fa-calendar-times"></i>
                                            </a>
                                           
                                            <form id="cancelar{{ $venta->id }}" method="POST" action="{{ route('ventas.cancel', $venta->id) }}" accept-charset="UTF-8">
                    <input name="_method" type="hidden" value="PUT">
                    {{ csrf_field() }}
                </form>
               @endif

               @if($venta->estado == 'Abierta')
               
               <a onclick="enviar_venta({{ $venta->id }})" class="cyan-text-d m-1" 
       data-toggle="tooltip" data-placement="bottom" title='Enviar la venta #{{ $venta->id }}'>
         <i class="fas fa-2x fa-dolly"></i>
               </a>
              
               <form id="enviar{{ $venta->id }}" method="POST" action="{{ route('ventas.send', $venta->id) }}" accept-charset="UTF-8">
<input name="_method" type="hidden" value="PUT">
{{ csrf_field() }}
</form>
@endif

@if($venta->estado == 'Enviado')
               
<a onclick="entregar_venta({{ $venta->id }})" class="teal-text m-1" 
data-toggle="tooltip" data-placement="bottom" title='Entregar la venta #{{ $venta->id }}'>
<i class="fas fa-2x fa-people-carry"></i>
</a>

<form id="entregar{{ $venta->id }}" method="POST" action="{{ route('ventas.deliver', $venta->id) }}" accept-charset="UTF-8">
<input name="_method" type="hidden" value="PUT">
{{ csrf_field() }}
</form>
@endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                                            <!-- Table  -->
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-calendar-venta" role="tabpanel" aria-labelledby="pills-calendar-venta-tab">
                                            <div class='fc-right'>
                                                
            <!-- Basic dropdown -->
            
            <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group btn-group-sm" role="group" aria-label="First group">
            <a class="btn btn-secondary  btn-sm dropdown-toggle mr-4" type="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false"><i class="fas fa-eye mr-1"></i>Ver</a>
            
            <div class="dropdown-menu">
            <a class="dropdown-item disabled" href="#"><i class="fas fa-calendar-alt mr-1"></i>Calendario</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" onclick="cambio_Venta('agendaDay')">Día</a>
            <a class="dropdown-item" href="#" onclick="cambio_Venta('agendaWeek')">Semana</a>
            <a class="dropdown-item" href="#" onclick="cambio_Venta('month')">Mes</a>
            
            <div class="dropdown-divider"></div>
            <a class="dropdown-item disabled" href="#"><i class="fas fa-clipboard-list mr-1"></i>Listas</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" onclick="cambio_Venta('listDay')">Día</a>
            <a class="dropdown-item" href="#" onclick="cambio_Venta('listWeek')">Semana</a>
            <a class="dropdown-item" href="#" onclick="cambio_Venta('listMonth')">Mes</a>
            <a class="dropdown-item" href="#" onclick="cambio_Venta('listYear')">Año</a>
            </div>
            <!-- Basic dropdown -->
            </div>
            </div>
            
                                            </div>
                                            <div id='calendar_ventas'></div>
            
                                        </div>
                                        <div class="tab-pane fade" id="pills-map-venta" role="tabpanel" aria-labelledby="pills-map-venta-tab">
                          
                                          @yield('gmaps_list')
                                      </div>
                                    
                                      </div>
            </div>

        </div>
        <!--/.Card-->

    </div>
    <!--Grid column-->

</div>
<!--Grid row-->
@endsection