<?php
    require "Session.php";

    function getUserType() {
        PupSession::LoadSession();
        $type = 'U';

        if (isset($_SESSION['userType']))
        {
            
            $type = $_SESSION['userType'];
        }

        return $type;
    }


    function getNavHtml() {
        $type = getUserType();


        if ($type == "M")
        {
            ?>
                <li><a href="help.html">Help</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a href="account.html">Account</a></li>
                <li><a href="cmain.html">Main</a></li>
            <?php
        }
        else if ($type == "D")
        {
            ?>
                <li><a href="help.html">Help</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a href="account.html">Account</a></li>
                <li><a href="cmain.html">Main</a></li>
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
                <li><a href="help.html">Help</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a href="account.html">Account</a></li>
                <li><a href="cmain.html">Main</a></li>
            <?php
        }    
    }
    
    
    
    
       

    

?>