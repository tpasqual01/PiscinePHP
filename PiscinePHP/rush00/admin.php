<?php
session_start();
include_once("functions.php");

if (!is_admin($db, $_SESSION['user_id']))
    header("Location: index.php");

$cats = db_query($db, "SELECT * FROM categories");
$users = db_query($db, "SELECT * FROM users");
$prods = db_query($db, "SELECT * FROM products");
$baskets = db_query($db, "SELECT * FROM baskets");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<?php if (isset($_GET['msg']))
        echo "<div class='amsg'><p>" . $_GET['msg'] . "</p></div>";
?>
    <div class='title'>
        <a href="index.php" class="linkright">Accueil</a>
        <h1>Panneau d'administration</h1>
    </div>
    <div class="mainadm">
        <div class="users admcont">
            <p class="sectiontitle">Utilisateurs</p>
<?php
    for ($i = 0; $i < count($users) ; $i++)
    {?>
        <div class='user'>
            <form name="user<?php echo $users[$i]['id']; ?>" action="admin_cmds.php" method="post">
                <input type="hidden" name="id" value="<?php echo $users[$i]['id']; ?>">
                <input type="text" name="name" value="<?php echo $users[$i]['name']; ?>">
                <input type="text" name="mail" value="<?php echo $users[$i]['mail']; ?>">
                <input type="text" name="pass" disabled value="<?php echo $users[$i]['pass']; ?>">
                <label><input type="checkbox" name="isadmin" <?php echo (is_admin($db, $users[$i]['id']) ? "checked='true' value='true'" : ""); ?>> Droits admins </label>
                <label><input class="del" type="checkbox" name="delete"> Supprimer</label>
                <input type="hidden" name="user" value="true">
                <input type="submit" value="Modifier" name="valid">
            </form>
        </div>
<?php }
?>
        </div>
        <div class="cats admcont">
            <p class="sectiontitle">Categories</p>
<?php
    for ($i = 0; $i < count($cats) ; $i++)
    {?>
        <div class='acat'>
            <form name="cat<?php echo $cats[$i]['id']; ?>" action="admin_cmds.php" method="post">
                <input type="hidden" name="id" value="<?php echo $cats[$i]['id']; ?>">
                <input type="hidden" name="cat" value="true">
                <input type="text" name="ref" value="<?php echo $cats[$i]['ref']; ?>">
                <label><input type="checkbox" class="del" name="delete"> Supprimer</label>
                <input type="submit" value="Modifier" name="valid">
            </form>
        </div>
<?php }
?>
            <form name="addcateg" action="admin_cmds.php" method="post" class="addcatform">
                <label>Nom : <input type="text" value="" name="newcatname"></label>
                <input type="submit" value="Ajouter une categorie" name="addcategory" class="addcatvalid">
            </form>
        </div>
        <div class="prods admcont">
            <p class="sectiontitle">Produits</p>
<?php
    for ($i = 0; $i < count($prods) ; $i++)
    {?>
        <div class='prod'>
            <form name="prod<?php echo $prods[$i]['id']; ?>" action="admin_cmds.php" method="post">
                <input type="hidden" name="id" value="<?php echo $prods[$i]['id']; ?>">
                <input type="hidden" name="prod" value="true">
                <input type="text" name="ref" value="<?php echo $prods[$i]['ref']; ?>">
                <input type="text" name="prix" value="<?php echo $prods[$i]['prix']; ?>">
                <input type="text" name="photo_dis" disabled value="<?php echo $prods[$i]['photo']; ?>">
                <input type="hidden" name="photo" value="<?php echo $prods[$i]['photo']; ?>">
                <label><input class="del" type="checkbox" name="delete"> Supprimer</label>
                <input class="catmod" type="text" name="addcat" placeholder="Ajouter une categorie" value="">
<?php
    $pcats = db_query($db, "SELECT * FROM categories LEFT JOIN catprod ON catprod.id_cat=categories.id WHERE catprod.id_prod='" . $prods[$i]['id'] . "'");
    foreach ($pcats as $pcat)
    {
        echo "<label class='pcat'><input type='checkbox' name='checkrmcat" . $pcat['id'] . "' value='" . $pcat['id'] . "'> " . $pcat['ref'] . "</label>";
    }
?>                <input type="submit" value="Modifier" name="valid">
            </form>
        </div>
<?php }
?>
            <form name="addprod" action="admin_cmds.php" method="post" class="addprodform">
                <label>Nom : <input type="text" value="" name="newprodname"></label>
                <label>Photo : <input type="text" value="" name="newprodpic"></label>
                <label>Prix : <input type="text" value="" name="newprodprice"></label>
                <input type="submit" value="Ajouter un produit" name="addproduct" class="addprodvalid">
            </form>
        </div>
        <div class="baskets admcont">
            <p class="sectiontitle">Paniers</p>
<?php
for ($i = 0 ; $i < count($baskets) ; $i++)
{
    $str = "";
    $price = 0.0;
    $content = json_decode($baskets[$i]['content'], true);
    foreach($content as $prods)
    {
        $str .= $prods['refprod'] . " (x" . $prods['quantity'] . ") => " . floatval($prods['price']) * floatval($prods['quantity']) . PHP_EOL;
        $price += floatval($prods['price']) * floatval($prods['quantity']);
    }
    echo "<form class='bask' action='admin_cmds.php' method='post'>";
    echo "  <p class='buser'>Utilisateur " . $baskets[$i]['id_user'] . "</p>";
    echo "  <p class='bcont'>" . $str . "</p>";
    echo "  <p class='bprice'>Total : " . $price . " euros</p>";
    echo "  <input type='hidden' name='basket' value='" . $baskets[$i]['id'] . "'>";
    echo "  <input type='submit' value='Supprimer' name='delete'>";
    echo "</form>";
}
?>
        </div>
    </div>
</body>
</html>

