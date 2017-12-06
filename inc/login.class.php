<?php
include_once("db_pdo.class.php");
include_once("./inc/settings.inc.php");

    $error = "";
  
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      
      $sql = "SELECT id_user FROM users WHERE nick = '$myusername' and passwd = '$mypassword'";
      //echo $sql;
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
   //   $active = $row['active'];
      
      $count = mysqli_num_rows($result);
      //echo $count;
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
          
 //      session_register("myusername");
         $_SESSION['login_user'] = $myusername;
         $user_check = $_SESSION['login_user'];
   
         $ses_sql = mysqli_query($db,"SELECT name FROM users WHERE nick = '$user_check' ");
 //   echo $ses_sql;

         $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
         $login_session = $row['name'];
         
         echo $login_session;
         //header("location: welcome.php");
          
          
      }else {
         $error = "Jméno a heslo nesouhlasí";
      }
   }


?>
<!-- LOGIN FORM -->
<div class="text-center" style="padding:50px 0">
	<div class="logo">Přihlášení</div>
	<!-- Main Form -->
	<div class="login-form-1">
		<form id="login-form" class="text-left" action="" method="post">
			<div class="login-form-main-message"></div>
			<div class="main-login-form">
				<div class="login-group">
					<div class="form-group">
						<label for="username" class="sr-only"></label>
						<input type="text" class="form-control" id="username" name="username" placeholder="Uživatelské jméno">
					</div>
					<div class="form-group">
						<label for="password" class="sr-only"></label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Heslo">
					</div>
<!--					<div class="form-group login-group-checkbox">
						<input type="checkbox" id="lg_remember" name="lg_remember">
						<label for="lg_remember">zapamatovat zadané údaje</label>
					</div>
-->
				</div>
				<button type="submit" class="btn btn-default">Přihlásit</button>
			</div>
			<div class="etc-login-form">
                <br>
				<p>Jsi nový uživatel? <a href="index.php?page=reg">Vytvoř si účet zde</a></p>
			</div>
		</form>
	</div>
	<!-- end:Main Form -->
</div>