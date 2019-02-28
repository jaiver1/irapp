@include('include.addons.gmaps.list', array('ordenes'=>json_encode($ordenes),
'infowindow'=> ((Auth::user()->getPersona()->primer_nombre && Auth::user()->getPersona()->primer_apellido) ? Auth::user()->getPersona()->primer_nombre .' '. Auth::user()->getPersona()->primer_apellido : Auth::user()->name) ))
 
 @section('div_ordenes')
 <!--Grid row-->
 <div class="row">

    <!--Grid column-->
    <div class="col-12">

        <!--Card-->
        <div class="card hoverable"> 
            <!--Card content-->
            <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="views-tab" role="tablist">
                            <li class="nav-item hoverable waves-effect mr-2 mt-2">
                              <a class="nav-link active z-depth-5" id="pills-list-tab" data-toggle="pill" href="#pills-list" role="tab" aria-controls="pills-list" aria-selected="true">
                                <h5> <i class="fas fa-clipboard-list mr-2"></i>Lista</h5></a>
                            </li>
                            <li class="nav-item hoverable waves-effect mr-2 mt-2">
                              <a class="nav-link z-depth-5" id="pills-calendar-tab" data-toggle="pill" href="#pills-calendar" role="tab" aria-controls="pills-calendar" aria-selected="false">
                                  <h5> <i class="fas fa-calendar-alt mr-2"></i>Calendario</h5></a>
                            </li>
                            @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR','ROLE_COLABORADOR'],FALSE))
                            <li class="nav-item hoverable waves-effect mr-2 mt-2">
                                    <a class="nav-link z-depth-5" id="pills-map-tab" data-toggle="pill" href="#pills-map" role="tab" aria-controls="pills-map" aria-selected="false">
                                        <h5> <i class="fas fa-map-marked-alt mr-2"></i>Mapa</h5></a>
                                  </li>
                                  @endif
                             
                                  <div class="btn-group ">
                                        <button type="button" data-toggle="dropdown" aria-haspopup="true"
                                          aria-expanded="false"
                                          class="btn dropdown-toggle right btn-sm mr-2 mt-2 waves-effect hoverable  @switch($estado)
                                                @case('Abierta')
                                                    blue darken-3
                                                @break
                                                @case('Cerrada')
                                                    teal darken-3
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
fa-business-time
@break
@case('Cerrada')
fa-flag-checkered  
@break
@case('Cancelada')
fa-times  
@break
@case('Pendiente')
fa-stopwatch
@break
@default
{{ ($estado) ? 'fa-ban' : 'fa-tasks' }}
@endswitch
"></i>{{  (!$estado || $estado == 'Abierta' || $estado == 'Cerrada' || $estado == 'Cancelada' ||$estado == 'Pendiente') ?  (($estado) ? $estado : 'Mostrar todo') : 'El estado no es valido' }}
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{route($route)}}" class="dropdown-item waves-effect hoverable {{(!$estado) ? 'ocultar' : ''}}" type="button">
                                                        <i class="mr-1 fas fa-lg  fa-tasks danger-text"></i>
                                                        Mostrar todo</a>
                                                @foreach($estados as $key => $item)
                                                <a href="{{route($route,array($item))}}" class="dropdown-item waves-effect hoverable {{($estado == $item) ? 'ocultar' : ''}}" type="button">
                                                        <i class="mr-1 fas fa-lg
                                                        @switch($item)
                                                    @case('Abierta')
                                                        fa-business-time indigo-text
                                                    @break
                                                    @case('Cerrada')
                                                        fa-flag-checkered teal-text 
                                                    @break
                                                    @case('Cancelada')
                                                        fa-times  red-text
                                                    @break
                                                    @default
                                                        fa-stopwatch orange-text
                                                    @endswitch
                                                        "></i>
                                                    {{$item}}</a>
                                                @endforeach
                                               
                                        </div>
                                      </div>

                          </ul>
                    <div class="tab-content" id="pills-tab-views">
                            <div class="tab-pane fade show active" id="pills-list" role="tabpanel" aria-labelledby="pills-list-tab">
                                    <div class="table-responsive">
                                            <!-- Table  -->
                                            <table id="dtordenes" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
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
                  @foreach($ordenes as $key => $orden)
                    <tr class="hoverable">
                      <td>{{$orden->id}}</td>
                      <td>{{$orden->nombre}}</td>  
                      <td> 
                          <span class="h5"><span class="hoverable badge
                            @switch($orden->estado)
                                @case('Abierta')
                                    blue darken-3
                                @break
                                @case('Cerrada')
                                    teal darken-3
                                @break
                                @case('Cancelada')
                                    red darken-3 
                                @break
                                @default
                                    amber darken-3
                                @endswitch
                                    ">
                                    <i class="mr-1 fas
                                    @switch($orden->estado)
                                @case('Abierta')
                                    fa-business-time
                                @break
                                @case('Cerrada')
                                    fa-flag-checkered  
                                @break
                                @case('Cancelada')
                                    fa-times  
                                @break
                                @default
                                    fa-stopwatch 
                                @endswitch
                                    "></i>{{ $orden->estado }}</span></span>
                       </td> 
                      <td> 
                            @if($orden->fecha_fin &&  $orden->estado == "Cerrada")
                        <br/>
                        @endif
                         <span class="h5"><span class="badge blue darken-3 hoverable"><i class="far fa-calendar-alt mr-1"></i>{{ Carbon\Carbon::parse($orden->fecha_inicio)->format('d/m/Y -:- h:i A') }}</span></span>
                        @if($orden->fecha_fin &&  $orden->estado == "Cerrada")
                           <br/> <span class="h5"><span class="badge teal darken-3 hoverable"><i class="far fa-calendar-check mr-1"></i>{{ Carbon\Carbon::parse($orden->fecha_fin)->format('d/m/Y -:- h:i A') }}</span></span>
                        @endif
                      </td> 
                      <td>
                          {{$orden->cliente->persona->primer_nombre}} {{$orden->cliente->persona->segundo_nombre}} {{$orden->cliente->persona->primer_apellido}} {{$orden->cliente->persona->segundo_apellido}}
                      </td>     
                      <td>{{$orden->ciudad->nombre}}</td>  
                      <td>{{$orden->barrio}}</td>
                      <td>{{$orden->direccion}}</td>       
                      <td>
                
                <a href="{{ route('ordenes.show', $orden->id) }}" class="text-primary m-1" 
                                    data-toggle="tooltip" data-placement="bottom" title='Información de la orden "{{ $orden->nombre }}"'>
                                      <i class="fas fa-2x fa-info-circle"></i>
                                            </a>
                                            @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE))
                      <a href="{{ route('ordenes.edit', $orden->id) }}" class="text-warning m-1" 
                                    data-toggle="tooltip" data-placement="bottom" title='Editar la orden "{{ $orden->nombre }}"'>
                                      <i class="fas fa-2x fa-pencil-alt"></i>
                                            </a>
                
                                            <a onclick="eliminar_orden({{ $orden->id }},'{{ $orden->nombre }}')" class="text-danger m-1" 
                                    data-toggle="tooltip" data-placement="bottom" title='Eliminar la orden "{{ $orden->nombre }}"'>
                                      <i class="fas fa-2x fa-trash-alt"></i>
                                            </a>
                                            <form id="eliminar{{ $orden->id }}" method="POST" action="{{ route('ordenes.destroy', $orden->id) }}" accept-charset="UTF-8">
                    <input name="_method" type="hidden" value="DELETE">
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
                            <div class="tab-pane fade" id="pills-calendar" role="tabpanel" aria-labelledby="pills-calendar-tab">
                                <div class='fc-right'>
                                    
