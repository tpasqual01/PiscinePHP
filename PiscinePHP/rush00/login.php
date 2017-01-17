<?php
session_start();
include_once("functions.php");

function f_error($msg) {
    header("Location: index.php?err=Connection%20refusee%20" . $msg);
    exit();
}

function f_sql_error($db) {
    header("Location: index.php?err=Connection%20impossible");
    exit();
}

if (!isset($_POST['login']) || !isset($_POST['passwd']))
   f_error("champ%20inexistant");
if (empty($_POST['login']) || empty($_POST['passwd']))
   f_error("champ%20vide");

$login = mysqli_real_escape_string($db, $_POST['login']);
$psw = substr(sha1($_POST['passwd']), 0, 32);

$row = db_query($db, "SELECT id, mail, pass FROM users WHERE mail='" . $login . "'");
if (!$row)
{
    f_sql_error($db);
}

if ($row[0]['pass'] != $psw)
  f_error("nopass");

$_SESSION['user_id'] = $row[0]['id'];
$_SESSION['mail'] = $row[0]['mail'];
// content [id_prod, idcat, qty, price]
//$_SESSION['basket'] = ['total' => 0, 'content' => []];

if (is_admin($db, $row[0]['id']))
{
    header("Location: admin.php");
    exit();
}

header("Location: index.php");
exit();
?>
