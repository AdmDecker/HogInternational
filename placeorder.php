<?php
    require "Session.php";

    PupSession::Validate();

    $json = file_get_contents('php://input');
    $obj = json_decode($json);

    $db = new dbaccess();
    $db->postOrder($_SESSION['userID'],
              $obj['whereto'],
              $obj['wherefrom'],
              $obj['travelTime'],
              $obj['when'],
              'Pending',
              0,
              $obj['price'],
              $obj['handicap'],
              $obj['distance'],
              $obj['paymentType']);
?>