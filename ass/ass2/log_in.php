<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Log In!</h1>

    <h4>Correctly Fill in the Fields</h4>
    
<form action="" method="post">
    
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email">

        </div>
        <br>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>
        <br>
        <button>Log In!</button>

        

    </form>
    

<?php
session_start();
include "db.inc";
$pdo=db_connect();


$email=$_POST["email"];
$password=$_POST["password"];


$sql = "SELECT * FROM user_registration WHERE email = :email AND password = :password";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $password);
$stmt->execute();


if ($stmt->rowCount() > 0) {
    $_SESSION['email'] = $email;
    header("Location: main_interface.html");
} else {

    echo "Invalid email or password.";
}


?>
    
</body>
</html>