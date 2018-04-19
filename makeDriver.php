<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="description" content="rides-r-us bus system">
    <meta name="author" content="Justin Hoogestraat">
    <script src="common.js"></script>


    <script type="text/javascript">

    	function stateChange()
        {
            //Save the server's response in a variable
            let response = xmlhttp.responseText;
            
            //We don't care about these states, so ignore them
            if (!(xmlhttp.readyState==4) && !(xmlhttp.status==200))
                return;
                
            //The response from the server will be our error message to the user
            document.getElementById("error").nodeValue = xmlhttp.responseText;
            if(response.includes("success-register"))
            {
                // go to register complete page
                window.location = "registerCompletePage.php";
            }
            else if (response.includes("success"))
            {
                //Redirect the user to the next page if the request is successful
                window.location = "index.php";
            }
            else
            {
                document.getElementById("error").innerHTML = response;
            }
        }
        
        function submitForm(reason)
        {
			let action = "/registerDriver.php";

            

            xmlhttp = new XMLHttpRequest();
            
            //Open our http request as POST with our action variable
            xmlhttp.open("POST", action, true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            
            //Set stateChange() as the onreadystatechange event handler
            //onreadystatechange is triggered any time the xmlhttp object changes state,
            //like when it receives a response from the server
            xmlhttp.onreadystatechange = stateChange;
            
            //Collect the data and send it
            let username = "username=" + document.getElementById("username").value;
            let password = "password=" + document.getElementById("password").value;
            xmlhttp.send(username +"&" + password);
            };

			xmlhttp.send(myJSON);
        }

        function onRegister()
        {
            submitForm("register");
        }
       
    </script>
    <link rel="stylesheet" href="w3.css"> 

	<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <header class="main-header">
      <ul class="nav-list">
        <?php 
        	require 'Nav.php';

        	echo Nav::getNavHtml();
        ?>

        <li class="rides-r-us"><a href="index.php"><b>Rides R' Us™</b></a></li>
      </ul>
      <hr width="100%">
    </header>
    <section>
	   <form onsubmit="return validateForm()">
          <input class ="w3-input center" type="text" name="username" id="username" style="width: 20em" placeholder="Username" /><br/><br/>
          <input class ="w3-input center" type="password" name="password" id="password" style="width: 20em" placeholder="Password" /><br/>
          <br/>
          <input class ="w3-button w3-blue center" type="button" value="Register" onClick="onRegister()" style="width: 10em"/>
          <div id="error"></div>
          <br/>
      </form>




    </section>


    <footer>
      <center>Copyright ©2018 Brookings Area Transit Authority</center>
      <center>Usage of this site constitues acceptance of our</center>
      
       <center> <a href="terms.php">Terms of Service</a>
        and our
      <a href="privacy.php">Privacy Policy</a></center>
    </footer>
  </body>
<body>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCLPoefHbYJCIvyhqpsj13man604bMmhto&callback=initMap&libraries=places">
</script>


</html>