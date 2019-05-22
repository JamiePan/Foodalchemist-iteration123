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

?>

<html>

<p>&nbspClick quantity to edit donation: </p>
<table id="data_table" class="table table-borderless">
<thead>
<tr>
<th>Id</th>
<th>Food Type</th>
<th>Quantity</th>
<th>Date</th>

</tr>
</thead>
<tbody>

<?php }?>

<?php



$conn = mysqli_connect("aws-wordpress-db.cde44m6xn6zq.us-west-2.rds.amazonaws.com","admin","foodalchemist", "bitnami_wordpress") or die("Connection failed: " . mysqli_connect_error());

    // $sql_9 = "SELECT C.REST_NAME, B.PROPERTY_ID AS RESTNAME FROM FA_REST_USERS A, FA_REST_META B, FA_RESTAURANTS C
    // WHERE A.PROPERTY_ID = B.PROPERTY_ID AND B.REST_ID  = C.REST_ID AND LOWER(A.USERNAME) = LOWER('$_POST[username]')";

    $sql_33 = "SELECT C.REST_NAME AS RESTNAME, B.PROPERTY_ID  AS PID FROM FA_REST_USERS A, FA_REST_META B, FA_RESTAURANTS C
    WHERE A.PROPERTY_ID = B.PROPERTY_ID 
    AND B.REST_ID  = C.REST_ID
    AND LOWER(A.USERNAME) = LOWER('$_POST[username]')";

    $result_33 = mysqli_query($conn,$sql_33);
    $row_33= mysqli_fetch_array($result_33,MYSQLI_ASSOC);



$conn = mysqli_connect("aws-wordpress-db.cde44m6xn6zq.us-west-2.rds.amazonaws.com","admin","foodalchemist", "bitnami_wordpress") or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()) {
printf("Connect failed: %s\n", mysqli_connect_error());
exit();
}

$input = filter_input_array(INPUT_POST);

if ($input['action'] == 'edit') {

            $update_field='';

            if(isset($input['FOOD_QUANT_SHOW'])) {
                $update_field = "FOOD_QUANT_SHOW='".$input['FOOD_QUANT_SHOW']."'";
            } 
            else if(isset($input['FOOD_TYPE'])) {
                $update_field= "FOOD_TYPE='".$input['FOOD_TYPE']."'";
            } 
            

            if($update_field && $input['DONATE_ID']) {
                $sql_query = "UPDATE FA_FOOD_REGO SET $update_field  WHERE DONATE_ID='" . $input['DONATE_ID'] . "'";
                mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
            }

}


$sql_query = "SELECT DONATE_ID, FOOD_TYPE,FOOD_QUANT_SHOW,TIME_STAMP FROM FA_FOOD_REGO WHERE  PROPERTY_ID = '$row_33[PID]' and FOOD_QUANT_SHOW > 0 order by DONATE_ID desc  LIMIT 7 ";
$resultset = mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
if ($active){
while( $developer = mysqli_fetch_assoc($resultset) ) {
?>
<tr id="<?php echo $developer ['DONATE_ID']; ?>">
<td><?php echo $developer ['DONATE_ID']; ?></td>
<td><?php echo $developer ['FOOD_TYPE']; ?></td>
<td><?php echo $developer ['FOOD_QUANT_SHOW']; ?></td>
<td><?php echo $developer ['TIME_STAMP']; ?></td>
</tr>
<?php } ?>
<?php } ?>



</tbody>
</table>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-tabledit@1.0.0/jquery.tabledit.min.js"></script>

<script>
$(document).ready(function(){
        $('#data_table').Tabledit({
            deleteButton: false,
            editButton: false,
            columns: {
            identifier: [0, 'DONATE_ID'],
            editable: [[2, 'FOOD_QUANT_SHOW']]
            },
            hideIdentifier: true
        });
});
</script>   
</html>
