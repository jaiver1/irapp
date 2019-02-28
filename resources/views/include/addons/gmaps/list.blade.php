@section('gmaps_list')
        

        <div class="form-row">
            <!-- Grid column -->
            <div class="col-md-12">
                    <div id="map" class="z-depth-1 hoverable div-border" style="height: 400px"></div>

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
  infowindow_gmaps = new google.maps.InfoWindow({
    content: "<strong>"+infowindow+"</strong>"
  });
  infowindow_gmaps.open(map, marker);
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

var infowindow = "{{ $infowindow }}";
     
if (navigator.geolocation) {
navigator.geolocation.getCurrentPosition(GoogleMap, showError);
} else {
DefaultLocation(infowindow);
}

}
catch(err) {
  console.log(err.message);
  DefaultLocation(infowindow);
}
});


</script>
@endsection