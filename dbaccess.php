<?php

//Copyright Hog International Incorporated LLC.
//All rights reserved
class dbAccess
{
    private $dbObject = NULL;
    public function __construct()
    {
        $dbinfo = parse_ini_file('dbconf.ini');
        $hostname = $dbinfo['hostname'];
        $dbname = $dbinfo['db_name'];
        $dbuser = $dbinfo['db_user'];
        $dbpassword = $dbinfo['db_password'];
	    $this->dbObject = new PDO("mysql:host=$hostname; dbname=$dbname", $dbuser, $dbpassword);
    }
    
    public function __destruct()
    {
        $dbObject = NULL;
    }
    
    public function addUser($username, $password, $role)
    {
        //Insert user to database
        $username = trim($username);
        $statement = $this->dbObject->prepare("insert into users values(NULL, :username, :password, :role)");
        $statement->bindParam(':username', $username);
        $statement->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
        $statement->bindParam(':role', $role);
        $statement->execute();
    }
    
    public function getPassword($username)
    {
        $statement = $this->dbObject->prepare("select password from users 
            where userName = :username");
		$username = trim($username);
		$statement->bindParam(':username', $username);;
		$statement->execute();
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$passwd_inDB = $statement->fetch();
        if (!empty($passwd_inDB))
            return $passwd_inDB["password"];
        else
            return NULL;
    }
    
    public function getUserID($username)
    {
        //Get userID
        $statement = $this->dbObject->prepare("SELECT userID FROM users where username=:username");
        $statement->bindParam(':username', $username);
        $statement->execute();
        $userID = $statement->fetch();
        if (!empty($userID))
            return $userID['userID'];
        else
            return NULL;
    }
    
    public function deleteUser($username)
    {
        
    }

    // GRAB EM ALL
    public function getAllOrders()
    {
        $statement = $this->dbObject->prepare("SELECT * FROM orders");
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        return $statement->fetchAll();
    }
    
    public function getOrders($userID)
    {
        $statement = $this->dbObject->prepare("SELECT * FROM orders WHERE userID=:userID");
        $statement->bindParam(':userID', $userID);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        return $statement->fetchAll();
    }

    public function getTodaysOrders($busID)
    {
        $today = date('Y-m-d');
        $today0 = $today. ' 00:00:00';
        $today1 = $today. ' 23:59:59';
        $statement = $this->dbObject->prepare("SELECT * FROM orders WHERE assignedBus=:busID AND pickupDateDT >= :today0 AND pickupDateDT <= :today1");
        $statement->bindParam(':busID', $busID);
        $statement->bindParam(':today0', $today0);
        $statement->bindParam(':today1', $today1);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        return $statement->fetchAll();
    }

    public function getOrderById($orderID)
    {
        $statement = $this->dbObject->prepare("SELECT * FROM orders WHERE orderID=:orderID");
        $statement->bindParam(':orderID', $orderID);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        return $statement->fetch();
    }
    
    public function postOrder($userID, $destination, $pickup, $travelTime, $pickupDate, $oStatus, $statusPercent, $price, $headCount, $handicap, $distance, $paymentMethod, $depotTime)
    {
        // get date from order
        $format = 'Y-m-d\TH:i:s.uP';
        $newFormat = 'Y-m-d H:i:s';
        $date = DateTime::createFromFormat('Y-m-d\TH:i:s.uP', $pickupDate, new DateTimeZone('Etc/Zulu'));
        $returnDate = clone $date;
        $totalTime = $travelTime + $depotTime;
        $returnDate->modify("+$totalTime seconds");
        $statement = $this->dbObject->prepare("insert into orders values(:userID, NULL, :destination, :pickup, :travelTime, :pickupDate, :oStatus, :statusPercent, :price, :headCount, :handicap, :distance, :paymentMethod, NULL, :pickupDateDT, :depotTime, :returnDate)");
        $statement->bindParam(':userID', $userID);
        $statement->bindParam(':destination', $destination);
        $statement->bindParam(':pickup', $pickup);
        $statement->bindParam(':travelTime', $travelTime);
        $statement->bindParam(':pickupDate', $pickupDate);
        $statement->bindParam(':oStatus', $oStatus);
        $statement->bindParam(':statusPercent', $statusPercent);
        $statement->bindParam(':price', $price);
        $statement->bindParam(':headCount', $headCount);
        $statement->bindParam(':handicap', $handicap);
        $statement->bindParam(':distance', $distance);
        $statement->bindParam(':paymentMethod', $paymentMethod);
        $statement->bindParam(':pickupDateDT', $date->format($newFormat));
        $statement->bindParam(':depotTime', $depotTime);
        $statement->bindParam(':returnDate', $returnDate->format($newFormat));
        $statement->execute();
        return $this->dbObject->lastInsertId();
    }

    // Delete an order
    public function deleteOrder($orderID)
    {
        $statement = $this->dbObject->prepare("DELETE * FROM orders WHERE orderID=:orderID");
        $statement->bindParam(':orderID', $orderID);
        $statement->execute();
    }

    // Set status to CANCELLED
    //This method is DEPRECATED. Use setOrderStatus instead
    public function cancelOrder($orderID)
    {
        $this->setOrderStatus($orderID, 'CANCELLED');
    }

    // SET STATUS TO ARCHIVED
    //This method is DEPRECATED. Use setOrderStatus instead
    public function archiveOrder($orderID)
    {
        $this->setOrderStatus($orderID, 'ARCHIVED');
    }

    public function setOrderStatus($orderID, $status)
    {
        $statement = $this->dbObject->prepare("UPDATE orders SET oStatus=:status WHERE orderID=:orderID");
        $statement->bindParam(':status', $status);
        $statement->bindParam(':orderID', $orderID);
        $statement->execute();
    }

    public function setOrderPercent($orderID, $status)
    {
        $statement = $this->dbObject->prepare("UPDATE orders SET statusPercent=:status WHERE orderID=:orderID");
        $statement->bindParam(':status', $status);
        $statement->bindParam(':orderID', $orderID);
        $statement->execute();
    }

    public function addBus($handicap)
    {
        if ($handicap === TRUE)
            $handicap = 1;
        if ($handicap === FALSE)
            $handicap = 0;
        $statement = $this->dbObject->prepare("insert into busses values(NULL, :handicap");
        $statement->bindParam(':handicap', $handicap);
        return $db->lastInsertID();
    }

    public function deleteBus($busID)
    {

    }

    public function getAvailableBus($orderID)
    {
        $order = $this->getOrderById($orderID);
        $pickupDate = $order['pickupDateDT'];
        $orderDate = $order['returnDateDT'];
        $statement = $this->dbObject->prepare("SELECT busID FROM busses WHERE busID NOT IN (SELECT assignedBus FROM orders WHERE (pickupDateDT >= :pickupDate AND returnDateDT <= :pickupDate OR pickupDateDT >= :returnDate AND returnDateDT <= :pickupDate) AND assignedBus IS NOT NULL)");
        $statement->bindParam(':pickupDate', $pickupDate);
        $statement->bindParam(':returnDate', $returnDate);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        return $statement->fetch()['busID'];
    }

    public function getAvailableHandicapBus($pickupDate)
    {
        $statement = $this->dbObject->prepare("SELECT busID FROM busses WHERE handicap=1 AND busID NOT IN (SELECT assignedBus FROM orders WHERE pickupDateDT >= :pickupDate AND returnDateDT <= :pickupDate OR pickupDateDT >= :returnDate AND returnDateDT <= :pickupDate");
        $statement->bindParam(':pickupDate', $pickupDate);
        $statement->bindParam(':returnDate', $returnDate);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        return $statement->fetch()['busID'];
    }
    
    public function getCCs($userID)
    {
        $statement = $this->dbObject->prepare("SELECT * FROM CCs WHERE userID=:userID");
        $statement->bindParam(':userID', $userID);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_OBJ);
        return $statement->fetchAll();
    }
    
