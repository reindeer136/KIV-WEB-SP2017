<?php

if(isset($_SESSION['logged'])){
    $pages = array();
    $pages["home"] = "Homepage";
    $pages["articles"] = "Články";
    $pages["userinfo"] = "Info o uživateli";
    $pages["logout"] = "Logout";
    $pages["reg"] = "Registrace";
    
}
else{
        $pages = array();
    $pages["home"] = "Homepage";
    $pages["articles"] = "Články";
    $pages["login"] = "Login";
    $pages["reg"] = "Registrace";
}

