<!DOCTYPE html>
<html>
    <?php 
        session_start();
        if (is_null($_SESSION['userID']))
            header('/login.html');
    >
    <head>
        <h1>Login Successful!</h1>
    </head>
</html>