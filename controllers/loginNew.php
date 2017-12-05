<?php
include_once("./inc/userAuth.class.php"); // trída uvedená v predchozí ukázce
session_start();

$user = new UserAuth;
$basePath = 'http://' . $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];

// odhlášení
if (isset($_SESSION['user']['id']) && isset($_GET['logout']))
{
    $_SESSION['user'] = [];
    session_regenerate_id(); // ochrana pred session fixation

    header('location:'.$basePath, TRUE, 303);
    exit;
}

// prihlášení
if (isset($_POST['username']) && isset($_POST['password']))
{
    if (($identity = $user->login($_POST['username'], $_POST['password'])) !== false)
    {
        $_SESSION['user'] = $identity;
        $_SESSION['user']['time_logged'] = new Datetime;
        session_regenerate_id();

        header ('location:'.$basePath, TRUE, 303);
        exit;
    }
    else
    {
        header ('location:'.$basePath.'?incorrect_login=1', TRUE, 303);
        exit;
    }
}


#  ####################### sablona ##########################################
echo '<meta charset="utf-8" />';

  // overení, jestli je uživatel prihlášen
  if (isset($_SESSION['user']['name']))
  {
    echo "Prihlášen: ".htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES).
            " <a href=\"$basePath?logout=1\">odhlásit</a></p>";
    if (in_array('admin', $_SESSION['user']['role']))
    {
      echo "<a href=\"$basePath?new\">Napsat clánek</a></p>";
    }
  }
  else
  {
      echo '<div>';
      if (isset($_GET['incorrect_login']))
      {
          echo "<p>Zadali jste neplatné uživatelské jméno nebo heslo</p>\n";
      }
      ?>
      <form action="<?php echo $basePath; ?>" method="post">
        Jméno: <input name="username" type="text"><br>
        Heslo: <input name="password" type="password"><br>
        <input name="submit" type="submit" value="Prihlásit">
      </form>
      </div>
<?php
  }
?>