<?php
    require 'Session.php';
    session_start();
    if (!is_null($_SESSION['userID']))
        PupSession::Destroy();
?>

<html>

    <head>
        
    </head>
    <body>
        <h1>You have been logged out successfully.</h1>
        <a href="/index.php">
            <button>Return</button>
        </a>
    </body>
</html>