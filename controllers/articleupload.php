<?php

//nacteni podpurnych souboru
include_once("./inc/db_pdo.class.php");
include_once("./inc/articlessave.class.php");
include_once("./inc/settings.inc.php");
include_once("./inc/functions.inc.php");
include_once("./view/articles.view.html");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    
//    printr($_FILES["fileToUpload"]["name"]);
    
    include_once("./inc/articleUpload.inc.php");
 //   if($uploadOk = 1){
        
        $iduser     = $_SESSION["id"];
        $nazev      = $_POST['nazev'];
        $abstract   = $_POST['abstract'];
        $filename   = $_FILES["fileToUpload"]["name"];
       
        $articles = new articlessave();
        $articles->Connect();
    
        $zapis_dat = $articles->AddArticle($iduser, $nazev, $abstract, $filename);     
    }
//    else echo "stala se chyba";

