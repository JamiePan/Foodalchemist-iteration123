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
                
                $sql_1 = "SELECT PROPERTY_ID FROM FA_CHARITY_USERS WHERE USERNAME = '$_POST[username]' AND PASSWORD = '$_POST[password]'";
                $sql_2 = "UPDATE FA_CHARITY_USERS SET TOKEN = 1 WHERE USERNAME = '$_POST[username]'";
                $sql_4 = "UPDATE FA_CHARITY_USERS SET TOKEN = 0 WHERE USERNAME = '$_POST[username]'";


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
            $sql_3 = "SELECT TOKEN FROM FA_CHARITY_USERS WHERE USERNAME = '$_POST[username]'";
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

        $sql_9 = "SELECT CHARITYNAME,PROPERTY_ID FROM FA_CHARITY_USERS WHERE LOWER(USERNAME) = LOWER('$_POST[username]')";

        $result_9 = mysqli_query($conn,$sql_9);
        $row_9 = mysqli_fetch_array($result_9,MYSQLI_ASSOC);

        //if ( isset($_POST['sbm']) && (int)$_POST['quantity'] > 0 ){
        if ( isset($_POST['sbm']) && (int) $_POST['quantity'] > 0 ){
           
            $charityname = $_POST['objectname'];
            $foodtyp = $_POST['mydrop1'];
            $quant =  (int)$_POST['quantity'];
            $fooname = $_POST['foo'];
            $desc = $_POST['desc'];
            $pid = (int)$_POST['PROPERTY_ID'];
           
            $sql_99 = "INSERT INTO FA_RAISE_REGO (DESCRIPTION,FOOD_QUANTITY,FOOD_NAME,FOOD_TYPE,PROPERTY_ID,TIME_STAMP) VALUES 
            ('$desc',$quant,'$fooname','$foodtyp', $pid,NOW())";
          mysqli_query($conn,$sql_99);
            $sql_100 = "UPDATE FA_CHARITY_USERS SET FOODRAISE_FLAG = 1 WHERE PROPERTY_ID = $pid";
          mysqli_query($conn,$sql_100);
        }
        mysqli_close($conn);
?>

        <html>
        <body>       
    </br>               
        <h5 style="color: #333333; font-family: ContaxPro, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 18px;">&nbsp &nbsp &nbsp &nbsp Launch Your Raising Food Event</h5>
        <form action="?" method="POST" autocomplete="off" style = "padding-left: 16px;">


        <span style="color: #333333; font-family: ContaxPro, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 15px;">
        &nbsp 🏦 Charity Name:&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
    </span>
        <input type="text" name="objectname" required value= <?php echo "\"".$row_9['CHARITYNAME']."\"" ?> style="width:65%;
                border-style:{1px solid ; #e3e3e3;};     
                width: 61%;
                padding: 12px 24px;
                border-radius: 3px;
                
                outline: 0;
                color: #3532bc;"  readonly ><br><br>

<span style="color: #333333; font-family: ContaxPro, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 15px;">&nbsp 🏷️ Type of food: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
    </span>
        <select name="mydrop1"  placeholder="Pick a type of food." required style="width:65%;
                border-style:{1px solid ; #e3e3e3;};     
                width: 61%;
                padding: 12px 24px;
                border-radius: 3px;
                
                outline: 0;
                color: #3532bc;">
        <option value="Vegetables and legumes/beans" selected>Vegetables and legumes/beans</option>
        <option value="Fruits">Fruits</option>
        <option value="Grain(cereal) foods">Grain(cereal) foods</option>
            <option value="Meat">Meat</option>
            <option value="Milk Product">Milk Product</option>
        <option value="Other">Other</option>
        </select><br><br>
        <span style="color: #333333; font-family: ContaxPro, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 15px;">
        &nbsp ➕ Goal Quantity: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  
    </span>
        <input type="number" min = "1" max = "100" name="quantity" required value=0 style="width:65%;
                border-style:{1px solid ; #e3e3e3;};     
                width: 61%;
                padding: 12px 24px;
                border-radius: 3px;
                
                outline: 0;
                color: #3532bc;"><br><br>
 
        <br><span style="color: #333333; font-family: ContaxPro, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 15px;"> &nbsp 🎪 Event Description: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
    </span>
        <input type="text" name="desc" placeholder="(required)Input Your Food Raising Events Descriptions" pattern="[A-Za-z0-9!@#$%^&*()_+=\|:;'""?/\|,]{1,160}" style="width:65%;
                border-style:{1px solid ; #e3e3e3;};     
                width: 61%;
                padding: 12px 24px;
                border-radius: 3px;
                outline: 0;
                color: #3532bc;" required><br>     

        <br> <span style="color: #333333; font-family: ContaxPro, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 15px;">&nbsp 🥗 Name of the food: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
    </span>
        <input type="text" required  name="foo" placeholder="(required)Food Name" pattern="[A-Za-z0-9]{1,32}" style="width:65%;
                border-style:{1px solid ; #e3e3e3;};     
                width: 61%;
                padding: 12px 24px;
                border-radius: 3px;
                outline: 0;
                color: #3532bc;"required><br>
                
        <input type="hidden"  name="username" value=<?php echo $_POST['username']; ?>>
        <input type="hidden"  name="source" value="refresh">
        <input type="hidden"  name="PROPERTY_ID" value=<?php echo $row_1['PROPERTY_ID']; ?>>
        <br>&nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp&nbsp&nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp&nbsp&nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp&nbsp&nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp&nbsp&nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp&nbsp&nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp&nbsp&nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp&nbsp&nbsp&nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp&nbsp&nbsp &nbsp &nbsp &nbsp &nbsp
        &nbsp 
        <!--<input type="submit" name="sbm" value="Raise Events" style = " align = right; color: darkslategray; background-color: lightseagreen; padding: 0%; font-size:11px; width: 140px;height: 50px;" >
        -->

        <div class="input-group" style="text-align: left;">
  	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp         <input type = "submit" name ="sbm" value = "Raise Food" onclick="myFunction()"
style = "color: darkslategray; background-color:limegreen; padding: 0%; font-size:11px; width:140px;height: 30px;"/>

        </div>
        <div id="snackbar">Aye Aye Captain</div>

</form>
<br>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>       

<script>
unction myFunction() {
  var x = document.getElementById("snackbar");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

</script>  

<style>

#snackbar{
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  bottom: 30px;
  font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;} 
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;} 
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}
    </style>

</html> 

<?php

}

?>
