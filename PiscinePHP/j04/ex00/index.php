<?php
	session_start();
	$login = $_GET['login'];
	$passwd = $_GET['passwd'];
	if ($_GET['login'])
	    $_SESSION['login'] = $login;
	if ($_GET['passwd'])
	    $_SESSION['passwd'] = $passwd;
	echo "<html><body>\n";
	echo '<form action="index.php" method="get">';
	echo 'Identifiant: <input type="text" name="login" value="' . $_SESSION['login'] . '" />';
	echo "<br />\n";
	echo 'Mot de passe: <input type="password" name="passwd" value="' . $_SESSION['passwd'] . '" />';
	echo "<br />\n";
	echo '<input type="submit" type="button" name="submit" value="OK"/>';
	echo "</form>\n";
	echo "</html></body>\n";
?>
