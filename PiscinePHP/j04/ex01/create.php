<?PHP
if (!$_POST['login'] || !$_POST['passwd'] || $_POST['submit'] !== "OK")
   {
      echo "ERROR\n";
      return ;
   }
$login = $_POST['login'];
$psw = hash('whirlpool', $_POST['passwd']);
if (!file_exists("../htdocs/"))
    mkdir("../htdocs");
if (!file_exists("../htdocs/private/"))
    mkdir("../htdocs/private/");
if (file_exists("../htdocs/private/passwd"))
   {
      $tab = unserialize(file_get_contents("../htdocs/private/passwd"));
      foreach ($tab as $index=>$valeur)
      {
        var_dump($valeur);
        var_dump($login);
         if ($valeur['login'] === $login)
         {
            echo "ERROR\n";
             return ;
         }
      }
      $tab [] = array("login" => $login, "passwd" => $psw); 
   }
else 
   {
      $tab = array("login" => $login, "passwd" => $psw); 
   }
$tab = serialize($tab);
file_put_contents("../htdocs/private/passwd", $tab);
echo "OK\n";
?>