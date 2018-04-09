<?php
    require 'Session.php';
    session_start();
    if (!is_null($_SESSION['userID']))
        PupSession::Destroy();
?>

<html lang="eng">
  <head>
    <meta charset="UTF-8">
    <meta name="description" content="rides-r-us bus system">
    <meta name="author" content="Justin Hoogestraat">
    <meta http-equiv="content-type" content="image/svg+xml">
    <link href="w3.css" rel="stylesheet" type="text/css">
    <link href="style.css" rel="stylesheet" type="text/css">

  </head>
  <body>
    <header class="main-header">
      <ul class="nav-list">

        <li class="rides-r-us"><a href="index.php"><b>Rides R' Us™</b></a></li>
      </ul>
      <hr width="100%">
    </header>
    <section>
      <img src="appicon.svg" class="center" style="width:17em" alt="App Icon Logo">

      <h1 style="text-align:center">You have been logged out successfully.</h1>
        <a class="no-decor" href="/index.php">
            <button class="w3-button w3-blue center">Return</button>
        </a>

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
