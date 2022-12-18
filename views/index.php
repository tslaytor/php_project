<?php include_once('header.php'); 
    $statement = $pdo->prepare("SELECT * FROM brand");
    $statement->execute();
    $brands = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<h1>Skate your way</h1>
<div class="splash">
    <img src="../images/rodneyhome/rodney-mullen-skateboarding.jpeg">
</div>

<div class="brand-homepage">
    <?php foreach($brands as $i => $brand): ?>
        <div class="brand-homepage_item">
            <img class="brand-homepage_logo" src="<?php echo '../'. $brand['logo'] ?>" ></img>
        </div>
    <?php endforeach ?>
</div>


    </body>
</html>

