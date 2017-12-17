<?php
// nacteni souboru
include_once("./inc/db_pdo.class.php");
include_once("./inc/articlesread.class.php");
include_once("./inc/settings.inc.php");
include_once("./inc/functions.inc.php");
include_once("./inc/userinfo.class.php");
    


// vytvoreni objektu
$articles = new articlesread();
$articles->Connect();

$vypis_clanku = $articles->LoadAllArticles();
//     printr($vypis_clanku);

if ($vypis_clanku != null){
    
    ?>   

    <div class="container">
    <h2>Články</h2>
    <table class="table table-hover">
    <thead>
      <tr>
        <th>Autor</th>
        <th>Název</th>
        <th>Abstrakt</th>
        <th>Odkaz ke stažení</th>
        <th>Stav</th>
        
      </tr>
    </thead>
    <tbody>
    <?php
    foreach ($vypis_clanku as $article)
    {
        ?>
        <tr>
        <td>
            <?php
            // vytvoreni objektu
            $userinfo = new userinfo();
            $userinfo->Connect();

            $ID = $article["id_user"];;

            $vypis_dat = $userinfo->LoadAllUserinfoAccToID($ID);
            //    printr($vypis_dat);

            if ($vypis_dat != null)
            foreach ($vypis_dat as $userinfo)
            {
                echo $userinfo["name"];
            }
        ?>
        </td>
        <td> <?php echo $article["a_name"]; ?></td>
        <td> <?php echo $article["a_abstract"]; ?></td>
        <td> <a href="./files/<?php echo $article["a_filename"]; ?>"><?php echo $article["a_filename"]; ?></a> </td>
        <td> <?php if($article["a_state"]=="1") echo "Schváleno"; elseif($article["a_state"]=="2") echo "Recenzuje se";  elseif($article["a_state"]=="3") echo "Zamítnuto"; elseif($article["a_state"]=="4") echo "Nahráno"; else echo "Stala se chyba"; ?></td>
        </tr>
    <?php    
    }
    ?>
    </tbody>
    </table>
    </div>

<?php
    }




else echo "Bohužel zde v tuto chvíli žádné články nejsou...";