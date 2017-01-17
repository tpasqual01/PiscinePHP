<?php
session_start();
include_once("functions.php");

if (!is_admin($db, $_SESSION['user_id']))
    header("Location: index.php");

//var_dump($_POST);

if (isset($_POST['id']) && isset($_POST['user']) && isset($_POST['name']) && isset($_POST['mail']))
    edit_user($db, escape_array($db, $_POST));
if (isset($_POST['newcatname']) && isset($_POST['addcategory']))
    add_category($db, escape_array($db, $_POST));
if (isset($_POST['addproduct']) && isset($_POST['newprodname']) && isset($_POST['newprodprice']) && isset($_POST['newprodpic']))
    add_product($db, escape_array($db, $_POST));
if (isset($_POST['id']) && isset($_POST['ref']) && isset($_POST['cat']))
    edit_cat($db, escape_array($db, $_POST));
if (isset($_POST['id']) && isset($_POST['ref']) && isset($_POST['prod']) && isset($_POST['prix']) && isset($_POST['photo']))
    edit_prod($db, escape_array($db, $_POST));
if (isset($_POST['basket']) && isset($_POST['delete']))
    delete_basket($db, escape_array($db, $_POST));

?>
