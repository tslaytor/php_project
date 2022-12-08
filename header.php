<?php 
    $pdo = new PDO('mysql:host=localhost;dbname=skate_shop', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="styles.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="skate.js"></script>
    </head>
    <body>
        <div class="navigation-bar">
            <div class="nav-logo" href="#">Skate Shop</div>
            <div class="inner-nav-container">     
                <nav class="nav-list">
                    <?php 
                        $statement = $pdo->prepare("SELECT * FROM category");
                        $statement->execute();
                        $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

                        $statement = $pdo->prepare("SELECT * FROM subcategory");
                        $statement->execute();
                        $sub_items = $statement->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <?php foreach ($categories as $key =>$category):?>

                        <div class="nav-item">
                            <span class="plus-minus">&plus;</span>
                            <span ><?php echo ucwords($category['category'])?></span>
                            <ul class="sub-list">
                            
                                <?php foreach($sub_items as $sub_item): ?>
                                    <?php if($sub_item["category_id"] === $category["id"]): ?>
                                        <li class="sub-list_item">
                                            <a href="product_list.php?subcategory=<?php echo $sub_item["id"]?>" class="sub-list_title"><?php echo ucwords($sub_item["subcategory_title"]) ?></a>
                                        </li>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </ul>
                                    </div>
                    <?php endforeach ?>    
                </nav>

                <div id="basket"></div> 
                <button class="nav-toggle-button">
                    <span class="toggle-span"></span>
                    <span class="toggle-span"></span>
                    <span class="toggle-span"></span>
                </button>     
            </div>
        </div>