<html>
   
   <head>
      <title>Login Page</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         a.link{
             text-decoration: underline;
         }

      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 0px #333333; " align = "left">
				
            <div style = "margin:30px">
               
               <form autocomplete="off" action = "https://foodalchemist.tk/restaurant-donation/" method = "POST">
                  <label>UserName  :</label><input type = "text" name = "username" required  class = "box" /><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" required class = "box"  /><br/><br />
                  <button class="button" type="submit" onclick="myFunction()">SIGN IN</button>
<div id="snackbar">Lets go Restaurant Dashboard.....</div>

<br />
<br />
<br />
             
             <p><b>
                Not a member yet? <a href="https://foodalchemist.tk/restaurant-register/">Register</a></b>
            </p>
           
               </form>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
					
            </div>
				
         </div>
			
      </div>

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




.button {
  border-radius: 15px;
  background-color: #7ce85f; /* Green */
  border: none;
  color: #2F4F4F;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  width: 80px;height: 30px;
  font-family:Arial, Helvetica, sans-serif;
  font-size:11px;
 font-weight: bold
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

</html>
