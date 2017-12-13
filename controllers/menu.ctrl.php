<?php

if(isset($_SESSION['logged'])){
    $pages = array();
    $pages["home"] = "Úvod";
    $pages["myarticles"] = "Moje články";
    $pages["userinfo"] = "Info o uživateli";
    $pages["logout"] = "Odhlášení";
//    $pages["reg"] = "Registrace";
    
}
else{
        $pages = array();
    $pages["home"] = "Úvod";
    $pages["articles"] = "Články";
    $pages["login"] = "Přihlášení";
    $pages["reg"] = "Registrace";
}

