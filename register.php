<?php
    require 'dbaccess.php';
    $password = $_POST['password'];
    $username = trim($_POST['username']);

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
        $db->addUser($username, $password);
        
        //Get userID
        $userID = $db->getUserID($username);
        
        //Add default words to user account
        $words = $db->getDefaultWordIDs();
        foreach($words as $row)
        {
            $db->associateWord($userID, $row['wordID']);
        }
        
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['timeout'] = time() + 60*60*12;
        $_SESSION['userID'] = $userID;
        echo "success";
	}
	catch(PDOException $e)
	{
		echo "Database error: " . $e->getMessage();
	}

?>