
 @section('div_compras')
 <!--Grid row-->
 <div class="row">

    <!--Grid column-->
    <div class="col-12">

        <!--Card-->
        <div class="card hoverable"> 
            <!--Card content-->
            <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="views-tab" role="tablist">
                        <li class="nav-item hoverable waves-effect mr-2 mt-2"  onclick="localDB_Compra('table');">
                            <a class="nav-link active z-depth-5" id="pills-list-compra-tab" data-toggle="pill" href="#pills-list-compra" role="tab" aria-controls="pills-list-compra" aria-selected="true">
                              <h5> <i class="fas fa-clipboard-list mr-2"></i>Lista</h5></a>
                          </li>
                          <li class="nav-item hoverable waves-effect mr-2 mt-2" onclick="localDB_Compra('calendar');">
                            <a class="nav-link z-depth-5" id="pills-calendar-compra-tab" data-toggle="pill" href="#pills-calendar-compra" role="tab" aria-controls="pills-calendar-compra" aria-selected="false">
                                <h5> <i class="fas fa-calendar-alt mr-2"></i>Calendario</h5></a>
                          </li>
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
                                                @case('Entregado')
indigo
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
fa-handshake
@break
@case('Enviado')
fa-truck-loading 
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
                                                @foreach($estados_compras as $key => $item)
                                                <button onclick="document.location.href='{{route($route,array($item))}}'" class="dropdown-item waves-effect hoverable {{($estado == $item) ? 'ocultar' : ''}}" type="button">
                                                        <i class="mr-1 fa-lg
                                                        @switch($item)
                                                    @case('Abierta')
                                                        far fa-calendar-check teal-text
                                                    @break
                                                    @case('Cancelada')
                                                       far fa-calendar-times  red-text
                                                    @break
                                                    @case('Entregado')
