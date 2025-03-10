<?php

// Include the database configuration file
require_once '../database/db.php';

// get all applications
$sql = "SELECT * FROM applications";
$result = $conn->query($sql);
$applications = mysqli_num_rows($result);



// Get the total number of pending applications
$sql = "SELECT * FROM applications WHERE Status = 'pending'";
$feed = $conn->query($sql);
$pending = mysqli_num_rows($feed);


// Get the total number of pending applications
$sql = "SELECT * FROM applications WHERE Status = 'approved'";
$feed = $conn->query($sql);
$approved = mysqli_num_rows($feed);



// Get the total number of pending applications
$sql = "SELECT * FROM applications WHERE Status = 'declined'";
$feed = $conn->query($sql);
$declined = mysqli_num_rows($feed);


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarease - Bursary Admin Dashboard</title>
    <style>
        :root {
            --primary-color: #e41e26;
            --secondary-color: #1e88e5;
            --dark-bg: #1a1e2e;
            --dark-card: #262c43;
            --dark-text: #ffffff;
            --light-bg: #f5f7fa;
            --light-card: #ffffff;
            --light-text: #333333;
            --status-pending: #ff9800;
            --status-approved: #4caf50;
            --status-declined: #f44336;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }

        body.dark-mode {
            background-color: var(--dark-bg);
            color: var(--dark-text);
        }

        body.light-mode {
            background-color: var(--light-bg);
            color: var(--light-text);
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 240px;
            transition: all 0.3s;
            z-index: 1000;
        }

        body.dark-mode .sidebar {
            background-color: #121422;
        }

        body.light-mode .sidebar {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .brand {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: var(--primary-color);
            font-weight: bold;
            font-size: 24px;
        }

        .brand img {
            height: 30px;
            margin-right: 10px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: bold;
        }

        .user-role {
            font-size: 12px;
            opacity: 0.7;
        }

        .user-status {
            width: 10px;
            height: 10px;
            background-color: #4caf50;
            border-radius: 50%;
            margin-left: 5px;
        }

        .menu-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        body.dark-mode .menu-item:hover, 
        body.dark-mode .menu-item.active {
            background-color: rgba(255, 255, 255, 0.1);
        }

        body.light-mode .menu-item:hover, 
        body.light-mode .menu-item.active {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .menu-item.active {
            border-left: 3px solid var(--primary-color);
        }

        .menu-item i {
            margin-right: 10px;
            font-size: 18px;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            padding: 20px;
            transition: background-color 0.3s;
        }

        /* Header Styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        body.dark-mode .search-bar {
            background-color: #222638;
        }

        body.light-mode .search-bar {
            background-color: #f1f3f6;
            border: 1px solid #e0e0e0;
        }

        .search-bar input {
            border: none;
            background: transparent;
            outline: none;
            padding: 5px;
            width: 200px;
            color: inherit;
        }

        .header-actions {
            display: flex;
            align-items: center;
        }

        .action-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 8px;
            margin-left: 10px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
        }

        body.dark-mode .action-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        body.light-mode .action-btn:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        /* Dashboard Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            border-radius: 8px;
            padding: 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }

        body.dark-mode .card {
            background-color: var(--dark-card);
        }

        body.light-mode .card {
            background-color: var(--light-card);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .card-icon.red {
            background-color: rgba(228, 30, 38, 0.1);
            color: var(--primary-color);
        }

        .card-icon.blue {
            background-color: rgba(30, 136, 229, 0.1);
            color: var(--secondary-color);
        }

        .card-icon.green {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--status-approved);
        }

        .card-icon.orange {
            background-color: rgba(255, 152, 0, 0.1);
            color: var(--status-pending);
        }

        .card-info {
            flex: 1;
        }

        .card-title {
            font-size: 14px;
            opacity: 0.7;
            margin-bottom: 5px;
        }

        .card-value {
            font-size: 24px;
            font-weight: bold;
        }

        /* Applications Table */
        .applications-section {
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: rgba(0, 0, 0, 0.03);
        }

        body.dark-mode .section-header {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .section-title {
            font-weight: bold;
            font-size: 18px;
        }

        .section-actions a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .applications-table {
            width: 100%;
            border-collapse: collapse;
        }

        .applications-table th, 
        .applications-table td {
            padding: 12px 15px;
            text-align: left;
        }

        body.dark-mode .applications-table {
            background-color: var(--dark-card);
        }

        body.light-mode .applications-table {
            background-color: var(--light-card);
        }

        body.dark-mode .applications-table thead tr {
            background-color: rgba(255, 255, 255, 0.05);
        }

        body.light-mode .applications-table thead tr {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .applications-table tbody tr {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: background-color 0.3s;
        }

        body.dark-mode .applications-table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.03);
        }

        body.light-mode .applications-table tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.01);
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }

        .status-pending {
            background-color: rgba(255, 152, 0, 0.1);
            color: var(--status-pending);
        }

        .status-approved {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--status-approved);
        }

        .status-declined {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--status-declined);
        }

        .action-buttons button {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            border: none;
            margin-right: 5px;
            transition: all 0.2s;
        }

        .approve-btn {
            background-color: var(--status-approved);
            color: white;
        }

        .decline-btn {
            background-color: var(--status-declined);
            color: white;
        }

        .detail-btn {
            background-color: var(--primary-color);
            color: white;
        }

        .action-buttons button:hover {
            opacity: 0.9;
        }

        /* Theme Toggle */
        .theme-toggle {
            position: relative;
            width: 60px;
            height: 30px;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s;
        }

        body.dark-mode .theme-toggle {
            background-color: rgba(255, 255, 255, 0.1);
        }

        body.light-mode .theme-toggle {
            background-color: rgba(0, 0, 0, 0.1);
        }

        .toggle-handle {
            position: absolute;
            top: 5px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            transition: all 0.3s;
        }

        body.dark-mode .toggle-handle {
            background-color: var(--dark-text);
            right: 5px;
        }

        body.light-mode .toggle-handle {
            background-color: var(--light-bg);
            left: 5px;
        }

        .theme-icon {
            position: absolute;
            top: 5px;
            width: 20px;
            height: 20px;
            text-align: center;
            line-height: 20px;
            font-size: 12px;
        }

        .sun-icon {
            left: 5px;
        }

        .moon-icon {
            right: 5px;
        }

        /* Login Dialog */
        .login-dialog {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1001;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s;
        }

        .login-dialog.active {
            opacity: 1;
            visibility: visible;
        }

        .login-form {
            width: 100%;
            max-width: 400px;
            border-radius: 8px;
            padding: 30px;
            transition: all 0.3s;
        }

        body.dark-mode .login-form {
            background-color: var(--dark-card);
        }

        body.light-mode .login-form {
            background-color: var(--light-card);
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            background: transparent;
            color: inherit;
            transition: all 0.3s;
        }

        .form-input:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .login-btn {
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .login-btn:hover {
            opacity: 0.9;
        }

        .cancel-btn {
            background-color: transparent;
            border: none;
            color: inherit;
            cursor: pointer;
            transition: all 0.3s;
        }

        .cancel-btn:hover {
            color: var(--primary-color);
        }

        /* Settings Dialog */
        .settings-dialog {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1001;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s;
        }

        .settings-dialog.active {
            opacity: 1;
            visibility: visible;
        }

        .settings-panel {
            width: 100%;
            max-width: 400px;
            border-radius: 8px;
            padding: 30px;
            transition: all 0.3s;
        }

        body.dark-mode .settings-panel {
            background-color: var(--dark-card);
        }

        body.light-mode .settings-panel {
            background-color: var(--light-card);
        }

        .settings-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .settings-title {
            font-size: 20px;
            font-weight: bold;
        }

        .settings-close {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 20px;
            color: inherit;
        }

        .settings-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .settings-option:last-child {
            border-bottom: none;
        }

        .option-label {
            font-weight: bold;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .page-item {
            margin: 0 5px;
        }

        .page-link {
            display: block;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }

        body.dark-mode .page-link {
            background-color: var(--dark-card);
        }

        body.light-mode .page-link {
            background-color: var(--light-card);
        }

        .page-link.active {
            background-color: var(--primary-color);
            color: white;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }

            .brand span, .user-info, .menu-item span {
                display: none;
            }

            .menu-item {
                justify-content: center;
            }

            .menu-item i {
                margin-right: 0;
            }

            .main-content {
                margin-left: 70px;
            }
        }

        @media (max-width: 768px) {
            .dashboard-cards {
                grid-template-columns: 1fr;
            }

            .applications-table {
                overflow-x: auto;
                display: block;
            }
        }

        @media (max-width: 576px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-bar {
                width: 100%;
                margin-bottom: 10px;
            }

            .header-actions {
                width: 100%;
                justify-content: flex-end;
            }
        }

        /* Checkbox styles */
        .checkbox-container {
            display: block;
            position: relative;
            padding-left: 35px;
            cursor: pointer;
            user-select: none;
        }

        .checkbox-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            border-radius: 4px;
            transition: all 0.3s;
        }

        body.dark-mode .checkmark {
            background-color: #2c3148;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        body.light-mode .checkmark {
            background-color: #f1f3f6;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .checkbox-container:hover input ~ .checkmark {
            opacity: 0.8;
        }

        .checkbox-container input:checked ~ .checkmark {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .checkbox-container input:checked ~ .checkmark:after {
            display: block;
        }

        .checkbox-container .checkmark:after {
            left: 7px;
            top: 3px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="dark-mode">
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="brand">
                <i class="fas fa-graduation-cap"></i>
                <span>Scholarease</span>
            </div>
            <div class="user-profile">
                <img src="/api/placeholder/50/50" alt="User Profile">
                <div class="user-info">
                    <div class="user-name">Admin User</div>
                    <div class="user-role">Administrator</div>
                </div>
                <div class="user-status"></div>
            </div>
            <ul class="menu-list">
                <li class="menu-item active" data-page="dashboard">
                    <i class="fas fa-chart-pie"></i>
                    <span>Dashboard</span>
                </li>
                <li class="menu-item" data-page="applications">
                    <i class="fas fa-file-alt"></i>
                    <span>Applications</span>
                </li>
                <li class="menu-item" data-page="students">
                    <i class="fas fa-user-graduate"></i>
                    <span>Students</span>
                </li>
                <li class="menu-item" data-page="reports">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports</span>
                </li>
                <li class="menu-item" data-page="settings">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search...">
                </div>
                <div class="header-actions">
                    <button class="action-btn" id="login-btn">
                        <i class="fas fa-sign-in-alt"></i>
                    </button>
                    <button class="action-btn" id="settings-btn">
                        <i class="fas fa-cog"></i>
                    </button>
                    <div class="theme-toggle" id="theme-toggle">
                        <div class="theme-icon sun-icon">☀️</div>
                        <div class="theme-icon moon-icon">🌙</div>
                        <div class="toggle-handle"></div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="dashboard-cards">
                <div class="card">
                    <div class="card-icon orange">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="card-info">
                        <div class="card-title">Pending Applications</div>
                        <div class="card-value" id="pending-count"><?= $pending ?></div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-icon blue">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="card-info">
                        <div class="card-title">Total Applications</div>
                        <div class="card-value" id="total-count"><?=$applications ?></div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-icon green">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="card-info">
                        <div class="card-title">Approved Applications</div>
                        <div class="card-value" id="approved-count"><?=$approved?></div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-icon red">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="card-info">
                        <div class="card-title">Declined Applications</div>
                        <div class="card-value" id="declined-count"><?=$declined ?></div>
                    </div>
                </div>
            </div>

            <!-- Recent Applications -->
            <div class="applications-section">
                <div class="section-header">
                    <div class="section-title">Recent Applications</div>
                    <div class="section-actions">
                        <a href="#" id="show-all-btn">Show All</a>
                    </div>
                </div>
                <table class="applications-table">
                    <thead>
                        <tr>
                            <th>
                                <label class="checkbox-container">
                                    <input type="checkbox" id="select-all">
                                    <span class="checkmark"></span>
                                </label>
                            </th>
                            <th>Date</th>
                            <th>Applicant ID</th>
                            <th>Applicant Name</th>
                            <th>Amount Requested</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="applications-table-body">
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr data-id="<?= $row['id'] ?>">
                            <td>
                                <label class="checkbox-container">
                                    <input type="checkbox" class="select-row">
                                    <span class="checkmark"></span>
                                </label>
                            </td>
                            <td><?= $row['dob'] ?></td>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['full_name'] ?></td>
                            <td><?= $row['amount_requested'] ?></td>
                            <td>
                                <span class="status-badge status-<?= strtolower($row['Status']) ?>">
                                    <?= ucfirst($row['Status']) ?>
                                </span>
                            </td>
                            <td class="action-buttons">
                                <button class="approve-btn" onclick="window.location='./operations/aprove.php?id=<?= $row['id'] ?>'">Approve</button>
                                <button class="decline-btn" onclick="window.location='./operations/decline.php?id=<?= $row['id'] ?>'">Decline</button>
                                <button class="detail-btn" onclick="window.location='./operations/details.php?id=<?= $row['id'] ?>'">Details</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <div class="pagination" id="pagination">
                    <!-- Pagination will be dynamically generated -->
                </div>
            </div>
        </div>
    </div>

    <!-- Login Dialog -->
    <div class="login-dialog" id="login-dialog">
        <div class="login-form">
            <div class="login-header">
                <div class="login-title">Login</div>
                <div class="login-subtitle">Sign in to your account</div>
            </div>
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" class="form-input" id="username-input" placeholder="Enter your username">
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" class="form-input" id="password-input" placeholder="Enter your password">
            </div>
            <div class="form-actions">
                <button class="cancel-btn" id="cancel-login-btn">Cancel</button>
                <button class="login-btn" id="submit-login-btn">Login</button>
            </div>
        </div>
    </div>

    <!-- Settings Dialog -->
    <div class="settings-dialog" id="settings-dialog">
        <div class="settings-panel">
            <div class="settings-header">
                <div class="settings-title">Settings</div>
                <button class="settings-close" id="close-settings-btn">&times;</button>
            </div>
            <div class="settings-option">
                <span class="option-label">Dark Mode</span>
                <div class="theme-toggle" id="settings-theme-toggle">
                    <div class="theme-icon sun-icon">☀️</div>
                    <div class="theme-icon moon-icon">🌙</div>
                    <div class="toggle-handle"></div>
                </div>
            </div>
            <div class="settings-option">
                <span class="option-label">Notifications</span>
                <label class="checkbox-container">
                    <input type="checkbox" checked>
                    <span class="checkmark"></span>
                </label>
            </div>
            <div class="settings-option">
                <span class="option-label">Email Alerts</span>
                <label class="checkbox-container">
                    <input type="checkbox" checked>
                    <span class="checkmark"></span>
                </label>
            </div>
        </div>
    </div>

    <script>