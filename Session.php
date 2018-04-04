<?php

class PupSession {
    
    public static function Create($timeout, $username, $userID, $userType)
    {
        //Start the session
        LoadSession();
        $_SESSION['timeout'] = time() + $timeout;
        $_SESSION['username'] = $username;
        $_SESSION['userID'] = $userID;
        $_SESSION['userType'] = $userType;
        echo "success";
    }
    
    public static function Destroy()
    {
        LoadSession();
        session_unset();
        session_destroy();
    }
    
    public static function LoadSession()
    {
        if (!isset($_SESSION))
            session_start();
    }
    
    //Check for valid userID TODO: return false if logged in from somewhere else
    public static function Validate()
    {
        LoadSession();
        //Check for session timeout
        if(!isset($_SESSION['timeout']) || $_SESSION['timeout'] < time())
        { 
            return "Session timed out";
        }
        
        //Check for valid userID
        if (!isset($_SESSION['userID']))
        {
            return "Session error: Invalid UserID";
        }

        return NULL;
    }
}