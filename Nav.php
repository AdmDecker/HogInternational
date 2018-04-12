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

            $id = $lookup['orderId'];

            // depending on user type define access
            if ($type == "M" || $type == "D")
            {
                // Always show for manager and driver
            }
            else if ($type == "C")
            {
                // Show if look up order userId matches session user id.

                if (id != userId)
                {
                    echo printPermsDenied();
                    return;
                }

            }
            else{
                ?>
                    Access Denied - Not Logged In
                <?php
                return;
            }

            echo printOrder($lookup);



        }

        // echo order in object form
        private static function printOrder($order)
        {
            echo "Order ID: " . $order["orderId"];
        }


        private static function printPermsDenied() {
            ?>
                Access Denied :(
            <?php
        }
    }
    
    
    
    
    
       

    

?>