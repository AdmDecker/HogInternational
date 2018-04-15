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

        //Get the driver's bus
        $driverBus = $db->getAssignedBus($userID);

        //If the driver doesn't have an assigned bus, assign one
        if ($driverBus == NULL)
        {
            $driverBus = $db->getAvailableBus();
            //If there's no available bus
            if ($driverBus == NULL)
            {
                echo "No busses available. Please contact your manager.";
                exit();
            }

            $db->setAssignedBus($userID, $driverBus);
        }
        
        $ordersObject = [];
        $ordersObject['orders'] = $db->getDriverOrders($userID);
        
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