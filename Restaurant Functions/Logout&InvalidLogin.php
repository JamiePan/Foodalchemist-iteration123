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



<html>
<body>

    <?php
        if ($active) {
    ?>
    
            <h2 style ="font-family: 'Enriqueta', arial, serif; line-height: 1.25; margin: 0 0 10px; font-size: 40px; font-weight: bold; color: darkslategray;"> Welcome to Food Dashboard, <?php echo  $_POST['username']; ?>!</h2>
            <form action= "https://foodalchemist.tk/logout/" method="post"> <input type = "submit" value = "Log Out " 
                style = "color: darkslategray; background-color:lightsalmon; padding: 0%; font-size:11px; width:100px;height: 30px;"/>
            <br>


    <?php }
    else {
    ?>

            <h2  style ="font-family: 'Enriqueta', arial, serif; line-height: 1.25; margin: 0 0 10px; font-size: 40px; font-weight: bold; color: darkslategray"> Invalid Login !</h2>
            <form action= "https://foodalchemist.tk/Restaurant-login/" method="post">
            <input type = "submit" value = "Log In " style = "color: darkslategray; background-color: lightseagreen; padding: 0%; font-size:11px; width: 80px;height: 30px;"/>
            <br>

    <?php } ?>

</form>
</body>
</html> 
