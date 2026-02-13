<?php
session_start();
include("../config/database.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    die("Access Denied");
}

$forms = $conn->query("SELECT * FROM forms ORDER BY id DESC");
?>

<link rel="stylesheet" href="../style.css">

<h2>Admin Dashboard</h2>

<a href="create.php">+ Create New Form</a> |
<a href="../logout.php">Logout</a>

<br><br>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Form Name</th>
    <th>Actions</th>
</tr>

<?php while ($row = $forms->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo htmlspecialchars($row['form_name']); ?></td>
    <td>
        <a href="add_field.php?form_id=<?php echo $row['id']; ?>">Add Fields</a> |
        <a href="fields.php?form_id=<?php echo $row['id']; ?>">Preview</a> |
        <a href="responses.php?form_id=<?php echo $row['id']; ?>">Responses</a> |
        <a href="delete_form.php?form_id=<?php echo $row['id']; ?>" 
           onclick="return confirm('Delete this form?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
