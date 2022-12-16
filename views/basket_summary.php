<?php include_once('header.php'); ?>

<div class="basket summary">

                        <div style="display: flex; flex-direction: column;">
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
                                <?php foreach($items as $item) :?>
                                    <?php 
                                        $statement = $pdo->prepare('SELECT * FROM products WHERE id = :product_id ');
                                        $statement->bindValue(':product_id', $item['product_id']);
                                        $statement->execute();
                                        $product = $statement->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <div class="hb-item">
                                        <div class="hb-item_title"><?php echo $product['title'] ;?></div>
                                        <img class="hb-item_image" src="<?php echo '../'. $product['image']?>" style="width: 40px; height: auto;">
                                        <div  class="hb-item_quantity-wrap">
                                            Quantity
                                            <div>
                                                <span class="minustobasket">&minus;</span>
                                                <input class="item-id" type="hidden" value="<?php echo $item['product_id']?>">
                                                <input class="product-price" type="hidden" value="<?php echo number_format($product['price'], 2, '.', ',')?>">
                                                <input class="total-item-price" type="hidden" value="<?php echo number_format($item['quantity'] * $product['price'], 2, '.', ',') ?>">
                                                <input class="product-stock" type="hidden" value="<?php echo $product['stock_level']?>">
                                                <input class="hb-item_quantity" value="<?php echo $item['quantity']; ?>"></input>
                                                <span class="plustobasket">&plus;</span>
                                            </div>
                                            
                                        </div>
                                        <div>
                                            <div>price</div>
                                            
                                            <span>$</span><span class="total-price-display">  <?php echo number_format($item['quantity'] * $product['price'], 2, '.', ',') ?></span>
                                        </div>

                                        <div class="trash">
                                            <img class="trash-svg" src="../images/icons/trash/trash.svg">
                                        </div>
                                    </div>          
                                <?php endforeach ?>
                                <div>
                                    <span>Basket total: </span>
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
                                    <span>$</span><span class="total-cost">  <?php echo number_format($total, 2, '.', ',')  ?></span>
                                    <input type="hidden" class="total-cost_value" value="<?php echo number_format($total, 2, '.', ',') ?>">
                                </div>
                                <div>
                                    <button class="confirm-purchase">Confirm purchase</button>
                                </div>
                                <?php else :?>
                                    <div class="basket-message">Basket Empty</div>
                                <?php endif ?>

                            
                            
                        </div>
                    </div>
