<?php
// DB connection
require "db.php";

// Start session
session_start();

// Login validation
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_name = mysqli_real_escape_string($conn, $_POST['admin_name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Validate form
    if (empty($admin_name)) $errors[] = "Admin name is required";
    if (empty($password)) $errors[] = "Password is required";
    
    if (count($errors) == 0) {
        // Query to fetch the admin record
        $sql = "SELECT * FROM admins WHERE admin_name = '$admin_name'";
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            // Direct password comparison
            if ($password === $admin['password']) {
                // Set session variables
                $_SESSION['admin_name'] = $admin['admin_name'];
                $_SESSION['admin_id'] = $admin['id']; // Optional: Store other admin details

                // Redirect to the admin dashboard
                header("Location: admin_dashboard.php");
                exit(); // Make sure to exit after redirection
            } else {
                $errors[] = "Incorrect password";
            }
        } else {
            $errors[] = "No admin found with this name";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include your CSS file -->
</head>
<body>
    <h2>Admin Login</h2>
    
    <?php if (!empty($errors)): ?>
        <div>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="admin_login.php" method="POST">
        <label for="admin_name">Admin Name:</label>
        <input type="text" id="admin_name" name="admin_name" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