<!-- Basic dropdown -->

<div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
<div class="btn-group btn-group-sm" role="group" aria-label="First group">
<a class="btn btn-secondary  btn-sm dropdown-toggle mr-4" type="button" data-toggle="dropdown" aria-haspopup="true"
aria-expanded="false"><i class="fas fa-eye mr-1"></i>Ver</a>

<div class="dropdown-menu">
<a class="dropdown-item disabled" href="#"><i class="fas fa-calendar-alt mr-1"></i>Calendario</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item" href="#" onclick="cambio('agendaDay')">Día</a>
<a class="dropdown-item" href="#" onclick="cambio('agendaWeek')">Semana</a>
<a class="dropdown-item" href="#" onclick="cambio('month')">Mes</a>

<div class="dropdown-divider"></div>
<a class="dropdown-item disabled" href="#"><i class="fas fa-clipboard-list mr-1"></i>Listas</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item" href="#" onclick="cambio('listDay')">Día</a>
<a class="dropdown-item" href="#" onclick="cambio('listWeek')">Semana</a>
<a class="dropdown-item" href="#" onclick="cambio('listMonth')">Mes</a>
<a class="dropdown-item" href="#" onclick="cambio('listYear')">Año</a>
</div>
<!-- Basic dropdown -->
</div>
</div>

                                </div>
                                <div id='calendar'></div>

                            </div>
                            @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR','ROLE_COLABORADOR'],FALSE))
                            <div class="tab-pane fade" id="pills-map" role="tabpanel" aria-labelledby="pills-map-tab">
                          
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