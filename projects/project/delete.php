<?php
session_start();
include "db.inc";
$pdo = db_connect();
$email = $_SESSION['email'];
$teamName = $_GET['team_name'];


try {
    // Update the team information in the database
    $sql = "DELETE FROM team WHERE team_name = :teamName";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':teamName', $teamName);
    $stmt->execute();

//         Redirect to the dashboard
    header("Location: dashboard.php");
    exit();
} catch (PDOException $e) {
    echo $e->getMessage();
    die("Database connection failed: " . $e->getMessage());
}

?>