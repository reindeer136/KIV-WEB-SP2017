<?php
// nacteni souboru
include_once("./inc/db_pdo.class.php");
include_once("./inc/userinfo.class.php");
include_once("./inc/settings.inc.php");
include_once("./inc/functions.inc.php");


// vytvoreni objektu
$userinfo = new userinfo();
$userinfo->Connect();

$username = $_SESSION['user'];

$vypis_dat = $userinfo->LoadAllUserinfos($username);
//    printr($vypis_dat);
?>



       
<?php 
if ($vypis_dat != null){ ?>
<h2>Informace o uživateli</h2>
<table class="table table-hover">
    <thead>
      <tr>
        <th>ID uživatele</th>
        <th>Jméno uživatele</th>
        <th>Založeno</th>
      </tr>
    </thead>
    <tbody>
    <?php
    foreach ($vypis_dat as $userinfo)
    {
        ?>
        <tr>
            <td><?php echo $userinfo["id_user"]; ?></td>
            <td><?php echo$userinfo["name"]; ?></td>
            <td><?php echo$userinfo["created"]; ?></td>
        </tr>
        <?php
    } ?>
    </tbody>
</table><?php
}