    public function getUserType($userID)
    {
        $statement = $this->dbObject->prepare("SELECT role FROM users WHERE userID=:userID");
        $statement->bindParam(':userID', $userID);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        return $statement->fetch()['role'];
    }

    public function setAssignedBus($driverID, $busID)
    {
        $statement = $this->dbObject->prepare("UPDATE drivers SET assignedBus=:busID WHERE driverID=:driverID");
        $statement->bindParam(':busID', $busID);
        $statement->bindParam(':driverID', $driverID);
        $statement->execute();
    }

    public function getAssignedBus($driverID)
    {
        $statement = $this->dbObject->prepare("SELECT assignedBus FROM drivers WHERE driverID=:driverID");
        $statement->bindParam(':driverID', $driverID);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        return $statement->fetch()['assignedBus'];
    }

    public function assignOrderToBus($orderID, $busID)
    {
        $statement = $this->dbObject->prepare('UPDATE orders SET assignedBus=:busID WHERE orderID=:orderID');
        $statement->bindParam(':busID', $busID);
        $statement->bindParam(':orderID', $orderID);
        $statement->execute();
    }

    public function getAvailableBusForDriver()
    {
        //Might want to date bind this later but that will require some database changes
        $today = gmdate('Y-m-d');
        $today0 = $today. ' 00:00:00';
        $today1 = $today. ' 23:59:59';
        trigger_error("today0: $today0 today1: $today1");
        $statement = $this->dbObject->prepare('SELECT busID FROM busses WHERE busID NOT IN (SELECT assignedBus FROM drivers WHERE assignedBus IS NOT NULL) AND busID IN (SELECT assignedBus FROM orders WHERE (pickupDateDT >= :today0 AND pickupDateDT <= :today1) AND assignedBus IS NOT NULL)');
        //$statement = $this->dbObject->prepare('SELECT busID FROM busses WHERE busID NOT IN (SELECT assignedBus FROM drivers WHERE assignedBus IS NOT NULL)');
        $statement->bindParam(':today0', $today0);
        $statement->bindParam(':today1', $today1);
        $statement->execute();
        return $statement->fetch()['busID'];
    }

    //Progresses the order and returns the next state
    public function progressOrder($orderID)
    {
        $orderState = $this->getOrderById($orderID)['oStatus'];
        $statuses = array('PENDING', 'Awaiting Dispatch', 'Driver Dispatched', 'Driver Arrived', 'Customers Picked Up', 'Complete');
        $index = array_search($orderState, $statuses) + 1;
        if ($index > count(statuses))
            return statuses[count(statuses) - 1];
        else if ($index === FALSE)
            return $orderState;
        else
            {
                $this->setOrderStatus($orderID, $statuses[$index]);
                $this->setOrderPercent($orderID, $index * (100 /count($statuses)));
                return $statuses[$index];
            }
    }
}
?>