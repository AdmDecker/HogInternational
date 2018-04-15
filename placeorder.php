<?php
    require "Session.php";
    require "dbaccess.php";

    PupSession::Validate();

    $json = file_get_contents('php://input');
    $obj = json_decode($json);

    $db = new dbaccess();
    $orderID = $db->postOrder($_SESSION['userID'],
              $obj->{'whereto'},
              $obj->{'wherefrom'},
              $obj->{'travelTime'},
              $date = $obj->{'when'},
              'Pending',
              0,
              $obj->{'price'},
              $obj->{'noofpeople'},
              $obj->{'handicap'},
              $obj->{'distance'},
              $obj->{'paymentType'},
              $obj->{'travelTimeFromDepot'} + $obj->{'travelTimeToDepot'});

    //The order must now be scheduled to a bus
    $busID = -1;
    if ($obj->{'handicap'})
        $busID = $db->getAvailableHandicapBus($orderID);
    else
        $busID = $db->getAvailableBus($orderID);
    if ($busID == NULL)
    {
        echo "Fail: No busses available";
    }
    else
        $db->assignOrderToBus($orderID, $busID);
?>