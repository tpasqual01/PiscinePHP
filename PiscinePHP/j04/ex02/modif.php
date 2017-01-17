<?php
if (!$_POST['login'] || !$_POST['oldpw'] || !$_POST['newpw'] || $_POST['submit'] !== 'OK')
{
	echo "ERROR\n";
	return ; 
}
$oldpw = hash("whirlpool", $_POST['oldpw']);
$newpw = hash("whirlpool", $_POST['newpw']);
$login = $_POST['login'];
$my_tab_users = unserialize(@file_get_contents("../htdocs/private/passwd"));
foreach ($my_tab_users as $key => $val)
{
	if ($val['login'] === $login && $val['passwd'] === $oldpw)
	{
		$val['passwd'] = $newpw;
		$user_index = $key;
		$user_find = $val;
		break ;
	}
	else
	{
		echo "ERROR\n";
		return ; 
	}
}
$my_tab_users[$user_index] = $user_find;
$my_tab_users = serialize($my_tab_users);
file_put_contents("../htdocs/private/passwd", $my_tab_users);
echo "OK\n";
?>