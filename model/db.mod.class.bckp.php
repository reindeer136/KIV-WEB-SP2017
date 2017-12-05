<?php

require_once ("menu.mod.class.php");
class databaze{
    
    //verejna promena kam se ulozi pripojeni
    public $spojeni;
  
    
    
    //konstruktor kde se vytvori pripojeni
    //a spusti session
    function __construct(){
        global $db_server, $db_name, $db_user, $db_pass;
        try{
        	$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);
            $this->spojeni =  new PDO("mysql:host=$db_server;dbname=$db_name",$db_user,$db_pass,$options);
                session_start();
        }catch(PDOException $e){
            print "Chyba ". $e->getMessage();
            die();
        }
    }
    
    
    
    //nacte a vrati pole plne prav
    function nactiPrava(){
    	// vznik chyby v PDO
    	$mysql_pdo_error = false;
            
        $dotaz = "SELECT * FROM prava";
        
        $priprav = $this->spojeni->prepare($dotaz);
            
        $priprav->execute();
            
            
            
            // kontrola chyb
            $errors = $priprav->errorInfo();
            if ($errors[0] + 0 > 0)
            {
            	// nalezena chyba
            	$mysql_pdo_error = true;
            }
            	
            // nacist data a vratit
            if ($mysql_pdo_error == false)
            {
            	$vse = $priprav->fetchAll(PDO::FETCH_ASSOC);
       			return $vse;
            }
            else
            {
            	echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
            	print_r($errors);
            	echo "SQL dotaz: $dotaz";
            }
     }
     
     /**
      * vrati pole s hodnocenim konkretniho prispevku
      * pro konkretni clanek pro administratory
      * 
      * @param $idClanek id konkretniho clanku
      */
     function hodnoceniPrispevkuAdmin($idClanek){
     	// vznik chyby v PDO
     	$mysql_pdo_error = false;
     	
     	$dotaz = " SELECT a.Zpracovani, a.Obsah, a.Styl, b.Login, c.Nazev, c.idStav 
     					FROM hodnoceni a, uzivatel b, prispevky c
     						WHERE a.Uzivatel_idUzivatel = b.idUzivatel
     							AND a.Prispevky_idPrispevky = :idC
     								AND c.idPrispevky = :idC;";
     
     	$priprav = $this->spojeni->prepare($dotaz);
     	
     	$priprav->bindValue(':idC', $idClanek);
     	
     	$priprav->execute();
     	
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	 
     	// nacist data a vratit
     	if ($mysql_pdo_error == false)
     	{
     		$vse = $priprav->fetchAll(PDO::FETCH_ASSOC);
     		return $vse;
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     	}
     }
     
     /**
      * Vrati pole s informacemi o vsech uzivatelech
      */
     function vsechnyInformaceZDatabaze(){
     	global $edit;
     	// vznik chyby v PDO
     	$mysql_pdo_error = false;
     	
     	$dotaz = "SELECT * from uzivatel,prava
     			  where prava.iDprava = uzivatel.idPrava
     					AND uzivatel.Smazano = :s;";
     	
     	$priprav = $this->spojeni->prepare($dotaz);
     	$priprav->bindValue(':s', $edit['default']);
     	
     	$priprav->execute();
     	
     	
     	
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	 
     	// nacist data a vratit
     	if ($mysql_pdo_error == false)
     	{
     		$vse = $priprav->fetchAll(PDO::FETCH_ASSOC);
     		return $vse;
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     	}
     }
     
     /**
      * vrati pole vsech recenzentu v databazi
      * 
      */
     function recenzenti(){
     	global $pravaId;
     	// vznik chyby v PDO
     	$mysql_pdo_error = false;
     	
     	$dotaz = "SELECT idUzivatel,Login FROM uzivatel 
     					WHERE idPrava = :prava";
     	
     	//pripraveni dotazu
     	$priprav = $this->spojeni->prepare($dotaz);
     	
     	$priprav->bindValue(':prava', $pravaId['recenzent']);
     	$priprav->execute();
     	
     	
     	
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	 
     	// nacist data a vratit
     	if ($mysql_pdo_error == false)
     	{
     		$vse = $priprav->fetchAll(PDO::FETCH_ASSOC);
     		return $vse;
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     	}
     }
     
     
     
     /**
      * 
      * zkontroluje jestli uz neexistuje uzivatel se stejnym loginem
      * @param unknown $login
      * @return boolean
      */
     function kontrolaLoginu($login){
     	// vznik chyby v PDO
     	$mysql_pdo_error = false;
     	$dotaz = "SELECT Login FROM uzivatel;";
     	
     	$priprav = $this->spojeni->prepare($dotaz);
     	$priprav->execute();
     	
     	
     	
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	// nacist data a vratit
     	if ($mysql_pdo_error == false)
     	{
     		$vse = $priprav->fetchAll(PDO::FETCH_ASSOC);
     		foreach ($vse as $i){
     			if($i["Login"] == $login){
     				return false;
     			}
     		}
     		return true;
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     	}
     	
    	
     }
     
     /**
      * nacte a vrati jako asociativni pole vsechny 
      * zverejnene prispevky administratory
      * serazene podle uploadu na server
      * 
      */
     function zverejnenePrispevky(){
     	//pouze zverejnene clanky
     	global $hodnoceni;
     	
     	// vznik chyby v PDO
     	$mysql_pdo_error = false;
     	
     	$dotaz = "SELECT a.* , b.Jmeno FROM prispevky a,uzivatel b
     				WHERE a.idAutor = b.idUzivatel
     					AND a.idStav = :stav
     						ORDER BY a.Datum DESC;";
     	
     	$priprav = $this->spojeni->prepare($dotaz);
     	$priprav->bindValue(':stav', $hodnoceni['schvaleno']);
     	$priprav->execute();
     	
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	 
     	// nacist data a vratit
     	if ($mysql_pdo_error == false)
     	{
     		$vse = $priprav->fetchAll(PDO::FETCH_ASSOC);
     		return $vse;
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     	}
     }
     
    
     
     
     
     /**
     *  Vraci vsechny informace o uzivateli.
     *  @param string $login    Login uzivatele.
     *  @return array           Pole s informacemi o konkretnim uzivateli nebo null.
     */
     function infoOUzivateli($login){
     	
     	// vznik chyby v PDO
     	$mysql_pdo_error = false;
     	
     	$dotaz = "select * from uzivatel,prava
     			  where uzivatel.Login = :log
     			  and prava.iDprava = uzivatel.idPrava;";
     	
     	$priprav = $this->spojeni->prepare($dotaz);
     	$priprav->bindValue(':log', $login);
     	$priprav->execute();
     	
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	 
     	// nacist data a vratit
     	if ($mysql_pdo_error == false)
     	{
     		$vse = $priprav->fetchAll(PDO::FETCH_ASSOC);
     		return $vse[0];
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     	}
     }
     /**
      *
      * vraci pole prispevku serazene podle data pridani do databaze
      */
     function clankyAdmin(){
     	global $pravaId,$edit;
     	// vznik chyby v PDO
     	$mysql_pdo_error = false;
     
     	$dotaz = "SELECT a.* , b.* FROM prispevky a,stav b
     					WHERE a.idStav = b.idStav
     						AND a.Smazano = :s
     						ORDER BY a.Datum DESC";
     
     	//pripraveni dotazu
     	$priprav = $this->spojeni->prepare($dotaz);
     
     	$priprav->bindValue(':s', $edit["default"]);
     
     	$priprav->execute();
     
     
     
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	 
     	// nacist data a vratit
     	if ($mysql_pdo_error == false)
     	{
     		$vse = $priprav->fetchAll(PDO::FETCH_ASSOC);
     		 
     		return $vse;
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     	}
     }
     /**
      * vrati vsechny clanky ktere byly prideleny
      * recenzentovi k ohodnoceni
      * s tim ze jsou serazene od nejnovejsiho po nejstarsi
      */
     function clankyRecenzent($idRec){
     	global $edit;
     	// vznik chyby v PDO
     	$mysql_pdo_error = false;
     	
     	$dotaz = "SELECT a.*,b.*
     				FROM prispevky a, hodnoceni b
     					WHERE b.Prispevky_idPrispevky = a.idPrispevky
     						AND b.Uzivatel_idUzivatel = :idrec
     							AND a.Smazano = :s
     							ORDER BY a.Datum DESC;";
     
     
     	$priprav = $this->spojeni->prepare($dotaz);
     
     	$priprav->bindValue(':s', $edit["default"]);
     	$priprav->bindValue(':idrec', $idRec);
     	
     	$priprav->execute();
     	
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	 
     	// nacist data a vratit
     	if ($mysql_pdo_error == false)
     	{
     		$vse = $priprav->fetchAll(PDO::FETCH_ASSOC);
     		return $vse;
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     	}
     
     }
     
     
     
     /**
      * vrati nazev a popis jednoho konkretniho clanku
      * 
      * 
      * @param integer $idAutor id autora clanku
      * @param integer $idClanku id clanku o ktery me jde
      */
     function clankyEditAutor($idAutor,$idClanku){
     	// vznik chyby v PDO
     	$mysql_pdo_error = false;
     	
     	//dotaz SQL
     	$dotaz = "SELECT Nazev,Popis FROM prispevky a
     					WHERE a.idAutor = :idA 
     						AND a.idPrispevky = :idP;";
     	
     	//pripravit dotaz pro databazi
     	$priprav = $this->spojeni->prepare($dotaz);
     	
     	//navazat hodnoty
     	$priprav->bindValue('idA', $idAutor);
     	$priprav->bindValue('idP', $idClanku);
     	
     	$priprav->execute();
     	
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	 
     	// nacist data a vratit
     	if ($mysql_pdo_error == false)
     	{
     		$vse = $priprav->fetchAll(PDO::FETCH_ASSOC);
     		return $vse;
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     	}
     }
     /**
      * priradi clanky recenzentum
      */
     function clankyRecenzentum($idClanku, $idAutor){
     
     	// MySql
     	$mysql_pdo_error = false;
     
     	$dotaz ="INSERT into hodnoceni(Uzivatel_idUzivatel, Prispevky_idPrispevky)
     				VALUES(:autor,:clanek);";
     	//pripraveni dotazu
     	$priprav = $this->spojeni->prepare($dotaz);
     
     	//postupne vlozim do databaze
     	if(isset($idAutor)){
     		foreach ($idAutor as $i){
     			$priprav->bindValue(':clanek', $idClanku);
     			$priprav->bindValue(':autor', $i);
     			$priprav->execute();
     		}
     	}
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	 
     	// v poradku
     	if ($mysql_pdo_error == false)
     	{
     		return true;
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     		return false;
     	}
     
     }
     /**
      * vratu pole se vsemi clanky autora
      *
      * @param integer $idAutor
      * @return boolean
      */
     function clankyAutora($idAutor){
     	global $edit;
     	// vznik chyby v PDO
     	$mysql_pdo_error = false;
     
     	$dotaz = "SELECT * FROM prispevky,stav
     				WHERE prispevky.idAutor = :autor
     						AND stav.idStav = prispevky.idStav
     							AND prispevky.Smazano = :s;";
     
     	$priprav = $this->spojeni->prepare($dotaz);
     
     	$priprav->bindValue(':s', $edit["default"]);
     	$priprav->bindValue(':autor', $idAutor);
     
     	$priprav->execute();
     
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	 
     	// nacist data a vratit
     	if ($mysql_pdo_error == false)
     	{
     		$vse = $priprav->fetchAll(PDO::FETCH_ASSOC);
     		return $vse;
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     	}
     	 
     }
     
     /**
      *  Upravi informace o danem uzivateli.
      *  ... vse potrebne ...
      *  @return boolean         Podarilo se data upravit?
      */
     function updateUzivatele($jmeno,$heslo,$email,$idprava,$iduzivatel){
     	$dotaz = "UPDATE uzivatel 
     				SET Jmeno = :jmeno ,Heslo = :heslo,
     					Email = :email,idPrava = :idprava
     				WHERE idUzivatel =:iduzivatel;";
     	
     	$priprav = $this->spojeni->prepare($dotaz);
     	
     	$priprav->bindValue(':jmeno', $jmeno);
     	$priprav->bindValue(':heslo', $heslo);
     	$priprav->bindValue(':email', $email);
     	$priprav->bindValue(':idprava', $idprava);
     	$priprav->bindValue(':iduzivatel', $iduzivatel);
     	
     	$priprav->execute();
     	
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	 
     	// vratit true pokud je vse ok
     	if ($mysql_pdo_error == false)
     	{
     		return true;
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     		return false;
     	}
     	
     }
     /**
      * upravuje stav clanku... jestli je predan recenzentum
      * nebo schvalen a zverejnen pripadne 
      * zamitnut
      * 
      * @param integer $idClanek
      * @param integer $idStav
      * @return boolean vraci true pokud vse probehno ok
      */
     function updatePublic($idClanek,$idStav){
     	//chyba
     	$mysql_pdo_error = false;
     	
     	$dotaz = "UPDATE prispevky set idStav = :idS 
     				WHERE prispevky.idPrispevky = :idC ;";
     	
     	$priprav = $this->spojeni->prepare($dotaz);
     	
     	$priprav->bindValue('idS', $idStav);
     	$priprav->bindValue('idC', $idClanek);
     	
     	$priprav->execute();
     	
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	 
     	// v poradku
     	if ($mysql_pdo_error == false)
     	{
     		return true;
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     		return false;
     	}
     }
     
     /**
      * 
      * upravy a ulozi hodnoceni clanku od recenzenta
      * 
      * @param integer $idUzivatel id recenzenta
      * @param int $idPrispevku  id prispevku
      * @param int $obsah hodnoceni
      * @param int $Zpracovani hodnoceni
      * @param int $Styl hodnoceni
      * @return boolean vraci true pokud vse probehne ok
      */
     function updateHodnoceni($idUzivatel,$idPrispevku,$ohodnoceni){
     	//chyba
     	$mysql_pdo_error = false;
     	
     	if(!isset($ohodnoceni[0])){
     		$Zpracovani = null;
     	}
     	else{
     		$Zpracovani =$ohodnoceni[0];
     	}
     	if(!isset($ohodnoceni[1])){
     		$obsah = null;
     	}else{
     		$obsah =$ohodnoceni[1];
     	}
     	if(!isset($ohodnoceni[2])){
     		$Styl = null;
     	}else{
     		$Styl = $ohodnoceni[2];
     	}
     	
     	$dotaz = "UPDATE hodnoceni SET Zpracovani = :zp, Obsah = :ob,
     						Styl = :st
     					WHERE Prispevky_idPrispevky = :idP
     						AND Uzivatel_idUzivatel = :idU;";
     	
     	$priprav = $this->spojeni->prepare($dotaz);
     	
     	$priprav->bindValue(':zp', $Zpracovani);
     	$priprav->bindValue(':ob', $obsah);
     	$priprav->bindValue(':st', $Styl);
     	$priprav->bindValue('idP', $idPrispevku);
     	$priprav->bindValue('idU', $idUzivatel);
     	
     	$priprav->execute();
     	
     	
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	 
     	// v poradku
     	if ($mysql_pdo_error == false)
     	{
     		return true;
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     		return false;
     	}
     }
     /**
      * upravy nazev nebo popis clanu v databazi
      * 
      * @param integer $idClanku upravovaneho clanku
      * @param string $nazev novy nazev clanku
      * @param string $popis novy popis clanku
      */
     function updateClanky($idClanku,$nazev,$popis){
     	//chyba
     	$mysql_pdo_error = false;
     	
     	$dotaz = "UPDATE prispevky 
     				SET Nazev = :nav, Popis = :pop
     					WHERE prispevky.idPrispevky = :idC;";
     	
     	$priprav = $this->spojeni->prepare($dotaz);
     	
     	$priprav->bindValue(':nav', $nazev);
     	$priprav->bindValue(':pop', $popis);
     	$priprav->bindValue(':idC', $idClanku);
     	
     	$priprav->execute();
     	
     	
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	 
     	// v poradku
     	if ($mysql_pdo_error == false)
     	{
     		return true;
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     		return false;
     	}
     }
     
     /**
      * upravi prava daneho uzivatele
      * 
      * 
      * @param unknown $idUzivatel id uzivatele ktereho chci upravit
      * @param unknown $idPrava id prava na jaka je chci zmenit
      * @return boolean pokud se vse povede vraci true
      */
     function updateRule($idUzivatel,$idPrava){
     	//chyba
     	$mysql_pdo_error = false;
     	
     	$dotaz = "UPDATE uzivatel SET idPrava = :idP WHERE uzivatel.idUzivatel = :idU ;";
     	
     	$priprav = $this->spojeni->prepare($dotaz);
     	$priprav->bindValue(':idP', $idPrava);
     	$priprav->bindValue(':idU', $idUzivatel);
     	$priprav->execute();
     	
     	
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	 
     	// v poradku
     	if ($mysql_pdo_error == false)
     	{
     		return true;
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     		return false;
     	}
     }
     
     /**
      *  Overi, zda dany uzivatel ma dane heslo.
      *  a zaroven neni jeho ucet smazany
      *  @param string $login  Login uzivatele.
      *  @param string $pass     Heslo uzivatele.
      *  @return boolean         Jsou hesla stejna?
      */
     function spravneHeslo($login,$pwd){
     	global $edit;
     	$pom = $this->infoOUzivateli($login);
     	
     	if($pom['Smazano'] == $edit['default']){
     		if($pom != null && $pom["Heslo"] == $pwd){
     			return true;
     		}
     	}
     	else{
     		return false;
     	}
     }
     
     
     
     /**
      * prihlasi uzivate a ulozi cele pole s informacemi 
      * o nem do _SESSION
      * @param unknown $login
      * @param unknown $pwd
      * @return boolean
      */
     function prihlaseni($login,$pwd){
     	
     	if($this->spravneHeslo($login, $pwd)){
     		$_SESSION["user"] = $this->infoOUzivateli($login);
     		return true;
     	}
     	else{
     		return false;
     	}
     }
     
     /**
      *  Odhlasi uzivatele.
      */
     function odhlaseni(){
     	@session_unset($_SESSION["user"]);
     }
     
     
     /**
      * pokud je prihlaseny vraci true jinak false
      * @return boolean
      */
     function jePrihlasen(){
     	if(isset($_SESSION["user"])){
     		return true;
     	}
     	return false;
     }
     
     
     /**
      *  Provede dotaz a bu� vr�t� jeho v�sledek, nebo null a vyp�e chybu.
      *  @param string $dotaz    Dotaz.
      *  @return object          Vysledek dotazu.
      */
     
     function provedDotaz($dotaz){
     	$pom = $this->spojeni->query($dotaz);
     	
     	if($pom == null){
     		$chyba = $this->spojeni->errorInfo();
     		
     		echo $chyba[2];
     		return null;
     	}
     	else{
     		return $pom;
     	}
     }
     /**
      *  Prevede vysledny objekt dotazu na pole.
      *  @param object $obj  Objekt s vysledky dotazu.
      *  @return array       Pole s vysledky dotazu.
      */
     function resultObjectToArray($obj){
     	
     	return $obj->fetchAll(); // v�echny ��dky do pole
     }
     
     
    
     
     
     /**
      * prida noveho uzivatele do databaze
      * @param unknown $login
      * @param unknown $jmeno
      * @param unknown $heslo
      * @param unknown $email
      * @param unknown $idprava
      * @return boolean
      */
     function novyUzivatel($login,$jmeno,$heslo,$email,$idprava){
     	$mysql_pdo_error = false;
     	
     	$dotaz = "INSERT into uzivatel(Login,Jmeno,Heslo,Email,idPrava)
     			values(:login,:jmeno,:heslo,:email,:prava)";
     	
     	//pripraveni dotazu
     	$priprav = $this->spojeni->prepare($dotaz);
     	
     	//navazani hodnot
     	$priprav->bindValue(':login', $login);
     	$priprav->bindValue(':jmeno', $jmeno);
     	$priprav->bindValue(':heslo', $heslo);
     	$priprav->bindValue(':email', $email);
     	$priprav->bindValue(':prava', $idprava);
     	
     	
     	//vlozeni do databaze
     	$priprav->execute();
     	
     	     	
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	 
     	// v poradku
     	if ($mysql_pdo_error == false)
     	{
     		return true;
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     		return false;
     	}
     }
     
     
    
     
     
     
     /**
      * ulozi zaznam o uploadu do databaze
      * zaroven do public promene ulozi 
      * 
      * @param string $nazev
      * @param string $popis
      * @param string $koncovka
      * @return boolean vraci hodnotu lastID pokud vse probehlo ok
      * 				jinak false
      */
     function upload($nazev,$popis,$koncovka){
     	$idUser = $_SESSION['user']['idUzivatel'];
     	
     	
     	$d = "INSERT into prispevky(idAutor,Nazev,Popis,idStav)
     				VALUES(:idUser,:nazev,:popis,:idstav)";
     	
     	
     	//pripraveni dotazu
     	$pom = $this->spojeni->prepare($d);
     	
     	//navazani hodnot
     	$pom->bindValue(':idUser', $idUser);
     	$pom->bindValue(':nazev', $nazev);
     	$pom->bindValue(':popis', $popis);
     	$pom->bindValue('idstav', 4);
     	
     	//vlozeni do databaze
     	$pom->execute();
     	
     	//TESTOVANI vypis chyb
     	//$errors = $pom->errorInfo();
     	//print_r($errors);
     	
     	//ID posledniho vlozeneho zaznamu
     	$lastID = $this->spojeni->lastInsertId();
     	//chyba pokud se nepovede
     	if($pom == null){
     		return -1;
     	}
     	
     	
     	
     	
     	//vlozeni do databaze nazev souboru
     	//sklada se z posledniho ID plus koncovka predana jako parametr
     	// takto v databazi nikdy nebudou dva stejne se jmenujici soubory
     	// pod stejnym nazvem se ulozi i na server
     	
     	$d = "UPDATE prispevky 
     				SET NazevSouboru = :nazevsouboru
     					WHERE idPrispevky =  :idprispevky";
     	//pripravit dotaz
     	$pom = $this->spojeni->prepare($d);
     	
     	//poskladam si jmeno souboru
     	$jmeno = $lastID .".".$koncovka;
     	
     	//navazani hodnoty promene
     	$pom->bindValue(':nazevsouboru', $jmeno);
     	$pom->bindValue(':idprispevky', $lastID);
     	
     	//vlozeni
     	$pom->execute();
     	
     	
     	//chyba pokud se nepovede
     	if($pom == null){
     		return -1;
     	}
     	
     	else 
     		//pokud se vse povedlo vrati jmeno zaznamu
     		//aby se pod stejnym nazvem mohl ulozit soubor na disk
     		return $jmeno;
     }
     
     
     /**
      *uzivatele nesmaze pouze se nebude moci prihlasit
      *ale bude mozne mu ucet obnovit
      * idUzivatel
      * 
      * @param unknown $idUzivatel id klic zaznamuv tabulce
      */
     function smazUzivatele($idUzivatel){
     	//prispevek se nesmaze jen se nebude uz zobrazovat
     	global $edit;
     	
     	$mysql_pdo_error = false;
     	
     	$dotaz = "UPDATE uzivatel
     				SET Smazano = :s
     				WHERE idUzivatel = :idU;";
     	
     	//provede bez navratove hodnoty..
     	$priprav = $this->spojeni->prepare($dotaz);
     	
     	$priprav->bindValue(':s', $edit['smazano']);
     	$priprav->bindValue(':idU', $idUzivatel);
     	
     	$priprav->execute();
     	
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	 
     	// v poradku
     	if ($mysql_pdo_error == false)
     	{
     		return true;
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     		return false;
     	}
     	
     }
     
     /**
      * nesmaze zaznam pouze zmeni priznak smazano
      * a tak se jiz nikomu nevypise ale bude mozne zaznam obnovit
      * idClanek
      * 
      * @param integer $idClanek
      * @return boolean
      */
     function smazClanek($idClanek){
     	//prispevek se nesmaze jen se nebude uz zobrazovat
     	global $edit;
     	
     	$mysql_pdo_error = false;
     	
     	$dotaz = " UPDATE prispevky
     				SET Smazano = :s
     				WHERE idPrispevky = :idC;";
     	
     	$priprav = $this->spojeni->prepare($dotaz);
     	
     	$priprav->bindValue(':s', $edit['smazano']);
     	$priprav->bindValue(':idC', $idClanek);
     	
     	$priprav->execute();
     	
     	
     	
     	// kontrola chyb
     	$errors = $priprav->errorInfo();
     	if ($errors[0] + 0 > 0)
     	{
     		// nalezena chyba
     		$mysql_pdo_error = true;
     	}
     	 
     	// v poradku
     	if ($mysql_pdo_error == false)
     	{
     		return true;
     	}
     	else
     	{
     		echo "Chyba v dotazu - PDOStatement::errorInfo(): ";
     		print_r($errors);
     		echo "SQL dotaz: $dotaz";
     		return false;
     	}
     	}
     
     
     
    
    function Disconnect(){
        
        $spojeni = null;
        //znicit promenou
        unset($spojeni);
    }
    
    
    
}


?>