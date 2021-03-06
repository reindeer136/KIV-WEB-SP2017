<?php
// nacteni souboru
include_once("./inc/db_pdo.class.php");
include_once("./inc/managearticles.class.php");
include_once("./inc/settings.inc.php");
include_once("./inc/functions.inc.php");
include_once("./inc/userinfo.class.php");
    


// vytvoreni objektu
$articles = new managearticles();
$articles->Connect();

$vypis_clanku = $articles->LoadVisibleArticles();
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

            $id = $article["id_user"];

            $vypis_dat = $userinfo->LoadAllUserinfoAccToID($id);
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