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
 <!--       <th>Odkaz ke stažení</th>   -->
        <th>Stav</th>
        <th>Schvalovací řízení</th>
        <th>Změna stavu</th>
        
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

            $ID = $article["id_user"];

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

 <!--       <td> <a href="./files/<?php //echo $article["a_filename"]; ?>"><?php //echo $article["a_filename"]; ?></a> </td>  -->
        <td> <?php if($article["a_state"]=="1") echo "Schváleno"; elseif($article["a_state"]=="2") echo "Recenzuje se";  elseif($article["a_state"]=="3") echo "Zamítnuto"; elseif($article["a_state"]=="4") echo "Nahráno"; else echo "Stala se chyba"; ?></td>
            
        <td>
            
            <button type="button" class="btn btn-primary active btn-xs" data-toggle="modal" data-target="#myModal<?php echo $userinfo["id_user"]; ?>">Nastavení článku</button>
                <div class="modal fade" id="myModal<?php echo $userinfo["id_user"]; ?>" role="dialog">
                <div class="modal-dialog">
    
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Nastavení podrobností článku <?php echo $article["a_name"] ?></h4>
                        </div>
                        <div class="modal-body">     
                       
                            <p>Vyberte prosím tři z následujících recenzentů </p>
                            <?php
                                    $role = "3";
                                    $recenzentinfo = new userinfo();
                                    $recenzentinfo->Connect();
                                    
                                    

                                    $vypis_recenzentu = $recenzentinfo->LoadAllUserinfoAccToRole($role);
                            ?>
                            <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Jméno</th>
                                            <th>Přiřadit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php
                                    foreach ($vypis_recenzentu as $recenzentinfo)
                                    { 
                                        ?><tr>
                                            <td> <?php echo $recenzentinfo["id_user"]; ?></td>
                                            <td> <?php echo $recenzentinfo["name"]; ?></td>
                                            <td> 
                                            <form action="" method="post">
                                
                                            <input type="hidden" name="changerole" value="1">
                                            <input type="hidden" name="idrecenzent" value="<?php echo $recenzentinfo["id_user"] ?>">                                
                                            <input type="hidden" name="idstate" value="0">      
                                            <button type="submit" class="btn btn-success btn-xs">Vybrat</button>
                            
                                            </form></td>
                                        </tr>
                                    <?php    
                                    } ?>
                                        
                                    </tbody>
                            </table>
                            
                            
                            
                           
                        
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
                    <?php if($article["a_exist"]=="1")
                            { ?>
                        
                                <input type="hidden" name="changerole" value="2">
                                <input type="hidden" name="changeexist" value="0">
                                <input type="hidden" name="idarticle" value="<?php echo $article["id_article"] ?>">
                                <button type="submit" class="btn btn-danger btn-xs "><span class="glyphicon glyphicon-remove"></span> Smazat</button>                        
                                <?php
                            }
                            elseif($article["a_exist"]=="0")
                            { ?>
                                <input type="hidden" name="changerole" value="2">
                                <input type="hidden" name="changeexist" value="1">
                                <input type="hidden" name="idarticle" value="<?php echo $article["id_article"] ?>">
                                <button type="submit" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span> Obnovit</button>
                        
                                <?php
                            }
                            
                        ?>
                    </form>
            
            
            
            
            </td>
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
        if($_POST['changerole']=="1")
        {
            
            $idchange = $_POST['idchange'];
            $idstate = $_POST['idstate'];
                
            $userchange = new userinfo();
            $userchange->Connect();

            $vypis_dat = $userchange->UpdateUserInfo($idchange,$idstate);
                                    
            header("location: index.php?page=managearticles");
        }
        elseif($_POST['changerole']=="2")
        {
            $idart      = $_POST['idarticle'];
            $schange    = $_POST['changeexist'];            
                        
            $statechange = new managearticles();
            $statechange->Connect();

            $smazneboobnov = $statechange->DeleteArticle($idart,$schange);
            
            header("location: index.php?page=managearticles");
        }
        
        
    }
    
