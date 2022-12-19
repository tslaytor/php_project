<?php 
include_once('header.php');

$product_id = $_GET['product_id'];

$statement = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$statement->bindValue(':id', $product_id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

$statement = $pdo->prepare("SELECT * FROM brand WHERE id = :brand_id");
$statement->bindValue(':brand_id', $product['brand_id']);
$statement->execute();
$brand = $statement->fetch(PDO::FETCH_ASSOC);

if(array_key_exists('user_id', $_SESSION)){
    $statement = $pdo->prepare("SELECT * FROM basket WHERE user_id = :user_id AND product_id = :product_id");
    $statement->bindValue(':user_id', $_SESSION['user_id']);
    $statement->bindValue(':product_id', $product_id);
    $statement->execute();
    $thisProductInBasket = $statement->fetch(PDO::FETCH_ASSOC);
}

$statement = $pdo->prepare("SELECT * FROM subcategory WHERE id = :id");
$statement->bindValue(':id', $product['subcategory_id']);
$statement->execute();
$subcategory = $statement->fetch(PDO::FETCH_ASSOC);

?>
<a href="product_list.php?subcategory=<?php echo $subcategory['id'] ?>" class="back-button"><img src="../images/icons/back-button/back-button.png"></a>
<h1>Product</h1>
<div class="outer-product-container">
    <div class="product_image-container">
        <img class="product_image" src="<?php echo '../'. $product['image']?>">
    </div>
    <div class="product-container">
        <div class="product_brand">
            <img class="product_brand-logo"src="<?php echo '../'.$brand['logo'] ?>">
            <div class="product_brand-text"><?php echo strtoupper($brand['brand_name']) ?></div>
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
        <form class="product-form">
            <input type="hidden" name="product_id" value="<?php echo $product_id?>">
            <input type="hidden" name="user_id" value="<?php echo (array_key_exists('user_id', $_SESSION)) ? $_SESSION['user_id'] : 'guest' ;?>">
            <input type="hidden" name="stock" value="<?php echo $product['stock_level']?>">
            <input type="hidden" name="quant_in_basket" value="<?php echo $thisProductInBasket ? $thisProductInBasket['quantity'] : 0 ?>">
            <input type="button" value="Add to Basket" class="product_add-to-basket <?php if($product['stock_level'] <= 0){echo 'inactive';} ?>"></button>
            
        </form>
    </div>
    
</div>

