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
              <!--Carousel Wrapper-->
<div id="carousel_referencias" class="carousel slide carousel-fade" data-ride="carousel">
        <!--Indicators-->
        <ol class="carousel-indicators">
          <li data-target="#carousel_referencias" data-slide-to="0" class="active"></li>
          @for ($i = 1; $i < $tipos_referencias->count(); $i++)
          <li data-target="#carousel_referencias" data-slide-to="{{$i}}"></li>
          @endfor
        </ol>
        <!--/.Indicators-->
        <!--Slides-->
      
        <div class="carousel-item active">
              <!--Mask color-->
              <div class="view">
                     
                    <img src="{{ asset(DNS1D::getBarcodePNGPath($producto->referencia, $tipos_referencias[0]->nombre)) }}" class="d-block w-100" alt="{{ $tipos_referencias[0]->nombre }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
                   
                    <div class="mask rgba-black-slight"></div>
              </div>
              <div class="carousel-caption">
                <h3 class="h3-responsive">Slight mask</h3>
                <p>Third text</p>
              </div>
            </div>
        @for ($i = 1; $i < $tipos_referencias->count(); $i++)
      
        <div class="carousel-item">
          <!--Mask color-->
          <div class="view">
                  @if($tipos_referencias[$i]->dimension == "1D")
                  <img src="{{ asset(DNS1D::getBarcodePNGPath($producto->referencia, $tipos_referencias[$i]->nombre)) }}" class="d-block w-100" alt="{{ $tipos_referencias[$i]->nombre }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
                  @endif
                  @if($tipos_referencias[$i]->dimension == "2D")
                <img src="{{ asset(DNS2D::getBarcodePNGPath($producto->referencia, $tipos_referencias[$i]->nombre)) }}" class="d-block w-100" alt="{{ $tipos_referencias[$i]->nombre }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
                @endif
                <div class="mask rgba-black-slight"></div>
          </div>
          <div class="carousel-caption">
            <h3 class="h3-responsive">{{ $tipos_referencias[$i]->dimension }}</h3>
            <p>{{ $tipos_referencias[$i]->nombre }}</p>
          </div>
        </div>
      
        @endfor
        <!--/.Slides-->
        <!--Controls-->
        <a class="carousel-control-prev" href="#carousel_referencias" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#carousel_referencias" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Siguiente</span>
        </a>
        <!--/.Controls-->
      </div>
      <!--/.Carousel Wrapper-->
            </div>

            <!--Footer-->
            <div class="modal-footer">
                 
                </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<!-- Central Modal Large Info-->
