<!DOCTYPE html>
<?php
    // includes
    require 'Nav.php';
?>
<html lang="end">
  <head>
    <meta charset="UTF-8">
    <meta name="description" content="rides-r-us bus system">
    <meta name="author" content="Justin Hoogestraat">
    <script src="common.js"></script>
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
          <h1 class="left">Reports</h1>
        </li>
      
      </ul>
       <hr width="100%">
    </section>

    
    <section>
      <?php
        $type = PupSession::getUserType();
        
        if ($type == 'M')
        {
          $db = new dbaccess();

          $orders = $db->getAllOrders();

          $sum = 0;

          foreach ($orders as $order) {
            $sum = $sum + $order->price;
          }

          echo "Total Revenue: $" . $sum;

          ?>
            <br/><br/>
            Export as JSON
            <br/><br/>
          <?php

          $sjson = json_encode($orders);
          echo $sjson;

          ?>

            <br/><br/>
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