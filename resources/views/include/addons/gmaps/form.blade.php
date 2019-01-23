@section('gmaps_form')
        <!-- Grid row -->
        <div class="form-row">
            <!-- Grid column -->
            <div class="col-md-6">
                <div class="md-form">
                  
                    <input type="hidden" readonly id="infowindow" value="{{$infowindow}}" name="infowindow" class="form-control validate" maxlength="50">               
                   </div>
                <!-- Material input -->
                <div class="md-form">
        <i class="fas fa-location-arrow prefix"></i>
        <input type="text" readonly required id="latitud" value="{{ old('latitud') ? old('latitud') : (($ubicacion->latitud != null && $ubicacion->latitud != 0 && $ubicacion->latitud != "") ? $ubicacion->latitud : 0 ) }}" name="latitud" class="form-control validate" maxlength="50">
        <label for="latitud" data-error="Error" data-success="Correcto">Latitud *</label>
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
        <i class="fas fa-map-marker-alt prefix"></i>
        <input type="text" readonly required id="longitud" value="{{ old('longitud') ? old('longitud') : (($ubicacion->longitud != null && $ubicacion->longitud != 0 && $ubicacion->longitud != "") ? $ubicacion->longitud : 0) }}" name="longitud" class="form-control validate" maxlength="50">
        <label for="longitud" data-error="Error" data-success="Correcto">Longitud *</label>
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
                    <input id="pac-input" class="mt-2 controls form-control z-depth-1 hoverable" type="search" placeholder="Buscar">
                    <div id="map" class="z-depth-1 hoverable div-border" style="height: 300px"></div>

 </div>
        
            <!-- Grid column -->
            </div>
        <!-- Grid row -->
@endsection
@section('gmaps_links')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDShqXOrTD_donWeWH4OJQwefouQ1mGbz8&libraries=places"
async defer></script>
<!--script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABNZTIj3RqipcAdvc7aZ9YM6Uv_pylqjA&libraries=places"
async defer></script-->

<script type="text/javascript">
// This example adds a search box to a map, using the Google Place Autocomplete
// feature. People can enter geographical searches. The search box will return a
// pick list containing a mix of places and predicted search terms.

// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

function GoogleMap(position,infowindow) {
var location = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
document.getElementById("latitud").value = position.coords.latitude;
document.getElementById("longitud").value = position.coords.longitude;
var map = new google.maps.Map(document.getElementById('map'), {
zoom: 15,
center: location,
panControl: true,
zoomControl: true,
mapTypeControl: true,
scaleControl: true,
streetViewControl: true,
overviewMapControl: true,
rotateControl: true,
mapTypeControlOptions: {
              style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
              position: google.maps.ControlPosition.LEFT_BOTTOM
          },
          streetViewControlOptions: {
              position: google.maps.ControlPosition.RIGHT_BOTTOM
          },
          zoomControlOptions: {
              position: google.maps.ControlPosition.RIGHT_CENTER
          },



mapTypeId: google.maps.MapTypeId.ROADMAP
});
var markers = [];
var image ="{{ asset('img/gmaps/pin.png')  }}";
var image2 ="{{ asset('img/gmaps/goal.png')  }}";

 var infowindow_gmaps = new google.maps.InfoWindow({
    content: "<h6>"+infowindow+"</h6>"
  });


var marker = new google.maps.Marker({
map: map,
position: location,
icon: image,
title:infowindow,
animation:google.maps.Animation.BOUNCE
});

 markers.push(marker);

marker.addListener('click', function() {
  infowindow = document.getElementById("infowindow").value;
  infowindow_gmaps = new google.maps.InfoWindow({
    content: "<strong>"+infowindow+"</strong>"
  });
  infowindow_gmaps.open(map, marker);
  });

google.maps.event.addListener(marker, 'dragend', function(event) {
document.getElementById("latitud").value = event.latLng.lat();
document.getElementById("longitud").value = event.latLng.lng();
});

google.maps.event.addListener(map, 'click', function(event) {
  deleteMarkers();
document.getElementById("latitud").value = event.latLng.lat();
document.getElementById("longitud").value = event.latLng.lng();
addMarker(event.latLng);
});

 // Adds a marker to the map and push to the array.
 function addMarker(location) {
        var marker2 = new google.maps.Marker({
          position: location,
map: map,
icon: image2,
animation:google.maps.Animation.BOUNCE
});
        markers.push(marker2);

        marker2.addListener('click', function() {
  infowindow = document.getElementById("infowindow").value;
  infowindow_gmaps = new google.maps.InfoWindow({
    content: "<strong>"+infowindow+"</strong>"
  });
  infowindow_gmaps.open(map, marker2);
  });
      }

      // Sets the map on all markers in the array.
      function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }

      // Removes the markers from the map, but keeps them in the array.
      function clearMarkers() {
        setMapOnAll(null);
      }

      // Shows any markers currently in the array.
      function showMarkers() {
        setMapOnAll(map);
      }

      // Deletes all markers in the array by removing references to them.
      function deleteMarkers() {
        clearMarkers();
        markers = [];
      }

// Create the search box and link it to the UI element.
var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers3 = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers3.forEach(function(marker) {
            marker.setMap(null);
          });
          markers3 = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            /*
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
           
            markers3.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));
*/
            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });


}


function DefaultLocation(infowindow) {
GoogleMap({ coords: { latitude: 3.5379625380068456, longitude: -76.29720673509519}},infowindow);
}

// show error if location can't be found
function showError() {
DefaultLocation("Ubicacion");
}

$(document).ready(function () {

  try {
  // execute geolocation
var default_latitude = document.getElementById("latitud").value;
var default_longitude = document.getElementById("longitud").value;
var infowindow = document.getElementById("infowindow").value;

if(default_latitude == 0 && default_longitude == 0){      
if (navigator.geolocation) {
navigator.geolocation.getCurrentPosition(GoogleMap, showError);
} else {
DefaultLocation(infowindow);
}
}else{
GoogleMap({ coords: { latitude: default_latitude, longitude: default_longitude}},infowindow);
}
}
catch(err) {
  console.log(err.message);
  DefaultLocation(infowindow);
}
});


</script>
@endsection