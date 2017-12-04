<?php 
    session_start();
    if (is_null($_SESSION['userID']))
        header('/login.html');
?>
<!DOCTYPE html>


<html>

    <head>
        
    </head>
    <body>
        <h1>Login Successful!</h1>
    </body>
</html>