<?php

class PupSession {
    
    public static function Create($timeout, $username, $userID, $userType)
    {
        //Start the session
        PupSession::LoadSession();
        $_SESSION['timeout'] = time() + $timeout;
        $_SESSION['username'] = $username;
        $_SESSION['userID'] = $userID;
        $_SESSION['userType'] = $userType;
        echo "success";
    }
    
    public static function Destroy()
    {
        PupSession::LoadSession();
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
        PupSession::LoadSession();
        //Check for session timeout
        if(!isset($_SESSION['timeout']) || $_SESSION['timeout'] < time())
        { 
            PupSession::ReturnToDefault();
        }
        
        //Check for valid userID
        if (!isset($_SESSION['userID']))
        {
            PupSession::ReturnToDefault();
        }

        return;
    }
    
    public static function ReturnToDefault()
    {
        header('Location: /index.php');
    }
}