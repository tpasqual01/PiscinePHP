<?php

error_reporting(E_ALL);

$conn = mysqli_connect("localhost", "root", "", "rush00");
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTO_INCREMENT, name VARCHAR(50), mail VARCHAR(70), pass VARCHAR(32), CONSTRAINT u_mail UNIQUE(mail))");
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS products (id INTEGER PRIMARY KEY AUTO_INCREMENT, ref VARCHAR(40), prix FLOAT, photo VARCHAR(254))");
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS categories (id INTEGER PRIMARY KEY AUTO_INCREMENT, ref VARCHAR(40))");
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS catprod (id_prod INTEGER, id_cat INTEGER, FOREIGN KEY (id_prod) REFERENCES products(id), FOREIGN KEY (id_cat) REFERENCES categories(id), CONSTRAINT prod_cat UNIQUE(id_prod, id_cat))");
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS baskets (id INTEGER PRIMARY KEY AUTO_INCREMENT, content TEXT, id_user INTEGER, FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE)");
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS admins (id INTEGER, FOREIGN KEY (id) REFERENCES users(id) ON DELETE CASCADE)");

// Default admin account
mysqli_query($conn, "INSERT INTO users (name, mail, pass) VALUES ('admin', 'admin@rush00.com', 'd033e22ae348aeb5660fc2140aec3585')");
$admin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users WHERE name='admin' LIMIT 1"));
mysqli_query($conn, "INSERT INTO admins (id) VALUES (" . $admin['id'] . ")");

// Base categories

$categories = [
    "Action",
    "Thriller",
    "Amour",
    "Noir et blanc"
];

// Base products

$products = [
    ["nom"=> "Sin City", "prix" => 15, "photo" => "img/sincity.jpg", "cats" => [0, 3]],
    ["nom"=> "Love Actually", "prix" => 30, "photo" => "img/loveactually.jpeg", "cats" => [2]],
    ["nom"=> "Le Journal de Bridget Jones", "prix" => 15, "photo" => "img/bridget.jpeg", "cats" => [2]],
    ["nom"=> "Les Sept Samourais", "prix" => 12.5, "photo" => "img/7samourais.jpg", "cats" => [0, 3]],
    ["nom" => "Fast and Furious 2", "prix" => 5, "photo" => "img/ff2.jpg", "cats" => [0]],
    ["nom" => "Jason Bourne", "prix" => 22.99, "photo" => "img/jasonbourne.png", "cats" => [0, 1]]
];

for ($i = 0 ; $i < count($categories) ; $i++)
{
    mysqli_query($conn, "INSERT INTO categories (ref) VALUES ('" . $categories[$i] . "')");
}


for ($i = 0 ; $i < count($products) ; $i++)
{
    mysqli_query($conn, "INSERT INTO products (ref, prix, photo) VALUES ('" . $products[$i]["nom"] . "', " . $products[$i]["prix"] . ", '" . $products[$i]["photo"] . "')");
    $prod = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM products WHERE ref='" . $products[$i]["nom"] . "' LIMIT 1"));
    for ($k = 0 ; $k < count($products[$i]["cats"]) ; $k++)
    {
        $cat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM categories WHERE ref='" . $categories[$products[$i]["cats"][$k]] . "' LIMIT 1"));
        mysqli_query($conn, "INSERT INTO catprod (id_prod, id_cat) VALUES (" . $prod["id"] . ", " . $cat['id'] . ")");
    }
}

?>
