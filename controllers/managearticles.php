<?php
// nacteni souboru
include_once("./inc/db_pdo.class.php");
include_once("./inc/managearticles.class.php");
include_once("./inc/settings.inc.php");
include_once("./inc/functions.inc.php");
include_once("./inc/userinfo.class.php");
include_once("./inc/evaluation.class.php");
    


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
        <th>ID</th>
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
    foreach ($vypis_clanku as $articles)
    {
        ?>
        <tr>
        <td> <?php echo $articles["id_article"]; ?></td>
        <td>
            <?php
            // vytvoreni objektu
            $userinfo = new userinfo();
            $userinfo->Connect();

            $id = $articles["id_user"];

            $vypis_dat = $userinfo->LoadAllUserinfoAccToID($id);
            //    printr($vypis_dat);

            if ($vypis_dat != null)
            foreach ($vypis_dat as $userinfo)
            {
                echo $userinfo["name"];
            }
        ?>
        </td>
        <td> <?php echo $articles["a_name"]; ?></td>

        <td> <?php if($articles["a_state"]=="1") echo "Schváleno"; elseif($articles["a_state"]=="2") echo "Recenzuje se";  elseif($articles["a_state"]=="3") echo "Zamítnuto"; elseif($articles["a_state"]=="4") echo "Nahráno"; else echo "Stala se chyba"; ?></td>
            
        <td>
            
            <button type="button" class="btn btn-primary active btn-xs" data-toggle="modal" data-target="#myModal<?php echo $userinfo["id_user"]; ?>">Nastavení článku</button>
                <div class="modal fade" id="myModal<?php echo $userinfo["id_user"]; ?>" role="dialog">
                <div class="modal-dialog">
    
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Nastavení podrobností článku <?php echo $articles["a_name"] ?></h4>
                        </div>
                        <div class="modal-body">     
                       
                            <p>Vyberte prosím alespoň tři z následujících recenzentů </p>
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
                                            <input type="hidden" name="articlerec" value="<?php echo $articles["id_article"]; ?>">
                                            <input type="hidden" name="idrecenzent" value="<?php echo $recenzentinfo["id_user"]; ?>">
                                            <input type="hidden" name="stavclanku" value="2">
                                            <input type="hidden" name="idstate" value="0">      
                                            <button type="submit" class="btn btn-success btn-xs">Vybrat</button>
                            
                                            </form></td>
                                        </tr>
                                    <?php    
                                    } ?>
                                        
                                    </tbody>
                            </table>
                        <div>
                            <p>Tento článek již hodnotili:</p>
                                
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Jméno</th>
                                            <th>Hodnocení</th>
                                        </tr>
                                    </thead>
                                    <?php
    
                                                //echo $articles["id_article"];

                                                $kdohodnotil = new manageevaluations();
                                                $kdohodnotil->Connect();
                                                $hodnocenyclanek = $articles["id_article"];
                                    
                                                $hodnoceni_recenzentu = $kdohodnotil->LoadEvalSpecificData($hodnocenyclanek);
        
                                                //printr($hodnoceni_recenzentu);
                                        
                                                if($kdohodnotil != null){ ?>
                                    
                                    
                                    
                                    <tbody>
                                         
                                                    <?php
                                                    foreach($hodnoceni_recenzentu as $kdohodnotil)
                                                    
                                                    { ?>
                                        <tr>
                                            <td>    <?php
                                                        //echo $kdohodnotil["id_user"];
                                                        
                                                        $jmenorec = new userinfo();
                                                        $jmenorec->Connect();
                                                        
                                                        $id_rreecc = $kdohodnotil["id_user"];
                                                        
                                                        $zjistijmeno = $jmenorec->LoadAllUserinfoAccToID($id_rreecc);
                                                        
                                                        foreach($zjistijmeno as $jmenorec){
                                                            
                                                            echo $jmenorec["name"];
                                                            
                                                        }
                                                        
                                                       ?>
                                            
                                            </td>
                                            <td>        <?php 
                                                        
                                                        $score = $kdohodnotil["a_expertise"] + $kdohodnotil["a_length"] + $kdohodnotil["a_quality"];
                                                        
                                                        echo "Celkové skore = "; echo $score;
                                                        //echo $kdohodnotil["a_expertise"];
                                                        ?>
                                            </td>
                                        </tr>

                                                      <?php  
                                                    }
                                                    
                                                    
                                                    
                                                }

                                                ?> 
                                    </tbody>
                            </table>
                            
                            
                            
                            <div>
                            <p>Nyní zbývají již jen dvě možnosti: </p>
                            <table>
                            <tr><td>
                            <form action="" method="post">
                            <input type="hidden" name="changerole" value="3">
                            <input type="hidden" name="stavclanku" value="1">
                            <input type="hidden" name="articlerec" value="<?php echo $articles["id_article"] ?>">
                            <button type="submit" class="btn btn-info btn-xs">Schválit</button></form>
                                </td>
                                
                                <td>
                            <form action="" method="post">
                            <input type="hidden" name="changerole" value="3">
                            <input type="hidden" name="stavclanku" value="3">
                            <input type="hidden" name="articlerec" value="<?php echo $articles["id_article"] ?>">
                            <button type="submit" class="btn btn-warning btn-xs">Zamítnout</button>
                            </form>
                                    </td>
                            </tr>
                            </table>
                            </div>
                            
                        </div>
                            
                            
                            
                            
                           
                        
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
                    <?php if($articles["a_exist"]=="1")
                            { ?>
                        
                                <input type="hidden" name="changerole" value="2">
                                <input type="hidden" name="changeexist" value="0">
                                <input type="hidden" name="idarticle" value="<?php echo $articles["id_article"] ?>">
                                <button type="submit" class="btn btn-danger btn-xs "><span class="glyphicon glyphicon-remove"></span> Smazat</button>                        
                                <?php
                            }
                            elseif($articles["a_exist"]=="0")
                            { ?>
                                <input type="hidden" name="changerole" value="2">
                                <input type="hidden" name="changeexist" value="1">
                                <input type="hidden" name="idarticle" value="<?php echo $articles["id_article"] ?>">
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
            
            
            header("location: index.php?page=managearticles");
        }
        elseif($_POST['changerole']=="3")
        {
            $arec   = $_POST['articlerec'];
            $newstate = $_POST['stavclanku'];
                        
            $newartstate = new managearticles();
            $newartstate->Connect();
            
            $zmenstav = $newartstate->UpdateArticleState($arec,$newstate);
            
            
            header("location: index.php?page=managearticles");
        }
        
        
    }
    
