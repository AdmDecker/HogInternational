<!DOCTYPE html>
<?php
    // includes
    require 'Nav.php';
    $suc = false;
    if (!isset($_GET['order']))
    {
      $suc = false;
      http_response_code(403);
    }
    else
    {
      // try
      if ( Nav::requestOrderProgress($_GET['order']))
        {
            $suc = true;
            http_response_code(200);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        else
        {
            $suc = false;
             http_response_code(403);
        }
    }

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
      <ul class="order-header-list">
        <li class="left">
          <h1 class="left">Order Progression</h1>
        </li>
      </ul>
       <hr width="100%">
    </section>
    <section>
      
      <?php
          if ( $suc)
            {
                ?>
                    Order progressed.
                <?php
            }
            else
            {
                ?>
                    We can't cancel that order. Sorry.
                <?php
            }


      ?>
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
