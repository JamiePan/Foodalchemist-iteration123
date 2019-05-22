<?php

// initializing variables
$username = "";
$restname ="";
$errors = array(); 
$successes = array(); 
// connect to the database
$db = mysqli_connect("aws-wordpress-db.cde44m6xn6zq.us-west-2.rds.amazonaws.com","admin","foodalchemist", "bitnami_wordpress");

// automatic complete "business name"
$array = array();
$query=mysqli_query($db, "SELECT * from FA_RESTAURANTS WHERE REST_NAME LIKE '%{$key}%'");
while($row=mysqli_fetch_assoc($query))
{
   $array[] = $row['REST_NAME'];
}

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $auth_key = mysqli_real_escape_string($db, $_POST['auth_key']);
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $restname = mysqli_real_escape_string($db, $_POST['restname']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array

 // check "Auth_key" is validated.

 $authkey_check_query =  "SELECT AUTH_KEY FROM FA_REST_META WHERE REST_ID IN
 (SELECT REST_ID FROM FA_RESTAURANTS WHERE REST_NAME ='$restname')";

  //$authkey_check_query =" SELECT * FROM FA_CHARITIES WHERE AUTH_KEY = '$auth_key' LIMIT 1"  ; 
  $result_authkey = mysqli_query($db, $authkey_check_query);
  $authkey = mysqli_fetch_assoc($result_authkey);
  if (!($authkey['AUTH_KEY'] === $auth_key)){
    array_push($errors, "* Your Auth Key did not match with restaurant Name! or your auth key is wrong!");
  }


  // first check the database to make sure 
  // a user does not already exist with the same username and/or email

  $user_check_query = "SELECT * FROM FA_REST_USERS WHERE USERNAME ='$username' OR RESTNAME='$restname' LIMIT 1";
  $result_user = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result_user);
   if ($user['USERNAME'] === $username){
     array_push($errors, "* Username already exists");
   }
   if ($user['RESTNAME'] === $restname) {
      array_push($errors, "* Restaurant already exists");
    }


 

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
    array_push($successes, "* Congratuations! Your Sign Up is Successful!");
    //$password = md5($password_1);//encrypt the password before saving in the database
    $password = $password_1;


    //$query = "INSERT INTO FA_CHARITY_USERS (ACTIVE_FLAG, FOODRAISE_FLAG,TOKEN, USERNAME, PASSWORD,CHARITYNAME,AUTH_KEY,PROPERTY_ID) 
             // SELECT 1,0,0, '$username','$password', '$restname','$auth_key',PROPERTY_ID FROM FA_CHARITIES WHERE CHAR_ID IN (
             // SELECT ID FROM FA_CHARITY_NAME WHERE Charity_Name = '$restname' )" ;

// insert records in "restaurant users"
$sql_3 = "INSERT INTO FA_REST_USERS (TOKEN, USERNAME, PASSWORD,RESTNAME,AUTH_KEY,PROPERTY_ID) 
SELECT 0, '$username','$password','$restname',$auth_key,PROPERTY_ID FROM FA_REST_META WHERE REST_ID IN (
SELECT REST_ID FROM FA_RESTAURANTS WHERE REST_NAME = '$restname' )" ;
mysqli_query($db,$sql_3);

// insert records in "FA_REST_ACTIVE"
$sql_4 = "INSERT INTO FA_REST_ACTIVE (PROPERTY_ID, ACTIVE_FLAG, DONATE_FLAG) 
                        SELECT  PROPERTY_ID, 1 ,0 FROM FA_REST_META RM WHERE REST_ID IN (
                        SELECT REST_ID FROM FA_RESTAURANTS WHERE REST_NAME = '$restname' )";
mysqli_query($db,$sql_4); 


    //mysqli_query($db, $query);
    mysqli_close($db);
    
  }
}
?>

<html>
<head>
  
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
 
  </div>
