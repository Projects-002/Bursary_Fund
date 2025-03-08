
    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "alex";
    $dbname = "scholarease";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
         $fullName = $_POST['fullName'];
         $email = $_POST['email'];
         $phone = $_POST['phone'];
         $dob = $_POST['dob'];
         $gender = $_POST['gender'];
         $education = $_POST['education'];
         $institution = $_POST['institution'];
         $amount = $_POST['amount'];
         $bank = $_POST['bank'];
         $branch = $_POST['branch'];
         $accountNumber = $_POST['accountNumber'];
         $accountName = $_POST['accountName'];

         // Handle file uploads
         $national_id = $_FILES['national_id']['name'];
         $death_certificate = $_FILES['death_certificate']['name'];

         // Move uploaded files to a directory
         move_uploaded_file($_FILES['national_id']['tmp_name'], "uploads/" . $national_id);
         if ($death_certificate) {
              move_uploaded_file($_FILES['death_certificate']['tmp_name'], "uploads/" . $death_certificate);
         }

         // Insert data into the database
         $sql = "INSERT INTO applications (full_name, email, phone, dob, gender, education_level, institution, amount_requested, national_id, death_certificate, bank_name, branch, account_number, account_name)
                    VALUES ('$fullName', '$email', '$phone', '$dob', '$gender', '$education', '$institution', '$amount', '$national_id', '$death_certificate', '$bank', '$branch', '$accountNumber', '$accountName')";

         if ($conn->query($sql) === TRUE) {
              echo "New record created successfully";
         } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
         }

         $conn->close();
    }
    ?>
    










