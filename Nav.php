<?php
    require "Session.php";
    require "dbaccess.php";

    // Contains navigational data and deals with access clearance for user type.
    class Nav {

        public static function getNavHtml() {
            $type = PupSession::getUserType();


            if ($type == "M")
            {
                ?>
                    <li><a href="help.php">Help</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <li><a href="account.php">Account</a></li>
                    <li><a href="busses.php">Busses</a></li>


                    <li><a href="drivers.php">Drivers</a></li>
                    <li><a href="reports.php">Reports</a></li>
                    <li><a href="locations.php">Locations</a></li>
                <?php
            }
            else if ($type == "D")
            {
                ?>
                    <li><a href="help.php">Help</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <li><a href="account.php">Account</a></li>
                    <li><a href="dhours.php">Hours</a></li>
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
                    <li><a href="help.php">Help</a></li>
                    <li><a href="login.html">Login</a></li>
                <?php

            }   

        }


        private static function printOrderAdmin($order)
        {
            echo Nav::printOrderWithActions($order, true, true, true);
        }

        private static function printOrderSmartAction($order)
        {
            // print reactive 2 columns, info, actions
            // @todo config
            $HRSFORCANCEL = '+24 hours';
            $cancellable = false;
            $driveContact = false;
            $archive = false;


            // get date from order
            $date = new DateTime('@' . $order['pickupDate']);

            
            $curTime = new DateTime("now");

            $curTime->modify('-24 hours');

            if ($curTime < $date)
            {
                $driveContact = true;
            }

            else if ($curTime > $date)
            {
                $archive = true;
            }

            $curTime->modify('+24 hours');

            $curTime->modify($HRSFORCANCEL);

            if ($curTime < $date)
            {
                // we can cancel our order
                $cancellable = true;
            }



            echo Nav::printOrderWithActions($order, $cancellable, $driveContact, $archive);




        }
        private static function printOrderWithActions($order, $cancelButton, $contactDriver, $archive)
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
                            <a href=<?= 'cancelOrder.php?order=' . $order["orderID"] ?>>
                                <button class="w3-button w3-blue"><b>Cancel Order</b></button>
                            </a>
                            <br/><br/>
                        <?php
                    }

                    if ($contactDriver)
                    {
                        ?>
                            <a href=<?= 'contactDriverForOrder.php?order=' . $order["orderID"] ?>>
                                <button class="w3-button w3-blue"><b>Contact Driver</b></button>
                            </a>
                            <br/><br/>

                        <?php
                    }

                    if ($archive)
                    {
                        ?>
                            <a href=<?= 'archiveOrder.php?order=' . $order["orderID"] ?>>
                                <button class="w3-button w3-blue"><b>Archive Order</b></button>
                            </a>
                            <br/><br/>
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
            $date = new DateTime('@' . $order['pickupDate']);


            if ($order["handicap"] != "0")
                $handicap="Yes"
            ?>
                <b>Order ID: </b> <?= $order["orderID"] ?><br />
                <b>Destination: </b> <?= $order["destination"] ?><br />
                <b>Pickup: </b> <?= $order["pickup"] ?><br />
                <b>Pickup Time: </b> <?= $date -> format("H:i") ?><br />
                <b>Pickup Date: </b> <?= $date -> format("Y:m-d") ?><br />

                <b>Status: </b> <?= $order["oStatus"] ?><br />
                <b>Price: </b> $<?= $order["price"] ?><br />
                <b>Number of People: </b> <?= $order["headCount"] ?><br />
                <b>Handicap: </b> <?= $handicap ?><br />
                <b>Distance: </b> <?= $order["distance"] ?><br />
                <b>Travel Time: </b> <?= $order["travelTime"] ?> seconds.<br />
                <b>Payment Method: </b> <?= $order["paymentMethod"] ?><br />
            <?php
        }

        private static function printOrderCustomerContactInfo($customer)
        {
            ?>
                <h3>Customer Contact</h3>
                Print Customer contact info here
            <?php
        }

        private static function printOrderDriverContactInfo($customer)
        {
            ?>
                <h3>Driver Contact</h3>

                Print Driver contact info here
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
                echo Nav::printOrderCustomerContactInfo($lookup);
                echo Nav::printOrderDriverContactInfo($lookup);


            }
            else if ($type == "D")
            {
                // print simple
                echo Nav::printOrder($lookup);
                echo Nav::printOrderCustomerContactInfo($lookup);



            }
            else if ($type == "C")
            {
                // Show if look up order userId matches session user id.

                if ($id != $userID)
                {
                    echo Nav::printPermsDenied();
                    return;
                }
                echo Nav::printOrderSmartAction($lookup);


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
            $type = PupSession::getUserType();
            $userID = PupSession::getUserID();


            //Initialize db
            $db = new dbaccess();

            $lookup = $db->getOrderById($orderId);

            if (is_null($lookup))
            {
                // order not found, return false
                return false;
            }

            $id = $lookup["userID"];

            // depending on user type define access
            if ($type == "M")
            {
                // we are an admin, delete order
                $db->cancelOrder($orderId);

            }
            else if ($type == "D")
            {
                // Driver's cant delete orders
                return false;
            }
            else if ($type == "C")
            {
                // Show if look up order userId matches session user id.

                if ($id != $userID)
                {
                    return false;
                }

                // else delete order
                $db->cancelOrder($orderId);




            }
            else {
                return false;
            }

            return true;
        }

        public static function progressOrder($orderID)
        {
            $db = new dbaccess();
            $db->progressOrder($orderID);
        }

        public static function requestOrderProgress($orderID)
        {
            $type = PupSession::getUserType();
            $userID = PupSession::getUserID();

            if ($type == "M")
            {
                // we are an admin, delete order
                Nav::progressOrder($orderID);
                return true;

            }
            else if ($type == "D")
            {
                // Driver's cant archive orders
                Nav::progressOrder($orderID);
                return true;
            }
            else
            {
                return false;
            }
        }

        public static function requestBusDelete($busID)
        {
            $type = PupSession::getUserType();

            if ($type == "M")
            {
                 //Initialize db
                $db = new dbaccess();

                $db->deleteBus($busID);
                return true;

            }
            else if ($type == "D")
            {
                // Driver's cant delete bus

                return false;
            }
            else
            {
                return false;
            }
        }

        public static function requestAddBus()
        {
            $type = PupSession::getUserType();

            if ($type == "M")
            {
                 //Initialize db
                $db = new dbaccess();

                $db->addBus(false);
                return true;

            }
            else if ($type == "D")
            {
                // Driver's cant delete bus

                return false;
            }
            else
            {
                return false;
            }
        }

        public static function requestOrderArchive($orderId)
        {
            $type = PupSession::getUserType();
            $userID = PupSession::getUserID();


            //Initialize db
            $db = new dbaccess();

            $lookup = $db->getOrderById($orderId);

            if (is_null($lookup))
            {
                // order not found, return false
                return false;
            }

            $id = $lookup["userID"];

            // depending on user type define access
            if ($type == "M")
            {
                // we are an admin, delete order
                $db->archiveOrder($orderId);

            }
            else if ($type == "D")
            {
                // Driver's cant archive orders
                return false;
            }
            else if ($type == "C")
            {
                // Show if look up order userId matches session user id.

                if ($id != $userID)
                {
                    return false;
                }

                // else archive order
                $db->archiveOrder($orderId);




            }
            else {
                return false;
            }

            return true;

        
        }

    }

    
    
    
    
    
       

    

?>