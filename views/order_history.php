<?php 
    include_once('header.php');
?>

<h1>Order History</h1>


<?php 
    $statement = $pdo->prepare('SELECT * FROM order_history WHERE user_id = :user_id ORDER BY date DESC');
    $statement->bindValue(':user_id', $_SESSION['user_id']);
    $statement->execute();
    $items = $statement->fetchAll(PDO::FETCH_ASSOC);

    $date = "null";
    $quantity = 0; 
    $price = 0;
    $ordersByDate = array();
    $temp_array = array();
?>

<?php
    foreach($items as $i => $item):
        
        $statement = $pdo->prepare('SELECT * FROM products WHERE id = :product_id');
        $statement->bindValue(':product_id', $item['product_id']);
        $statement->execute();
        $product = $statement->fetch(PDO::FETCH_ASSOC);
 ?>        
        <?php if($item['date'] !== $date): ?>
            <?php 
                if(count($temp_array) > 0) {
                    $ordersByDate[] = $temp_array;
                }
                $temp_array = array();
                $temp_array[] = $item;
                $date = $item['date'];
            ?>
        <?php else : ?> 
            <?php $temp_array[] = $item; ?>
        <?php endif ?>
<?php endforeach; ?>

<?php $ordersByDate[] = $temp_array; ?>


   




<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th class="table-heading">Time</th>
                <th class="table-heading">Items Purchased</th>
                <th class="table-heading">Total Order Cost</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($ordersByDate as $orders): ?> 
            <?php 
            $total_spend = 0;
            $quantity = 0;
            foreach($orders as $order){
                $statement = $pdo->prepare("SELECT * FROM products WHERE id = :product_id");
                $statement->bindValue(':product_id', $order['product_id']);
                $statement->execute();
                $product = $statement->fetch(PDO::FETCH_ASSOC);

                
                $quantity += $order['quantity'];
                $total_spend += $product['price'] * $order['quantity'];
            }

            ?>
            <tr class="table-row" onclick="window.location='past_order.php?date=<?php echo $orders[0]['date'] ?>';">
                    <td class="cell"><?php echo $orders[0]['date'] ?></td>
                    <td class="cell"><span><?php echo $quantity?></span></td>
                    <td class="cell"><span>$ </span><span><?php echo number_format($total_spend, 2, ".", ",")?></span></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>