@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/select2.css') }}" type="text/css"/>
@endsection
@section('crud_form')

@if($editar)
<form method="POST" action="{{ route('ordenes.update', $orden->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="PUT">
    @else
    <form method="POST" action="{{ route('ordenes.store') }}" accept-charset="UTF-8">
@endif

 {{ csrf_field() }}
    <!-- Grid row -->
    <div class="form-row">
        <!-- Grid column -->
        <div class="col-md-6">
            <!-- Material input -->
            <div class="md-form">
    <i class="fa fa-object-group prefix"></i>
    <input type="text" required id="nombre" value="{{ $orden->nombre}}" name="nombre" class="form-control validate" maxlength="50">
    <label for="nombre" data-error="Error" data-success="Correcto">Nombre</label>
</div>
@if ($errors->has('nombre'))
                                            <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                           {{ $errors->first('nombre') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
                                
                                @endif
        </div>
    
        <!-- Grid column -->
        </div>
    <!-- Grid row -->

        <!-- Grid row -->
        <div class="form-row">
            <!-- Grid column -->
            <div class="col-md-6">
                <!-- Material input -->
                <div class="md-form">
        <i class="fa fa-location-arrow prefix"></i>
        <input type="text" readonly required id="latitud" value="{{ ($orden->latitud) ? $orden->latitud : 0}}" name="latitud" class="form-control validate" maxlength="50">
        <label for="latitud" data-error="Error" data-success="Correcto">Latitud</label>
    </div>
    @if ($errors->has('latitud'))
                                                <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                               {{ $errors->first('latitud') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
                                    
                                    @endif
            </div>
        
            <!-- Grid column -->
             <!-- Grid column -->
             <div class="col-md-6">
                <!-- Material input -->
                <div class="md-form">
        <i class="fa fa-map-marker-alt prefix"></i>
        <input type="text" readonly required id="longitud" value="{{($orden->longitud) ? $orden->longitud : 0}}" name="longitud" class="form-control validate" maxlength="50">
        <label for="longitud" data-error="Error" data-success="Correcto">Longitud</label>
    </div>
    @if ($errors->has('longitud'))
                                                <div class="hoverable waves-light alert alert-danger alert-dismissible fade show" role="alert">
                                               {{ $errors->first('longitud') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
                                    
                                    @endif
            </div>
        
            <!-- Grid column -->
            </div>
        <!-- Grid row -->

        <div class="form-row">
            <!-- Grid column -->
            <div class="col-md-12">
                    <input id="pac-input" class="controls" type="text" placeholder="Buscar">
                    <div id="map_canvas" class="z-depth-1 hoverable" style="height: 300px"></div>

 </div>
        
            <!-- Grid column -->
            </div>
        <!-- Grid row -->

    <button type="submit" class="mt-4 waves-effect btn {{($editar) ? 'btn-warning' : 'btn-success'}} btn-md hoverable">
    <i class="fa fa-2x {{($editar) ? 'fa-pencil-alt' : 'fa-plus'}}"></i> {{($editar) ? 'Editar' : 'Registrar'}}
    </button>
</form>
@endsection
@section('js_links')
<script type="text/javascript" src="{{ asset('js/addons/select2.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCckQKZIikbUS_jT0ouJ2rTIGPINIm0F1c&v=3.exp&libraries=places"></script>

<script type="text/javascript">
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
$('#tipo_orden_id').select2({
        placeholder: "Tipos de ordenes",
        theme: "material"
    });
    $(".select2-selection__arrow")
        .addClass("fa fa-chevron-down");


function GoogleMap(position) {
  var location = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
  document.getElementById("latitud").value = position.coords.latitude;
    document.getElementById("longitud").value = position.coords.longitude;
  var map = new google.maps.Map(document.getElementById('map_canvas'), {
    zoom: 8,
    disableDefaultUI: true,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });

  var marker = new google.maps.Marker({
    map: map,
    position: location,
    animation: google.maps.Animation.DROP,
    title: "This is your location"
  });
google.maps.Map.prototype.clearMarkers = function() {
    for(var i=0; i < this.markers.length; i++){
        this.markers[i].setMap(null);
    }
    this.markers = new Array();
};
  
  map.setCenter(location);
  google.maps.event.addListener(marker, 'dragend', function(event) {


    document.getElementById("latitud").value = event.latLng.lat();
    document.getElementById("longitud").value = event.latLng.lng();
  });

  google.maps.event.addListener(map, 'click', function(event) {


    document.getElementById("latitud").value = event.latLng.lat();
    document.getElementById("longitud").value = event.latLng.lng();
    marker.setPosition(event.latLng);
  });
  
   var searchBox = new google.maps.places.SearchBox(document.getElementById('pac-input'));
   map.controls[google.maps.ControlPosition.TOP_CENTER].push(document.getElementById('pac-input'));
   google.maps.event.addListener(searchBox, 'places_changed', function() {
     searchBox.set('map', null);


     var places = searchBox.getPlaces();

     var bounds = new google.maps.LatLngBounds();
     var i, place;
     for (i = 0; place = places[i]; i++) {
       (function(place) {
         var marker = new google.maps.Marker({

           position: place.geometry.location
         });
         marker.bindTo('map', searchBox, 'map');
         google.maps.event.addListener(marker, 'map_changed', function() {
           if (!this.getMap()) {
             this.unbindAll();
           }
         });
         bounds.extend(place.geometry.location);


       }(place));

     }
     map.fitBounds(bounds);
     searchBox.set('map', map);
     map.setZoom(Math.min(map.getZoom(),12));

   });
  
}


function DefaultLocation() {
GoogleMap({ coords: { latitude: 4.60971, longitude: -74.08175}});
}

// show error if location can't be found
function showError() {
    DefaultLocation();
}

// execute geolocation
var default_latitude = document.getElementById("latitud").value;
var default_longitude = document.getElementById("longitud").value;

if(default_latitude == 0 && default_longitude == 0){      
        if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(GoogleMap, showError);
  } else {
   DefaultLocation();
}
    }else{
        GoogleMap({ coords: { latitude: default_latitude, longitude: default_longitude}});
    }


    </script>
@endsection