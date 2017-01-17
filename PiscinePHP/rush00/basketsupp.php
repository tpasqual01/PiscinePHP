<?php
session_start();
include_once("functions.php");
if (!isset($_POST['delete']) || !isset($_POST['idprod']))
{
  header("Location: basket.php");
  exit();
}

$id_prod = $_POST['idprod'];
$basket = $_SESSION['basket'];

for ($i = 0 ; $i < count($_SESSION['basket']['content']) ; $i++)
{
    if ($_SESSION['basket']['content'][$i]['id_prod'] === $id_prod)
        array_splice($_SESSION['basket']['content'], $i, 1);
}
header("Location: basket.php");
exit();
?>
