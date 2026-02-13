<?php
session_start();
include("../config/database.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    die("Access Denied");
}

$form_id = intval($_GET['form_id']);

$form = $conn->query("SELECT * FROM forms WHERE id=$form_id")->fetch_assoc();
$fields = $conn->query("SELECT * FROM form_fields WHERE form_id=$form_id");
$responses = $conn->query("SELECT * FROM form_responses WHERE form_id=$form_id");

$field_array = [];
?>

<link rel="stylesheet" href="../style.css">

<h2>Responses - <?php echo htmlspecialchars($form['form_name']); ?></h2>

<table border="1" cellpadding="10">
<tr>
<th>Submitted At</th>

<?php while($f = $fields->fetch_assoc()):
$field_array[] = $f;
?>
<th><?php echo htmlspecialchars($f['label']); ?></th>
<?php endwhile; ?>
</tr>

<?php while($r = $responses->fetch_assoc()): ?>
<tr>
<td><?php echo $r['submitted_at']; ?></td>

<?php foreach($field_array as $f):
$value = $conn->query(
"SELECT value FROM form_response_values 
 WHERE response_id=".$r['id']." 
 AND field_id=".$f['id']
)->fetch_assoc();
?>
<td><?php echo $value ? htmlspecialchars($value['value']) : "-"; ?></td>
<?php endforeach; ?>

</tr>
<?php endwhile; ?>
</table>

<br>
<a href="home.php">Back</a>
