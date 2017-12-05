<?php
include_once("./inc/userAuth.class.php"); // tr�da uveden� v predchoz� uk�zce
session_start();

$user = new UserAuth;
$basePath = 'http://' . $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];

// odhl�en�
if (isset($_SESSION['user']['id']) && isset($_GET['logout']))
{
    $_SESSION['user'] = [];
    session_regenerate_id(); // ochrana pred session fixation

    header('location:'.$basePath, TRUE, 303);
    exit;
}

// prihl�en�
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

  // overen�, jestli je u�ivatel prihl�en
  if (isset($_SESSION['user']['name']))
  {
    echo "Prihl�en: ".htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES).
            " <a href=\"$basePath?logout=1\">odhl�sit</a></p>";
    if (in_array('admin', $_SESSION['user']['role']))
    {
      echo "<a href=\"$basePath?new\">Napsat cl�nek</a></p>";
    }
  }
  else
  {
      echo '<div>';
      if (isset($_GET['incorrect_login']))
      {
          echo "<p>Zadali jste neplatn� u�ivatelsk� jm�no nebo heslo</p>\n";
      }
      ?>
      <form action="<?php echo $basePath; ?>" method="post">
        Jm�no: <input name="username" type="text"><br>
        Heslo: <input name="password" type="password"><br>
        <input name="submit" type="submit" value="Prihl�sit">
      </form>
      </div>
<?php
  }
?>