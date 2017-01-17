<?php
session_start();
include_once("functions.php");

$basket = $_SESSION['basket'];
if (!isset($basket['content']))
    $basket['content'] = array();
if (!isset($basket['total']))
    $basket['total'] = 0;

$g = $_POST;
if (isset($g['del']) && isset($g['ref']) && isset($g['delete']))
{
    $ind = -1;
    $price = -1;
    for ($i = 0 ; $i < count($basket['content']) ; $i++)
    {
        if ($basket['content'][$i]['ref'] === $g['ref'])
            $ind = $i;
    }
    if ($ind > -1)
    {
        $price = $basket['content'][$ind]['prix'];
        array_splice($_SESSION['basket']['content'], $ind, 1);
        $_SESSION['basket']['total'] -= $price;
    }
    header("Location: basket.php");
    exit();
}

if (/*isset($g['content']) && isset($g['prix']) && */isset($g['valid']))
{
    if (is_logged($db) && !empty($basket['content']))
    {
        $uid = $_SESSION['user_id'];
        // drop previous basket
        db_query($db, "DELETE FROM baskets WHERE id_user='" . $uid . "'");
        // insert new one
        db_query($db, "INSERT INTO baskets (content, id_user) VALUES ('" . json_encode($basket['content']) . "', '" . $uid . "')");
    }
    header("Location: basket.php");
    exit();
}

display_head($db, "Panier", "Votre panier");
?>
        <div class="basket">
            <?php
        $apayer = 0;
        foreach($basket['content'] as $prod)
        {
            echo "<form class='baskform' action='basketsupp.php' method='post' id='sup" . $prod['id_prod'] . "' name='sup" . $prod['id_prod'] . "'>";
            echo "  <p class='baskitem'>" . $prod['refprod'] . "</p>";
            echo "  <p class='baskprice'>Quantite : " . $prod['quantity'] . "</p>";
            echo "  <p class='baskprice'>Prix : " . (floatval($prod['price']) *  floatval($prod['quantity'])) . " euros</p>";
            $apayer = $apayer + (floatval($prod['price']) *  floatval($prod['quantity']));
            echo "  <input type='hidden' name='ref' value='" . $prod['refprod'] . "'>";
            echo "  <input type='hidden' name='idprod' value='" . $prod['id_prod'] . "'>";
            echo "  <input type='submit' value='Supprimer' name='delete'>";
            echo "</form>";
        }  ?>

            <form id="panier" action="basket.php" method="post">
                <h3 class="total">Prix total: <?php echo $apayer; ?></h3>
                <!--<input type="hidden" value="<php json_encode($basket['content']); >" name="content">
                <input type="hidden" value="<php echo $basket['total']; >" name="prix">-->
                <input type="submit" value="Valider votre panier" name="valid">
            </form>
        </div>
<?php
display_foot();
?>
