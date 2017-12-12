
    <div class="container">
		<h3> <b>Přihlášený uživatel</b></h3>
		<b>Jméno: </b><?php echo $_SESSION["login_user"] ?><br>
		<b>Heslo: </b><?php echo $_SESSION["login_password"] ?><br>
		</div>
    <?php include("./view/logout.view.html");