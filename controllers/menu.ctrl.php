<?php

if(isset($_SESSION['rights'])){
    
    //Menu pro běžného návštěvníka
    if($_SESSION['rights']=="1"){
        $pages = array();
        $pages["home"] = "Úvod";
        $pages["articles"] = "Články";
        $pages["login"] = "Přihlášení";
        $pages["reg"] = "Registrace";
    }


    //Menu pro autora článků
    elseif($_SESSION['rights']=="2"){
        $pages = array();
        $pages["home"] = "Úvod";
        $pages["myarticles"] = "Moje články";
        $pages["articleupload"] = "Nahrát nový článek";
        $pages["userinfo"] = "Info o uživateli";
        $pages["logout"] = "Odhlášení";
    }


    //Menu pro recenzenta článků
    elseif($_SESSION['rights']=="3"){
        $pages = array();
        $pages["home"] = "Úvod";
        $pages["reviewed"] = "Články přidělené k recenzi";
        $pages["userinfo"] = "Info o uživateli";
        $pages["logout"] = "Odhlášení";
    }


    //Menu pro administrátora
    elseif($_SESSION['rights']=="4"){
        $pages = array();
        $pages["home"] = "Úvod";
        $pages["manageaccounts"] = "Správa uživatelů";
        $pages["managearticles"] = "Správa článků";
        $pages["userinfo"] = "Info o uživateli";
        $pages["logout"] = "Odhlášení";
    }
    
}



else{
    $pages = array();
    $pages["home"] = "Úvod";
    $pages["articles"] = "Články";
    $pages["login"] = "Přihlášení";
    $pages["reg"] = "Registrace";
}

