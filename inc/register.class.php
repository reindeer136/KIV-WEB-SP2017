<?php
include_once("db_pdo.class.php");
include_once("./inc/settings.inc.php");
include_once("./inc/userinfo.class.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        //data from form      
        $name       = $_POST['name'];
        $username   = $_POST['username']; 
        $password   = $_POST['password'];
        $email      = $_POST['email'];
    
//        $data[] = [$name, $username, $password, $email];
    
//        printr($data);
    
        $userinfo = new userinfo();
        $userinfo->Connect();
    
//        $zapis_dat = $userinfo->SaveAllUserinfos($data);
    
    
       $zapis_dat = $userinfo->SaveAllUserinfos($name, $username, $password, $email);
        
}