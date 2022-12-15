<?php 
include_once('dbconnection.php');

var_dump($_POST);

$product_id = $_POST['product_id'];
$user_id = $_POST['user_id'];

    
$statement = $pdo->prepare('DELETE FROM basket WHERE user_id = :user_id AND product_id = :product_id');
$statement->bindValue(':user_id', $user_id);
$statement->bindValue(':product_id', $product_id);
$statement->execute();


?>


