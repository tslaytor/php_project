<a href="order_history.php" class="back-button"><img src="../images/icons/back-button/back-button.png"></a>
<h1>Past order</h1>

<?php 
list($date, $time) = explode(" ", $_GET['date']);



include_once('header.php');
if(!array_key_exists('user_id', $_SESSION)):?>
    <div class="basket-message">Login to view page</div>   

<?php else:
    $statement = $pdo->prepare('SELECT * FROM order_history WHERE date = :date AND user_id = :user_id');
    $statement->bindValue(':date', $_GET['date']);
    $statement->bindValue(':user_id', $_SESSION['user_id']);
    $statement->execute();
    $orders = $statement->fetchAll(PDO::FETCH_ASSOC);

    $total = 0;
    ?>
    <div style="padding-left: 2rem;">
        <div><b>Date</b></div>
        <div style="margin-bottom: 1rem;"><?php echo $date ?></div>
        <div><b>Time</b></div>
        <div><?php echo $time ?></div>
    </div>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th class="table-heading" colspan="2">Item</th>
                    <th class="table-heading">Price</th>
                    <th class="table-heading">Quantity</th>
                    <th class="table-heading">Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orders as $order): 
                        $statement = $pdo->prepare('SELECT * FROM products WHERE id = :product_id');
                        $statement->bindValue(':product_id', $order['product_id']);
                        $statement->execute();
                        $product = $statement->fetch(PDO::FETCH_ASSOC);
                        $total += $order['quantity'] * $product['price'];
                    ?>
                <tr>
                    <td class="cell past-order_title"><?php echo $product['title']?></td>
                    <td class="past-order_image"><img src="<?php echo '../'. $product['image']?>"></td>
                    <td class="cell"><span>$ </span><span><?php echo $product['price']?></span></td>
                    <td class="cell"><span><?php echo $order['quantity']?></span></td>
                    <td class="cell"><span>$ </span><span><?php echo number_format($order['quantity'] * $product['price'], 2, ".", ",")?></span></td>
                </tr>
                <?php endforeach ?>
            </tbody>
            <tr>
                    <td class=""></td>
                    <td class=""></td>
                    <td class=""></td>
                    <td class="cell total">Total</td>
                    <td class="cell figure"><span>$ </span><span><?php echo number_format($total, 2, ".", ",")?></span></td>

                </tr>
        </table>  
    </div>

<?php endif ?>

