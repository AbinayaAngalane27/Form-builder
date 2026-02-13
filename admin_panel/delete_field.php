<?php
session_start();
include("../config/database.php");

$field_id=intval($_GET['field_id']);
$form_id=intval($_GET['form_id']);

$stmt=$conn->prepare("DELETE FROM form_fields WHERE id=?");
$stmt->bind_param("i",$field_id);
$stmt->execute();

header("Location:view_form.php?form_id=".$form_id);
exit;
