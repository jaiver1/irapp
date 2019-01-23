<!-- Central Modal Medium Info -->
<div class="modal fade" id="modal_search_cliente" tabindex="-1" role="dialog" aria-labelledby="modal_search_cli"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-secondary modal-lg" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead"><i class="fas fa-search"></i> Buscar colaborador</p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <div class="text-center">
          <i class="fas fa-user-tie fa-4x mb-3 animated rotateIn text-secondary"></i>
          <h4>  @if ($colaboradores->count() === 1)
            Un colaborador
        @elseif ($colaboradores->count() > 1)
            {{ $colaboradores->count() }} colaboradores
        @else
           No hay colaboradores
        @endif </h4>
          </div>
          <hr/>
        <div class="table-responsive">
          <!-- Table  -->
          <table id="dtclientes" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
<thead class="th-color white-text">
<tr class="z-depth-2">
<th class="th-sm">#
</th>
<th class="th-sm">Cedula
</th>   
<th class="th-sm">Primer nombre
</th>
<th class="th-sm">Segundo nombre
</th>
<th class="th-sm">Primer apellido
</th>
<th class="th-sm">Segundo apellido
</th>
<th class="th-sm">Telefono móvil
</th>
<th class="th-sm">Telefono fijo
</th>
<th class="th-sm">Email
</th>
<th class="th-sm">Ciudad
</th>
<th class="th-sm">Barrio
</th>
<th class="th-sm">Dirección
</th>
<th class="th-sm">Cuenta banco
</th>
<th class="th-sm">Acciones
</th>


</tr>
</thead>
<tbody>
@foreach($colaboradores as $key => $colaborador)
<tr class="hoverable">
<td>{{$colaborador->id}}</td>
<td>{{$colaborador->cedula}}</td>
<td>{{$colaborador->primer_nombre}}</td>
<td>{{$colaborador->segundo_nombre}}</td>
<td>{{$colaborador->primer_apellido}}</td>
<td>{{$colaborador->segundo_apellido}}</td>
<td>{{$colaborador->telefono_movil}}</td>
<td>{{$colaborador->telefono_fijo}}</td>
<td>{{$colaborador->email}}</td>
<td>{{$colaborador->ciudad}}</td>
<td>{{$colaborador->barrio}}</td>
<td>{{$colaborador->direccion}}</td>
<td>{{$colaborador->cuenta_banco}}</td>
<td>
  <a href="#" onclick="seleccionar_cliente({{$colaborador->id}},'{{$colaborador->primer_nombre}} {{$colaborador->primer_apellido}}','{{$colaborador->primer_nombre}} {{$colaborador->segundo_nombre}} {{$colaborador->primer_apellido}} {{$colaborador->segundo_apellido}}')" class="text-success m-1" 
    data-toggle="tooltip" data-placement="bottom" title='Seleccionar colaborador "{{$colaborador->primer_nombre}} {{$colaborador->primer_apellido}}"'>
      <i class="fas fa-2x fa-check-circle"></i>
            </a>
</td>
</tr>
@endforeach
</tbody>
</table>
          <!-- Table  -->
          </div>
      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- Central Modal Medium Info-->