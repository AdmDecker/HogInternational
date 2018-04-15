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

  </head>
  <body>
    <header class="main-header">
      <ul class="nav-list">
        <?php 
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

        $uid = PupSession::getUserType();

        if ($uid == 'M')
        {
            ?>

              <a href="mmain.php" class="no-decor">
                <button  class="w3-button w3-blue center" style="width:17em">Manager Enter</button>
              </a>
            <?php
        }
        else if ($uid == 'D')
        {
            ?>
                
              <a href="dmain.php" class="no-decor">
                <button  class="w3-button w3-blue center" style="width:17em">Driver Enter</button>
              </a>
            <?php
        }
        else if ($uid == 'C')
        {
            ?>
                <a href="cmain.php" class="no-decor">
                    <button  class="w3-button w3-blue center" style="width:17em">Enter</button>
                </a>
            <?php
        }
        else
        {
            ?>
                  <a href="login.html" class="no-decor">
                    <button  class="w3-button w3-blue center" style="width:17em">Login</button>
                  </a>
                  <br/>
                  <a href="login.html" class="no-decor">
                    <button  class="w3-button w3-blue center" style="width:17em">Create Account</button>
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
      
       <center> <a href="terms.php">Terms of Service</a>
        and our
      <a href="privacy.php">Privacy Policy</a></center>
    </footer>
  </body>
</html>
