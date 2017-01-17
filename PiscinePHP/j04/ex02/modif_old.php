<?PHP
	if (!$_POST['login'] || !$_POST['oldpw'] ||  $_POST['submit'] !== "OK")
	   {
	      echo "ERROR\n";
	      return ;
	   }
	$login = $_POST['login'];
	$oldpw = $_POST['oldpw'];
	$psw = hash('whirlpool', $_POST['newpw']);
	if (!file_exists("../htdocs"))
				mkdir("../htdocs");
	if (!file_exists("../htdocs/private"))
				mkdir("../htdocs/private");
	if (file_exists("../htdocs/private/passwd"))
	   {
	      $tab = unserialize(file_get_contents("../htdocs/private/passwd"));
	      $matched = false;
	      foreach ($tab as $valeur)
	      {
	         	if ($valeur['login'] === $login && $valeur['passwd'] === $oldpw)
	            	$matched = true;
	      }  
	      if ($matched == false)
	      {       
	         	echo "ERROR\n";
	            return ;
	      }
	      $tab = array("login" => "$login", "passwd" => "$psw");
	    } 
	else 
		{
	       echo "ERROR\n";
	       return ;
	    }
	$tab = serialize($tab);
	file_put_contents("../htdocs/private/passwd", $tab);
	echo "OK\n";
?>
