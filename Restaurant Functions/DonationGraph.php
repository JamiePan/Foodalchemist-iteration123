<?php

$active = false;
$banner = false;

   $conn = mysqli_connect("aws-wordpress-db.cde44m6xn6zq.us-west-2.rds.amazonaws.com","admin","foodalchemist", "bitnami_wordpress") or die("Connection failed: " . mysqli_connect_error());
    if (mysqli_connect_errno()) {
        //echo "CONNECTION FALIED";
        exit();
    }

   
   if($_SERVER["REQUEST_METHOD"] == "POST") {      
            $username = mysqli_real_escape_string( $conn,$_POST['username']);
            $password = mysqli_real_escape_string( $conn,$_POST['password']);
            
            $sql_1 = "SELECT PROPERTY_ID FROM FA_REST_USERS WHERE USERNAME = '$_POST[username]' AND PASSWORD = '$_POST[password]'";
            $sql_2 = "UPDATE FA_REST_USERS SET TOKEN = 1 WHERE USERNAME = '$_POST[username]'";
            $sql_4 = "UPDATE FA_REST_USERS SET TOKEN = 0 WHERE USERNAME = '$_POST[username]'";
            
            //echo '<br>';
            //echo 'executed statement 1 : USER VALIDATED';
            //echo '<br>';
            $result_1 = mysqli_query($conn,$sql_1);
            $row_1 = mysqli_fetch_array($result_1,MYSQLI_ASSOC);
        
            if ($row_1['PROPERTY_ID']) {
                $active = true;
            }
            else {
                    //echo "you are here: ".$_POST['source'] ;
                    if (! $_POST['source'] ) {
                        //echo '<br>';
                        //echo 'executed statement 4 : USER SESSION DELETED';
                        //echo '<br>';
                        $result_4 = mysqli_query($conn,$sql_4);
                    }
                }
            
            if($active) {
                $result_2 = mysqli_query($conn,$sql_2);
                //echo '<br>';
                //echo 'executed statement 2 : USER SESSION CREATED';
                //echo '<br>';
                //header("location: https://foodalchemist.tk/jamie-welcome-phpafter-login/");
            }
   }

    if (!$active) {
        $sql_3 = "SELECT TOKEN FROM FA_REST_USERS WHERE USERNAME = '$_POST[username]'";
        $result_3 = mysqli_query($conn,$sql_3);
        $row_3 = mysqli_fetch_array($result_3,MYSQLI_ASSOC);
        //echo '<br>';
        //echo 'executed statement 3 : USER SESSION VALIDATED ON REFRESH';
        //echo '<br>';
        if ($row_3['TOKEN'] == 1) {
            $active = true;
        }
    }  



//echo '<br>';
//echo '------';
//echo ($active);
//echo '------';
//echo '<br>';

?>



<?php
if ($active)
{

    $conn = mysqli_connect("aws-wordpress-db.cde44m6xn6zq.us-west-2.rds.amazonaws.com","admin","foodalchemist", "bitnami_wordpress") or die("Connection failed: " . mysqli_connect_error());

    // $sql_9 = "SELECT C.REST_NAME, B.PROPERTY_ID AS RESTNAME FROM FA_REST_USERS A, FA_REST_META B, FA_RESTAURANTS C
    // WHERE A.PROPERTY_ID = B.PROPERTY_ID AND B.REST_ID  = C.REST_ID AND LOWER(A.USERNAME) = LOWER('$_POST[username]')";

    $sql_33 = "SELECT C.REST_NAME AS RESTNAME, B.PROPERTY_ID  AS PID FROM FA_REST_USERS A, FA_REST_META B, FA_RESTAURANTS C
    WHERE A.PROPERTY_ID = B.PROPERTY_ID 
    AND B.REST_ID  = C.REST_ID
    AND LOWER(A.USERNAME) = LOWER('$_POST[username]')";

    $result_33 = mysqli_query($conn,$sql_33);
    $row_33= mysqli_fetch_array($result_33,MYSQLI_ASSOC);

    //echo $row_33['PID'];
 
    $dataPoints = array();
    $con = mysqli_connect("aws-wordpress-db.cde44m6xn6zq.us-west-2.rds.amazonaws.com", "admin", "foodalchemist", "bitnami_wordpress");
    
    $query = mysqli_query($con, "SELECT SUM(FOOD_QUANTITY) AS f_data , 
                                        FOOD_TYPE AS f_name 
                                   FROM FA_FOOD_REGO 
                                   WHERE FOOD_QUANT_SHOW > 0 
                                   AND PROPERTY_ID = '$row_33[PID]'
                                   GROUP BY FOOD_TYPE"
                            );
    
    while ($row = mysqli_fetch_assoc($query)) {
        array_push($dataPoints,  array("y" =>  (int)$row['f_data'], "label" => $row['f_name']));
    }
    
?>


<html>
<head>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "Excess Food Waste"
	},
	axisY: {
		title: "Quantity",
		prefix: "",
		suffix:  ""
	},
	data: [{
		type: "bar",
		yValueFormatString: "####",
		indexLabel: "{y}",
		indexLabelPlacement: "inside",
		indexLabelFontWeight: "bolder",
		indexLabelFontColor: "white",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>

<br>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<br>

</body>
</html>    

<?php } ?>
