<?php
// Database connection
require "db.php";

// Fetch progress data
$sql = "SELECT * FROM progress";
$result = $conn->query($sql);

// Create CSV file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="progress.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['Field ID', 'Farmer ID', 'Date', 'Progress']); // Header

if ($result->num_rows > 0) {
    while ($progress = $result->fetch_assoc()) {
        fputcsv($output, $progress);
    }
}
fclose($output);
exit();
