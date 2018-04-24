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
        $uidi = PupSession::getUserID();

        $print = true;

        if ($uid == 'M')
        {
            ?>
              Account Info For Manager<br/>

              <b>Name: </b>John Doe<br/>
              <b>Phone Number: </b> 666-123-1234<br/>
              <b>Email: </b> john.doe@ridesrus.com<br/>
              <b>Address: </b> 12312 N 14th St, Brookings, SD<br/>
            <?php
        }
        else if ($uid == 'D')
        {
            ?>
              Account Info For Driver<br/>

              <b>Name: </b>Robert Doe<br/>
              <b>Phone Number: </b> 666-123-1235<br/>
              <b>Email: </b> robert.doe@ridesrus.com<br/>
              <b>Address: </b> 12313 N 14th St, Brookings, SD<br/>
            <?php

            echo Nav::getDriverInfo($uidi);


        }
        else if ($uid == 'C')
        {
            ?>
              <br/>

              <b>Name: </b>Sam Doe<br/>
              <b>Phone Number: </b> 605-123-5632<br/>
              <b>Email: </b> sam.doe@gmail.com<br/>
              <b>Address: </b> 3123 N 13th St, Lennox, SD<br/><br/>

                <a href= 'callorders.php'>
                  <button class="w3-button w3-blue"><b>All Orders</b></button>
              </a>
            <?php
        }
        else
        {
            ?>
                Not valid account type.
            <?php
            $print = false;

        }


        if ($print == true)
        {
          ?>
              <h2>Notfications </h2><br/>
              No notifications<br/>
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