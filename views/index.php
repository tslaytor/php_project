<?php include_once('header.php'); 

    

    
    $statement = $pdo->prepare("SELECT * FROM brand");
    $statement->execute();
    $brands = $statement->fetchAll(PDO::FETCH_ASSOC);
    // var_export($brands);
?>

<h2 style="margin-left: 32px;">Shop by brand</h2>
<div class="brand-homepage">
    <?php foreach($brands as $i => $brand): ?>
        <div class="brand-homepage_item">
            <img class="brand-homepage_logo" src="<?php echo '../'. $brand['logo'] ?>" ></img>
        </div>
    <?php endforeach ?>
</div>


    </body>
</html>

