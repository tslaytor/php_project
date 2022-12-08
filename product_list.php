<?php include_once('header.php'); 

$nav_item = $_GET["nav_item"];
// $subnav_item = $_GET["subnav_item"];

$statement = $pdo->prepare("SELECT * FROM category WHERE category = :category");
$statement->bindValue(':category', $nav_item);
$statement->execute();
$category_id = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare("SELECT * FROM subcategory WHERE category_id = :category_id");
    $statement->bindValue(":category_id", $category_id[0]['id']);
    $statement->execute();
    $sub_categories = $statement->fetchAll(PDO::FETCH_ASSOC);




// print_r($nav_item);
// print_r($subnav_item);
var_dump($category_id[0]['id']);
var_dump($sub_categories);

foreach($sub_categories as $s): ?>
<p><?php echo $s['subcategory_title'] ?></p>
<?php endforeach ?>