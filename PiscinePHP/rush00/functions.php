<?php

function db_connect()
{
    $db = mysqli_connect("localhost", "root", "", "rush00");
    if (mysqli_connect_errno())
        die("Failed to connect to DB : " . mysqli_connect_error());
    return $db;
}

function db_query($db, $query)
{
    $res = mysqli_query($db, $query);
    if (is_bool($res))
        return $res;
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

function is_logged($db)
{
    $uid = $_SESSION['user_id'];
    $rows = db_query($db, "SELECT id FROM users WHERE id='" . $uid . "'");
    return !empty($rows);
}

function is_admin($db, $uid)
{
    $admins = db_query($db, "SELECT admins.id FROM admins LEFT JOIN users ON admins.id=users.id WHERE admins.id='" . $uid . "'");
    return !empty($admins);
}

function escape_array($db, $arr)
{
    $res = array();
    foreach ($arr as $key => $val)
    {
        if (is_string($val))
            $res[$key] = mysqli_real_escape_string($db, $val);
        else if(is_array($val))
            $res[$key] = escape_array($db, $val);
        else
            $res[$key] = $val;
    }
    return ($res);
}

function add_category($db, $post)
{
    $match = db_query($db, "SELECT * FROM categories WHERE ref='" . $post['newcatname'] . "'");
    $ins = "match";
    if (!empty($post['newcatname']))
    {
        if (empty($match))
        {
            $ins = db_query($db, "INSERT INTO categories (ref) VALUES ('" . $post['newcatname'] . "')");
        }
    }
    else
        $ins = "Nom%20vide";
    header("Location: admin.php?msg=Done&res=" . $ins);
}

function add_product($db, $post)
{
    $match = db_query($db, "SELECT * FROM products WHERE ref='" . $post['newprodname'] . "'");
    $ins = "match";
    if (!empty($post['newprodname']) && !empty($post['newprodpic']) && !empty($post['newprodprice']))
    {
        if (empty($match))
        {
            $ins = db_query($db, "INSERT INTO products (ref, photo, prix) VALUES ('" . $post['newprodname'] . "', '" . $post['newprodpic'] . "', " . $post['newprodprice'] . ")");
        }
    }
    else
        $ins = "Champ%20vide";
    header("Location: admin.php?msg=Done&res=" . $ins);
}

function edit_user($db, $post)
{
    if (isset($post['delete']) && $post['delete'] === 'on')
    {
        if (is_admin($db, $post['id']))
        {
            header("Location: admin.php?msg=Cant%20delete%20that%20account");
            exit();
        }
        db_query($db, "DELETE FROM admins WHERE id='" . $post['id'] . "'");
        db_query($db, "DELETE FROM users WHERE id='" . $post['id'] . "'");
        header("Location: admin.php?msg=User%20deleted");
        exit();
    }
    $res = "invalid%20query";
    if (!empty($post['mail']) && !empty($post['name']))
    {
        if (!isset($post['isadmin']))
            $post['isadmin'] = 'off';
        if ($post['name'] === 'admin' && $post['isadmin'] != 'on')
            $post['isadmin'] = 'on';
        if (is_admin($db, $post['id']) && $post['isadmin'] === 'off')
            db_query($db, "DELETE FROM admins WHERE id='" . $post['id'] . "'");
        else if (!is_admin($db, $post['id']) && $post['isadmin'] === 'on')
            db_query($db, "INSERT INTO admins (id) VALUES('" . $post['id'] . "')");
        $res = db_query($db, "UPDATE users SET name='" . $post['name'] . "', mail='" . $post['mail'] . "' WHERE id='" . $post['id'] . "'");
    }
    header("Location: admin.php?msg=Done&res=" . $res);
}

function edit_prod($db, $post)
{
    if (isset($post['delete']) && $post['delete'] === 'on')
    {
        db_query($db, "DELETE FROM catprod WHERE id_prod='" . $post['id'] . "'");
        db_query($db, "DELETE FROM products WHERE id='" . $post['id'] . "'");
        header("Location: admin.php?msg=Product%20deleted");
        exit();
    }
    foreach ($post as $key => $val)
    {
        if (substr($key, 0, 10) === 'checkrmcat')
        {
            $todel = $val;
            db_query($db, "DELETE FROM catprod WHERE id_cat='" . $todel . "' AND id_prod='" . $post['id'] . "'");
        }
    }
    if (isset($post['addcat']) && !empty($post['addcat']))
    {
        $cat = db_query($db, "SELECT id, ref FROM categories WHERE ref='" . $post['addcat'] . "'");
        if (!empty($cat))
        {
            $cid = $cat[0]['id'];
            db_query($db, "INSERT INTO catprod (id_cat, id_prod) VALUES (" . $cid . ", " . $post['id'] . ")");
        }
    }
    $res = db_query($db, "UPDATE products SET ref='" . $post['ref'] . "', photo='" . $post['photo'] . "', prix='" . $post['prix'] . "' WHERE id='" . $post['id'] . "'");
    header("Location: admin.php?msg=Done&res=" . $res);
}

function edit_cat($db, $post)
{
    if (isset($post['delete']) && $post['delete'] === 'on')
    {
        db_query($db, "DELETE FROM catprod WHERE id_cat='" . $post['id'] ."'");
        db_query($db, "DELETE FROM categories WHERE id='" . $post['id'] . "'");
        header("Location: admin.php?msg=Category%20deleted");
        exit();
    }
    $res = db_query($db, "UPDATE categories SET ref='" . $post['ref'] . "' WHERE id='" . $post['id'] . "'");
    header("Location: admin.php?msg=Done&res=" . $res);
}

function delete_basket($db, $post)
{
    $res = db_query($db, "DELETE FROM baskets WHERE id='" . $post['basket'] . "'");
    header("Location: admin.php?msg=Done&res=" . $res);
}

function disconnect()
{
    session_destroy();
    $_SESSION = array();
    header("Location: index.php");
    exit();
}

function display_head($db, $b_title, $title)
{
    if (is_admin($db, $_SESSION['user_id']))
        $nav = "<a href='admin.php' class='rlink adminbutton'>Administration</a>";
    else
        $nav = "";
    if (is_logged($db))
        $nav .= "<a class='disconnect rlink' href='disconnect.php'>Se deconnecter</a>";
    else
        $nav .= "<a class='rlink' href='login.html'>Se connecter</a><a class='rlink' href='register.html'>S'inscrire</a>";
      if (isset($_GET['err']))
        $msg = $_GET['err'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $b_title; ?></title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
<?php
    if (isset($msg))
        echo "  <div class='error'><p>" . $msg . "</p></div>";
?>    <nav>
    <h2 id="acctit">
        <a class='ltit' href='index.php'>Accueil</a>
    </h2>
        <div class='navright'>
<?php if (is_logged($db) && !is_admin($db, $_SESSION['user_id']))
echo "<form action='disconnect.php' method='post' class='delacc'><input class='delbut' type='submit' name='delaccount' value='Supprimer mon compte'></form>"; ?>
            <a class="rlink" href="basket.php">Panier</a>
            <?php echo $nav; ?>
        </div>
    </nav>
    <div class='title'>
        <h1><?php echo $title; ?></h1>
    </div>
    <div class="main"><?php
}

function display_foot()
{
?>
    </div>
</body>
</html>
<?php
}

$db = db_connect();
?>
