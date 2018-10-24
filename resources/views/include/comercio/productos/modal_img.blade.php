<!-- Central Modal Large Info-->
 <div class="modal modal-top fade" id="modal_img" tabindex="-1" role="dialog" aria-labelledby="modal_img" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-notify modal-secondary" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <h3 class="heading lead"><i class="white-text fa fa-images mr-1"></i>Imagenes de "{{ $producto->nombre }}"</h3>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
                <div class="text-center">
                    <i class="fa fa-5x mb-3 animated rotateIn fa-images"></i>
                    <h3> Imagenes de "{{ $producto->nombre }}"</h3>
                </div>
                <hr/>
                <center>
                  
                    <div class="view overlay hoverable zoom img-border">
  @if($producto->tipo_referencia->dimension == "1D")
                      <img src="{{ DNS1D::getBarcodePNGPath($producto->referencia, $producto->tipo_referencia->nombre) }}" class="img-fluid rounded img-thumbnail" alt="{{ $producto->referencia }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
                      @elseif($producto->tipo_referencia->dimension == "2D")
                      <img src="{{ DNS2D::getBarcodePNGPath($producto->referencia, $producto->tipo_referencia->nombre) }}" class="img-fluid rounded img-thumbnail" alt="{{ $producto->referencia }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
                      @endif
                    </div>
               
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
