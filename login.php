<?php
// DB connection
require "db.php";

// Start session
session_start();

// Login validation
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Validate form
    if (empty($name)) $errors[] = "Name is required";
    if (empty($password)) $errors[] = "Password is required";
    
    if (count($errors) == 0) {
        $sql = "SELECT * FROM farmers WHERE name = '$name'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $farmer = $result->fetch_assoc();
            if (password_verify($password, $farmer['password'])) {
                // Set session variables
                $_SESSION['farmer_name'] = $farmer['name'];
                $_SESSION['farmer_id'] = $farmer['id']; // Optional: Store other farmer details

                // Redirect to the dashboard
                header("Location: dashboard_farm.php");
                exit(); // Make sure to exit after redirection
            } else {
                $errors[] = "Incorrect password";
            }
        } else {
            $errors[] = "No farmer found with this name";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Farmer Login</h2>
    <?php if (!empty($errors)): ?>
        <div>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
