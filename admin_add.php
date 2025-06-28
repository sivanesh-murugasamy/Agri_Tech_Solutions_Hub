<?php
?>
 
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .sidebar {
            width: 250px;
            background-color:rgb(76, 168, 22);
            color: white;
            padding-top: 30px;
            flex-shrink: 0;
            position: fixed;
            height: 100%;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 22px;
            font-weight: bold;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 15px 20px;
            border-bottom: 1px solidrgb(34, 207, 11);
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #ddd;
            display: flex;
            align-items: center;
            transition: background 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #1e293b;
            border-radius: 5px;
        }

        .sidebar ul li a i {
            margin-right: 10px;
        }

        main {
            margin-left: 250px;
            padding: 40px;
            flex-grow: 1;
        }

        main h1 {
            margin-bottom: 30px;
            font-size: 28px;
            color: #333;
        }

        .btn-link {
            display: inline-block;
            background-color: #007BFF;
            color: white;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 6px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .btn-link:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            main {
                margin-left: 200px;
                padding: 20px;
            }
        }

        @media (max-width: 500px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            main {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2><i class="fas fa-leaf"></i> AgriSmart</h2>
        <ul>
            <li><a href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="admin_users.php"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="admin_field_analysis.php"><i class="fas fa-chart-bar"></i> Field Analysis</a></li>
            <li><a href="Recommendation_admin.php"><i class="fas fa-seedling"></i> Field Recommendation</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

