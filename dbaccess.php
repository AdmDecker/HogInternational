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

    public function getDriverOrders($userID)
    {
        $statement = $this->dbObject->prepare("SELECT * FROM orders WHERE driverID=:userID");
        $statement->bindParam(':userID', $userID);
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

    public function getOrdersForDriver($driverID)
    {
        
    }
    
    public function postOrder($userID, $destination, $pickup, $travelTime, $pickupDate, $oStatus, $statusPercent, $price, $headCount, $handicap, $distance, $paymentMethod)
    {
        $statement = $this->dbObject->prepare("insert into orders values(:userID, NULL, :destination, :pickup, :travelTime, :pickupDate, :oStatus, :statusPercent, :price, :headCount, :handicap, :distance, :paymentMethod)");
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
        $statement->execute();
    }

    // Delete an order
    public function deleteOrder($orderID)
    {
        $statement = $this->dbObject->prepare("DELETE * FROM orders WHERE orderID=:orderID");
        $statement->bindParam(':orderID', $orderID);
        $statement->execute();
    }

    // Set status to CANCELLED
    public function cancelOrder($orderID)
    {
        $statement = $this->dbObject->prepare("UPDATE orders SET oStatus='CANCELLED' WHERE orderID=:orderID");
        $statement->bindParam(':orderID', $orderID);
        $statement->execute();
    }

    // SET STATUS TO ARCHIVED
    public function archiveOrder($orderID)
    {
        $statement = $this->dbObject->prepare("UPDATE orders SET oStatus='ARCHIVED' WHERE orderID=:orderID");
        $statement->bindParam(':orderID', $orderID);
        $statement->execute();
    }

    // set status, percent status, to specified
    public function setStatus($orderId, $status, $percent)
    {

    }

    public function postBus()
    {

    }

    public function deleteBus()
    {

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
}
?>