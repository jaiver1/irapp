<!-- Central Modal Large Info-->
 <div class="modal modal-top fade" id="modal_img" tabindex="-1" role="dialog" aria-labelledby="modal_img" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-notify modal-secondary" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <h3 class="heading lead"><i class="white-text fas fa-images mr-1"></i>Imagenes de "{{ $producto->nombre }}"</h3>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-5x mb-3 animated rotateIn fa-images"></i>
                    <h3> Imagenes de "{{ $producto->nombre }}"</h3>
                </div>
                <hr/>
            <!--Carousel Wrapper-->
<div id="carousel_imagenes" class="carousel slide carousel-fade hoverable div-border" data-ride="carousel">
    <!--Indicators-->
    <ol class="carousel-indicators">
      <li data-target="#carousel_imagenes" data-slide-to="0" class="active"></li>
      @for ($i = 1; $i < $producto->imagenes->count(); $i++)
      <li data-target="#carousel_imagenes" data-slide-to="{{$i}}"></li>
      @endfor
    </ol>
    <!--/.Indicators-->
    <!--Slides-->
  
    <div class="carousel-item imagen-carousel-item active">
          <!--Mask color-->
          <div class="view imagen-carousel-img">
                 
              @if($producto->imagenes->count())
              <img src="{{ asset($producto->imagenes->first()->ruta) }}" class="img-fluid rounded img-thumbnail"  alt="{{ $producto->imagenes->first()->nombre }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
              @else
              <img src="{{ asset('img/dashboard/productos/404.png')  }}" class="img-fluid rounded img-thumbnail" alt="404">
              @endif
                <div class="mask rgba-white-slight"></div>
          </div>
          <div class="carousel-caption imagen-carousel-caption">
              @if($producto->imagenes->count())
            <h3 class="h3-responsive">{{ $producto->imagenes->first()->nombre }}</h3>
            <p>{{ $producto->imagenes->first()->nombre }}</p>
            @else
            <h3 class="h3-responsive">No hay imagenes</h3>
            <p>El producto "{{ $producto->nombre }}" no tiene imagenes.</p>
            @endif
          </div>
        </div>
    @for ($i = 1; $i < $producto->imagenes->count(); $i++)
  
    <div class="carousel-item imagen-carousel-item">
      <!--Mask color-->
      <div class="view imagen-carousel-img">
              <img src="{{ asset($producto->imagenes[$i]->ruta) }}" class="img-fluid rounded img-thumbnail"  alt="{{ $producto->imagenes[$i]->nombre }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
            <div class="mask rgba-white-slight"></div>
      </div>
      <div class="carousel-caption imagen-carousel-caption">
        <h3 class="h3-responsive">{{ $producto->imagenes[$i]->nombre }}</h3>
        <p>{{ $producto->imagenes[$i]->nombre }}</p>
      </div>
    </div>
  
    @endfor
    <!--/.Slides-->
    <!--Controls-->
    <a class="carousel-control-prev" href="#carousel_imagenes" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Anterior</span>
    </a>
    <a class="carousel-control-next" href="#carousel_imagenes" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Siguiente</span>
    </a>
    <!--/.Controls-->
  </div>
  <!--/.Carousel Wrapper-->
            </div>

            <!--Footer-->
            <div class="modal-footer">
                <small>{{ $producto->descripcion }}</small>
                </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<!-- Central Modal Large Info-->
