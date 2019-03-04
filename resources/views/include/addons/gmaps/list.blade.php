@section('gmaps_list')
        

        <div class="form-row">
            <!-- Grid column -->
            <div class="col-md-12">
             {{--@json($JSON_ordenes)--}} 
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

function GoogleMap(position) {
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
var infowindow = "{{ $infowindow }}";
var ruta_info = "{{ route('ordenes.show',array(null)) }}";
var ruta_edit = "{{ route('ordenes.edit',array(null)) }}";
var is_admin = "{{ Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE) }}";
var ordenes = @json($JSON_ordenes);

 var infowindow_gmaps = new google.maps.InfoWindow({
    content: "<h6 style='font-weight:900;'>"+infowindow+"</h6>"
  });


var gps = new google.maps.Marker({
map: map,
position: location,
icon: image,
title:infowindow,
animation:google.maps.Animation.BOUNCE
});

 markers.push(gps);

gps.addListener('click', function() {
  infowindow_gmaps = new google.maps.InfoWindow({
    content: "<strong>"+infowindow+"</strong>"
  });
  infowindow_gmaps.open(map, gps);
  });



 // Adds a marker to the map and push to the array.


    for (var i = 0; i < ordenes.length; i++) {
      var texto_info = "<h6 style='font-weight:900;'>"+ordenes[i].direccion+" ("+ordenes[i].barrio+")</h6>";
      texto_info += "<hr/><strong style='font-weight:900;'>Nombre:</strong> <em style='font-weight:400;'>"+ordenes[i].title+"</em>";
      texto_info += "<br/><strong style='font-weight:900;'>Estado:</strong> <span class='h6'><span class='badge hoverable' style='background-color:"+ordenes[i].color+";'><i class='mr-1 fas "+ordenes[i].icon+"'></i>"+ordenes[i].estado+"</span></span>";
      texto_info += "<br/><strong style='font-weight:900;'>Cliente:</strong> <em style='font-weight:400;'>"+ordenes[i].primer_nombre+" "+ordenes[i].segundo_nombre+" "+ordenes[i].primer_apellido+" "+ordenes[i].segundo_apellido+"</em>";
      texto_info += "<br/><strong style='font-weight:900;'>Ciudad:</strong> <em style='font-weight:400;'>"+ordenes[i].ciudad+" - "+ordenes[i].departamento+" ("+ordenes[i].pais+")</em>";  
      texto_info += "<br/><strong style='font-weight:900;'>Fecha inicio:</strong> <em style='font-weight:400;'>"+ordenes[i].fecha_inicio+"</em>";  
      if(ordenes[i].fecha_fin && ordenes[i].estado == "Cerrada" ){
        texto_info += "<br/><strong style='font-weight:900;'>Fecha fin:</strong> <em style='font-weight:400;'>"+ordenes[i].fecha_fin+"</em>";  
      }
      texto_info += "<hr/><a class='text-primary m-1' target='_blank' href='"+ruta_info+"/"+ordenes[i].id+"'><strong style='font-weight:900;'><i class='fas fa-info-circle'></i>Mas información</strong></a>";
      if(is_admin){
        texto_info += "<a class='text-warning m-1' target='_blank' href='"+ruta_edit+"'><strong style='font-weight:900;'><i class='fas fa-pencil-alt'></i> Editar</strong></a>";
        texto_info += "<a class='text-danger m-1' target='_blank' onclick='eliminar_orden("+ordenes[i].id+",\""+ordenes[i].title+"\")'><strong style='font-weight:900;'><i class='fas fa-trash-alt'></i> Eliminar</strong></a>";
        texto_info = texto_info.replace('//edit','/'+ordenes[i].id+'/edit');
      }
      texto_info = texto_info.replace('null','');
      var marker = new google.maps.Marker({
          position: new google.maps.LatLng(ordenes[i].latitud, ordenes[i].longitud),
map: map,
icon: image2,
title:ordenes[i].direccion+" ("+ordenes[i].barrio+")",
animation:google.maps.Animation.BOUNCE
});
        markers.push(marker);

        marker.addListener('click', function() {
  infowindow_marker = new google.maps.InfoWindow({
    content: texto_info
  });
  infowindow_marker.open(map, marker);
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


function DefaultLocation() {
GoogleMap({ coords: { latitude: 3.5379625380068456, longitude: -76.29720673509519}});
}

// show error if location can't be found
function showError() {
DefaultLocation();
}

$(document).ready(function () {

  try {
  // execute geolocation


if (navigator.geolocation) {
navigator.geolocation.getCurrentPosition(GoogleMap, showError);
} else {
DefaultLocation();
}

}
catch(err) {
  console.log(err.message);
  DefaultLocation();
}
});


</script>
@endsection