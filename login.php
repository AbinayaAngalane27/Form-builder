<?php
session_start();
include("config/database.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){

$username = trim($_POST['username']);

$stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
$stmt->bind_param("s",$username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if($user){
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    header("Location:index.php");
    exit;
}else{
    $error="Invalid Username";
}
}
?>

<link rel="stylesheet" href="style.css">

<h2>Login</h2>

<form method="POST">
<input type="text" name="username" placeholder="Enter username" required>
<button type="submit">Login</button>
</form>

<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
