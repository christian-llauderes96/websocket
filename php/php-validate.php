<?php
require_once("Phplogin.php");

if(isset($_POST["username"]) && !empty($_POST["username"]))
{
    $uname = trim($_POST["username"]);
    if(!is_numeric($uname)) exit('Invalid ID');
    $login = new Phplogin;
    
    $userdata = $login->ValidateUser($uname);
    if(!$userdata)
    {
        exit("User dont exist");
    }
    else
    {
        
        session_start();
        $_SESSION["userdata"] = $userdata;
        header("Location: ../index.php");
        exit;
    }
}