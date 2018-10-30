@section('gmaps_form')
        <!-- Grid row -->
        <div class="form-row">
            <!-- Grid column -->
            <div class="col-md-6">
                <!-- Material input -->
                <div class="md-form">
        <i class="fa fa-location-arrow prefix"></i>
        <input type="text" readonly required id="latitud" value="{{ ($ubicacion->latitud) ? $ubicacion->latitud : 0}}" name="latitud" class="form-control validate" maxlength="50">
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
        <input type="text" readonly required id="longitud" value="{{($ubicacion->longitud) ? $ubicacion->longitud : 0}}" name="longitud" class="form-control validate" maxlength="50">
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
                    <div id="map" class="z-depth-1 hoverable div-border" style="height: 300px"></div>

 </div>
        
            <!-- Grid column -->
            </div>
        <!-- Grid row -->
@endsection
@section('gmaps_links')

<script src="https://maps.googleapis.com/maps/api/js?key=&libraries=places"
async defer></script>


<script type="text/javascript">
// This example adds a search box to a map, using the Google Place Autocomplete
// feature. People can enter geographical searches. The search box will return a
// pick list containing a mix of places and predicted search terms.

// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

function GoogleMap(position) {
var location = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
document.getElementById("latitud").value = position.coords.latitude;
document.getElementById("longitud").value = position.coords.longitude;
var map = new google.maps.Map(document.getElementById('map'), {
zoom: 8,
panControl: true,
zoomControl: true,
mapTypeControl: true,
scaleControl: true,
streetViewControl: true,
overviewMapControl: true,
rotateControl: true,
mapTypeId: google.maps.MapTypeId.ROADMAP
});

var marker = new google.maps.Marker({
map: map,
position: location,
animation:google.maps.Animation.BOUNCE
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
 marker = new google.maps.Marker({
   animation:google.maps.Animation.BOUNCE,
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