<?php
ob_start();
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>verification</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if(isset($_POST['verification'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            require_once "database.php";
            $stmt = $pdo->prepare("SELECT * FROM login_reg WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if($user && password_verify($password,$user['password'])){
                $_SESSION['email']= $email;
                header("Location: amendment.php");
            }else{
                echo "<div class='alert alert-danger'>الايميل او كلمة السر خاطئة</div>";
            }


        }
        ob_end_flush();
        ?>
        <form method="post">
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="enter email.....">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="enter password.....">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="التالي" name="verification">
            </div>
        </form>
    </div>

    
</body>
</html>