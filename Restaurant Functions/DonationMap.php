<?php  
$db = new mysqli("aws-wordpress-db.cde44m6xn6zq.us-west-2.rds.amazonaws.com","admin","foodalchemist", "bitnami_wordpress");
$ftypes = $db->query("SELECT DISTINCT FOOD_TYPE from FA_FOOD_REGO");
$fquant = $db->query("SELECT DISTINCT FOOD_QUANT_SHOW from FA_FOOD_REGO");  
if(isset($_POST['SubmitButton'])){ //check if form was submitted

$oj_quantity     = $_POST['oj-quantity']; //get input text
$oj_date         = $_POST['oj-date'];

if($oj_date){ $oj_date = date("Y-m-d", strtotime($oj_date));}
$oj_foodtype     = $_POST['oj-foodtype'];
}
?>

<div class="oj-filter-form" >

  <form action="" method="post" name="food_filter" >

    <div class="row" >
     <!-- <?php if($fquant->num_rows > 0):?>  
      <div class="col-lg-4 col-sm-6 gap-bottom">
        <label for="oj-quantity">Available Quantities</label>
        <select name="oj-quantity" class="form-control">
          <option <?php if(!$oj_quantity) echo 'selected="true"'; ?> disabled="disabled">Select</option>
          <?php  while($row = $fquant->fetch_assoc()):?>
          <option <?php if($row["FOOD_QUANT_SHOW"]==$oj_quantity)echo 'selected="selected"'; ?> value="<?php echo $row["FOOD_QUANT_SHOW"]; ?>"><?php echo $row["FOOD_QUANT_SHOW"]; ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <?php endif; ?>-->

<!--       <div class="col-sm-4 gap-bottom">
        <label for="oj-datepicker">Date</label>
        <input id="oj-datepicker" <?php if($oj_date)echo 'value='.date($oj_date); ?> name="oj-date" class="form-control" placeholder="MM/DD/YY"/>
        <script>

            jQuery('#oj-datepicker').datepicker({
                uiLibrary: 'bootstrap4',

            });
        </script>
      </div> -->
<div class="col-sm-3" ></div>
      <?php if($ftypes->num_rows > 0):?>     
          
      <div class="col-lg-4 col-sm-6 gap-bottom">
        <label for="oj-foodtype" style="font-weight:bold;font-size: 15px; color: #000000">Food Category</label>
        <select name="oj-foodtype" class="form-control">
          <option <?php if(!$oj_foodtype)echo 'selected="true"'; ?> disabled="disabled">Select</option>
          <?php  while($row = $ftypes->fetch_assoc()):?>
          <option <?php if($row["FOOD_TYPE"]==$oj_foodtype)echo 'selected="selected"'; ?>  value="<?php echo $row["FOOD_TYPE"]; ?>"><?php echo $row["FOOD_TYPE"]; ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <?php endif; ?>

      <div class="col-lg-4 col-sm-12 gap-bottom top-gap center">
        <input type="submit" value = "Search category" name="SubmitButton" class="oj-filter-btn green"/>
        <input type="button" name="ResetButton" id="oj-reset" value="Select All categories" class="oj-filter-btn red" onclick="ResetForm()"/>
        <script type="text/javascript">
          function ResetForm() {
             var frm = document.getElementsByName('food_filter')[0];
             frm.reset();  // Reset all form data
             frm.submit(); // Submit the form
             return false; // Prevent page refresh
          }
        </script>
      </div>
    </div>
  </form>

</div> 
 
<style>
.oj-filter-form{
      padding:0 15px;
    }
  @media(min-width:992px){
    .oj-filter-form{
      padding:0 50px;
    }
    .top-gap{
      margin-top: 23px;
    }
  }
   .gap-bottom{
      margin-bottom:20px;
    }
  .oj-filter-form label{
    display:block;
    font-weight:normal;
  text-transform:uppercase
  }
  .oj-filter-form .form-control{
   border-radius:0;
    border:2px solid #eee;
height:40px !important;
  }
  .oj-filter-form .form-control:focus{
     border-color:#23A455;
     box-shadow:none;
  }
  .oj-filter-form .center{
    text-align: center;
  }
  .oj-filter-btn{
    
    padding: 10px 25px !important;
    color: #ffffff;
    display: inline-block;
    margin: 0 10px;
  }

  .oj-filter-btn.red{
    background: #f02b2d;
  }
  .oj-filter-btn.red:hover{
    background: #d90f11;
  }
  .oj-filter-btn.blue{
    background: #2b2da5;
  }
  .oj-filter-btn.green:hover{
    background: #2b2da5;
  }
  
