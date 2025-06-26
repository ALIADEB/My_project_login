<?php
ob_start();
session_start();
if (isset($_SESSION["email"])){
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registrition</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        
        if(isset($_POST['registrition'])){
            $name = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $repeat_password = $_POST['repeat_password'];
           
            $erorr=array();
            if(empty($name) || empty($email) || empty($password) || empty($repeat_password) ){
                array_push($erorr,"لابد من تعبئة كل البيانات");
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                array_push($erorr, "الايميل غير صالح");
            }
            if(strlen($password) < 8){
                array_push($erorr,"كلمة المرور اقل من ثمانية حروف");
            }
            if($password!== $repeat_password){
                array_push($erorr,"كلمة المرور غير مطابقة");
            }
            require_once "database.php";
            $stmt = $pdo->prepare("SELECT * FROM login_reg WHERE email = ? ");
            $stmt->execute([$email]);
            if($stmt->fetchColumn() > 0){
                array_push($erorr,"الايميل مستخدم بالفعل");
            }
            if(!empty($erorr)){
                foreach($erorr as $eror){
                    echo "<div class='alert alert-danger'>$eror</div>";
                }  
            }
            else{
                $passwordHash = password_hash($password,PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO login_reg(full_name, email, password) VALUES(?,?,?)");
                $stat = $stmt->execute([$name,$email,$passwordHash]);
                if($stat){
                    $_SESSION['email'] = $email;
                    header("Location: index.php");
                exit;
                }
            }
           

        }
        ob_end_flush();
        ?>
        <form  method="post">
            <div class="form-group">
                <input type="text" name="fullname" class="form-control" placeholder="Full name: ">
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="email: ">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="password: ">
            </div>
            <div class="form-group">
                <input type="password" name="repeat_password" class="form-control" placeholder="repeat_password: ">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="registrition" name="registrition">
            </div>
        </form>
        <div>
            <div><p>Already Registered <a href="login.php">Login Here</a></p></div>
        </div>
    </div>
</body>
</html>