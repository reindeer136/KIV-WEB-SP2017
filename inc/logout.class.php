<?php
 //  session_start();


	function logOut(){
		?>
		
        <form action="" method="POST">
            <input type="hidden" name="action" value="logout">
            <input type="submit" class="btn btn-info btn-sm " name="potvrzeni" value="Odhlásit">
        </form>
        <?php 
	}

/*
   
   if(session_destroy()) {
      header("Location: .php");
   }
   
   */
?>