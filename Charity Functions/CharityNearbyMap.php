<?php
$db = new mysqli("aws-wordpress-db.cde44m6xn6zq.us-west-2.rds.amazonaws.com","admin","foodalchemist", "bitnami_wordpress");
if ($db->connect_error) {
die("Connection failed: " . $db->connect_error);}
//$result = $db->query( "SELECT * FROM restro_staging where Flag = 1" );
//$result2 = $db->query( "SELECT * FROM restro_staging where Flag = 1" );
$result = $db->query( 
    "SELECT ID as REST_MAP, contact AS FOOD_TYPE , latitude, Longitude FROM charities_staging limit 11;");

$result2 = $db->query( 
"SELECT ID as REST_MAP, contact AS FOOD_TYPE ,  latitude, Longitude FROM charities_staging LIMIT 11;");
?>

<!DOCTYPE html>
<html lang="en-us">
<head>
<title>It shows info windows for donating window</title>
<style>
#map{
width: 100%;
height: 550px;
}
</style>
</head>

<body>

<div id="map"></div>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB797FOd-amryH9f99Oc8OGPGUie7a4Vmw&callback=initMap">
</script>
<script>
function initMap() {
var map;

var center = {lat:-37.8186327 , lng: 144.94507313};
var bounds = new google.maps.LatLngBounds();
var mapOptions = {
mapTypeId: 'roadmap'
};
// Display a map on the web page
map = new google.maps.Map(document.getElementById('map'), {zoom: 0, center:center,
          styles: [
  {
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#242f3e"
      }
    ]
  },
  {
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#746855"
      }
    ]
  },
  {
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#242f3e"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "labels",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "administrative.locality",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#d59563"
      }
    ]
  },
  {
    "featureType": "poi",
    "stylers": [
      {
        "visibility": "simplified"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#d59563"
      }
    ]
  },
  {
    "featureType": "poi.attraction",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi.attraction",
    "elementType": "labels.icon",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi.business",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#263c3f"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "labels.text",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#6b9a76"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#38414e"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#212a37"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#9ca5b3"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#746855"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#1f2835"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#f3d19c"
      }
    ]
  },
  {
    "featureType": "road.local",
    "elementType": "labels",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "transit",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#2f3948"
      }
    ]
  },
  {
    "featureType": "transit.station",
    "stylers": [
      {
        "saturation": 100
      },
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "transit.station",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#d59563"
      },
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#17263c"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#515c6d"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#17263c"
      }
    ]
  }
]});
map.setTilt(50);
var markers = [
<?php if($result->num_rows > 0){
while($row = $result->fetch_assoc()){
echo '["'.$row['REST_MAP'].'", '.$row['latitude'].', '.$row['Longitude'].'],';
}
}
?>
];
//info window content
var infoWindowContent = [
<?php if($result2->num_rows > 0){
while($row = $result2->fetch_assoc()){ ?>
['<div class="info_content">' +
'<p>Charity: <?php echo $row['REST_MAP']; ?></p>' +'<h7>Contact: <?php echo $row['FOOD_TYPE']; ?></h7> '+ '<br>' + 
'</div>'],
<?php }
}
?>
];

// Add multiple markers to map
var infoWindow = new google.maps.InfoWindow(), marker, i;

// Place each marker on the map
for( i = 0; i < markers.length; i++ ) {
var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
bounds.extend(position);
marker = new google.maps.Marker({
position: position,
map: map,
title: markers[i][0],
icon : 'https://i.imgur.com/Dy6FP8O.png'
});

// Add info window to marker
google.maps.event.addListener(marker, 'click', (function(marker, i) {
return function() {
infoWindow.setContent(infoWindowContent[i][0]);
infoWindow.open(map, marker);
}
})(marker, i));
// Center the map to fit all markers on the screen
map.fitBounds(bounds);
}

// Set zoom level
var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
this.setZoom(14);
google.maps.event.removeListener(boundsListener);
});
}

// Load initialize function
google.maps.event.addDomListener(window, 'load', initMap);
</script>

</body>
</html>

<?php 
mysqli_close($db);
?>
