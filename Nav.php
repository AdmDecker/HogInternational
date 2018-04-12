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


        private static function printOrderAdmin($order)
        {

        }

        private static function printOrderBasic($order)
        {
            // print reactive 2 columns, info, actions
            // @todo config
            $HRSFORCANCEL = '+24 hours';
            $cancellable = false;


            // get date from order
            $date = DateTime::createFromFormat(DateTime::ISO8601, $order['pickupDate']);
            $curTimePlusOffset = (new \DateTime())->modify($HRSFORCANCEL);

            if ($curTimePlusOffset < $date)
            {
                // we can cancel our order
                $cancellable = true;
            }

            echo Nav::printOrderWithActions($order, $cancellable);




        }
        private static function printOrderWithActions($order, $cancelButton)
        {
                        ?>
            <div class="w3 row">
                <div class="w3-half w3-container">
                    <h3>Info:</h3>
                    <?= Nav::printOrder($order) ?>
                </div>
                <div class="w3-half w3-container">
                    <h3>Actions:</h3>
                    <?php 

                    if ($cancelButton)
                    {
                        ?>
                            <a href=<?= "cancelOrder.php$order="+$order["orderID"] ?>>
                                <button class="w3-button w3-blue"><b>Make Order</b></button>
                            </a>
                        <?php
                    }

                    ?>

                </div>
            </div>

            <?php
        }
        // echo order in object form
        private static function printOrder($order)
        {
            $handicap = "No";

            if ($order["handicap"] != "0")
                $handicap="Yes"
            ?>
                <b>Order ID: </b> <?= $order["orderID"] ?><br />
                <b>Destination: </b> <?= $order["destination"] ?><br />
                <b>Pickup: </b> <?= $order["pickup"] ?><br />
                <b>Pickup Time: </b> <?= $order["pickupDate"] ?><br />
                <b>Status: </b> <?= $order["oStatus"] ?><br />
                <b>Price: </b> $<?= $order["price"] ?><br />
                <b>Number of People: </b> <?= $order["headCount"] ?><br />
                <b>Handicap: </b> <?= $handicap ?><br />
                <b>Distance: </b> <?= $order["distance"] ?><br />
                <b>Travel Time: </b> <?= $order["travelTime"] ?> seconds.<br />
                <b>Payment Method: </b> <?= $order["paymentMethod"] ?><br />
            <?php
        }


        private static function printPermsDenied() {
            ?>
                Access Denied :(
            <?php
        }


        // prints order
        // has acesss security control
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
            if ($type == "M")
            {
                // print admin
                echo Nav::printOrderAdmin($lookup);
            }
            else if ($type == "D")
            {
                // print simple
                echo Nav::printOrder($lookup);


            }
            else if ($type == "C")
            {
                // Show if look up order userId matches session user id.

                if ($id != $userID)
                {
                    echo Nav::printPermsDenied();
                    return;
                }

                echo Nav::printOrderBasic($lookup);


            }
            else{
                ?>
                    Access Denied - Not Logged In
                <?php
                return;
            }




        }

        public static function requestOrderCancel($orderId)
        {

        }

    }

    
    
    
    
    
       

    

?>