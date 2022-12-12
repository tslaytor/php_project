<?php 
    include_once('../dbconnection.php');
    session_start();
    
    // set default session values
    // $_SESSION['user_id'] = NULL;
    // $_SESSION['username'] = "Guest";
    
    // reassign session values if login form submitted
    if($_SERVER['REQUEST_METHOD'] === "POST" && array_key_exists('username', $_POST)){
        if(array_key_exists('logout', $_POST)){
            // var_dump($_POST['logout']);
            unset($_SESSION['user_id']);
            unset($_SESSION['username']);
        }
        else{
            $statement = $pdo->prepare("SELECT * from user where username = :username");
            $statement->bindValue(':username', $_POST['username']);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if($user){
                if ($_POST['password'] === $user['password']){
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                }
                else {
                    var_dump($_SESSION);
                }
            }
        }
        
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
        <nav class="navigation-bar">
            <a class="nav-logo" href="index.php">Skate Shop</a>
            <div class="inner-nav-container">
                <!-- <div> -->
                    <button class="nav-toggle-button">
                        <span class="toggle-span"></span>
                        <span class="toggle-span"></span>
                        <span class="toggle-span"></span>
                    </button>      
                    <div class="nav-list">
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
                    <!-- </div> -->
                </div>
                

                

                <div class="navbar-icons">
                    <div class="basket">
                        <img class="basket-image"  src="../images/icons/basket/pngaaa.com-460382.png"></img>
                        <span class="basket-count"></span>
                        <div class="sub-list basket-list">
                            <?php if(array_key_exists('username', $_SESSION)) :?>
                                <?php 
                                    $statement = $pdo->prepare('SELECT * FROM basket WHERE user_id = :user_id ');
                                    $statement->bindValue(':user_id', $_SESSION['user_id']);
                                    $statement->execute();
                                    $items = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    // var_dump($items) ;
                                ?>
                                <?php foreach($items as $item) :?>
                                    <?php 
                                        $statement = $pdo->prepare('SELECT * FROM products WHERE id = :product_id ');
                                        $statement->bindValue(':product_id', $item['product_id']);
                                        $statement->execute();
                                        $product = $statement->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <div><?php echo $product['title'] ;?></div>
                                    <img src="<?php echo '../'. $product['image']?>" style="width: 40px; height: auto;">
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="profile-wrapper">
                        <div class="profile">
                            <img class="profile-image" src="../images/icons/profile/pngaaa.com-6282973.png"></img>
                        </div>
                        <div class="nav-username"><?php
                        if(array_key_exists('username', $_SESSION)){
                            echo $_SESSION['username'];
                        }
                        else {
                            echo 'Guest';
                        }
                        ?></div>
                        <div class="sub-list profile-dropdown">
                            <?php if(!array_key_exists('username', $_SESSION)) :?>
                                <form class="login-form" method="post">
                                    <div>
                                        <lable>Username</lable>
                                        <input type="text" name="username">
                                    </div>
                                    <div>
                                        <label>Password</label>
                                        <input type="password" name="password">
                                    </div>
                                    <input type="submit">
                                    <a>Register</a>
                                </form>
                            <?php else : ?>
                                <form method="post">
                                    <input name="logout" type="hidden">
                                    <input type="submit" value="Log Out">
                                </form>
                            <?php endif ?>
                        </div>
                    </div>
                   
                </div>
               
                
                    
            </div>
        </nav>