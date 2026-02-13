<?php
session_start();
include("../config/database.php");

// Only admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    die("Access Denied");
}

// Generate CSRF token for delete links
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

$form_id = intval($_GET['form_id']);
$form = $conn->query("SELECT * FROM forms WHERE id=$form_id")->fetch_assoc();
if (!$form) {
    die("Form not found.");
}

$fields = $conn->query("SELECT * FROM form_fields WHERE form_id=$form_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Preview: <?php echo htmlspecialchars($form['form_name']); ?></title>
<style>
    body { font-family: Arial, sans-serif; background: #f8f9fa; padding: 20px; margin: 0; }
    h2 { color: #333; margin-bottom: 10px; }
    a { text-decoration: none; color: white; background: #4CAF50; padding: 6px 12px; border-radius: 4px; display: inline-block; margin-top: 5px; }
    a.delete-btn { background: #e74c3c; }
    a.delete-btn:hover { background: #c0392b; }
    input, textarea, select { display: block; margin: 5px 0 10px; padding: 8px; width: 100%; max-width: 400px; }
    label { font-weight: bold; margin-top: 10px; display: block; }
    hr { border: 0.5px solid #ddd; margin: 20px 0; }
    .field-container { margin-bottom: 20px; }
    .action-links { margin-top: 10px; }
    @media (max-width: 480px) {
        input, textarea, select { width: 100%; }
    }
</style>
</head>
<body>

<h2>Preview: <?php echo htmlspecialchars($form['form_name']); ?></h2>
<a href="add_field.php?form_id=<?php echo $form_id; ?>">+ Add More Fields</a>
<br><br>

<?php while($field = $fields->fetch_assoc()): 
    $type = $field['field_type'];
    $required = $field['required'] ?? 0; // safe default
?>
<div class="field-container">
    <label><?php echo htmlspecialchars($field['label']); ?><?php echo $required ? " *" : ""; ?></label>

    <?php if ($type == "text"): ?>
        <input type="text" <?php echo $required ? "required" : ""; ?>>
    <?php elseif ($type == "textarea"): ?>
        <textarea <?php echo $required ? "required" : ""; ?>></textarea>
    <?php elseif ($type == "number"): ?>
        <input type="number" <?php echo $required ? "required" : ""; ?>>
    <?php else: ?>
        <select <?php echo $required ? "required" : ""; ?>>
        <?php
        $options = $conn->query("SELECT * FROM field_options WHERE field_id=".$field['id']);
        while($opt = $options->fetch_assoc()):
        ?>
            <option><?php echo htmlspecialchars($opt['option_value']); ?></option>
        <?php endwhile; ?>
        </select>
    <?php endif; ?>

    <div class="action-links">
        <a class="delete-btn" href="delete_field.php?field_id=<?php echo $field['id']; ?>&form_id=<?php echo $form_id; ?>&csrf=<?php echo $csrf_token; ?>" onclick="return confirm('Delete this field?')">Delete Field</a>
    </div>
</div>
<hr>
<?php endwhile; ?>

<a href="home.php">Back</a>

</body>
</html>
