<?php
session_start();
include("../config/database.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    die("Access Denied");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['form_name']);

    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO forms (form_name, created_by) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $_SESSION['user_id']);
        $stmt->execute();

        header("Location: home.php");
        exit;
    } else {
        $error = "Form name cannot be empty.";
    }
}
?>

<link rel="stylesheet" href="../style.css">

<h2>Create New Form</h2>

<form method="POST">
    <input type="text" name="form_name" placeholder="Form Title" required>
    <br><br>
    <button type="submit">Create</button>
    <a href="home.php">Back</a>
</form>

<?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
