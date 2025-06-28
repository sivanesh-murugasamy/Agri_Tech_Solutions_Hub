<?php
require "db.php"; // Database connection

// Fetch all farmers
$sql = "SELECT id, name FROM farmers";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        button {
    display: inline-block;
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    text-align: center;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    margin-top: 20px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #45a049;
}

        .form-container {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            max-width: 500px;
        }

        select, textarea, button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
   


    </style>
</head>
<body>
   
     <?php require "admin_add.php" ?>
    <main>
      
    <div class="form-container">
    <form action="admin_post_suggestion.php" method="POST">
        <label for="farmer_id">Select Farmer:</label>
        <select name="farmer_id" id="farmer_id" required>
            <option value="">Select a Farmer</option>
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="suggestion">Suggestion:</label>
        <textarea name="suggestion" id="suggestion" rows="4" placeholder="Write your suggestion..." required></textarea>

        <button type="submit">Post Suggestion</button>
    </form>
    </div>
    </main>
</body>
</html>
