<?php
session_start();
include_once("functions.php");
display_head($db, "Index", "FilmZy - Accueil");

$cats = db_query($db, "SELECT * FROM categories");

for ($i = 0 ; $i < count($cats) ; $i++)
{
    $cat_id = $cats[$i]['id'];
    $cat_ref = $cats[$i]['ref'];
    $art = db_query($db, "SELECT * FROM products LEFT JOIN catprod ON products.id=catprod.id_prod WHERE catprod.id_cat='" . $cat_id . "'");
    $art_photo = isset($art[0]['photo']) ? $art[0]['photo'] : false;
?>
        <div class='cat'>
            <div class='centered'>
            <a href="cat.php?id=<?php echo $cat_id; ?>" class="noul">
            <p class="catname"><?php echo $cat_ref; ?></p>
            <?php if ($art_photo)
                    echo "<img src='" . $art_photo . "' alt='cat " . $cat_id . "' class='thumb'>";
                  else
                    echo "<div class='thumbdef'><img src='img/gliss.jpg' alt='noproduct' class='defimg'><p>Aucun produit dans cette categorie</p></div>";
?>
            </a>
            </div>
        </div>
<?php
}
?>

<?php
display_foot();
?>
