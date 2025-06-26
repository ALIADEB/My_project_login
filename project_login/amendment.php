<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>amendment</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if(isset($_POST['amendment'])){
            $name = $_POST['new_name'];
            $email = $_POST['new_email'];
            $password = $_POST['new_password'];
            $new_password_statement = $_POST['new_password_statement'];

            $erorr=array();
            if(empty($name) || empty($email) || empty($password) || empty($new_password_statement) ){
                array_push($erorr,"لابد من تعبئة كل البيانات");
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                array_push($erorr, "الايميل غير صالح");
            }
            if(strlen($password) < 8){
                array_push($erorr,"كلمة المرور اقل من ثمانية حروف");
            }
            if($password!== $new_password_statement){
                array_push($erorr,"كلمة المرور غير مطابقة");
            }
            require_once "database.php";
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM login_reg WHERE email = ? AND email != ? ");
            $stmt->execute([$email,$_SESSION['email']]);
            if($stmt->fetchColumn() > 0){
                array_push($erorr,"لابد من تغيير الايميل الايميل مستخدم بالفعل");
            }
            if(!empty($erorr)){
                foreach($erorr as $eror){
                    echo "<div class='alert alert-danger'>$eror</div>";
                }  
            }else{
                $old_email = $_SESSION['email'];
                $passwordhash = password_hash($password,PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE login_reg SET full_name = ? , email = ? , password = ? WHERE email= ? ");
                $stat = $stmt->execute([$name,$email,$passwordhash,$old_email = $_SESSION]);
                if($stat){
                    $_SESSION['email'] = $email;
                    header("Location: index.php");
                }
            }
        }
        ob_end_flush();
        ?>
        <form  method="post">
            <div class="form-group">
                <input type="text" name="new_name" class="form-control" placeholder="ادخل الاسم الجديد ......">
            </div>
            <div class="form-group">
                <input type="email" name="new_email" class="form-control" placeholder="ادخل الايميل الجديد ......">
            </div>
            <div class="form-group">
                <input type="password" name="new_password" class="form-control" placeholder="ادخل كلمة المرور  الجديدة ......">
            </div>
            <div class="form-group">
                <input type="password" name="new_password_statement" class="form-control" placeholder="ادخل تاكيد كلمة المرور  الجديدة ......">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="update" name="amendment">
            </div>
        </form>
    </div>
</body>
</html>