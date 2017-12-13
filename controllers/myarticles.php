<?php

// nacteni podpurnych souboru
include_once("./inc/db_pdo.class.php");
include_once("./inc/articles.class.php");
include_once("./inc/settings.inc.php");
include_once("./inc/functions.inc.php");

    


// vytvoreni objektu
    $articles = new articles();
    $articles->Connect();

    $vypis_clanku = $articles->LoadMyArticles();
//     printr($vypis_clanku);

    if ($vypis_clanku != null)
        foreach ($vypis_clanku as $article)
        {
            echo "Název článku: $article[a_name], Abstrakt: $article[a_abstract] <br/>";
        }
    else{
        echo "Pod Vaším uživatelským jménem bohužel žádný článek neevidujeme. Můžete však přidat nový.";
    }

 //   

    include_once("./view/articles.view.html");
        
   // }
if($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once("./inc/articleUpload.inc.php");
    }
