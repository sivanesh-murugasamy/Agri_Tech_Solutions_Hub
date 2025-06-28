<?php session_start(); 

// Check if the farmer is logged in
if (!isset($_SESSION['farmer_name'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$farmer_name = $_SESSION['farmer_name']; // Get farmer's name from session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgriSmart Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="">
    <style>
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #2E7D32;
            --accent-color: #8BC34A;
            --text-color: #333;
            --light-color: #f8f9fa;
            --sidebar-width: 250px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: var(--text-color);
        }
        
        /* Header Styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
        }
        
        .logo-container i {
            font-size: 24px;
            color: var(--primary-color);
            margin-right: 10px;
        }
        
        .logo-text {
            font-weight: bold;
            font-size: 20px;
            color: var(--primary-color);
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            cursor: pointer;
            position: relative;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--accent-color);
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 10px;
        }
        
        .user-avatar i {
            color: white;
        }
        
        .user-name {
            font-weight: 500;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 45px;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 4px;
        }
        
        .dropdown-content a {
            color: var(--text-color);
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
        }
        
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        
        .show {
            display: block;
        }
        
        /* Sidebar Styles */
        .sidebar {
            height: 100%;
            width: var(--sidebar-width);
            position: fixed;
            top: 70px;
            left: 0;
            background-color: white;
            overflow-x: hidden;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 5px;
        }
        
        .sidebar-menu a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 16px;
            color: var(--text-color);
            display: flex;
            align-items: center;
            transition: 0.3s;
            border-left: 4px solid transparent;
        }
        
        .sidebar-menu a i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background-color: #f8f9fa;
            color: var(--primary-color);
            border-left-color: var(--primary-color);
        }
        
        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: 70px;
            padding: 30px;
        }
        
        .welcome-card {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .welcome-card h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-icon {
            background-color: rgba(76, 175, 80, 0.1);
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .card-icon i {
            color: var(--primary-color);
            font-size: 24px;
        }
        
        .card h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .card p {
            color: #666;
            margin-bottom: 15px;
        }
        
        .btn {
            display: inline-block;
            padding: 8px 15px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: var(--secondary-color);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                padding-top: 15px;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-menu-btn {
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo-container">
            <i class="fas fa-leaf"></i>
            <span class="logo-text">AgriSmart</span>
        </div>
        <div class="user-profile" onclick="toggleDropdown()">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <span class="user-name"><?php echo $farmer_name; ?></span>
            <i class="fas fa-angle-down" style="margin-left: 5px;"></i>
            <div id="profileDropdown" class="dropdown-content">
                <a href="profile.php"><i class="fas fa-user-circle"></i> Profile</a>
                <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="dashboard_farm.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="Farmer/Weather.php"><i class="fas fa-cloud-sun"></i> Weather Updates</a></li>
            <li><a href="Farmer/progress.php"><i class="fas fa-chart-line"></i> Progress</a></li>
            <li><a href="Farmer/suggestion.php"><i class="fas fa-lightbulb"></i> Suggestions</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="welcome-card">
            <h2>Welcome, <?php echo $farmer_name; ?>!</h2>
            <p>Manage your farm, check weather updates, and optimize your productivity with AgriSmart.</p>
        </div>
        
        <div class="dashboard-cards">
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-cloud-sun"></i>
                </div>
                <h3>Weather Forecast</h3>
                <p>Check today's weather and 5-day forecast to plan your farming activities efficiently.</p>
                <a href="Farmer/Weather.php" class="btn">View Weather</a>
            </div>
            
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Farm Progress</h3>
                <p>Track your crops' growth and farm productivity with detailed analytics.</p>
                <a href="Farmer/progress.php" class="btn">View Progress</a>
            </div>
            
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3>Smart Suggestions</h3>
                <p>Get AI-powered suggestions on crop management, pest control, and more.</p>
                <a href="Farmer/suggestion.php" class="btn">View Suggestions</a>
            </div>
        </div>
    </div>

    <script>
        // JavaScript function to toggle dropdown
        function toggleDropdown() {
            document.getElementById("profileDropdown").classList.toggle("show");
        }
        
        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.user-profile') && !event.target.parentNode.matches('.user-profile')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>
</html>