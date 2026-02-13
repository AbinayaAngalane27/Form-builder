<?php
session_start();
include("../config/database.php");

$form_id=intval($_GET['form_id']);
$form=$conn->query("SELECT * FROM forms WHERE id=$form_id")->fetch_assoc();
$fields=$conn->query("SELECT * FROM form_fields WHERE form_id=$form_id");
?>

<link rel="stylesheet" href="../style.css">

<h2><?php echo $form['form_name']; ?></h2>

<table>
<tr>
<th>Label</th>
<th>Type</th>
<th>Required</th>
<th>Options</th>
<th>Action</th>
</tr>

<?php while($f=$fields->fetch_assoc()): ?>
<tr>
<td><?php echo $f['label']; ?></td>
<td><?php echo $f['type']; ?></td>
<td><?php echo $f['required']?'Yes':'No'; ?></td>
<td>
<?php
if(in_array($f['type'],['dropdown','radio','checkbox'])){
$opts=$conn->query("SELECT option_text FROM field_options WHERE field_id=".$f['id']);
while($o=$opts->fetch_assoc()){
echo $o['option_text']."<br>";
}
}else{
echo "-";
}
?>
</td>
<td>
<a href="delete_field.php?field_id=<?php echo $f['id']; ?>&form_id=<?php echo $form_id; ?>" onclick="return confirm('Delete?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>
