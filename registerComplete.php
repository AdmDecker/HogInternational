<!DOCTYPE html>
<?php
    // includes
    require 'Nav.php';

?>
<html lang="eng">
  <head>
    <meta charset="UTF-8">
    <meta name="description" content="rides-r-us bus system">
    <meta name="author" content="Justin Hoogestraat">
    <meta http-equiv="content-type" content="image/svg+xml">
    <link href="w3.css" rel="stylesheet" type="text/css">
    <link href="style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        
        function stateChange()
        {

        }
        
        //This method is called when the user submits the form
        function submitForm(reason)
        {
            
            //Determine the action variable. The action variable determines where the info is sent
            let action = "";
            if(reason == "login")
                action = "login.php"
            else
                action = "register.php"


            window.location = "index.php";
        }
        
        
        function onLogin()
        {
            submitForm("login");
        }
        function onRegister()
        {
            submitForm("register");
        }
    </script>
  </head>
  <body>
    <header class="main-header">
      <ul class="nav-list">

        <li class="rides-r-us"><a href="index.php"><b>Rides R' Us™</b></a></li>
      </ul>
      <hr width="100%">
    </header>
    <section>
      <form onsubmit="return validateForm()">
          <input class ="w3-input center" type="text" name="firstName" id="firstName" style="width: 20em" placeholder="First Name" /><br/><br/>
          <input class ="w3-input center" type="text" name="lastName" id="lastName" style="width: 20em" placeholder="Last Name" /><br/><br/>
          <input class ="w3-input center" type="text" name="phoneNumber" id="phoneNumber" style="width: 20em" placeholder="Phone Number" /><br/><br/>
          <input class ="w3-input center" type="text" name="creditCardNumber" id="creditCardNumber" style="width: 20em" placeholder="Credit Card Number" /><br/><br/>
          <input class ="w3-input center" type="text" name="cvn" id="cvn" style="width: 20em" placeholder="CVN" /><br/>
          <br/>
          <input class ="w3-button w3-blue center" type="button" value="Complete Registration" onClick="onRegister()" style="width: 15em"/>
          <div id="error"></div>
          <br/>
      </form>



      
      <br/>

       <hr width="100%">
    </section>

  
    <footer>
      <center>Copyright ©2018 Brookings Area Transit Authority</center>
      <center>Usage of this site constitues acceptance of our</center>
      
       <center> <a href="terms.php">Terms of Service</a>
        and our
      <a href="privacy.php">Privacy Policy</a></center>
    </footer>
  </body>
</html>
