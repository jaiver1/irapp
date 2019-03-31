@include('include.addons.gmaps.request', array('JSON_solicitudes'=>$JSON_solicitudes,
'infowindow'=> ((Auth::user()->getPersona()->primer_nombre && Auth::user()->getPersona()->primer_apellido) ? Auth::user()->getPersona()->primer_nombre .' '. Auth::user()->getPersona()->primer_apellido : Auth::user()->name) ))
 
 @section('div_solicitudes')
 <!--Grid row-->
 <div class="row">

    <!--Grid column-->
    <div class="col-12">

        <!--Card-->
        <div class="card hoverable"> 
            <!--Card content-->
            <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="views-tab" role="tablist">
                            <li class="nav-item hoverable waves-effect mr-2 mt-2"  onclick="localDB_Solicitud('table');">
                              <a class="nav-link active z-depth-5" id="pills-list-solicitud-tab" data-toggle="pill" href="#pills-list-solicitud" role="tab" aria-controls="pills-list-solicitud" aria-selected="true">
                                <h5> <i class="fas fa-clipboard-list mr-2"></i>Lista</h5></a>
                            </li>
                            <li class="nav-item hoverable waves-effect mr-2 mt-2" onclick="localDB_Solicitud('calendar');">
                              <a class="nav-link z-depth-5" id="pills-calendar-solicitud-tab" data-toggle="pill" href="#pills-calendar-solicitud" role="tab" aria-controls="pills-calendar-solicitud" aria-selected="false">
                                  <h5> <i class="fas fa-calendar-alt mr-2"></i>Calendario</h5></a>
                            </li>
                            @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR','ROLE_COLABORADOR'],FALSE))
                            <li class="nav-item hoverable waves-effect mr-2 mt-2" onclick="localDB_Solicitud('map');">
                                    <a class="nav-link z-depth-5" id="pills-map-solicitud-tab" data-toggle="pill" href="#pills-map-solicitud" role="tab" aria-controls="pills-map-solicitud" aria-selected="false">
                                        <h5> <i class="fas fa-map-marked-alt mr-2"></i>Mapa</h5></a>
                                  </li>
                                  @endif
                             
                                  <div class="btn-group ">
                                        <button type="button" data-toggle="dropdown" aria-haspopup="true"
                                          aria-expanded="false"
                                          class="btn dropdown-toggle right mr-2 mt-2 waves-effect hoverable  @switch($estado)
                                                @case('Abierta')
                                                    teal darken-1
                                                @break
                                                @case('Cancelada')
                                                    red darken-3 
                                                @break
                                                @case('Pendiente')
                                                    amber darken-3
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
@default
{{ ($estado) ? 'fa-ban' : 'fa-tasks' }}
@endswitch
"></i>{{  (!$estado || $estado == 'Abierta' || $estado == 'Cerrada' || $estado == 'Cancelada' ||$estado == 'Pendiente') ?  (($estado) ? (($estado == 'Abierta') ? 'Aprobado' : $estado) : 'Mostrar todo') : 'El estado no es valido' }}
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                                <button onclick="document.location.href='{{route($route)}}'" class="dropdown-item waves-effect hoverable {{(!$estado) ? 'ocultar' : ''}}" type="button">
                                                        <i class="mr-1 fas fa-lg  fa-tasks danger-text"></i>
                                                        Mostrar todo</button>
                                                @foreach($estados_solicitudes as $key => $item)
                                                <button onclick="document.location.href='{{route($route,array($item))}}'" class="dropdown-item waves-effect hoverable {{($estado == $item) ? 'ocultar' : ''}}" type="button">
                                                        <i class="mr-1 fa-lg
                                                        @switch($item)
                                                    @case('Abierta')
                                                        far fa-calendar-check teal-text
                                                    @break
                                                    @case('Cancelada')
                                                       far fa-calendar-times  red-text
                                                    @break
                                                    @default
                                                       fas fa-stopwatch orange-text
                                                    @endswitch
                                                        "></i>
                                                    {{$item}}</button>
                                                @endforeach
                                               
                                        </div>
                                      </div>

                          </ul>
                    <div class="tab-content" id="pills-tab-views">
                            <div class="tab-pane fade show active" id="pills-list-solicitud" role="tabpanel" aria-labelledby="pills-list-solicitud-tab">
                                    <div class="table-responsive">
                                            <!-- Table  -->
                                            <table id="dtsolicitudes" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
                  <thead class="th-color white-text">
                    <tr class="z-depth-2">
                      <th class="th-sm">#
                      </th>
                      <th class="th-sm">Nombre
                      </th>
                      <th class="th-sm">Estado
                      </th>
                      <th class="th-sm">Fecha
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
                  @foreach($solicitudes as $key => $solicitud)
                    <tr class="hoverable">
                      <td>{{$solicitud->id}}</td>
                      <td>{{$solicitud->nombre}}</td>  
                      <td> 
                          <span class="h5"><span class="hoverable badge
                            @switch($solicitud->estado)
                                @case('Abierta')
                                    teal darken-1
                                @break
                                @case('Cancelada')
                                    red darken-3 
                                @break
                                @default
                                    amber darken-3
                                @endswitch
                                    ">
                                    <i class="mr-1 fas
                                    @switch($solicitud->estado)
                                @case('Abierta')
                                    fa-calendar-check 
                                @break
                                @case('Cancelada')
                                    fa-calendar-times  
                                @break
                                @default
                                    fa-stopwatch 
                                @endswitch
                                    "></i>{{ ($solicitud->estado == "Abierta") ? "Aprobado" : $solicitud->estado }}</span></span>
                       </td> 
                      <td> 
                            @if($solicitud->fecha_fin &&  $solicitud->estado == "Cerrada")
                        <br/>
                        @endif
                         <span class="h5"><span class="badge blue darken-3 hoverable"><i class="far fa-calendar-alt mr-1"></i>{{ Carbon\Carbon::parse($solicitud->fecha_inicio)->format('d/m/Y -:- h:i A') }}</span></span>
                        @if($solicitud->fecha_fin &&  $solicitud->estado == "Cerrada")
                           <br/> <span class="h5"><span class="badge teal darken-1 hoverable"><i class="far fa-calendar-check mr-1"></i>{{ Carbon\Carbon::parse($solicitud->fecha_fin)->format('d/m/Y -:- h:i A') }}</span></span>
                        @endif
                      </td> 
                      <td>
                          {{$solicitud->cliente->persona->primer_nombre}} {{$solicitud->cliente->persona->segundo_nombre}} {{$solicitud->cliente->persona->primer_apellido}} {{$solicitud->cliente->persona->segundo_apellido}}
                      </td>     
                      <td>{{$solicitud->direccion->ciudad->nombre}}</td>  
                      <td>{{$solicitud->direccion->barrio}}</td>
                      <td>{{$solicitud->direccion->direccion}}</td>       
                      <td>
                
                <a target="_blank" href="{{ route('solicitudes.show', $solicitud->id) }}" class="text-primary m-1" 
                                    data-toggle="tooltip" data-placement="bottom" title='Información de la solicitud "{{ $solicitud->nombre }}"'>
                                      <i class="fas fa-2x fa-info-circle"></i>
                                            </a>
                                            @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE))
                                            <a onclick="aprobar_solicitud({{ $solicitud->id }},'{{ $solicitud->nombre }}')" class="teal-text m-1" 
                                                data-toggle="tooltip" data-placement="bottom" title='Aprobar la solicitud "{{ $solicitud->nombre }}"'>
                                                  <i class="far fa-2x fa-calendar-check"></i>
                                                        </a>

                            @endif
                                            <a onclick="cancelar_solicitud({{ $solicitud->id }},'{{ $solicitud->nombre }}')" class="text-danger m-1" 
                                    data-toggle="tooltip" data-placement="bottom" title='Cancelar la solicitud "{{ $solicitud->nombre }}"'>
                                      <i class="far fa-2x fa-calendar-times"></i>
                                            </a>
                                            <form id="cancelar{{ $solicitud->id }}" method="POST" action="{{ route('solicitudes.cancel', $solicitud->id) }}" accept-charset="UTF-8">
                    <input name="_method" type="hidden" value="PUT">
                    {{ csrf_field() }}
                </form>
                <form id="aprobar{{ $solicitud->id }}" method="POST" action="{{ route('solicitudes.approve', $solicitud->id) }}" accept-charset="UTF-8">
                    {{ csrf_field() }}
                </form>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                                            <!-- Table  -->
                                            </div>
                            </div>
                            <div class="tab-pane fade" id="pills-calendar-solicitud" role="tabpanel" aria-labelledby="pills-calendar-solicitud-tab">
                                <div class='fc-right'>
                                    
