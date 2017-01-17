<?php
session_start();
include_once("functions.php");
if (!isset($_POST['idprod']) || !isset($_POST['catid']) || !isset($_POST['quantity']) || !isset($_POST['price']))
{
  header("Location: cat.php");
  exit();
}
$basket = $_SESSION['basket'];
$id_prod = $_POST['idprod'];
$catid = $_POST['catid'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];
$ref_prod = $_POST['refprod'];
// content [id_prod, idcat, qty, price]
//var_dump($basket);
//var_dump($_POST);
$newdata =  array (
      'id_cat' => $catid,
      'id_prod' => $id_prod,
      'refprod' => $ref_prod,
      'quantity' => $quantity,
      'price' => $price);

$exists = false;
for ($i = 0 ; $i < count($basket['content']) ; $i++)
{          
        //echo "<br>";
        //var_dump($basket['content']);
        //var_dump($id_prod);
        if ($basket['content'][$i]['id_prod'] === $id_prod)
        {
          $_SESSION['basket']['content'][$i]['quantity'] = floatval($basket['content'][$i]['quantity']) + floatval($quantity); 
          $exists = true;
          break;
        }    
}
if (!$exists)
   $_SESSION['basket']['content'][] = $newdata;
//   array_push($_SESSION['basket']['content'], $newdata);
header("Location: cat.php?id=" . $catid);
exit();
?>