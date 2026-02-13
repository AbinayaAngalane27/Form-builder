<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['role']) || $_SESSION['role']!="user"){
    die("Access Denied");
}

$forms = $conn->query("SELECT * FROM forms");
?>

<link rel="stylesheet" href="../style.css">

<h2>User Dashboard</h2>
<a href="../logout.php">Logout</a>

<ul>
<?php while($f=$forms->fetch_assoc()): ?>
<li>
<?php echo htmlspecialchars($f['form_name']); ?>
| <a href="fill.php?form_id=<?php echo $f['id']; ?>">Fill</a>
</li>
<?php endwhile; ?>
</ul>
