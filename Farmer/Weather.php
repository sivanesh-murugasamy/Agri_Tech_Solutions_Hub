<?php
session_start();

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
    <title>Weather Updates - AgriSmart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js library -->
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
        
        /* Weather Specific Styles */
        .weather-header {
            background: linear-gradient(135deg, #3498db, #1a6aa8);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .current-weather {
            display: flex;
            align-items: center;
        }
        
        .weather-icon {
            font-size: 60px;
            margin-right: 20px;
        }
        
        .temperature {
            font-size: 48px;
            font-weight: 400;
            margin: 0;
        }
        
        .condition {
            font-size: 20px;
            opacity: 0.9;
        }
        
        .location {
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 5px;
        }
        
        .weather-details {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 15px;
        }
        
        .weather-detail {
            display: flex;
            align-items: center;
        }
        
        .weather-detail i {
            margin-right: 8px;
            font-size: 18px;
        }
        
        .forecast-container {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .forecast-container h3 {
            margin-bottom: 20px;
            font-size: 20px;
            color: var(--text-color);
            display: flex;
            align-items: center;
        }
        
        .forecast-container h3 i {
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        .forecast-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .forecast-item {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .forecast-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .forecast-day {
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--primary-color);
        }
        
        .forecast-icon {
            font-size: 36px;
            margin: 10px 0;
            color: #3498db;
        }
        
        .forecast-temp {
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        .forecast-condition {
            color: #666;
        }
        
        .chart-container {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .chart-container h3 {
            margin-bottom: 20px;
            font-size: 20px;
            display: flex;
            align-items: center;
        }
        
        .chart-container h3 i {
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        canvas {
            width: 100% !important;
            height: 300px !important;
        }
        
        /* Additional tips section */
        .tips-container {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .tips-container h3 {
            margin-bottom: 20px;
            font-size: 20px;
            display: flex;
            align-items: center;
        }
        
        .tips-container h3 i {
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        .tips-list {
            list-style: none;
        }
        
        .tips-list li {
            padding: 12px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: flex-start;
        }
        
        .tips-list li:last-child {
            border-bottom: none;
        }
        
        .tips-list li i {
            color: var(--primary-color);
            margin-right: 10px;
            margin-top: 4px;
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
            
            .weather-header {
                flex-direction: column;
                text-align: center;
            }
            
            .current-weather {
                flex-direction: column;
                margin-bottom: 20px;
            }
            
            .weather-icon {
                margin-right: 0;
                margin-bottom: 10px;
            }
            
            .forecast-grid {
                grid-template-columns: 1fr;
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
                <a href="../profile.php"><i class="fas fa-user-circle"></i> Profile</a>
                <a href="../settings.php"><i class="fas fa-cog"></i> Settings</a>
                <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="../dashboard_farm.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="Weather.php" class="active"><i class="fas fa-cloud-sun"></i> Weather Updates</a></li>
            <li><a href="progress.php"><i class="fas fa-chart-line"></i> Progress</a></li>
            <li><a href="suggestion.php"><i class="fas fa-lightbulb"></i> Suggestions</a></li>
            <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
       
        <?php require "../Locations/index.php"  ?>
     
        
        
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

        // Function to generate the weather chart
        window.onload = function() {
            const ctx = document.getElementById('weatherChart').getContext('2d');
            const weatherChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Monday', 'Tuesday', 'Wednesday'], // Days of the week
                    datasets: [{
                        label: 'Temperature (°C)',
                        data: [26, 24, 22], // Temperature data
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.4 // For smooth curves
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false,
                            text: 'Temperature Trend'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>