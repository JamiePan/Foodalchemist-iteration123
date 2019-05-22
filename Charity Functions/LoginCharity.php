<html>
   
   <head>
      <title>Login Page</title>
      
       

      </style>
      
   </head>
   
   <body>
	
      <div align = "center">
         <div style = "width:300px; " align = "left">
				
            <div>
               
               <form autocomplete="off" action = "https://foodalchemist.tk/raising-food/" method = "POST">
              
                <div class="input-group">
                  <label>User Name : </label>
  	              <input type="text" name="username"  id = "username"  required>
               </div>
               <div class="input-group">
                  <label>Password : </label>
  	              <input type="password" name="password"  id = "password"  required>
               </div>
               </br></br>
               <button class="button" type="submit" onclick="myFunction()">SIGN IN</button>
              
               <div id="snackbar">Lets go Charity Dashboard.....</div>
  </br>
               <p><b>
                  Not yet a member? <a href="https://foodalchemist.tk/charity_register/" style="color: rgb(0,0,255)">Sign up</a></b>
               </p>

               </form>
               
              	
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
