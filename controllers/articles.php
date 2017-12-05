<?php
 //   session_start();

    // nacteni souboru
    include_once("./inc/db_pdo.class.php");
    include_once("./inc/articles.class.php");
    include_once("./inc/settings.inc.php");
    include_once("./inc/functions.php");

/*
    // prihlaseni uzivatele
    $key_my_user = "predmety_user";
    if (isset($_SESSION[$key_my_user]))
    {
        // muzu provest
    }
    else $_SESSION[$key_my_user] = array();

    $prihlasen = false;
    if (isset($_SESSION[$key_my_user]["login"]))
        $prihlasen = true;

    //printr($_POST);
    $action = @$_POST["action"]."";
    $user = @$_POST["user"];
    if ($action == "login_go")
    {
        echo "uzivatel: ";
        printr($user);

        if (trim($user["login"]) == "admin" && trim($user["heslo"]) == "admin")
        {
            $_SESSION[$key_my_user]["login"] = $user["login"];
            $prihlasen = true;
        }
    }
    // konec prihlasovani

    if ($prihlasen)
    {
        echo "<h1>Přihlášený uživatel</h1>";
    }
    else
    {
        echo "<h1>Nepřihlášený uživatel</h1>";

        echo "<form method=\"post\">
                    <input type='hidden' name='action' value='login_go'/>
                    Login: <input type='text' name='user[login]'/>
                    Heslo: <input type='text' name='user[heslo]'/>
                    <input type='submit' value='Přihlásit'>
                </form>";
    }

*/

    // vytvoreni objektu
    $articles = new articles();
    $articles->Connect();

    $vypis_clanku = $articles->LoadAllArticles();
    // printr($vypis_clanku);

    if ($vypis_clanku != null)
        foreach ($vypis_clanku as $article)
        {
            echo "Název článku: $article[a_name], Abstrakt: $article[a_abstract] <br/>";
        }



