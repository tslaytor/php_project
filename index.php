<?php include_once('header.php'); 
    
    $statement = $pdo->prepare("SELECT * FROM brand");
    $statement->execute();
    $brands = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

        <?php foreach($brands as $i => $brand): ?>
            <p style="z-index: -2;"><?php echo $i. ': '. $brand['brand']?></p>
        <?php endforeach ?>
    </body>
</html>

