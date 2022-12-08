<?php include_once('header.php'); 

$id = $_GET["subcategory"];
// $subnav_item = $_GET["subnav_item"];

$statement = $pdo->prepare("SELECT * FROM products WHERE subcategory_id = :id");
$statement->bindValue(':id', $id);
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $pdo->prepare("SELECT * FROM brand");
$statement->execute();
$brands = $statement->fetchAll(PDO::FETCH_BOTH);

?>



<div class="products-container">
    <?php foreach($products as $product):?>
        <div class="products-container_item">
            <div class="product-image_wrapper">
                <img class="product-image" src="<?php echo $product['image'] ?> ">
            </div>
            <div>
                <?php foreach($brands as $brand) :?>
                    <?php if($brand['id'] === $product['brand_id']){
                        echo $brand['brand'];
                    }?>
                <?php endforeach ?>
            </div>
    
            
            <?php echo $product['title']?>
        </div>
    <?php endforeach ?>
</div>






