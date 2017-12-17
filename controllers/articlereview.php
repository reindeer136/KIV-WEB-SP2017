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

$vypis_clanku = $articles->LoadReviewableArticles();
//printr($vypis_clanku);



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
        <th>Odkaz ke stažení</th>
        <th>Odbornost</th>
        <th>Délka</th>
        <th>Kvalita</th>
        <th>Ohodnotit</th>        
      </tr>
    </thead>
    <tbody>
    <?php   
    
    foreach($vypis_clanku as $article)
    {
        $r_condition = $article["id_article"];
        //echo $article["id_article"];
        
        
        $r_articles = new managearticles();
        $r_articles->Connect();

        $vypis_r_clanku = $r_articles->LoadSpecificArticles($r_condition);
        
        if ($vypis_r_clanku != null)
        foreach($vypis_r_clanku as $r_article)
            {
            ?>
                <tr>
                    <td><?php echo $r_article["id_article"]; ?></td>
                    <td>            
                    <?php
            
                    // vytvoreni objektu
                    $uuserinfo = new userinfo();
                    $uuserinfo->Connect();

                    $id = $r_article["id_user"];

                    $vypis_u_dat = $uuserinfo->LoadAllUserinfoAccToID($id);
            

                    if ($vypis_u_dat != null)
                    foreach ($vypis_u_dat as $uuserinfo)
                    {
                    echo $uuserinfo["name"];
                    }?>
                    </td>
                    <td><?php echo $r_article["a_name"]; ?></td>
                    <td> <a href="./files/<?php echo $r_article["a_filename"]; ?>"><?php echo $r_article["a_filename"]; ?></a></td>
                            
                    <form id="eval-form" class="text-left" action="" method="post">
                    <td><input type="text" class="form-control" id="expertise" name="expertise" placeholder="<?php echo $article["a_expertise"]; ?>"></td>
            
                    <td><input type="text" class="form-control" id="length" name="length" placeholder="<?php echo $article["a_length"]; ?>"></td>
        
                    <td><input type="text" class="form-control" id="quality" name="quality" placeholder="<?php echo $article["a_quality"]; ?>"></td>
            
                    <td>
                        <input type="hidden" name="ideval" value="<?php echo $article["id_eval"]; ?>">
                        
                        <button type="submit" class="btn btn-info">Uložit</button></td>
                    </form>
            </tr>
                    <?php
                /*
                echo $r_article["a_abstract"];
                echo $r_article["a_filename"];*/
            
            }
        
    }
}


    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $id_eval        = $_POST['ideval'];
        $a_expertise    = $_POST['expertise'];
        $a_length       = $_POST['length'];
        $a_quality    = $_POST['quality'];
                
        $evalchange = new managearticles();
        $evalchange->Connect();

        $zapis_dat = $evalchange->RateArticle($id_eval, $a_expertise, $a_length, $a_quality);
                                    
        header("location: index.php?page=articlereview");
    }

        
