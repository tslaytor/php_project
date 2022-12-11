<?php 
    $pdo = new PDO('mysql:host=localhost;dbname=skate_shop', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    session_start();

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $_SESSION['user_id'] = $_POST['user_id'];
        $statement = $pdo->prepare("SELECT username from user where id = :id");
        $statement->bindValue(':id', $_SESSION['user_id']);
        $statement->execute();
        $statement->fetch(PDO::FETCH_ASSOC);
        $username = $statement['username'];
    }
    else {
        
        $_SESSION['user_id'] = NULL;
        $_SESSION['user_name'] = "Guest";
    }
     

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../static/styles.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="../static/skate.js"></script>
    </head>
    <body>
        <div class="navigation-bar">
            <a class="nav-logo" href="index.php">Skate Shop</a>
            <div class="inner-nav-container">
                <div>
                    <button class="nav-toggle-button">
                        <span class="toggle-span"></span>
                        <span class="toggle-span"></span>
                        <span class="toggle-span"></span>
                    </button>      
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
                                <span><?php echo ucwords($category['category'])?></span>
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
                </div>
                

                

                <div class="navbar-icons">
                    <div class="basket">
                        <img class="basket-image"  src="../images/icons/basket/pngaaa.com-460382.png"></img>
                    </div>
                    <div class="profile-wrapper">
                        <div class="profile">
                            <img class="profile-image" src="../images/icons/profile/pngaaa.com-6282973.png"></img>
                        </div>
                        <div class="nav-username"><?php echo $_SESSION['user_name']?></div>
                        <!-- <ul class="nav-list">
                            <form method="post">
                                <lable>Username</lable>
                                <input type="text">
                                <label>Password</label>
                                <input type="password">
                            </form> -->
                        </ul>
                    </div>
                </div>
               
                
                    
            </div>
        </div>