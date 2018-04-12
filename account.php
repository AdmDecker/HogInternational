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
    <script src="cmain.js"></script>
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
        <h1 class="left">Account</h1>
      </ul>
       <hr width="100%">
    </section>

    <section>
      <?php 

        $uid = PupSession::getUserType();

        if ($uid == 'M')
        {
            ?>
              Account Info For Manager
            <?php
        }
        else if ($uid == 'D')
        {
            ?>
              Account Info For Driver
            <?php
        }
        else if ($uid == 'C')
        {
            ?>
                Account Info For Customer
                <a href= 'callorders.php'>
                  <button class="w3-button w3-blue"><b>All Order</b></button>
              </a>
            <?php
        }
        else
        {
            ?>
                Not valid account type.
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