<!-- Basic dropdown -->

<div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
<div class="btn-group btn-group-sm" role="group" aria-label="First group">
<a class="btn btn-secondary  btn-sm dropdown-toggle mr-4" type="button" data-toggle="dropdown" aria-haspopup="true"
aria-expanded="false"><i class="fas fa-eye mr-1"></i>Ver</a>

<div class="dropdown-menu">
<a class="dropdown-item disabled" href="#"><i class="fas fa-calendar-alt mr-1"></i>Calendario</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item" href="#" onclick="cambio_Solicitud('agendaDay')">Día</a>
<a class="dropdown-item" href="#" onclick="cambio_Solicitud('agendaWeek')">Semana</a>
<a class="dropdown-item" href="#" onclick="cambio_Solicitud('month')">Mes</a>

<div class="dropdown-divider"></div>
<a class="dropdown-item disabled" href="#"><i class="fas fa-clipboard-list mr-1"></i>Listas</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item" href="#" onclick="cambio_Solicitud('listDay')">Día</a>
<a class="dropdown-item" href="#" onclick="cambio_Solicitud('listWeek')">Semana</a>
<a class="dropdown-item" href="#" onclick="cambio_Solicitud('listMonth')">Mes</a>
<a class="dropdown-item" href="#" onclick="cambio_Solicitud('listYear')">Año</a>
</div>
<!-- Basic dropdown -->
</div>
</div>

                                </div>
                                <div id='calendar_solicitudes'></div>

                            </div>
                            @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR','ROLE_COLABORADOR'],FALSE))
                            <div class="tab-pane fade" id="pills-map-solicitud" role="tabpanel" aria-labelledby="pills-map-solicitud-tab">
                          
                                @yield('gmaps_list')
                            </div>
@endif
                          </div>
          
            </div>

        </div>
        <!--/.Card-->

    </div>
    <!--Grid column-->

</div>
<!--Grid row-->
@endsection