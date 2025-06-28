_<?php
require "db.php"; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $farmer_id = mysqli_real_escape_string($conn, $_POST['farmer_id']);
    $suggestion = mysqli_real_escape_string($conn, $_POST['suggestion']);

    // Insert suggestion into the database
    $sql = "INSERT INTO suggestion (farmer_id, content) VALUES ('$farmer_id', '$suggestion')";

    if ($conn->query($sql) === TRUE) {
        echo "Suggestion posted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Redirect or display a message after submission
    header("Location: Recommendation_admin.php");
    exit();
}
?>
