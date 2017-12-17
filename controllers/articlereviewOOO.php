<?php
// nacteni souboru
include_once("./inc/db_pdo.class.php");
include_once("./inc/managearticles.class.php");
include_once("./inc/settings.inc.php");
include_once("./inc/functions.inc.php");
include_once("./inc/userinfo.class.php");
include_once("./inc/evaluation.class.php");
    

$poleclanku = array(1,2,3,4);

// vytvoreni objektu
$articles = new managearticles();
$articles->Connect();

$vypis_clanku = $articles->LoadReviewableArticles($poleclanku);
//     printr($vypis_clanku);

if ($vypis_clanku != null){
    
    ?>   

    <div class="container">
    <h2>Články k recenzi</h2>
    <table class="table table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Autor</th>
        <th>Název</th>
        <th>Odkaz ke stažení</th>
        <th>Odbornost</th>
        <th>Délka</th>
        <th>Kvalita</th>
        <th>Ohodnotit</th>        
      </tr>
    </thead>
    <tbody>
    <?php
    foreach ($vypis_clanku as $article)
    {
        ?>
        <tr>
        <td> <?php echo $article["id_article"]; ?></td>
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

        <td> <a href="./files/<?php echo $article["a_filename"]; ?>"><?php echo $article["a_filename"]; ?></a> </td>
        
        <form id="eval-form" class="text-left" action="" method="post">
        <td><input type="text" class="form-control" id="expertise" name="expertise" placeholder=""></td>
            
        <td><input type="text" class="form-control" id="length" name="length" placeholder=""></td>
        
        <td><input type="text" class="form-control" id="quality" name="quality" placeholder=""></td>
            
        <td><button type="button" class="btn btn-info">Uložit</button></td>
        
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



    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if($_POST['changerole']=="2")
        {
            
            $idart      = $_POST['idarticle'];
            $schange    = $_POST['changeexist'];         
     

            $statechange = new managearticles();
            $statechange->Connect();
            
            $smazneboobnov = $statechange->DeleteArticle($idart,$schange);           

            header("location: index.php?page=managearticles");
        }
        elseif($_POST['changerole']=="1")
        {
            $arec   = $_POST['articlerec'];
            $aid    = $_POST['idrecenzent'];
            $newstate = $_POST['stavclanku'];
                        
            $evaluation = new managearticles();
            $evaluation->Connect();
            $pridejrecenzenta = $evaluation->EvaluateArticle($aid, $arec);
            
            $newartstate = new managearticles();
            $newartstate->Connect();
            
            $zmenstav = $newartstate->UpdateArticleState($arec,$newstate);
            
            
            //header("location: index.php?page=managearticles");
        }
        
        
    }
    
