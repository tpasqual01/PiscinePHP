<?php
session_start();
include_once("functions.php");

$cid = -1;
if (isset($_GET['id']))
{
    $dummy = mysqli_real_escape_string($db, $_GET['id']);
    $cat = db_query($db, "SELECT * FROM categories WHERE id='" . $dummy . "'");
    $cat_id = $cat[0]['id'];
    $cat_name = $cat[0]['ref'];
    $prods = db_query($db, "SELECT * FROM products INNER JOIN catprod ON products.id=catprod.id_prod WHERE catprod.id_cat='" . $cat_id . "'");
}
else
    header("Location: index.php?err=Pas%20de%20categorie%20correspondante");

display_head($db, "Categorie " . $cat_name, "Categorie : " . $cat_name);

/*for ($i = 0 ; $i < count($basket['content']) ; $i++)
{
        if ($basket['content'][$i]['id_prod'] = $id_prod)
        {
          echo $basket['content'][$i]['qty']; 
          $exists = true;
          break;
        }    
}*/

for ($i = 0 ; $i < count($prods) ; $i++)
{ ?>
        <div class="prod">
            <h3 class="ptitle"><?php echo $prods[$i]['ref']; ?></h3>
            <img src="<?php echo $prods[$i]['photo']; ?>" alt="product <?php echo $prods[$i]['id']; ?>" title="<?php echo $prods[$i]['ref']; ?>" class="pimg">
            <p class="price"><?php echo $prods[$i]['prix']; ?> euros</p>
            <form method="post" action="baskethidden.php" name="basketadd<?php echo $prods[$i]['id']; ?>">
                <input type="number" value="1" name="quantity">
                <input type="hidden" value="<?php echo $cat_id; ?>" name="catid">
                <input type="hidden" value="<?php echo $prods[$i]['id']; ?>" name="idprod">
                <input type="hidden" value="<?php echo $prods[$i]['ref']; ?>" name="refprod">
                <input type="hidden" value="<?php echo $prods[$i]['prix']; ?>" name="price">
                <input type="submit" value="Ajouter">
            </form>
        </div>
<?php
}
display_foot();
?>
