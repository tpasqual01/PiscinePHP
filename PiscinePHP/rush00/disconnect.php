<?php
session_start();
include_once("functions.php");

if (isset($_POST['delaccount']))
{
    db_query($db, "DELETE FROM users WHERE id='" . $_SESSION['user_id'] . "'");
}
disconnect();
?>
