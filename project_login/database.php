<?php

$host= "mysql";
$user= "root";
$password = "ALI@3590@ALI";
$db = "login";

try{
    $pdo= new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e){
    echo "no to ...." . $e->getMessage();
}




?>