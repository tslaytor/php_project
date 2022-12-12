<?php 
include_once('dbconnection.php');

$product_id = $_POST['product_id'];
$user_id = $_POST['user_id'];

$statement = $pdo->prepare('INSERT INTO basket values (:user_id, :product_id)');
$statement->bindValue(':user_id', $user_id);
$statement->bindValue(':product_id', $product_id);
$statement->execute();

