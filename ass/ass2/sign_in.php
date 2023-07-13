<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Sign Up!</h1>

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

        <div>
                <label for="confirm_password">Repeat Password</label>
                <input type="password" id="confirm_password" name="confirm_password">
        </div>

        <br>
        <button>Sign Up!</button>

    </form>

    <br>
    <p><bold>Already have an Account <a href="./log_in.php">Log In</a></bold></p>
    

<?php
session_start();
include "db.inc";
$pdo=db_connect();

try {

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ($_POST["password"] !== $_POST["confirm_password"]) {
    die("Password
    ''s must match");
}

$email=$_POST["email"];
$password=$_POST["password"];


$sql = "INSERT INTO user_registration (email, password) VALUES (:email, :password)";
$stmt = $pdo->prepare($sql);

    if (!$stmt) {
        die("SQL error: " . $pdo->errorInfo()[2]);
    }
   
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
        $_SESSION['email'] = $email;
        header("Location: main_interface.html");
    } else {
        $errorCode = $stmt->errorInfo()[1];
        if ($errorCode === 1062) {
            die("Email already taken");
        } else {
            die("Database error: " . $stmt->errorInfo()[2]);
        }
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
    
</body>
</html>