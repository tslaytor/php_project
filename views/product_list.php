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



<div class="products">
    <?php foreach($products as $product):?>
        <div class="products-item">
            <div class="products-item_image-wrapper">
                <img class="products-item_image" src="<?php echo $product['image'] ?> ">
            </div>
            <div class="products-item_text">
                <div class="products-item_text-top">
                    <div class="products-item_brand">
                        <?php foreach($brands as $brand) :?>
                            <?php if($brand['id'] === $product['brand_id']){
                                echo strtoupper($brand['brand']);
                            }?>
                        <?php endforeach ?>
                    </div>
                    <div class="products-item_title">
                        <?php echo ucwords(strtolower($product['title']))?>
                    </div>
                </div>
                <div class="products-item_text-bottom">
                    <div class="product-item_price">
                        <?php echo "$".$product['price']?>
                    </div>

                </div>
            </div>
            
                
            
        </div>
    <?php endforeach ?>
</div>






