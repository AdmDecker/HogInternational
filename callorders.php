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
    <script src="cmain.js">
      showArchived = true;
    </script>
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
          <h1 class="left">Orders</h1>
        </li>
        <li class="right">
          <a href="placeorderpage.php">
            <button><b>Make Order</b></button>
          </a>
          
        </li>
      </ul>
       <hr width="100%">
    </section>

    <template id="order-template">
      <ul class="orderListElement">
        <li>
          <p class="pickup">Pickup: </p>
          <p class="destination">Destination: </p>
          <p class="pickupTime">Pickup Time: </p>
        </li>
        <li class="right">
          <a class="orderLink"href="404.html">
            <button><span>i</span></button>
          </a>

        </li>
        <li class="right status">
          <p class="Status">Status: </p>
          <progress class="statusBar" value= "0" max="100"></progress> 
        </li>
      </ul>
      <hr class="light" width="100%">
    </template>
    <section>
      <div id="orders">
      </div>
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