

<?php
// DB connection
require "db.php";

if (isset($_POST['submit'])) {
    $farmer_id = $_POST['farmer_id'];
    $date = $_POST['date'];
    $progress_text = $_POST['progress_text'];

    // Handle Image Upload
    $image_name = $_FILES['field_image']['name'];
    $image_tmp = $_FILES['field_image']['tmp_name'];
    $image_path = "uploads/images/" . basename($image_name);
    move_uploaded_file($image_tmp, $image_path);

    // Handle Audio Upload
    $audio_name = $_FILES['progress_audio']['name'];
    $audio_tmp = $_FILES['progress_audio']['tmp_name'];
    $audio_path = "uploads/audios/" . basename($audio_name);
    move_uploaded_file($audio_tmp, $audio_path);

    // Insert into DB
    $sql = "INSERT INTO progress (farmer_id, date, field_image, progress_audio, progress_text)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $farmer_id, $date, $image_path, $audio_path, $progress_text);

    if ($stmt->execute()) {
        echo "Progress successfully recorded!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
