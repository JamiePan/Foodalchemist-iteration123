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
            
            // echo '<br>';
            // echo 'executed statement 1 : USER VALIDATED';
            // echo '<br>';
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
                // echo '<br>';
                // echo 'executed statement 2 : USER SESSION CREATED';
                // echo '<br>';
                //header("location: https://foodalchemist.tk/jamie-welcome-phpafter-login/");
            }
   }

    if (!$active) {
        $sql_3 = "SELECT TOKEN FROM FA_CHARITY_USERS WHERE USERNAME = '$_POST[username]'";
        $result_3 = mysqli_query($conn,$sql_3);
        $row_3 = mysqli_fetch_array($result_3,MYSQLI_ASSOC);
        // echo '<br>';
        // echo 'executed statement 3 : USER SESSION VALIDATED ON REFRESH';
        // echo '<br>';
        if ($row_3['TOKEN'] == 1) {
            $active = true;
        }
    }  



//echo '<br>';
// echo '------';
// echo ($active);
// echo '------';
// echo $_POST['username'];
// echo '------';
//echo '<br>';

?>

<?php
    if ($active) {
?>

                <?php
                    
                    $conn = mysqli_connect("aws-wordpress-db.cde44m6xn6zq.us-west-2.rds.amazonaws.com","admin","foodalchemist", "bitnami_wordpress") or die("Connection failed: " . mysqli_connect_error());

                    
                    //$sql_33 = "SELECT C.REST_NAME AS RESTNAME, B.PROPERTY_ID  AS PID FROM FA_REST_USERS A, FA_REST_META B, FA_RESTAURANTS C
                   // WHERE A.PROPERTY_ID = B.PROPERTY_ID 
                    //AND B.REST_ID  = C.REST_ID
                    //AND LOWER(A.USERNAME) = LOWER('$_POST[username]')";

                     $sql_33 = "SELECT CHARITYNAME,PROPERTY_ID FROM FA_CHARITY_USERS WHERE LOWER(USERNAME) = LOWER('$_POST[username]')";

                    $result_33 = mysqli_query($conn,$sql_33);
                    $row_33= mysqli_fetch_array($result_33,MYSQLI_ASSOC);


                    if ($_POST['source'] == 'offline'){

                        //echo "bazzooookaa!!!";
    
                        //$sql_22 = "UPDATE FA_FOOD_REGO SET FOOD_QUANT_SHOW = 0 WHERE PROPERTY_ID = '$row_33[PROPERTY_ID]'";
                        $sql_22 = "UPDATE FA_RAISE_REGO SET FOOD_QUANTITY = 0 WHERE PROPERTY_ID = '$row_33[PROPERTY_ID]'";
                        $sql_11 = "UPDATE FA_CHARITY_USERS SET FOODRAISE_FLAG = 0 WHERE PROPERTY_ID = '$row_33[PROPERTY_ID]'";
    
                        mysqli_query($conn,$sql_22);
                        mysqli_query($conn,$sql_11);
                        mysqli_commit($conn);
                     }

                    //echo $row_33['PID'];

                    $sql_44 = "SELECT count(1) as valint from FA_RAISE_REGO where PROPERTY_ID = '$row_33[PROPERTY_ID]' and FOOD_QUANTITY > 0 ";
                    $result_44 = mysqli_query($conn,$sql_44);
                    $row_44= mysqli_fetch_array($result_44,MYSQLI_NUM);

                                    

                    //echo $row_44[0];

                    if ($row_44[0] > 0) {

                                                    //echo "Enabled" ;
                                            
                                            ?>
                                                    <html>
                                                    <head>

                                                    <style>
                                                    .button {
                                                    border-radius: 4px;
                                                    background-color: #f4511e;
                                                    border: none;
                                                    color: #FFFFFF;
                                                    text-align: center;
                                                    
                                                    padding: 20px;
                                                    width: 200px;
                                                    transition: all 0.5s;
                                                    cursor: pointer;
                                                    margin: 5px;
                                                    }

                                                    .button span {
                                                    cursor: pointer;
                                                    display: inline-block;
                                                    position: relative;
                                                    transition: 0.5s;
                                                    }

                                                    .button span:after {
                                                    content: '\00bb';
                                                    position: absolute;
                                                    opacity: 0;
                                                    top: 0;
                                                    right: -20px;
                                                    transition: 0.5s;
                                                    }

                                                    .button:hover span {
                                                    padding-right: 25px;
                                                    }

                                                    .button:hover span:after {
                                                    opacity: 1;
                                                    right: 0;
                                                    }
                                                    </style>
                                                    </head>
                                                    <body>

                                                    <form action= "?" method="post"> 
                                                    <div class="input-group">
  	&nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp                                                <input type = "submit" name ="sbm" value = "Clear Events" onclick="myFunction()"
style = "color: darkslategray; background-color:limegreen; padding: 0%; font-size:11px; width:140px;height: 30px;"/>
                                                    </div>
                                                    <div id="snackbar">Your raising food event is offline........</div>
                                                    <input type="hidden"  name="username" value=<?php echo $_POST['username']; ?>>
                                                    <input type="hidden"  name="source" value="offline">
                                                    <br>
                                                </form>  
                                                    </body>
                                                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
                                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>       
                                                    <script>
                                                       //snack bar
                                                           function myFunction() {
                                                           var x = document.getElementById("snackbar");
                                                           x.className = "show";
                                                           setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                                                           }

                                                    </script>   
                                                    <style>


     #snackbar {
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
                                            
                                            <?php } 
                else {

                    //echo "Disabled" ;
                ?>

                                                <html>
                                                <head>

                                                <style>
                                                .button {
                                                border-radius: 4px;
                                                background-color: #f4511e;
                                                border: none;
                                                color: #FFFFFF;
                                                text-align: center;
                                                
                                                padding: 20px;
                                                width: 200px;
                                                transition: all 0.5s;
                                                cursor: pointer;
                                                margin: 5px;
                                                }

                                                .button span {
                                                cursor: pointer;
                                                display: inline-block;
                                                position: relative;
                                                transition: 0.5s;
                                                }

                                                .button span:after {
                                                content: '\00bb';
                                                position: absolute;
                                                opacity: 0;
                                                top: 0;
                                                right: -20px;
                                                transition: 0.5s;
                                                }

                                                .button:hover span {
                                                padding-right: 25px;
                                                }

                                                .button:hover span:after {
                                                opacity: 1;
                                                right: 0;
                                                }
                                                </style>
                                                </head>
                                                <body>

                                                <form action= "?" method="post"> 
                                                      <div class="input-group">
  	                                                  <button type="submit" value=" Signin " onclick="myFunction()" disabled>You are offline</button>
                                                      </div>
                                                    
                                                <input type="hidden"  name="username" value=<?php echo $_POST['username']; ?>>
                                                <br>
                                            </form>
                                                </body>
                                                </html>


                <?php } 
                 ?>

<?php } ?>
