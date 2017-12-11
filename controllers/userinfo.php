<?php

    // nacteni souboru
    include_once("./inc/db_pdo.class.php");
    include_once("./inc/userinfo.class.php");
    include_once("./inc/settings.inc.php");
    include_once("./inc/functions.inc.php");


// vytvoreni objektu
    $userinfo = new userinfo();
    $userinfo->Connect();

    $vypis_dat = $userinfo->LoadAllUserinfos();
//    printr($vypis_dat);

    if ($vypis_dat != null)
        foreach ($vypis_dat as $userinfo)
        {
            echo "ID uživatele: $userinfo[id_user], Jméno uživatele: $userinfo[name] <br/>";
            
            $existuje = $userinfo["exist"];
            //printr($existuje);
        }



