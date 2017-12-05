<?php
    //include souboru s funkcemi
    include_once("inc/functions.php");
    include_once("controllers/base.php");

    //nacteni parametru page
    if (isset($_REQUEST["page"]))
        $page = $_REQUEST["page"];
    else
        $page = "home";

    //testovaci vypis
    //echo "page: $page <br/>";

    // pages - povolene stranky
    $pages = array();
    $pages["home"] = "Homepage";
    $pages["articles"] = "Články";
    $pages["login"] = "Login";
    $pages["reg"] = "Registrace";
    


    //$pages["error"] = "Error 404";

    //generovani menu
    $menu = "";
        if ($pages != null)
            foreach ($pages as $key => $title)
            {
                if ($page == $key) $active_pom = "class='active'";
                else $active_pom = "";
                $menu .= "<li $active_pom><a href='index.php?page=$key'>$title</a></li>";
            }

    // pokud stranka neni povolena, vrat 404 controller
    if (!array_key_exists($page, $pages)) {
        $page = "error";
        $obsah = phpWrapperFromFile("controllers/$page.php");
        $paticka = phpWrapperFromFile("controllers/footer.php");
    }

    //include stranky s obsahem
    if (array_key_exists($page, $pages)) {        
        $obsah = phpWrapperFromFile("controllers/$page.php");
        $paticka = phpWrapperFromFile("controllers/footer.php");
    }    

    //echo "page je: $page ";

    //echo "obsah je: $obsah ";

    //šablona přes twig
    //nacist Twig pres autoloader - pokud nainstalovano pres Composer
    require_once 'vendor/autoload.php';
    $loader = new Twig_Loader_Filesystem('sablony');
    $twig = new Twig_Environment($loader, array());
    echo $twig->render('sablona1.htm', array('menu' => $menu, 'obsah' => $obsah, 'paticka'=> $paticka));