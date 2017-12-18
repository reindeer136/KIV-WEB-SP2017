<?php
// nacteni souboru
include_once("./inc/db_pdo.class.php");
include_once("./inc/settings.inc.php");
include_once("./inc/functions.inc.php");
include_once("./inc/userinfo.class.php");


$userinfo = new userinfo();
$userinfo->Connect();


$vypis_dat = $userinfo->LoadAllUsers();
//    printr($vypis_dat);

if ($vypis_dat != null){
    
    ?> 
    
    <div class="container">
    <h2>Přehled uživatelů</h2>
    <table class="table table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Jméno</th>
        <th>Uživatelské jméno</th>
        <th>Role</th>
        <th>Stav</th>
        <th>Změna role</th>
        <th>Změna stavu</th>
        
      </tr>
    </thead>
    <tbody>
        
    <?php
 //   if($userinfo["id_user"]!=4){
        foreach ($vypis_dat as $userinfo)
        {
            ?>
            <tr>
                <td> <?php echo $userinfo["id_user"]; ?>
                </td>
                <td> <?php echo $userinfo["name"]; ?>
                </td>
                <td> <?php echo $userinfo["nick"]; ?>
                </td>
                <td> <?php if($userinfo["id_right"]=="2") echo "Autor"; elseif($userinfo["id_right"]=="3") echo "Recenzent"; elseif($userinfo["id_right"]=="4") echo "Administrátor"; else echo "Chyba"?>
                </td>
                <td><?php if($userinfo["exist"]=="0") echo "Smazán"; elseif($userinfo["exist"]=="1") echo "Aktivní"; else echo "Chyba"?>
                </td>
                <td>
                    <?php if($userinfo["id_right"]=="4"){
                ?> 
                    <button type="button" class="btn btn-primary disabled btn-xs">Změnit</button> <?php
                }
                else{
                ?>
                <button type="button" class="btn btn-primary active btn-xs" data-toggle="modal" data-target="#myModal<?php echo $userinfo["id_user"]; ?>">Změnit</button> <?php
                }
                ?>
                <div class="modal fade" id="myModal<?php echo $userinfo["id_user"]; ?>" role="dialog">
                <div class="modal-dialog">
    
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Změna dat uživatele <?php echo $userinfo["name"] ?></h4>
                        </div>
                        <div class="modal-body">     
                       
                            <p>Z tohoto uživatele může být <?php if($userinfo["id_right"]=="3") echo "Autor"; elseif($userinfo["id_right"]=="2") echo "Recenzent"; else echo "Chyba"; ?></p>
                            
                            <form action="" method="post">
                                
                                <input type="hidden" name="changerole" value="1">
                                <input type="hidden" name="idchange" value="<?php echo $userinfo["id_user"] ?>">                                
                                <input type="hidden" name="idstate" value="<?php if($userinfo["id_right"]=="3") echo "2"; elseif($userinfo["id_right"]=="2") echo "3"; ?>">      
                                <button type="submit" class="btn btn-success btn-xs">Změnit</button>
                            
                            </form>
                            
                           
                        
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Zavřít</button>
                        </div>
                    </div>
      
                </div>
                </div>
                </td>
                <td>
                    <form action="" method="post">
                    <?php if($userinfo["id_right"]!="4")
                            {
                            if($userinfo["exist"]=="1")
                            { ?>
                        
                                <input type="hidden" name="changerole" value="2">
                                <input type="hidden" name="changeexist" value="0">
                                <input type="hidden" name="idchng" value="<?php echo $userinfo["id_user"] ?>">
                                <button type="submit" class="btn btn-danger btn-xs "><span class="glyphicon glyphicon-remove"></span> Smazat</button>                        
                                <?php
                            }
                            elseif($userinfo["exist"]=="0")
                            { ?>
                                <input type="hidden" name="changerole" value="2">
                                <input type="hidden" name="changeexist" value="1">
                                <input type="hidden" name="idchng" value="<?php echo $userinfo["id_user"] ?>">
                                <button type="submit" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span> Obnovit</button>
                        
                                <?php
                            }
                            }
                        ?>
                    </form>
                </td>
            </tr>

        <?php
        }
//    }
    ?>
    </tbody>
    </table>
        
    </div>

 <?php
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if($_POST['changerole']=="1")
        {
            
            $idchange = $_POST['idchange'];
            $idstate = $_POST['idstate'];
                
            $userchange = new userinfo();
            $userchange->Connect();

            $vypis_dat = $userchange->UpdateUserInfo($idchange,$idstate);
                                    
            header("location: index.php?page=manageusers");
        }
        elseif($_POST['changerole']=="2")
        {
            $idchng         = $_POST['idchng'];
            printr($idchng);
            $schange    = $_POST['changeexist'];            
            printr($statechange);
            
            $statechange = new userinfo();
            $statechange->Connect();

            $smazneboobnov = $statechange->DeleteUser($idchng,$schange);
            
            header("location: index.php?page=manageusers");
        }
        
        
    }
                            
            

}