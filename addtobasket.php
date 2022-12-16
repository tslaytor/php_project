<?php 
include_once('dbconnection.php');

$product_id = $_POST['product_id'];
$user_id = $_POST['user_id'];


$statement = $pdo->prepare('SELECT * FROM basket WHERE user_id = :user_id AND product_id = :product_id');
$statement->bindValue(':user_id', $user_id);
$statement->bindValue(':product_id', $product_id);
$statement->execute();
$records = $statement->fetch(PDO::FETCH_ASSOC);

var_dump($records);


if(!$records){
    $statement = $pdo->prepare('INSERT INTO basket (user_id, product_id) values (:user_id, :product_id)');
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':product_id', $product_id);
    $statement->execute();
}
else {
    $quantity = $records['quantity'];
    $quantity += 1;
    $statement = $pdo->prepare('UPDATE basket SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id');
    $statement->bindValue(':quantity', $quantity);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':product_id', $product_id);
    $statement->execute();
}




?>


