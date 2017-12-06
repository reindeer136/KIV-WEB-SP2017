<?php

//include('./inc/login.class.php');
session_start();
   if(!isset($_SESSION['login_user'])){
      include('./inc/login.class.php');
   }
    else{
        include('./inc/logout.class.php');
    }