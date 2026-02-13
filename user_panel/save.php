<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['role']) || $_SESSION['role']!="user"){
    die("Access Denied");
}

$form_id = intval($_POST['form_id']);

/* 1️⃣ Insert into form_responses */
$stmt = $conn->prepare("INSERT INTO form_responses (form_id) VALUES (?)");
$stmt->bind_param("i", $form_id);
$stmt->execute();

$response_id = $stmt->insert_id;

/* 2️⃣ Get all fields for this form */
$fields = $conn->query("SELECT id FROM form_fields WHERE form_id=$form_id");

/* 3️⃣ Insert each field value */
while($field = $fields->fetch_assoc()){

    $field_id = $field['id'];
    $value = $_POST['field_'.$field_id] ?? '';

    $stmt2 = $conn->prepare(
        "INSERT INTO form_response_values (response_id, field_id, value)
         VALUES (?, ?, ?)"
    );
    $stmt2->bind_param("iis", $response_id, $field_id, $value);
    $stmt2->execute();
}

header("Location: home.php");
exit;
?>
