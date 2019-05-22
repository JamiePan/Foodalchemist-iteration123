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
        $sql_3 = "SELECT TOKEN FROM FA_CHARITY_USERS WHERE USERNAME = '$_POST[username]'";
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



<html>
<body>

    <?php
        if ($active) {
    ?>
            <h2 style="color: #333333; font-family: ContaxPro, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 40px;"> Let the community help you, <?php echo  $_POST['username']; ?>!</h2>
             <!--<form action= "https://foodalchemist.tk/logout/" method="post"> <input type = "submit" value = "Log Out " 
                style = "color: darkslategray; background-color:lightsalmon; padding: 0%; font-size:11px; width:100px;height: 30px;"/>
            <br>
             -->
            <form autocomplete="off" action = "https://foodalchemist.tk/" method = "POST">
            <div class="input-group">
  	             <input type = "submit" name ="sbm" value = "Log Out" onclick="myFunction()"
style = "color: darkslategray; background-color:limegreen; padding: 0%; font-size:11px; width:140px;height: 30px;"/>

            </div>
            <div id="snackbar">Try again, Charity....</div>
            </form>


    <?php }
    else {
    ?>

            <h2  style ="color: #333333; font-family: ContaxPro, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 40px;"> Invalid Login !</h2>
            <!--   <form action= "https://foodalchemist.tk/charity-login-copy/" method="post">
            <input type = "submit" value = "Log In " style = "color: darkslategray; background-color: lightseagreen; padding: 0%; font-size:11px; width: 80px;height: 30px;"/>
            <br>
             -->
             <form autocomplete="off" action = "https://foodalchemist.tk/charity-login-copy/" method = "POST">
            <dl><div class="input-group">
  	             <input type = "submit" name ="sbm" value = "Log In" onclick="myFunction()"
style = "color: darkslategray; background-color:limegreen; padding: 0%; font-size:11px; width:140px;height: 30px;"/>

            </div>
            <div id="snackbar">Log in again Captain......</div>
            </form>


    <?php } ?>

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
</br>
</html> 
