<?php
ob_start();
session_start();
if (!isset($_SESSION["email"])){
header("Location: login.php");
}
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="continer">
        <h1>Welcome to dashboard</h1>
        <a href="logout.php" class="btn btn-warning">Logout</a>
        <div>
            <br>
            <br>
            <br>
            <br>
            <a href="verification.php" class="btn btn-warning">data verification</a>
        </div>
    </div>
</body>
</html>