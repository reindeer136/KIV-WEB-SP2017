<?php
 //   session_start();

    // nacteni souboru
    include_once("./inc/db_pdo.class.php");
    include_once("./inc/articles.class.php");
    include_once("./inc/settings.inc.php");
    include_once("./inc/functions.inc.php");
    


// vytvoreni objektu
    $articles = new articles();
    $articles->Connect();

    $vypis_clanku = $articles->LoadAllArticles();
//     printr($vypis_clanku);

    if ($vypis_clanku != null)
        foreach ($vypis_clanku as $article)
        {
            echo "Název článku: $article[a_name], Abstrakt: $article[a_abstract] <br/>";
        }



