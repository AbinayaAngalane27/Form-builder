<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['role']) || $_SESSION['role']!="user"){
    die("Access Denied");
}

$form_id = intval($_GET['form_id']);

$form = $conn->query("SELECT * FROM forms WHERE id=$form_id")->fetch_assoc();

if(!$form){
    die("Invalid Form");
}

$fields = $conn->query("SELECT * FROM form_fields WHERE form_id=$form_id");
?>

<link rel="stylesheet" href="../style.css">

<h2><?php echo htmlspecialchars($form['form_name']); ?></h2>

<form method="POST" action="save.php">
<input type="hidden" name="form_id" value="<?php echo $form_id; ?>">

<?php while($f = $fields->fetch_assoc()): ?>

<label><?php echo htmlspecialchars($f['label']); ?></label>

<?php if($f['field_type']=="text"): ?>
<input type="text" name="field_<?php echo $f['id']; ?>">

<?php elseif($f['field_type']=="textarea"): ?>
<textarea name="field_<?php echo $f['id']; ?>"></textarea>

<?php elseif($f['field_type']=="number"): ?>
<input type="number" name="field_<?php echo $f['id']; ?>">

<?php elseif($f['field_type']=="dropdown"):
$opts = $conn->query("SELECT * FROM field_options WHERE field_id=".$f['id']);
?>
<select name="field_<?php echo $f['id']; ?>">
<?php while($o=$opts->fetch_assoc()): ?>
<option value="<?php echo htmlspecialchars($o['option_value']); ?>">
<?php echo htmlspecialchars($o['option_value']); ?>
</option>
<?php endwhile; ?>
</select>
<?php endif; ?>

<br><br>

<?php endwhile; ?>

<button type="submit">Submit</button>
</form>
