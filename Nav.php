<?php
    require "Session.php";

    class Nav {
        public static function getUserType() {
            PupSession::LoadSession();
            $type = 'U';

            if (isset($_SESSION['userType']))
            {
                
                $type = $_SESSION['userType'];
            }

            return $type;
        }


         public static function getNavHtml() {
            $type = getUserType();


            if ($type == "M")
            {
                ?>
                    <li><a href="help.html">Help</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <li><a href="account.html">Account</a></li>
                    <li><a href="account.html">Busses</a></li>

                    <li><a href="dhours.html">Drivers</a></li>
                    <li><a href="dcontact.html">Reports</a></li>
                    <li><a href="dcontact.html">Locations</a></li>
                <?php
            }
            else if ($type == "D")
            {
                ?>
                    <li><a href="help.html">Help</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <li><a href="account.html">Account</a></li>
                    <li><a href="dhours.html">Hours</a></li>
                    <li><a href="dcontact.html">Contact</a></li>
                <?php
            }
            else if ($type == "C")
            {
                ?>
                    <li><a href="help.html">Help</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <li><a href="account.html">Account</a></li>
                    <li><a href="cmain.html">Main</a></li>
                <?php
            }
            else{
                ?>

                <?php
            }    
        }
    }
    
    
    
    
    
       

    

?>