<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dynamic Form Builder</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f2f5;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        text-align: center;
    }

    h2 {
        color: #333;
        margin-bottom: 20px;
    }

    a {
        display: inline-block;
        padding: 10px 20px;
        text-decoration: none;
        background-color: #4CAF50;
        color: white;
        border-radius: 5px;
        transition: background 0.3s;
    }

    a:hover {
        background-color: #45a049;
    }
</style>
</head>
<body>
<div>
    <h2>Welcome to  Form Builder</h2>

    <?php if(!isset($_SESSION['role'])): ?>
        <a href="login.php">Login</a>
    <?php else: ?>
        <?php
        if($_SESSION['role']=="admin"){
            header("Location:admin_panel/home.php");
        } else {
            header("Location:user_panel/home.php");
        }
        exit;
        ?>
    <?php endif; ?>
</div>
</body>
</html>
