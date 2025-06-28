<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_name'])) {
    header("Location: admin_login.php"); // Redirect to login page if not logged in
    exit();
}

// Database connection
require "db.php";

// Fetch farmers data
$sql = "SELECT * FROM farmers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Field Analysis</title>
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/table.css">
</head>
<body>

    <?php require "admin_add.php" ?>

    <main>
       
       
    
        <h1>Farmers</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone number</th>
                    <th>Village</th>
                    <th>Taluk</th>
                    <th>District</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($progress = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $progress['name']; ?></td>
                            <td><?php echo $progress['phone_no']; ?></td>
                            <td><?php echo $progress['village']; ?></td>
                            <td><?php echo $progress['taluk']; ?></td>
                            <td><?php echo $progress['district']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No progress records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <button onclick="window.location.href='export_progress.php'">Download Excel</button>
    </main>
</body>
</html>

    </main>
</body>
</html>
