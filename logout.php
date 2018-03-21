<?php 
    session_start();
    if (is_null($_SESSION['userID']))
        header('/login.html');
    else
        PupSession->Destroy();
?>

<html>

    <head>
        
    </head>
    <body>
        <h1>You have been logged out successfully.</h1>
        <a href="/login.html">
            <button>Return</button>
        </a>
    </body>
</html>