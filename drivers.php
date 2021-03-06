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
          <h1 class="left">Drivers</h1>
        </li>
        <li class="right">
          <a href="makeDriver.php">
            <button><b>New Driver</b></button>
          </a>
          
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
          $lookup = $db->getAllDrivers();

          foreach ($lookup as $driver)
          {
             ?>
              <ul class="orderListElement">
                <li>
                  <p class="id">Driver ID: <?= $driver->driverID ?></p>
                  <p class="id">Driver Salary: <?= $driver->salary ?></p>
                  <p class="id">Driver Hours: <?= $driver->hours ?></p>
                </li>
                <li class="right">
                  <a class="orderLink" href=<?= "driver.php?driver=" . $driver->driverID ?>>
                    <button><span>i</span></button>
                  </a>

                </li>
                <hr class="light" width="100%">
              </ul>
            <?php
          }

         
        }
        else
        {
          echo "Security Violation";
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