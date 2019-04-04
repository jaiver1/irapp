
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
                      <th class="th-sm">Fecha
                      </th>
                      <th class="th-sm">Acciones
                      </th>
                   
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($compras as $key => $compra)
                    <tr class="hoverable">
                      <td>{{$compra->id}}</td>    
                      <td> 
                         <span class="h5"><span class="badge blue darken-3 hoverable"><i class="far fa-calendar-alt mr-1"></i>{{ Carbon\Carbon::parse($compra->fecha)->format('d/m/Y -:- h:i A') }}</span></span>
                      </td> 
   
                      <td>
                
                        <a href="{{ route('compras.show',$compra->id) }}" class="text-primary m-1" 
                          data-toggle="tooltip" data-placement="bottom" title='Información de la compra #{{ $compra->id }}'>
                            <i class="fas fa-2x fa-info-circle"></i>
                                  </a>
      
            <a href="{{ route('compras.edit',$compra->id) }}" class="text-warning m-1" 
                          data-toggle="tooltip" data-placement="bottom" title='Editar la compra #{{ $compra->id }}'>
                            <i class="fas fa-2x fa-pencil-alt"></i>
                                  </a>
      
                                  <a onclick="eliminar_compra({{ $compra->id }})" class="text-danger m-1" 
                          data-toggle="tooltip" data-placement="bottom" title='Eliminar la compra #{{ $compra->id }}'>
                            <i class="fas fa-2x fa-trash-alt"></i>
                                  </a>
                                  <form id="eliminar{{ $compra->id }}" method="POST" action="{{ route('compras.destroy', $compra->id) }}" accept-charset="UTF-8">
          <input name="_method" type="hidden" value="DELETE">
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