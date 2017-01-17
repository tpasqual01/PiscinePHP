<?PHP
session_start();
include_once("functions.php");

function f_error($msg) {
    header("Location: index.php?err=Connection%20refusee%20" . $msg);
    exit();
}

function f_sql_error($connexion) {
    header("Location: index.php?err=Connection%20impossible");
    exit();
}

if (!isset($_POST['login']) || !isset($_POST['passwd']) || !isset($_POST['name']))
   f_error("missing%20element");
if (empty($_POST['login']) || empty($_POST['passwd']) || empty($_POST['name']))
    f_error("missing%20element");

// hash du mot de passe, escape des chaines
$login = mysqli_real_escape_string($db, $_POST['login']);
$name = mysqli_real_escape_string($db, $_POST['name']);
$psw = substr(sha1($_POST['passwd']), 0, 32);

// interrogation base pour eviter doublon
$row = db_query($db, "SELECT mail, pass FROM users WHERE mail='" . $login . "'");
if (!empty($row)) {
    f_error("Compte%20existant");
}

// insertion en base
$upd = db_query($db, "INSERT INTO users (name, mail, pass) VALUES ('" . $name . "', '" . $login . "', '" . $psw . "')");
if (!$upd)
    f_error("Inserton%20failed");
header("Location: login.html");
exit();
?>
