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
        <th>Akce</th>
        
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
                <td><?php if($userinfo["exist"]=="0") echo "Eliminován"; elseif($userinfo["exist"]=="1") echo "Aktivní"; else echo "Chyba"?>
                </td>
                <td> <?php if($userinfo["id_right"]=="4"){
                ?> <button type="button" class="btn btn-primary disabled btn-sm">Změnit</button> <?php
                }
                else{
                ?>
                <button type="button" class="btn btn-primary active btn-sm">Změnit</button> <?php
                }
                ?>
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
}