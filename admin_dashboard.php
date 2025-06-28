<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_name'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<>
    <meta charset="UTF-8">
    <title>Admin Dashboard - AgriSmart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php require "admin_add.php" ?>

    <main>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?> 👋</h1>
      
    </main>

</body>
</html>
