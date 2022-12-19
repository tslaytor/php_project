<?php 
include_once('dbconnection.php');
session_start();


$statement = $pdo->prepare('SELECT * FROM basket WHERE user_id = :user_id');
$statement->bindValue(':user_id', $_SESSION['user_id']);
$statement->execute();
$items = $statement->fetchAll(PDO::FETCH_ASSOC);
var_dump($items);

if($items){
    foreach($items as $item){
        $statement = $pdo->prepare('INSERT INTO order_history (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)');
        $statement->bindValue(':user_id', $item['user_id']);
        $statement->bindValue(':product_id', $item['product_id']);
        $statement->bindValue(':quantity', $item['quantity']);
        $statement->execute();

        $statement = $pdo->prepare('SELECT * FROM products WHERE id = :product_id');
        $statement->bindValue(':product_id', $item['product_id']);
        $statement->execute();
        $product = $statement->fetch(PDO::FETCH_ASSOC);

        $new_stock_level = $product['stock_level'] - $item['quantity'];

        $statement = $pdo->prepare('UPDATE products SET stock_level = :new_stock_level WHERE id = :product_id');
        $statement->bindValue(':new_stock_level', $new_stock_level);
        $statement->bindValue(':product_id', $item['product_id']);
        $statement->execute();
    }
    $statement = $pdo->prepare('DELETE FROM basket WHERE user_id = :user_id');
    $statement->bindValue(':user_id', $_SESSION['user_id']);
    $statement->execute();
}

    



?>


