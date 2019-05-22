<?php

$connect = new PDO("mysql:host=aws-wordpress-db.cde44m6xn6zq.us-west-2.rds.amazonaws.com;dbname=bitnami_wordpress", "admin", "foodalchemist");

 $query = "SELECT CN.Charity_Name, R.RAISE_ID, R.PROPERTY_ID, RECE.RECEIVE_QUANTITY
,R.FOOD_QUANTITY,R.FOOD_TYPE,R.FOOD_NAME,R.DESCRIPTION,R.TIME_STAMP,
ST.Contact FROM FA_CHARITY_NAME CN, FA_CHARITIES C, FA_RAISE_REGO R,
 FA_CHARITY_RECEIVEFOOD RECE,charities_staging ST
 WHERE R.PROPERTY_ID = C.PROPERTY_ID 
 AND C.CHAR_ID = CN.ID and R.FOOD_TYPE = RECE.FOOD_TYPE
 AND ST.ID = CN.Charity_Name;";
 
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $total_row = $statement->rowCount();
 $output = '';
echo '<div class="row">';

 if($total_row > 0)
 {


  foreach($result as $row)
  {
     $pieces = explode("Contact:", $row['Contact']);
     $space = explode(",", $row['Contact']);
$contact = explode(",", $pieces[0]);
$email = explode(" ", $contact[2]);

//echo $rece = $row['RECEIVE_QUANTITY'];
//echo $raise = $row['FOOD_QUANTITY'];
$percent = round(($row['RECEIVE_QUANTITY']/$row['FOOD_QUANTITY'])*100,2);
//echo $como[2];
     //echo $pieces[1]; 
   
   $output .= '
	
 

      <div class="card-body" style="width: 30rem; border-radius: 30px;">
        <header class="w3-container w3-green" style ="border-radius: 15px;">
        <h5 style="font-weight: bold;color:white">🏦 '.$row['Charity_Name'].'</h5>
        </header>
        <h5 class="card-title" style="font-weight:bold">🏷️ Food Type: '. $row['FOOD_TYPE'] .' </br>
 🌈 Event Topic : '. $row['DESCRIPTION'] .'</br>
🥗 Food Name : '. $row['FOOD_NAME'] .'</h5>

<h6>📍&nbsp &nbspAddress : '. $space[0] .'</br>
📞 Contact : '.$email[1] .'</br>
📧 email:  '.$email[2].'</br>
👱 Manager: '.$pieces[1].'  </h6>
<h5 style="font-size:120%;color:red;font-weight:bold">Food Receive Percentage:<h5 style="font-size:120%;color:blue;font-weight:bold">&nbsp&nbsp&nbsp&nbsp'.$percent.'%</h5>

<div class = "outter">
 <div class = "inner">
 </div>
 </div>
     
      </div>


<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">




</br>';

  }
 }

 echo $output;
  echo '</div>';
echo '</div>';
?>

