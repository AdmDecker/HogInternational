<?php
    require 'dbaccess.php';
    require 'Session.php';

    PupSession::LoadSession();
    $type = PupSession::getUserType();

    if (type == 'M')
    {

        //Make the database queries
        try 
        {
            //Initialize db
            $db = new dbaccess();
            
            $ordersObject = [];
            $ordersObject['orders'] = $db->getAllOrders();
            
            //Encode the json
            $sjson = json_encode($ordersObject);
            echo $sjson;
        }
        catch(PDOException $e)
        {
            $response->error = "Database error: " . $e->getMessage();
            echo json_encode($response);
        }
    }
    else
    {
          $ordersObject = [];
        $sjson = json_encode($ordersObject);
        echo $sjson;
    }


    exit();
?>