<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bursary Application Dashboard</title>
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary-color: #f59e0b;
            --light-bg: #f3f4f6;
            --dark-text: #1f2937;
            --light-text: #f9fafb;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
            --info: #3b82f6;
            --sidebar-width: 250px;
        }

        body {
            background-color: var(--light-bg);
            color: var(--dark-text);
        }

        /* Layout */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--primary-color);
            color: var(--light-text);
            padding: 1.5rem;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .logo {
            margin-bottom: 2rem;
            text-align: center;
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            text-decoration: none;
            color: var(--light-text);
            transition: background-color 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            background-color: var(--primary-dark);
        }

        .nav-link i {
            margin-right: 0.75rem;
            width: 1.25rem;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 1.5rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h2 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Cards */
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .card {
            background-color: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .card-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .card-icon.primary { background-color: var(--primary-color); }
        .card-icon.danger { background-color: var(--danger); }
        .card-icon.success { background-color: var(--success); }
        .card-icon.warning { background-color: var(--warning); }

        .card-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .card-label {
            color: #6b7280;
            font-size: 0.875rem;
        }

        /* Table */
        .applications-table {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .table-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .search-input {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            width: 300px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            font-weight: 600;
            color: #4b5563;
            background-color: #f9fafb;
        }

        tbody tr:hover {
            background-color: #f3f4f6;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .status-disbursed {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .action-btn {
            background-color: transparent;
            border: none;
            padding: 0.375rem;
            cursor: pointer;
            color: #6b7280;
            border-radius: 0.25rem;
            transition: background-color 0.3s;
        }

        .action-btn:hover {
            background-color: #f3f4f6;
            color: var(--primary-color);
        }

        /* Form */
        .form-container {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: none;
        }

        .form-container.active {
            display: block;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 1rem;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .radio-group {
            display: flex;
            gap: 1.5rem;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 1rem;
            background-color: white;
        }

        .form-textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 1rem;
            resize: vertical;
            min-height: 100px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--dark-text);
            border: 1px solid #d1d5db;
        }

        .btn-outline:hover {
            background-color: #f3f4f6;
        }

        /* Application Details Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background-color: white;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .close-btn {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .detail-section {
            margin-bottom: 1.5rem;
        }

        .detail-section h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #4b5563;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .detail-item {
            margin-bottom: 0.5rem;
        }

        .detail-label {
            font-weight: 500;
            color: #6b7280;
            margin-bottom: 0.25rem;
        }

        .detail-value {
            font-weight: 400;
        }

        .timeline {
            margin-top: 1.5rem;
            border-left: 2px solid #e5e7eb;
            padding-left: 1.5rem;
        }

        .timeline-item {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .timeline-item::before {
            content: "";
            position: absolute;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--primary-color);
            left: -1.625rem;
            top: 0.25rem;
        }

        .timeline-date {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.25rem;
        }

        .timeline-title {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .timeline-description {
            font-size: 0.875rem;
            color: #4b5563;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                padding: 0;
                position: fixed;
                z-index: 999;
                transition: all 0.3s;
            }

            .sidebar.active {
                width: var(--sidebar-width);
                padding: 1.5rem;
            }

            .main-content {
                margin-left: 0;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .card-container {
                grid-template-columns: 1fr;
            }

            .hamburger-menu {
                display: block;
                font-size: 1.5rem;
                cursor: pointer;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="logo">
                <h1>Bursary Portal</h1>
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="#" class="nav-link active" data-section="dashboard">
                        <i>📊</i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="new-application">
                        <i>📝</i> New Application
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="my-applications">
                        <i>📋</i> My Applications
                    </a>
                </li>
                
                </li>
                
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i>🚪</i> Logout
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="hamburger-menu" id="hamburger-menu">☰</div>
                <h2>Applicant Dashboard</h2>
                <div class="user-profile">
                    <img src="/api/placeholder/40/40" alt="User">
                    <span>John Doe</span>
                </div>
            </div>

            <!-- Dashboard Section -->
            <div class="section-content active" id="dashboard">
                <div class="card-container">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <div class="card-value">3</div>
                                <div class="card-label">Total Applications</div>
                            </div>
                            <div class="card-icon primary">📊</div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <div class="card-value">1</div>
                                <div class="card-label">Approved</div>
                            </div>
                            <div class="card-icon success">✅</div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <div class="card-value">1</div>
                                <div class="card-label">Pending</div>
                            </div>
                            <div class="card-icon warning">⏳</div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <div class="card-value">1</div>
                                <div class="card-label">Rejected</div>
                            </div>
                            <div class="card-icon danger">❌</div>
                        </div>
                    </div>
                </div>

                <div class="applications-table">
                    <div class="table-header">
                        <div class="table-title">Recent Applications</div>
                        <input type="text" class="search-input" placeholder="Search...">
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Ref. Number</th>
                                <th>Date Applied</th>
                                <th>Amount (KES)</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>BUR-2025-001</td>
                                <td>01/02/2025</td>
                                <td>15,000</td>
                                <td><span class="status-badge status-approved">Approved</span></td>
                                <td>
                                    <button class="action-btn view-details" data-id="BUR-2025-001">👁️ View</button>
                                </td>
                            </tr>
                            <tr>
                                <td>BUR-2025-002</td>
                                <td>15/02/2025</td>
                                <td>20,000</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td>
                                    <button class="action-btn view-details" data-id="BUR-2025-002">👁️ View</button>
                                </td>
                            </tr>
                            <tr>
                                <td>BUR-2025-003</td>
                                <td>01/03/2025</td>
                                <td>25,000</td>
                                <td><span class="status-badge status-rejected">Rejected</span></td>
                                <td>
                                    <button class="action-btn view-details" data-id="BUR-2025-003">👁️ View</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- New Application Form -->
            <div class="section-content" id="new-application">
                <div class="form-container active">
                    <h3 class="form-title">New Bursary Application</h3>
                    <form id="application-form">
                        <div class="form-group">
                            <label class="form-label" for="fullName">Full Name</label>
                            <input type="text" id="fullName" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Email Address</label>
                            <input type="email" id="email" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="phone">Phone Number</label>
                            <input type="tel" id="phone" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="dob">Date of Birth</label>
                            <input type="date" id="dob" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Gender</label>
                            <div class="radio-group">
                                <div class="radio-option">
                                    <input type="radio" id="male" name="gender" value="male" required>
                                    <label for="male">Male</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="female" name="gender" value="female">
                                    <label for="female">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="education">Level of Education</label>
                            <select id="education" class="form-select" required>
                                <option value="">Select Education Level</option>
                                
                                <option value="secondary">Secondary School</option>
                                <option value="certificate">Certificate</option>
                                <option value="diploma">Diploma</option>
                                <option value="undergraduate">Undergraduate Degree</option>
                                <option value="postgraduate">Postgraduate Degree</option>
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="institution">Current Institution</label>
                            <input type="text" id="institution" class="form-input" required>
                        </div>
                        <div class="form-group">
                        <label class="form-label" for="amount">Amount Requested (KES)</label>
                        <input type="number" id="amount" class="form-input" max="30000" required>
                        </div> 
                        <!-- <div class="form-group">  -->
                            <!-- <label class="form-label" for="purpose">Purpose of Bursary</label> -->
                            <!-- <textarea id="purpose" class="form-textarea" required></textarea> -->
                        <!-- </div> -->
                        <div class="form-group">
                        <label class="form-label" for="amount">Required Documents </label>
                        <fieldset>
                            <legend:</legend>
                            <label for="national_id">National ID / Birth Certificate: (required)</label>
                            <input type="file" id="national_id" name="national_id" accept=".pdf,.jpg,.jpeg,.png" required><br><br>

                            <label for="death_certificate">Death Certificate: (if applicable)</label>
                            <input type="file" id="death_certificate" name="death_certificate" accept=".pdf,.jpg,.jpeg,.png"><br><br>
                            </div
                        </fieldset>
                        <div class="form-group">
                            <label class="form-label" for="bank">Bank Name</label>
                            <input type="text" id="bank" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="branch">Branch</label>
                            <input type="text" id="branch" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="accountNumber">Account Number</label>
                            <input type="text" id="accountNumber" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="accountName">Account Name</label>
                            <input type="text" id="accountName" class="form-input" required>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn btn-outline" id="cancel-form">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit Application</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- My Applications Section -->
            <div class="section-content" id="my-applications">
                <div class="applications-table">
                    <div class="table-header">
                        <div class="table-title">All My Applications</div>
                        <input type="text" class="search-input" placeholder="Search applications...">
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Ref. Number</th>
                                <th>Date Applied</th>
                                <th>Purpose</th>
                                <th>Amount (KES)</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>BUR-2025-001</td>
                                <td>01/02/2025</td>
                                <td>Tuition Fees</td>
                                <td>15,000</td>
                                <td><span class="status-badge status-approved">Approved</span></td>
                                <td>
                                    <button class="action-btn view-details" data-id="BUR-2025-001">👁️ View</button>
                                </td>
                            </tr>
                            <tr>
                                <td>BUR-2025-002</td>
                                <td>15/02/2025</td>
                                <td>Books and Materials</td>
                                <td>20,000</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td>
                                    <button class="action-btn view-details" data-id="BUR-2025-002">👁️ View</button>
                                </td>
                            </tr>
                            <tr>
                                <td>BUR-2025-003</td>
                                <td>01/03/2025</td>
                                <td>Accommodation</td>
                                <td>25,000</td>
                                <td><span class="status-badge status-rejected">Rejected</span></td>
                                <td>
                                    <button class="action-btn view-details" data-id="BUR-2025-003">👁️ View</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Application Details Modal -->
    <div class="modal" id="application-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Application Details</h3>
                <button class="close-btn" id="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="detail-section">
                    <h4>Application Information</h4>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Reference Number</div>
                            <div class="detail-value" id="detail-ref">BUR-2025-001</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Date Applied</div>
                            <div class="detail-value" id="detail-date">01/02/2025</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value" id="detail-status">
                                <span class="status-badge status-approved">Approved</span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Amount Requested</div>
                            <div class="detail-value" id="detail-amount">KES 15,000</div>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <h4>Personal Information</h4>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Full Name</div>
                            <div class="detail-value" id="detail-name">John Doe</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Email</div>
                            <div class="detail-value" id="detail-email">johndoe@example.com</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Phone</div>
                            <div class="detail-value" id="detail-phone">+254 712 345 678</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Date of Birth</div>
                            <div class="detail-value" id="detail-dob">15/05/2000</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Gender</div>
                            <div class="detail-value" id="detail-gender">Male</div>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <h4>Education Information</h4>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Level of Education</div>
                            <div class="detail-value" id="detail-education">Undergraduate Degree</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Institution</div>
                            <div class="detail-value" id="detail-institution">University of Nairobi</div>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <h4>Purpose of Bursary</h4>
                    <div class="detail-value" id="detail-purpose">
                        To cover tuition fees for the 2nd semester of my undergraduate program.
                    </div>
                </div>

                <div class="detail-section">
                    <h4>Application Timeline</h4>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-date">01/02/2025</div>
                            <div class="timeline-title">Application Submitted</div>
                            <div class="timeline-description">
                                Your application was successfully submitted to the system.
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-date">03/02/2025</div>
                            <div class="timeline-title">Under Review</div>
                