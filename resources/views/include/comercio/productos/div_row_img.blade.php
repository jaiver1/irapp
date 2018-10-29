<div class="row">
    @foreach($producto->imagenes as $key => $imagen)
    <div class="col-md-4 col-sm-6 col-lg-2  mt-3">
        <!-- Card -->
<div class="card card-producto-img hoverable h-100 z-depth-1">

    <!-- Card image -->
    <div class="view overlay zoom hoverable waves-effect z-depth-1">
    <img class="card-img-top img-fluid" src="{{ asset($imagen->ruta) }}" alt="{{ $imagen->nombre }}" onerror=this.src="{{ asset('img/dashboard/productos/404.png')  }}">
      <a href="#!">
        <div class="mask rgba-white-slight"></div>
      </a>
    </div>
  
    <!-- Card content -->
    <div class="card-body">
  <center>
      <!-- Title -->
    <h6 class="card-title truncate-text">{{ $imagen->nombre }}</h6>
     <!-- Button -->  
      <a onclick="eliminar_imagen({{ $imagen->id }} ,'{{$imagen->nombre}}', '{{ route('productos.deleteImagenes', $imagen->id) }}')" 
        class="btn btn-outline-danger btn-circle waves-effect hoverable">
          <i class="fa fa-2x fa-trash-alt"></i>
                </a>
  </center>
    </div>
  
  </div>
  <!-- Card -->
        
    </div>
    @endforeach
</div>

