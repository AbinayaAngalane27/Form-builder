<?php
session_start();
include("../config/database.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    die("Access Denied");
}

$form_id = intval($_GET['form_id']);

$stmt = $conn->prepare("DELETE FROM forms WHERE id=?");
$stmt->bind_param("i", $form_id);
$stmt->execute();

header("Location: home.php");
exit;
?>
