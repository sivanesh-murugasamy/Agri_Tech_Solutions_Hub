<?php
// DB connection
require 'db.php';

// Registration validation
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
    $village = mysqli_real_escape_string($conn, $_POST['village']);
    $taluk = mysqli_real_escape_string($conn, $_POST['taluk']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    
    // Validate form
    if (empty($name)) $errors[] = "Name is required";
    if (empty($password)) $errors[] = "Password is required";
    if ($password != $confirm_password) $errors[] = "Passwords do not match";
    if (empty($phone_no)) $errors[] = "Phone number is required";
    if (empty($village)) $errors[] = "Village is required";
    if (empty($taluk)) $errors[] = "Taluk is required";
    if (empty($district)) $errors[] = "District is required";
    
    if (count($errors) == 0) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO farmers (name, password, phone_no, village, taluk, district)
                VALUES ('$name', '$hashed_password', '$phone_no', '$village', '$taluk', '$district')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Registration successful. <a href='login.php'>Login here</a>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Registration</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Farmer Registration</h2>
    <?php if (!empty($errors)): ?>
        <div>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="register.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>

        <label for="phone_no">Phone Number:</label>
        <input type="text" id="phone_no" name="phone_no" required><br>

        <label for="village">Village:</label>
        <input type="text" id="village" name="village" required><br>

        <label for="taluk">Taluk:</label>
        <input type="text" id="taluk" name="taluk" required><br>

        <label for="district">District:</label>
        <input type="text" id="district" name="district" required><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
