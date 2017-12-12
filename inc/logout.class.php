<?php

function logOut(){
    
    include("./controllers/logout.php");
    include("./view/logout.view.html");
    }

    printr($_SESSION);
    
    $logout = logOut();

    echo $logout;


/*   
   if(session_destroy()) {
      header("Location: .php");
   }
   */