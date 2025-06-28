<?php
// Database connection
require "db.php";

// Fetch farmers data
$sql = "SELECT * FROM farmers";
$result = $conn->query($sql);

// Create CSV file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="farmers.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['Name', 'Phone No', 'Village', 'Taluk', 'District']); // Header

if ($result->num_rows > 0) {
    while ($farmer = $result->fetch_assoc()) {
        fputcsv($output, $farmer);
    }
}
fclose($output);
exit();
