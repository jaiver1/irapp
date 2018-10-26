<!-- Central Modal Large Info-->
 <div class="modal modal-top fade" id="modal_ref" tabindex="-1" role="dialog" aria-labelledby="modal_ref" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-notify modal-secondary" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <h3 class="heading lead"><i class="white-text fa fa-box-open mr-1"></i>Referencia de "{{ $producto->nombre }}"</h3>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
                <div class="text-center">
                    <i class="fa fa-5x mb-3 animated rotateIn {{($producto->tipo_referencia->dimension == '2D') ? 'fa-qrcode' : 'fa-barcode'}}"></i>
                    <h3> Codigo: {{ $producto->tipo_referencia->nombre }} ({{ $producto->tipo_referencia->dimension }})</h3>
                </div>
                <hr/>
                <center>
                  
                    <div class="view overlay hoverable zoom img-border">
  @if($producto->tipo_referencia->dimension == "1D")
                      <img src="{{ 'data:image/png;base64,' .DNS1D::getBarcodePNG($producto->referencia, $producto->tipo_referencia->nombre,3,33,array(58,77,86)) }}" class="img-fluid rounded img-thumbnail" alt="{{ $producto->referencia }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
                      @elseif($producto->tipo_referencia->dimension == "2D")
                      <img src="{{ 'data:image/png;base64,' .DNS2D::getBarcodePNG($producto->referencia, $producto->tipo_referencia->nombre,3,3,array(58,77,86)) }}" class="img-fluid rounded img-thumbnail" alt="{{ $producto->referencia }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
                      @endif
                    </div>
                 
                    <h1> <span class="mt-4 badge badge-secondary hoverable"><i class="white-text fa fa-box-open mr-1"></i>{{ $producto->referencia }}</span><h1>
  </center>

            </div>

            <!--Footer-->
            <div class="modal-footer">
   
                </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<!-- Central Modal Large Info-->
