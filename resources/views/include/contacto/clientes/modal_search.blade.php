<!-- Central Modal Medium Info -->
<div class="modal fade" id="modal_search_cliente" tabindex="-1" role="dialog" aria-labelledby="modal_search_cli"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-secondary modal-lg" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead"><i class="fas fa-search"></i> Buscar cliente</p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <div class="text-center">
          <i class="fas fa-user-tie fa-4x mb-3 animated rotateIn text-secondary"></i>
          <h4>  @if ($clientes->count() === 1)
            Un cliente
        @elseif ($clientes->count() > 1)
            {{ $clientes->count() }} clientes
        @else
           No hay clientes
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
@foreach($clientes as $key => $cliente)
<tr class="hoverable">
<td>{{$cliente->id}}</td>
<td>{{$cliente->cedula}}</td>
<td>{{$cliente->primer_nombre}}</td>
<td>{{$cliente->segundo_nombre}}</td>
<td>{{$cliente->primer_apellido}}</td>
<td>{{$cliente->segundo_apellido}}</td>
<td>{{$cliente->telefono_movil}}</td>
<td>{{$cliente->telefono_fijo}}</td>
<td>{{$cliente->email}}</td>
<td>{{$cliente->ciudad}}</td>
<td>{{$cliente->barrio}}</td>
<td>{{$cliente->direccion}}</td>
<td>{{$cliente->cuenta_banco}}</td>
<td>
  <a href="javascript:void(0)" onclick="seleccionar_cliente({{$cliente->id}},'{{$cliente->primer_nombre}} {{$cliente->primer_apellido}}','{{$cliente->primer_nombre}} {{$cliente->segundo_nombre}} {{$cliente->primer_apellido}} {{$cliente->segundo_apellido}}')" class="text-success m-1" 
    data-toggle="tooltip" data-placement="bottom" title='Seleccionar cliente "{{$cliente->primer_nombre}} {{$cliente->primer_apellido}}"'>
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