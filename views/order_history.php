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

<?php
foreach($ordersByDate as $orders): ?>
   <div class="past-order" style="border: solid black 2px; margin: 1rem; display:flex; justify-content: space-evenly">
        <?php 
        $total_spend = 0;
        $quantity = 0;
        foreach($orders as $order){
            $statement = $pdo->prepare("SELECT * FROM products WHERE id = :product_id");
            $statement->bindValue(':product_id', $order['product_id']);
            $statement->execute();
            $product = $statement->fetch(PDO::FETCH_ASSOC);

            $total_spend += $product['price'];
            $quantity += $order['quantity'];
        }
        $date = $orders[0]['date'];

         ?>
        <input type="hidden" class="date" value="<?php echo $date ?>">
        <div><?php echo $date ?></div>
        <input type="hidden" class="quantity" value="<?php echo $quantity ?>">
        <div><?php echo $quantity ?></div>
        <input type="hidden" class="total-spend" value="<?php echo $total_spend ?>">
        <div>
            <span>$ </span><span><?php echo $total_spend ?></span>
        </div> 

    </div>
<?php endforeach ?>
   

