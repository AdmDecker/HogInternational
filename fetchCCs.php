<?php
    require 'dbaccess.php';
    require 'Session.php';

    //Make the database queries
    try 
    {
        //Initialize db
        $db = new dbaccess();
		
        $ccsObject = $db->getCCs($_SESSION[userID]);
        
        //Encode the json
        $sjson = json_encode($ccsObject);
        echo $sjson;
    }
	catch(PDOException $e)
    {
        $response->error = "Database error: " . $e->getMessage();
		echo json_encode($response);
	}

    exit();
?>