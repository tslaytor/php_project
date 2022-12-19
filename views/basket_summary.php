<h1>Basket Summary</h1>

<?php include_once('header.php'); ?>

<?php 
if(array_key_exists('username', $_SESSION)) :?>
    <?php 
        $statement = $pdo->prepare('SELECT * FROM basket WHERE user_id = :user_id ');
        $statement->bindValue(':user_id', $_SESSION['user_id']);
        $statement->execute();
        $items = $statement->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <input type="hidden" class="user-id" value="<?php echo $_SESSION['user_id']?>">
    
    <div class= <?php  echo !$items ? "basket-message" : "basket-message hidden" ?> >Basket empty</div>
        
    <?php
        $total = 0;
        foreach($items as $item){
            $total += $item['quantity']; 
        }
    ?>

    <input type="hidden" class="total-items" value="<?php echo $total;?>">
    
    <?php if ($total > 0) :?>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th class="table-heading" colspan="2">Item</th>
                    <th class="table-heading">Price</th>
                    <th class="table-heading">Quantity</th>
                    <th class="table-heading">Total Price</th>
                    <th class="table-heading">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items as $item) :?>
                    <?php 
                        $statement = $pdo->prepare('SELECT * FROM products WHERE id = :product_id ');
                        $statement->bindValue(':product_id', $item['product_id']);
                        $statement->execute();
                        $product = $statement->fetch(PDO::FETCH_ASSOC);
                    ?> 
                    <tr class="delete-item">
                        <td class="cell cell-title"><?php echo $product['title'] ;?></td>
                        <td class="cell cell-image"><img class="hb-item_image" src="<?php echo '../'. $product['image']?>"></td>
                        <td class="cell"><?php echo number_format($product['price'], 2, ".", ",")?></td>
                        <td class="cell">
                            <div  class="hb-item_quantity-wrap flex-row">
                                <input class="item-id" type="hidden" value="<?php echo $item['product_id']?>">
                                <input class="product-price" type="hidden" value="<?php echo number_format($product['price'], 2, '.', ',')?>">
                                <input class="total-item-price" type="hidden" value="<?php echo number_format($item['quantity'] * $product['price'], 2, '.', ',') ?>">
                                <input class="product-stock" type="hidden" value="<?php echo $product['stock_level']?>">
                                
                                <span class="minustobasket">&minus;</span>
                                <input class="hb-item_quantity" value="<?php echo $item['quantity']; ?>"></input>
                                <span class="plustobasket">&plus;</span>
                            </div>
                        </td>
                        <td class="cell total-price-display"><span class="total-price-display"><?php echo number_format($product['price'] * $item['quantity'], 2, ".", ",")?></span></td>
                        <td class="cell"><img class="trash-svg" src="../images/icons/trash/trash.svg"></td>
                    </tr>
                <?php endforeach ?>
                <?php 
                    $total = 0;
                    foreach($items as $item) {
                        $statement = $pdo->prepare('SELECT * FROM products WHERE id = :product_id ');
                            $statement->bindValue(':product_id', $item['product_id']);
                            $statement->execute();
                            $product = $statement->fetch(PDO::FETCH_ASSOC);
                            $total += $item['quantity'] * $product['price'];
                    } 
                    ?>

                    <tr>
                        <td class=""></td>
                        <td class=""></td>
                        <td class=""></td>
                        <td class="cell total">Total</td>
                        <td class="cell figure"><span>$ </span><span class="total-cost"><?php echo number_format($total, 2, ".", ",")?></span></td>
                        <input type="hidden" class="total-cost_value" value="<?php echo number_format($total, 2, '.', ',') ?>">
                    </tr>

            </tbody>
        </table>
    </div>
    
    <div style="text-align: end;">
        
        <button class="confirm-purchase" style="margin-right: 2rem;">Confirm purchase</button>
    </div>
    <?php endif ?>
<?php else :?>
    <div class="basket-message">Login to view page</div>
<?php endif ?>     
