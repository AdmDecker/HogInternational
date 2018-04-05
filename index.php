<!DOCTYPE html>
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
        <?php 
            require 'Nav.php';

            echo Nav::getNavHtml();
        ?>

        <li class="rides-r-us"><a href="index.php"><b>Rides R' Us™</b></a></li>
      </ul>
      <hr width="100%">
    </header>
    <section>
      <img src="appicon.svg" class="center" style="width:17em" alt="App Icon Logo">
      <p style="text-align:center">Exceptional bus transit services.</p>

      <?php 
        require 'nav.php';

        $uid =Nav::getUserType();

        if ($uid == 'M')
        {
            ?>

              <a href="mmain.html" class="no-decor">
                <button  class="w3-button w3-blue center" style="width:17em">Manager Enter</button>
              </a>
            <?php
        }
        else if ($uid == 'D')
        {
            ?>
                
              <a href="dmain.html" class="no-decor">
                <button  class="w3-button w3-blue center" style="width:17em">Driver Enter</button>
              </a>
            <?php
        }
        else if ($uid == 'C')
        {
            ?>
                <a href="cmain.html" class="no-decor">
                    <button  class="w3-button w3-blue center" style="width:17em">Enter</button>
                </a>
            <?php
        }
        else
        {
            ?>
                <a href="mmain.html" class="no-decor">
                    <button  class="w3-button w3-blue center" style="width:17em">Manager Enter</button>
                </a>
            <?php
        }


      ?>



      
      <br/>

       <hr width="100%">
    </section>

  
    <footer>
      <center>Copyright ©2018 Brookings Area Transit Authority</center>
      <center>Usage of this site constitues acceptance of our</center>
      
       <center> <a href="terms.html">Terms of Service</a>
        and our
      <a href="privacy.html">Privacy Policy</a></center>
    </footer>
  </body>
</html>


<?php
    require "Session.php";
    
    PupSession::LoadSession();
    $location = 'index.html';
    
    if (!isset($_SESSION['userType']))
    {
        header("Location: /$location");
        exit();
    }
       

    if ($_SESSION["userType"] == "M")
        $location = 'mindex.html';
    if ($_SESSION["userType"] == "D")
        $location = 'dindex.html';
    if ($_SESSION["userType"] == "C")
        $location = 'cindex.html';

    header("Location: /$location");
    

?>