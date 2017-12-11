<?php
include_once("db_pdo.class.php");
include_once("./inc/settings.inc.php");
include_once("./inc/userinfo.class.php");
//include_once("./view/login.view.html");

//přihlášení
//if(!isset($_SESSION['logged'])){
    
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        //username and password sent from form      
        $myusername = mysqli_real_escape_string($db,$_POST['username']);
        $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      
        $sql = "SELECT * FROM users WHERE nick = '$myusername' and passwd = '$mypassword'";
        
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        
        
        
        $userinfo = new userinfo();
        $userinfo->Connect();

        $vypis_dat = $userinfo->LoadAllUserinfos($myusername);
        //    printr($vypis_dat);

        if ($vypis_dat != null)
            foreach ($vypis_dat as $userinfo)
            {
 //               echo "ID uživatele: $userinfo[id_user], Jméno uživatele: $userinfo[name] <br/>";
            
                $existuje = $userinfo["exist"];
  //              printr($existuje);
            }

		
        if($count == 1 && exist =="1") {
            
            //nastaveni stavu ze je uzivatel prihlasen
            $_SESSION['logged'] = "true";
            
            //ulozeni do session uzivatelskeho jmena uzivatele
            $_SESSION['user'] = $myusername;
            
            //$_SESSION['id'] = $result;
            

            header("location: index.php");
            }
        elseif($count == 1 && exist ==0){
            $error = "Tento uživatel byl eliminován, kontaktujte administrátora";
            echo $error;
            printr($exist);
            
        }
                
        else {
            $error = "Jméno a heslo nesouhlasí, zkuste to znovu";
            echo $error;
        }        
    }    
//}