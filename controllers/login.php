<?php
    if(!isset($_SESSION['logged'])){
        include('./inc/login.class.php');
        include_once("./view/login.view.html");        
    }

    else{
        include('./inc/logout.class.php');
    }