<?php
    require 'dbaccess.php';
    require 'Session.php';

    PupSession::LoadSession();

    //Make the database queries
    try 
    {
        //Initialize db
        $db = new dbaccess();
		
        $ordersObject = $db->getOrders($userID);
        
        //Encode the json
        $sjson = json_encode($ordersObject);
        echo $sjson;
    }
	catch(PDOException $e)
    {
        $response->error = "Database error: " . $e->getMessage();
		echo json_encode($response);
	}

    exit();
?>