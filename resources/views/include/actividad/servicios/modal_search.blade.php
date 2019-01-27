<!-- Central Modal Medium Info -->
<div class="modal fade" id="modal_search_servicio" tabindex="-1" role="dialog" aria-labelledby="modal_search_cli"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-secondary modal-lg" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead"><i class="fas fa-search"></i> Buscar servicio</p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <div class="text-center">
          <i class="fas fa-cogs fa-4x mb-3 animated rotateIn text-secondary"></i>
          <h4>  @if ($servicios->count() === 1)
            Un servicio
        @elseif ($servicios->count() > 1)
            {{ $servicios->count() }} servicios
        @else
           No hay servicios
        @endif </h4>
          </div>
          <hr/>
        <div class="table-responsive">
          <!-- Table  -->
          <table id="dtservicios_modal" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
<thead class="th-color white-text">
<tr class="z-depth-2">

</tr>
</thead>
<tbody>
@foreach($servicios as $key => $servicio)
<tr class="hoverable">
    <td>{{$servicio->id}}</td>
    <td>{{$servicio->nombre}}</td>  
    <td> <h5><span class="badge badge-success hoverable">
          @money($servicio->valor_unitario)
          </span>
          </h5>
        </td>
      <td>{{$servicio->descripcion}}</td>
      
<td>
  <a href="#" onclick="seleccionar_servicio({{$servicio->id}},'{{$servicio->nombre}}')" class="text-success m-1" 
    data-toggle="tooltip" data-placement="bottom" title='Seleccionar servicio "{{$servicio->nombre}}"'>
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