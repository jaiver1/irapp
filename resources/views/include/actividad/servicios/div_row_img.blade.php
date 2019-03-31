<div class="row">
    @foreach($servicio->imagenes as $key => $imagen)
    <div class="col-md-4 col-sm-6 col-lg-2  mt-3">
        <!-- Card -->
<div class="card card-servicio-img hoverable h-100 z-depth-1">

    <!-- Card image -->
    <a target="_blank" href="{{ asset($imagen->ruta) }}">
    <div class="view overlay zoom hoverable waves-effect z-depth-1">
    <img class="card-img-top img-fluid" src="{{ asset($imagen->ruta) }}" alt="{{ $imagen->nombre }}" onerror=this.src="{{ asset('img/dashboard/servicios/404.png')  }}">
      <a href="#!">
        <div class="mask rgba-white-slight"></div>
      </a>
    </div>
  </a>
  
    <!-- Card content -->
    <div class="card-body">
  <center>
      <!-- Title -->
    <h6 class="card-title truncate-text">{{ $imagen->nombre }}</h6>
     <!-- Button -->  
      <a onclick="eliminar_imagen({{ $imagen->id }} ,'{{$imagen->nombre}}', '{{ route('servicios.deleteImagenes', $imagen->id) }}')" 
        class="btn btn-outline-danger btn-circle waves-effect hoverable">
          <i class="fas fa-2x fa-trash-alt"></i>
                </a>
  </center>
    </div>
  
  </div>
  <!-- Card -->
        
    </div>
    @endforeach
</div>

