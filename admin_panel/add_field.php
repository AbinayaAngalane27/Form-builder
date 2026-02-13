<?php
session_start();
include("../config/database.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    die("Access Denied");
}

$form_id = intval($_GET['form_id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $label = trim($_POST['label']);
    $type = $_POST['field_type'];

    $stmt = $conn->prepare("INSERT INTO form_fields (form_id, label, field_type) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $form_id, $label, $type);
    $stmt->execute();

    $field_id = $stmt->insert_id;

    if ($type == "dropdown" && !empty($_POST['options'])) {
        $options = explode(",", $_POST['options']);
        foreach ($options as $opt) {
            $opt = trim($opt);
            $stmt2 = $conn->prepare("INSERT INTO field_options (field_id, option_value) VALUES (?, ?)");
            $stmt2->bind_param("is", $field_id, $opt);
            $stmt2->execute();
        }
    }

    header("Location: fields.php?form_id=".$form_id);
    exit;
}
?>

<link rel="stylesheet" href="../style.css">

<h2>Add Field</h2>

<form method="POST">
    <input type="text" name="label" placeholder="Field Label" required>
    <br><br>

    <select name="field_type" required>
        <option value="text">Text</option>
        <option value="textarea">Textarea</option>
        <option value="number">Number</option>
        <option value="dropdown">Dropdown</option>
    </select>

    <br><br>

    <input type="text" name="options" placeholder="Option1, Option2 (for dropdown)">
    <br><br>

    <button type="submit">Add Field</button>
</form>

<br>
<a href="home.php">Back to Dashboard</a>
