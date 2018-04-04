<?php
    require "Session.php";
    
    PupSession::LoadSession();
    $location = 'index.html';

    if ($_SESSION["userType"] == "M")
        $location = 'mindex.html';
    if ($_SESSION["userType"] == "D")
        $location = 'dindex.html';
    if ($_SESSION["userType"] == "C")
        $location = 'cindex.html';

    header("Location: /$location");
    

?>