<?php 
include_once('header.php');
// echo "hello" ;

$product_id = $_GET['product_id'];

$statement = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$statement->bindValue(':id', $product_id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

$statement = $pdo->prepare("SELECT * FROM brand WHERE id = :brand_id");
$statement->bindValue(':brand_id', $product['brand_id']);
$statement->execute();
$brand = $statement->fetch(PDO::FETCH_ASSOC);

?>

<div class="product-container">
    <div class="product_image-container">
        <img class="product_image" src="<?php echo '../'. $product['image']?>">
    </div>
    <div class="product_brand">
        <img class="product_brand-logo"src="<?php echo '../'.$brand['logo'] ?>">
        <div class="product_brand-text"><?php echo strtoupper($brand['brand']) ?></div>
    </div>
    <div class="product_text">  <?php echo $product['title'] ?></div>
    <div class="product_price"><?php echo '$'.$product['price'] ?></div>
    <div class="product_stock-level"><?php 
        if($product['stock_level'] > 0){
            echo "<span class='in-stock'>". $product['stock_level']." in stock</span>";
        }
        else {
            echo "<span class='out-of-stock'>Out of stock</span>";
        }
        ?></div>
    <form class="product-form" method="POST" action="../addtobasket.php">
        <input type="hidden" name="product_id" value="<?php echo $product_id?>">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']?>">
        <input type="submit" class="product_add-to-basket">Add to basket</button>
        
    </form>
    <form>
        <button class="product_add-to-wishlist">Add to wishlist</button>
    </form>
    
    <div class="product_description"><?php echo $product['description'] ?></div>
</div>

