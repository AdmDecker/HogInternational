<?php
    require 'dbaccess.php';
    require 'Session.php';

    PupSession::LoadSession();
    $userID = PupSession::getUserID();

    //Make the database queries
    try 
    {
        //Initialize db
        $db = new dbaccess();
        
        $ordersObject = [];
        $ordersObject['orders'] = $db->getOrders($userID);
        
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