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
    
    private function __destruct()
    {
        $dbObject = NULL;
    }
    
    public function addUser($username, $password)
    {
        //Insert user to database
        $username = trim($username);
        $statement = $this->dbObject->prepare("insert into users values(NULL, :username, :password)");
        $statement->bindParam(':username', $username);
        $statement->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
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
    
    public function addWord($word, $type)
    {
        $statement = $this->dbObject->prepare("INSERT IGNORE INTO words values (NULL, :word, :type)");
        $word = trim($word);
        $statement->bindParam(':word', $word);
        $statement->bindParam(':type', $type);
        $statement->execute();
        return $this->dbObject->lastInsertID();
    }
    
    public function associateWord($userID, $wordID)
    {
        $statement = $this->dbObject->prepare("INSERT INTO userWords values(:userID, :wordID)");
        $statement->bindParam(':userID', $userID);
        $statement->bindParam(':wordID', $wordID);
        $statement->execute();
    }
    
    public function removeUsersWords($userID)
    {
        $statement = $this->dbObject->prepare("DELETE FROM userWords WHERE userID=:userID");
        $statement->bindParam(':userID', $userID);
        $statement->execute();
    }
    
    public function getDefaultWordIDs()
    {
        $statement = $this->dbObject->prepare("SELECT wordID FROM userWords WHERE userID=11");
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $words = $statement->fetchAll();
        return $words;
    }
    
    public function getWords($userID)
    {
        $statement = $this->dbObject->prepare("SELECT words.word, words.type from words INNER JOIN userWords ON   userWords.wordID=words.wordID AND userWords.userID=:userid");
		$statement->bindParam(':userid', $userID);
		$statement->execute();
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$words = $statement->fetchAll();
        
        $wordArray = array(
                        'cnoun'=>array(),
                        'pnoun'=>array(),
                        'prep'=>array(),
                        'adj' =>array(),
                        'verb'=>array(),
                        'article'=>array()
                        );
        
        //Parse words into arrays
        foreach($words as $row)
        {
            array_push($wordArray[$row['type']],$row['word']);
        }
        
        return $wordArray;
    }
    
}
?>