<?php   if (count($errors) > 0) : ?>
        <div class="error">
        	<?php foreach ($errors as $error) : ?>
  	           <p style="font-size:100%;font-weight:bold"><?php echo $error ?></p>
  	       <?php endforeach ?>
        </div>
    <?php  endif ?>

    <?php   if (count($successes) > 0) : ?>
        <div class="success">
        	<?php foreach ($successes as $success) : ?>
                 <p style="font-size:100%;font-weight:bold"><?php echo $success ?></p>
                 </br>
                 <p style="font-size:100%;font-weight:bold"><?php echo "Taking you to the login page in 5 seconds";
                          echo do_shortcode("[redirect url='https://foodalchemist.tk/Restaurant-login/' sec='5']"); ?></p>
  	       <?php endforeach ?>
        </div>
    <?php  endif ?>
    </br>
  <form method="post" action="https://foodalchemist.tk/restaurant-register/">
    <h7 style="text-align:center;font-size:120%;color:black;font-weight:bold">Step 1: Check your Restaurant's Authentication Key.​</h7>

    <div class="input-group">
  	    <label>Authentication Key </label>
  	    <input type="text" name="auth_key"  required>
        </br>
        <p style="font-size:80%;color:black">* How to get Authentication key?<em> <a href="https://foodalchemist.tk/contact-us/" style="color: rgb(0,0,255)">click here</a></em></p>
    </div> 

    <h7 style="text-align:center;font-size:120%;color:black;font-weight:bold">Step 2: Register your organization details.​</h7>
  	<div class="input-group">
  	  <label>Username</label>
  	  <input type="text" name="username"  id = "username_check" onChange="checkUsernameExist();" required>
      </div>
      <div class="registrationFormAlert" id="divCheckUsernameExist"></div>     

  	<div class="input-group">
  	  <label>Business Name</label>
  	  <input type="text" name="restname" value="<?php echo $restname; ?>" class="typeahead_1"  required>
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password_1" id = "one"  required>
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2" id = "two"  onChange="checkPasswordMatch();" required>
      </div>
    <div class="registrationFormAlert" id="divCheckPasswordMatch"></div>            
   

      <div class="input-group" style="text-align: left;">
  	  <button type="submit" class="btn" name="reg_user" onclick="myFunction()">Sign Up</button>
    </div>
</br>
  	<p style="font-size:100%;color:black">Already a member?<em>  <a href="https://foodalchemist.tk/Restaurant-login/" style="color: rgb(0,0,255)">Sign in </a> </em>
<div id="snackbar">Validating your sign up details...</div>
      </p>
      
  </form>
  
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>       
<script>
// automatic complete "business name" & "address"
var source_arr = <?php echo json_encode($array);?>;    
$(document).ready(function() {
            $('.typeahead_1').typeahead({source: <?php echo json_encode($array); ?>
            })});

// check two password is matching or not
$(document).ready(function () {
        $("#one, #two").keyup(checkPasswordMatch);
        });


function checkPasswordMatch() {
      var password = $("#one").val();
      var confirmPassword = $("#two").val();
      
       if (password != confirmPassword)
       {
        var match="Passwords do not match!";
        var result=match.fontcolor('red');
        $("#divCheckPasswordMatch").html(result);
       }
      else
      {
        var match="Passwords match.";
        var result=match.fontcolor('green');
        $("#divCheckPasswordMatch").html(result);
     }
  }

//snack bar
function myFunction() {
  var x = document.getElementById("snackbar");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

</script>   


<style>
        *{
            margin: 0px;
            padding: 0px;
        }

        form{
            width:90%;
            margin:0px auto;
            padding:20px;
            border:20px ;
            background:#e3f7e7;
            border-radius:10px 10px 10px 10px;
        }

        .input-group{
            margin:10px 0px 10px 0px;
        }

        .input-group label{
            display:black;
            text-align:left;
            margin:3px;
        }

        .input-group input{
            height:30px;
            width:93%;
            padding: 5px 10px;
            font-size:16px;
            border-radius:5px;
            border:1px solid gray;
        }

        .btn{
            padding:10px;
            width: 93%;
            font-size:15px;
            color:white;
            background:rgb(71, 173, 135);
            border:none;
            border-radius:5px;
        }
        .error {
            width:92%;
            margin:0px auto;
            padding:10px;
            border:1px solid #a94442;
            color:#a94442;
            background: #f2dede;
            border-radius:5px;
            text-align:left;
            }
        .success{
            width:92%;
            margin:0px auto;
            padding:10px;
            border:1px solid #0fe0af;
            color:#0fe0af;
            background: #caf7f0;
            border-radius:5px;
            text-align:left;
            }

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
