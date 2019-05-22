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
                //echo $_POST['source'];
                $result_1 = mysqli_query($conn,$sql_1);
                $row_1 = mysqli_fetch_array($result_1,MYSQLI_ASSOC);
            
                if ($row_1['PROPERTY_ID']) {
                    $active = true;
                }
                else {
                        //echo "you are here: ".$_POST['source'] ;
                        if (! $_POST['source'] ) {
                            // echo '<br>';
                            // echo 'executed statement 4 : USER SESSION DELETED';
                            // echo '<br>';
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
                mysqli_close($conn);
            }
        }  

//echo '<br>';
//echo '------';
//echo ($active);
//echo '------';
//echo '<br>';

?>

<?php
    if ($active) {

        $conn = mysqli_connect("aws-wordpress-db.cde44m6xn6zq.us-west-2.rds.amazonaws.com","admin","foodalchemist", "bitnami_wordpress") or die("Connection failed: " . mysqli_connect_error());

        // $sql_9 = "SELECT C.REST_NAME, B.PROPERTY_ID AS RESTNAME FROM FA_REST_USERS A, FA_REST_META B, FA_RESTAURANTS C
        // WHERE A.PROPERTY_ID = B.PROPERTY_ID AND B.REST_ID  = C.REST_ID AND LOWER(A.USERNAME) = LOWER('$_POST[username]')";

        $sql_9 = "SELECT C.REST_NAME AS RESTNAME, B.PROPERTY_ID  AS PID FROM FA_REST_USERS A, FA_REST_META B, FA_RESTAURANTS C
        WHERE A.PROPERTY_ID = B.PROPERTY_ID 
        AND B.REST_ID  = C.REST_ID
        AND LOWER(A.USERNAME) = LOWER('$_POST[username]')";

        $result_9 = mysqli_query($conn,$sql_9);
        $row_9 = mysqli_fetch_array($result_9,MYSQLI_ASSOC);

        //if ( isset($_POST['sbm']) && (int)$_POST['quantity'] > 0 ){
        if ( isset($_POST['sbm']) && (int) $_POST['quantity'] > 0 ){

            $restname = $_POST['objectname'];
            $foodtyp = $_POST['mydrop1'];
            $quant =  (int)$_POST['quantity'];
            $metric = $_POST['mydrop2'];
            $fooname = $_POST['foo'];
            $pid = (int)$_POST['PID'];

            
            $sql_99 = "INSERT INTO FA_FOOD_REGO (FOOD_QUANTITY,FOOD_NAME,METRIC,FOOD_TYPE,FOOD_QUANT_SHOW,PROPERTY_ID,TIME_STAMP) VALUES 
            ($quant,'$fooname','$metric', '$foodtyp',$quant,$row_9[PID],NOW())";
            $result_99 = mysqli_query($conn,$sql_99);
            $sql_100 = "UPDATE FA_REST_ACTIVE SET DONATE_FLAG = 1 WHERE PROPERTY_ID = $pid";
            $sql_100 = mysqli_query($conn,$sql_100);
        }

        mysqli_close($conn);

?>

        <html>
        <body>  
 
        <form action="?" method="POST" autocomplete="off" style = "padding-left: 16px;">
        <br>

        &nbsp Restaurant Name:&nbsp &nbsp &nbsp
        <input type="text" name="objectname" required value= <?php echo "\"".$row_9['RESTNAME']."\"" ?> style="width:65%;
                border-style:{1px solid ; #e3e3e3;};     
                width: 61%;
                padding: 12px 24px;
                border-radius: 3px;
                outline: 0;
                color: green;"  readonly ><br><br>

        &nbsp Type of food:&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 

        <select name="mydrop1"  placeholder="Pick a type of food." required style="width:65%;
                border-style:{1px solid ; #e3e3e3;};     
                width: 61%;
                padding: 12px 24px;
                border-radius: 3px;
                outline: 0;
                color: green;">
        <option value="Vegetables and legumes/beans" selected>Vegetables and legumes/beans</option>
        <option value="Fruits">Fruits</option>
        <option value="Grain(cereal) foods">Grain(cereal) foods</option>
            <option value="Meat">Meat</option>
            <option value="Milk Product">Milk Product</option>
        <option value="Other">Other</option>
        </select><br><br>

        &nbsp Quantity: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 

        <input type="number" name="quantity" required max = "100" min = "1" style="width:65%;
                border-style:{1px solid ; #e3e3e3;};     
                width: 61%;
                padding: 12px 24px;
                border-radius: 3px;
                outline: 0;
                color: green;"><br><br>
                
        &nbsp Metric:  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp&nbsp



        <select name="mydrop2"  placeholder="Pick your metrics" required style="width:65%;
                border-style:{1px solid ; #e3e3e3;};     
                width: 40%;
                padding: 12px 24px;
                border-radius: 3px;
                outline: 0;
                color: green;">
        
        <option value="take">Take away box</option>
        <option value="kilo">Kilos</option>
            <option value="lit">Litre</option>
            <option value=""></option>
        <option value=""></option>
        </select><br>
                
                
        <br> &nbsp Name of the food: &nbsp&nbsp&nbsp&nbsp
        <input type="text" name="foo" placeholder="Food name (optional)" pattern= "[a-zA-Z0-9]+[a-zA-Z0-9 ]+{1,40}" style="width:65%;
                border-style:{1px solid ; #e3e3e3;};     
                width: 61%;
                padding: 12px 24px;
                border-radius: 3px;
                outline: 0;
                color: green;"><br>
                
                
        <input type="hidden"  name="username" value=<?php echo $_POST['username']; ?>>
        <input type="hidden"  name="source" value="refresh">
        <input type="hidden"  name="PID" value=<?php echo $row_1['PROPERTY_ID']; ?>>
        <br>&nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp&nbsp&nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp&nbsp&nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp&nbsp&nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp&nbsp&nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp&nbsp&nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp&nbsp&nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp&nbsp&nbsp&nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp&nbsp&nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp <input type="submit" name="sbm" value="Donate" style = " align = right; color: darkslategray; background-color: lightseagreen; padding: 0%; font-size:11px; width: 100px;height: 30px;" >

</form>
<br>
</body>
</html> 

<?php

}

?>
