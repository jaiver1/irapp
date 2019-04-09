@section('gmaps_list')
        

        <div class="form-row">
            <!-- Grid column -->
            <div class="col-md-12">
             {{--@json($JSON_ventas)--}} 
                    <div id="map_ventas" class="z-depth-1 hoverable div-border" style="height: 400px"></div>

 </div>
        
            <!-- Grid column -->
            </div>
        <!-- Grid row -->
@endsection
@section('gmaps_links')

<!--script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDShqXOrTD_donWeWH4OJQwefouQ1mGbz8&libraries=places"
async defer></script-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABNZTIj3RqipcAdvc7aZ9YM6Uv_pylqjA&libraries=places"
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
var map = new google.maps.Map(document.getElementById('map_ventas'), {
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
var details = [];
var image ="{{ asset('img/gmaps/pin.png')  }}";
var image2 ="{{ asset('img/gmaps/goal.png')  }}";
var infowindow = "{{ $infowindow }}";
var ruta_info = "{{ route('ventas.show',array(null)) }}";
var ventas = @json($JSON_ventas);

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


gps.addListener('click', function() {
  infowindow_gmaps = new google.maps.InfoWindow({
    content: "<strong>"+infowindow+"</strong>"
  });
  infowindow_gmaps.open(map, gps);
  });

  gps.setMap(map)

  var timer = setInterval(localize, 3000);

function localize() {
  try {
if (navigator.geolocation) {
navigator.geolocation.getCurrentPosition(change_gps,error_gps);
} 
}
catch(err) {
  console.log(err.message);
}
}

function change_gps(position){
  gps.setMap(null);
  location = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
 gps = new google.maps.Marker({
map: map,
position: location,
icon: image,
title:infowindow,
animation:google.maps.Animation.BOUNCE
});


gps.addListener('click', function() {
  infowindow_gmaps = new google.maps.InfoWindow({
    content: "<strong>"+infowindow+"</strong>"
  });
  infowindow_gmaps.open(map, gps);
  });

  gps.setMap(map)
}

function error_gps(){
  console.log("No se pudo obtener la ubicacion");
}

 // Adds a marker to the map and push to the array.


    for (var i = 0; i < ventas.length; i++) {
      var estado = (ventas[i].estado == "Abierta")?'Aprobado':ventas[i].estado;
      var texto_info = "<h6 style='font-weight:900;'>"+ventas[i].direccion+" ("+ventas[i].barrio+")</h6>";
      texto_info += "<hr/><strong style='font-weight:900;'>Venta #</strong> <em style='font-weight:400;'>"+ventas[i].title+"</em>";
      texto_info += "<br/><strong style='font-weight:900;'>Estado:</strong> <span class='h6'><span class='badge hoverable' style='background-color:"+ventas[i].color+";'><i class='mr-1 fas "+ventas[i].icon+"'></i>"+estado+"</span></span>";
      texto_info += "<br/><strong style='font-weight:900;'>Cliente:</strong> <em style='font-weight:400;'>"+ventas[i].primer_nombre+" "+ventas[i].segundo_nombre+" "+ventas[i].primer_apellido+" "+ventas[i].segundo_apellido+"</em>";
      texto_info += "<br/><strong style='font-weight:900;'>Ciudad:</strong> <em style='font-weight:400;'>"+ventas[i].ciudad+" - "+ventas[i].departamento+" ("+ventas[i].pais+")</em>";  
      texto_info += "<br/><strong style='font-weight:900;'>Fecha:</strong> <em style='font-weight:400;'>"+ventas[i].fecha+"</em>";  
      texto_info += "<hr/><a class='text-primary m-1' target='_blank' href='"+ruta_info+"/"+ventas[i].id+"'><strong style='font-weight:900;'><i class='fas fa-info-circle'></i>Mas información</strong></a>";
      if(ventas[i].estado == "Pendiente"){
texto_info += "<a class='text-danger m-1' target='_blank' onclick='cancelar_venta("+ventas[i].id+",\""+ventas[i].title+"\")'><strong style='font-weight:900;'><i class='far fa-calendar-times'></i> Cancelar</strong></a>";
      }

      else if(ventas[i].estado == "Abierta"){
texto_info += "<a class='cyan-text-d m-1' target='_blank' onclick='enviar_venta("+ventas[i].id+",\""+ventas[i].title+"\")'><strong style='font-weight:900;'><i class='fas fa-dolly'></i> Enviar</strong></a>";
      }
      else if(ventas[i].estado == "Enviado"){
texto_info += "<a class='teal-text m-1' target='_blank' onclick='entregar_venta("+ventas[i].id+",\""+ventas[i].title+"\")'><strong style='font-weight:900;'><i class='fas fa-people-carry'></i> Entregar</strong></a>";
      }
      texto_info = texto_info.replace('null','');
      var marker = new google.maps.Marker({
          position: new google.maps.LatLng(ventas[i].latitud, ventas[i].longitud),
map: map,
icon: image2,
title:ventas[i].direccion+" ("+ventas[i].barrio+")",
animation:google.maps.Animation.BOUNCE,
info: texto_info
});
        markers.push(marker);

        infoWindow = new google.maps.InfoWindow({ content: texto_info });
        google.maps.event.addListener( marker, 'click', function()  {
          infoWindow.setContent( this.info );
          infoWindow.open( map, this );
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