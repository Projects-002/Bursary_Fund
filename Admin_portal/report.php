<?php

// Include the database configuration file
require_once '../database/db.php';
session_start();
if (!isset($_SESSION['google_auth']) && !isset($_SESSION['github_auth']) && !isset($_SESSION['email_auth'])) {
    header('location: ../AUTH/signin.php');
    exit();
}

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

// Check which session variable is set and get the user ID
$id = isset($_SESSION['google_auth']) ? $_SESSION['google_auth'] : (isset($_SESSION['github_auth']) ? $_SESSION['github_auth'] : $_SESSION['email_auth']);

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM users WHERE SN = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$details = $result->fetch_object();

$profileImage = htmlspecialchars($details->Avatar, ENT_QUOTES, 'UTF-8'); // Sanitize output
$fname = htmlspecialchars($details->First_Name, ENT_QUOTES, 'UTF-8'); // Sanitize output
$lname = htmlspecialchars($details->Last_Name, ENT_QUOTES, 'UTF-8'); // Sanitize output
$email = htmlspecialchars($details->Email, ENT_QUOTES, 'UTF-8'); // Sanitize output

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

// Calculate the total amount requested
$sql = "SELECT SUM(amount_requested) AS total_amount FROM applications";
$totalResult = $conn->query($sql);
$totalRow = $totalResult->fetch_assoc();
$totalAmountRequested = $totalRow['total_amount'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <!-- Bootstrap CSS -->
     <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
     <div class="container mt-5">
          <!-- Recent Applications -->
          <div class="applications-section">
                <div class="section-header d-flex justify-content-between align-items-center mb-3">
                     <h2 class="section-title">Applications Report</h2>
                     <div class="section-actions">
                          <!-- <a href="#" id="show-all-btn" class="btn btn-primary">Show All</a> -->
                     </div>
                </div>
                <table class="table table-striped table-bordered">
                     <thead class="thead-dark">
                          <tr>
                                <th>
                                     <input type="checkbox" id="select-all">
                                </th>
                                <th>Date</th>
                                <th>Applicant ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Amount Requested</th>
                                <th>Status</th>
                                <th>Actions</th>
                          </tr>
                     </thead>
                     <tbody id="applications-table-body">
                          <?php while($row = $result->fetch_assoc()): ?>
                          <tr data-id="<?= $row['id'] ?>">
                                <td>
                                     <input type="checkbox" class="select-row">
                                </td>
                                <td><?= $row['dob'] ?></td>
                                <td><?= $row['id'] ?></td>
                                <td><?= $fname ?></td>
                                <td><?= $lname?></td>
                                <td><?= $row['amount_requested'] ?></td>
                                <td>
                                     <span class="badge badge-<?= strtolower($row['Status']) == 'approved' ? 'success' : (strtolower($row['Status']) == 'pending' ? 'warning' : 'danger') ?>">
                                          <?= ucfirst($row['Status']) ?>
                                     </span>
                                </td>
                                <td class="action-buttons">
                                     <button class="btn btn-success btn-sm" onclick="window.location='./operations/aprove.php?id=<?= $row['id'] ?>'">Approve</button>
                                     <button class="btn btn-danger btn-sm" onclick="window.location='./operations/decline.php?id=<?= $row['id'] ?>'">Decline</button>
                                     <button class="btn btn-info btn-sm" onclick="window.location='./operations/details.php?id=<?= $row['id'] ?>'">Details</button>
                                </td>
                          </tr>
                          <?php endwhile; ?>
                     </tbody>
                     <tfoot>
                          <tr>
                                <td colspan="5" class="text-right"><strong>Total Amount Requested:</strong></td>
                                <td colspan="3"><?= $totalAmountRequested ?></td>
                          </tr>
                     </tfoot>
                </table>
                <div class="pagination" id="pagination">
                     <!-- Pagination will be dynamically generated -->
                </div>
          </div>
     </div>
     <!-- Bootstrap JS and dependencies -->
     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
