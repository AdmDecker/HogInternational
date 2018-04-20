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
          <h1 class="left">Busses</h1>
        </li>
        <li class="right">
          <a href="addBus.php">
            <button><b>Make Bus</b></button>
          </a>
          
        </li>
      
      </ul>
       <hr width="100%">
    </section>

    <section>
      <div id="busses">
        <?php 
          $type = PupSession::getUserType();
          if ($type == "M")
          {
              $db = new dbaccess();

              $lookup = $db->getAllBusses();

              // print busses

              foreach ($lookup as $bus)
              {
                ?>
                  <ul class="orderListElement">
                    <li>
                      <p class="id">Bus ID: <?= $bus->busID ?></p>
                    </li>
                    <li class="right">
                      <a class="orderLink" href=<?= "deleteBus.php?busID=" . $bus->busID ?>>
                        <button><h1>x</h1></button>
                      </a>
                    <?php
                      $orders = $db->getTodaysOrders($bus->busID);
                      foreach ($orders as $order)
                      {
                        ?>
                          <br/>
                          <a class="orderLink" href=<?= "order.php?order=" . $order->orderID ?>>
                            <?= "Order to " . $order->destination ?>
                          </a>
                        <?php
                      }

                    ?>
                    </li>
                    
                  </ul>

                  <hr class="light" width="100%">


                <?php
              }

          }
            
        ?>
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