far fa-handshake indigo-text
@break
@case('Enviado')
fas fa-truck-loading cyan-text-d
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
                            <div class="tab-pane fade show active" id="pills-list-compra" role="tabpanel" aria-labelledby="pills-list-compra-tab">
                                   
                         <div class="table-responsive">
                                            <!-- Table  -->
                                            <table id="dtcompras" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
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
                  @foreach($compras as $key => $compra)

                  @php
                  $pay = 0
                  @endphp  
              @foreach($compra->detalles as $key => $detalle)
              @php
                  $pay += ($detalle->cantidad * $detalle->producto->valor_unitario)
                  @endphp  
                  @endforeach  
                    <tr class="hoverable">
                      <td>{{$compra->id}}</td>
                     
                      <td> 
                          <span class="h5"><span class="hoverable badge
                            @switch($compra->estado)
                                @case('Abierta')
                                    teal darken-1
                                @break
                                @case('Cancelada')
                                    red darken-3 
                                @break
                                @case('Entregado')
                                indigo
                                @break
                                @case('Enviado')
                                cyan darken-2
                                @break
                                @default
                                    amber darken-3
                                @endswitch
                                    ">
                                    <i class="mr-1 fas
                                    @switch($compra->estado)
                                @case('Abierta')
                                    fa-calendar-check 
                                @break
                                @case('Cancelada')
                                    fa-calendar-times  
                                @break
                                @case('Entregado')
                                fa-handshake
                                @break
                                @case('Enviado')
                                fa-truck-loading
                                @break
                                @default
                                    fa-stopwatch 
                                @endswitch
                                    "></i>{{ ($compra->estado == "Abierta") ? "Aprobado" : $compra->estado }}</span></span>
                       </td> 
                      <td> 
                         
                         <span class="h5"><span class="badge blue darken-3 hoverable"><i class="far fa-calendar-alt mr-1"></i>{{ Carbon\Carbon::parse($compra->fecha)->format('d/m/Y -:- h:i A') }}</span></span>
                      
                      </td> 
                      <td> <h5><span class="badge badge-success hoverable">
                        @money($pay)
                        </span>
                        </h5>
                      </td>
                      <td>
                          {{$compra->cliente->persona->primer_nombre}} {{$compra->cliente->persona->segundo_nombre}} {{$compra->cliente->persona->primer_apellido}} {{$compra->cliente->persona->segundo_apellido}}
                      </td>     
                      <td>{{$compra->direccion->ciudad->nombre}}</td>  
                      <td>{{$compra->direccion->barrio}}</td>
                      <td>{{$compra->direccion->direccion}}</td>       
                      <td>
                
                <a target="_blank" href="{{ route('compras.info', $compra->id) }}" class="text-primary m-1" 
                                    data-toggle="tooltip" data-placement="bottom" title='Información de la compra "{{ $compra->nombre }}"'>
                                      <i class="fas fa-2x fa-info-circle"></i>
                                            </a>
                  @if($compra->estado == 'Pendiente')
                  <a onclick="pagar_compra({{ $compra->id }},{{ $pay }})" class="text-success m-1" 
                    data-toggle="tooltip" data-placement="bottom" title='Pagar la compra #{{ $compra->id }}'>
                      <i class="fas fa-2x fa-file-invoice-dollar"></i>
                            </a>
                                            <a onclick="cancelar_compra({{ $compra->id }})" class="text-danger m-1" 
                                    data-toggle="tooltip" data-placement="bottom" title='Cancelar la compra #{{ $compra->id }}'>
                                      <i class="far fa-2x fa-calendar-times"></i>
                                            </a>
                                            <form method="POST" id="pagar{{ $compra->id }}" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/">
                                                <input name="merchantId"    type="hidden"  value="508029">
                                                <input name="accountId"     type="hidden"  value="512321">
                                                <input name="description"   type="hidden"  value="Compra de productos en IRAPP">
                                                <input name="referenceCode" type="hidden"  value="IRAPP_{{$compra->id}}">
                                                <input name="amount"        type="hidden"  value="{{$pay}}">
                                                <input name="tax"           type="hidden"  value="0">
                                                <input name="taxReturnBase" type="hidden"  value="0">
                                                <input name="currency"      type="hidden"  value="COP">
                                                <input name="signature"     type="hidden"  value="{{md5('4Vj8eK4rloUd272L48hsrarnUA~508029~IRAPP_'.$compra->id.'~'.$pay.'~COP')}}">
                                                <input name="test"          type="hidden"  value="1">
                                                <input name="buyerEmail"    type="hidden"  value="{{$compra->cliente->persona->usuario->email}}">
                                                <input name="buyerFullName"    type="hidden"  value="{{$compra->cliente->persona->primer_nombre}} {{$compra->cliente->persona->segundo_nombre}} {{$compra->cliente->persona->primer_apellido}} {{$compra->cliente->persona->segundo_apellido}}">
                                                <input name="responseUrl"    type="hidden"  value="{{ route('compras.cancel', $compra->id) }}">
                                                <input name="confirmationUrl"    type="hidden"  value="{{ route('compras.cancel', $compra->id) }}">
                                            </form>
                                            <form id="cancelar{{ $compra->id }}" method="POST" action="{{ route('compras.cancel', $compra->id) }}" accept-charset="UTF-8">
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
                                        <div class="tab-pane fade" id="pills-calendar-compra" role="tabpanel" aria-labelledby="pills-calendar-compra-tab">
                                            <div class='fc-right'>
                                                
            <!-- Basic dropdown -->
            
            <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group btn-group-sm" role="group" aria-label="First group">
            <a class="btn btn-secondary  btn-sm dropdown-toggle mr-4" type="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false"><i class="fas fa-eye mr-1"></i>Ver</a>
            
            <div class="dropdown-menu">
            <a class="dropdown-item disabled" href="#"><i class="fas fa-calendar-alt mr-1"></i>Calendario</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" onclick="cambio_Compra('agendaDay')">Día</a>
            <a class="dropdown-item" href="#" onclick="cambio_Compra('agendaWeek')">Semana</a>
            <a class="dropdown-item" href="#" onclick="cambio_Compra('month')">Mes</a>
            
            <div class="dropdown-divider"></div>
            <a class="dropdown-item disabled" href="#"><i class="fas fa-clipboard-list mr-1"></i>Listas</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" onclick="cambio_Compra('listDay')">Día</a>
            <a class="dropdown-item" href="#" onclick="cambio_Compra('listWeek')">Semana</a>
            <a class="dropdown-item" href="#" onclick="cambio_Compra('listMonth')">Mes</a>
            <a class="dropdown-item" href="#" onclick="cambio_Compra('listYear')">Año</a>
            </div>
            <!-- Basic dropdown -->
            </div>
            </div>
            
                                            </div>
                                            <div id='calendar_compras'></div>
            
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