<?php
    require "Session.php";
    require "dbaccess.php";

    class Nav {

        public static function getNavHtml() {
            $type = PupSession::getUserType();


            if ($type == "M")
            {
                ?>
                    <li><a href="help.php">Help</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <li><a href="account.php">Account</a></li>
                    <li><a href="account.php">Busses</a></li>


                    <li><a href="dhours.html">Drivers</a></li>
                    <li><a href="dcontact.html">Reports</a></li>
                    <li><a href="dcontact.html">Locations</a></li>
                <?php
            }
            else if ($type == "D")
            {
                ?>
                    <li><a href="help.php">Help</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <li><a href="account.php">Account</a></li>
                    <li><a href="dhours.html">Hours</a></li>
                    <li><a href="dcontact.html">Contact</a></li>
                <?php
            }
            else if ($type == "C")
            {
                ?>
                    <li><a href="help.php">Help</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <li><a href="account.php">Account</a></li>
                    <li><a href="cmain.php">Main</a></li>
                <?php
            }
            else{
                ?>

                <?php

            }   

        }


        // echo order in object form
        private static function printOrder($order)
        {
            $handicap = "No";

            if ($order["handicap"] != "0")
                $handicap="Yes"
            ?>
                <b>Order ID: </b> <?= $order["orderID"] ?>
                <b>Destination: </b> <?= $order["destination"] ?>
                <b>Pickup: </b> <?= $order["pickup"] ?>
                <b>Pickup Time: </b> <?= $order["pickupDate"] ?>
                <b>Status: </b> <?= $order["oStatus"] ?>
                <b>Price: </b> <?= $order["price"] ?>
                <b>Number of People: </b> <?= $order["headCount"] ?>
                <b>Handicap: </b> <?= $handicap ?>
                <b>Distance: </b> <?= $order["distance"] ?>
                <b>Travel Time: </b> <?= $order["travelTime"] ?>
                <b>Payment Method: </b> <?= $order["paymentMethod"] ?>
            <?php
        }


        private static function printPermsDenied() {
            ?>
                Access Denied :(
            <?php
        }


        public static function getOrderInfo($orderId) {

            $type = PupSession::getUserType();
            $userID = PupSession::getUserID();


            //Initialize db
            $db = new dbaccess();

            $lookup = $db->getOrderById($orderId);

            if (is_null($lookup))
            {
                echo "Order not found :(";
                return;
            }

            $id = $lookup["userID"];

            // depending on user type define access
            if ($type == "M" || $type == "D")
            {
                // Always show for manager and driver
            }
            else if ($type == "C")
            {
                // Show if look up order userId matches session user id.

                if ($id != $userID)
                {
                    echo Nav::printPermsDenied();
                    return;
                }

            }
            else{
                ?>
                    Access Denied - Not Logged In
                <?php
                return;
            }

            echo Nav::printOrder($lookup);



        }

    }
    
    
    
    
    
       

    

?>