</style>
<?php
if ($db->connect_error) {
die("Connection failed: " . $db->connect_error);}
//$result = $db->query( "SELECT * FROM restro_staging where Flag = 1" );
//$result2 = $db->query( "SELECT * FROM restro_staging where Flag = 1" );
$result = $db->query( 
    "SELECT R.REST_NAME,RM.LATITUDE, RM.LONGITUDE, FR.FOOD_TYPE, FR.FOOD_QUANT_SHOW, FR.METRIC 
    FROM FA_REST_ACTIVE RA, FA_REST_META RM, FA_RESTAURANTS R, FA_FOOD_REGO FR
    WHERE RA.PROPERTY_ID = RM.PROPERTY_ID AND R.REST_ID = RM.REST_ID AND FR.PROPERTY_ID = RM.PROPERTY_ID
    AND RA.DONATE_FLAG = 1 and FR.FOOD_QUANT_SHOW > 0;");
$myquery = "SELECT R.REST_NAME,RM.LATITUDE, RM.LONGITUDE, FR.FOOD_TYPE, FR.FOOD_QUANT_SHOW, FR.METRIC , FR.TIME_STAMP
FROM FA_REST_ACTIVE RA, FA_REST_META RM, FA_RESTAURANTS R, FA_FOOD_REGO FR
WHERE RA.PROPERTY_ID = RM.PROPERTY_ID AND R.REST_ID = RM.REST_ID AND FR.PROPERTY_ID = RM.PROPERTY_ID
AND RA.DONATE_FLAG = 1";

if($oj_quantity){
  $myquery .= " AND FR.FOOD_QUANT_SHOW >= '$oj_quantity'";
}else{
  $myquery .= " AND FR.FOOD_QUANT_SHOW >= 1";
}

if($oj_foodtype){
  $myquery .= " AND FR.FOOD_TYPE = '$oj_foodtype'";
}

if($oj_date){
  $myquery .= " AND FR.TIME_STAMP = '$oj_date'";
}


$result2 = $db->query($myquery);
$result  = $db->query($myquery);
// if($oj_foodtype):
// $result2 = $db->query( 
// "SELECT R.REST_NAME,RM.LATITUDE, RM.LONGITUDE, FR.FOOD_TYPE, FR.FOOD_QUANT_SHOW, FR.METRIC , FR.TIME_STAMP
// FROM FA_REST_ACTIVE RA, FA_REST_META RM, FA_RESTAURANTS R, FA_FOOD_REGO FR
// WHERE RA.PROPERTY_ID = RM.PROPERTY_ID AND R.REST_ID = RM.REST_ID AND FR.PROPERTY_ID = RM.PROPERTY_ID
// AND RA.DONATE_FLAG = 1  and  FR.FOOD_QUANT_SHOW > 0 AND FR.FOOD_TYPE = '$oj_foodtype';");

// else:

// $result2 = $db->query( 
// "SELECT R.REST_NAME,RM.LATITUDE, RM.LONGITUDE, FR.FOOD_TYPE, FR.FOOD_QUANT_SHOW, FR.METRIC , FR.TIME_STAMP
// FROM FA_REST_ACTIVE RA, FA_REST_META RM, FA_RESTAURANTS R, FA_FOOD_REGO FR
// WHERE RA.PROPERTY_ID = RM.PROPERTY_ID AND R.REST_ID = RM.REST_ID AND FR.PROPERTY_ID = RM.PROPERTY_ID
// AND RA.DONATE_FLAG = 1  and  FR.FOOD_QUANT_SHOW > 0;");
// endif;

?>
<style>
#map{
width: 100%;
height: 600px;
}
</style>

<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB797FOd-amryH9f99Oc8OGPGUie7a4Vmw&callback=initMap">
</script>
<script>
function initMap() {
var map;
var uluru = {lat: -37.8130703 , lng: 144.9611061 };
var bounds = new google.maps.LatLngBounds();
var mapOptions = {
mapTypeId: 'roadmap'
};
// Display a map on the web page
map = new google.maps.Map(document.getElementById('map'), {zoom: 1, center: uluru,
          styles: [
  {
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#ffffff"
      }
    ]
  },
  {
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#e3f3f9"
      }
    ]
  },
  {
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#ffffff"
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
        "color": "#ffffff"
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
        "color": "#f4fff4"
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
        "color": "#ffffff"
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
        "color": "#ffffff"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#fff4fd"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#f7f1c0"
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
        "color": "#ffffff"
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
        "color": "#ffffff"
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
        "color": "#e8faff"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#e8faff"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#e8faff"
      }
    ]
  }
]});
map.setTilt(50);



var markers = [
<?php if($result->num_rows > 0){
while($row = $result->fetch_assoc()){
echo '["'.$row['REST_NAME'].'", '.$row['LATITUDE'].', '.$row['LONGITUDE'].'],';
}
}
?>
];
//info window content
var infoWindowContent = [
<?php if($result2->num_rows > 0){
while($row = $result2->fetch_assoc()){ ?>
['<div class="info_content">' +
'<p>Restaurant Name: <?php echo $row['REST_NAME']; ?></p>' +'<h7>Food Type: <?php echo $row['FOOD_TYPE']; ?></h7> '+ '<br>'+
'<h7>Quantity: <?php echo $row['FOOD_QUANT_SHOW']; ?> KG</h7>'+
'</div>'],
<?php }
}
?>
];
console.log(markers);
console.log(infoWindowContent);



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
icon : 'http://foodalchemist.tk/wp-content/uploads/2019/05/google-309741_640-1-e1558268420937.png'
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
this.setZoom(13);
google.maps.event.removeListener(boundsListener);
});
}

// Load initialize function
google.maps.event.addDomListener(window, 'load', initMap);
</script>
<?php 
mysqli_close($db);
?>
