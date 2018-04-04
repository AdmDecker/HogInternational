<?php
    require "Session.php";
    
    PupSession::LoadSession();
    $location = 'index.html';
    
    if (!is_set($_SESSION['userType']))
        header("Location: /$location");

    if ($_SESSION["userType"] == "M")
        $location = 'mindex.html';
    if ($_SESSION["userType"] == "D")
        $location = 'dindex.html';
    if ($_SESSION["userType"] == "C")
        $location = 'cindex.html';

    header("Location: /$location");
    

?>