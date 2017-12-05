<?php



class login{
	
	function __construct(){
		@session_start();
	}
	
	
	
	/**
	 * zobrazi vypis s informacemi o prihlasenem uzivateli
	 * @return string
	 */
	function User(){
		
		?>
		<div class="container">
		<h3> <b>Přihlášený Uživatel</b></h3>
		<b>Jméno : </b><?php echo $_SESSION["user"]["Jmeno"] ?><br>
		<b>Login : </b><?php echo $_SESSION["user"]["Login"] ?><br>
		<b>E-mail : </b><?php echo $_SESSION["user"]["Email"] ?><br>
		<b>Právo : </b><?php echo $_SESSION["user"]["Nazev"] ?><br>
		<?php echo $this->logOut();?>
		</div>
		<?php 
		
		
	}
	
	/**
	 * zobrazi tlaciko pro odhlaseni uzivatele
	 */
	function logOut(){
		?>
		
        <form action="" method="POST">
            <input type="hidden" name="action" value="logout">
            <input type="submit" class="btn btn-info btn-sm " name="potvrzeni" value="Odhlásit">
        </form>
        <?php 
	}
	
	/**
	 * zobrazi pole pro prihlaseni
	 */
	function log($alert){
		?>
		<div class="container">
		<?php if($alert != true){?>
		<div class="alert alert-danger">
  				<strong>Špatný login nebo heslo.</strong>
			</div>
			<?php }?>
		<form class="form-horizontal" action="" method="POST">
		
		<div class="form-group">
            <label class="control-label col-sm-2" for="Login"> Login:</label>
                <div class="col-sm-3">
                <input type="text" class="form-control" name="login">
                </div>
              </div>
		<div class="form-group">
        	<label class="control-label col-sm-2" for="Heslo">Heslo :</label>
        		<div class="col-sm-3">
        		<input type="password" class="form-control" name="heslo">
				</div>
              </div>
		<input type="hidden" name="action" value="login">
		<div class="form-group">        
      		<div class="col-sm-offset-2 col-sm-10">
		<input type="submit" class="btn btn-success" name="potvrzeni" value="Přihlásit">
			</div>
           </div>
		</form>
		</div>
	 	<?php 
	}
}
