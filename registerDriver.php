<?php
    require 'dbaccess.php';
    require "Session.php";

    $password = $_POST['password'];
    $username = trim($_POST['username']);

    $type = PupSession::getUserType();


    if ($type == "M")
    {
        try {
            //Create our database object
            $db = new dbaccess();
            
            //Check if the user already exists.
            $user_inDB = $db->getUserID($username);
            if (!is_null($user_inDB))
            {
                echo "User already exists";
                exit();
            }
            
            //Insert user to database
            $db->addDriver($username, $password, 100, 40);

            

            echo "success-register";
        }
        catch(PDOException $e)
        {            echo "Database error: " . $e->getMessage();
        }
    }
    else
    {
        echo "Insufficient Permissions";
    }


	

?>