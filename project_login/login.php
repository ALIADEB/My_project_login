<?php
ob_start();
session_start();
if (isset($_SESSION["email"])){
header("Location: index.php");
exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if(isset($_POST['login'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            if(empty($email) || empty($password)){
                echo "<div class='alert alert-warning'>يرجى تعبئة جميع الحقول</div>";
            }
            else{
                require_once "database.php";
                $stmt = $pdo->prepare("SELECT * FROM login_reg WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user && password_verify($password, $user['password'])) {
                $_SESSION['email'] = $email;
                header("Location: index.php");
                exit;
                }else {
                echo "<div class='alert alert-danger'>بيانات الدخول غير صحيحة</div>";
                }
            }
        }
        ob_end_flush();
        ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="enter email:" require>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="enter password:" require>
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div>
            <div><p>Not registred yet  <a href="registrition.php">registrition Here</a></p></div>
        </div>
    </div>
</body>
</html>