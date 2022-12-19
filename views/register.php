<?php include_once('header2.php'); ?>
<form action="" method="POST" class="register-form">
    <div>
        <label for="username">Username</label>
        <input type="text" name="username">
    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" name="password">
    </div>
    <div>
        <label for="confirm-password">Confirm Password</label>
        <input type="password" name="confirm-password">
    </div>
    <input type="submit" value="Register">
</form>

<?php 
if($_SERVER['REQUEST_METHOD'] === "POST") :?>

    <?php 
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];
    ?>
    <?php if(strlen($username) <= 0):?>
        <script type="text/javascript">alert('Please enter a username');</script>;
    <?php elseif($password != $confirmPassword):?>
        <script type="text/javascript">alert('Passwords must match');</script>;
    <?php else:?>
        <?php 
        $statement = $pdo->prepare('INSERT INTO user (username, password) values (:username, :password)');
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $password);
        $statement->execute();

        $statement = $pdo->prepare('SELECT * FROM user WHERE username = :username AND password = :password');
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        ?>
        <script type="text/javascript">alert('You have successfully registered');</script>;
        <?php
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        ?>
        <script type="text/javascript">window.location.replace("index.php");</script>;
    <?php endif ?>
<?php endif ?>

