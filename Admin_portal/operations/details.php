<?php



$conn = new mysqli('localhost', 'root', 'alex', 'scholarease'); // Initialize the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$id = $_GET['id'];

$sql = "SELECT id, full_name, email, phone, dob, gender, education_level, institution, amount_requested, user_type, national_id, death_certificate, admission_letter, bank_name, branch, account_number, account_name FROM applications WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- boostrap link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f9f9f9;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
<?php
if ($row) {
    echo '<table class="table table-bordered">';
    echo '<tr><th>ID</th><td>' . $row['id'] . '</td></tr>';
    echo '<tr><th>Full Name</th><td>' . $row['full_name'] . '</td></tr>';
    echo '<tr><th>Email</th><td>' . $row['email'] . '</td></tr>';
    echo '<tr><th>Phone</th><td>' . $row['phone'] . '</td></tr>';
    echo '<tr><th>Date of Birth</th><td>' . $row['dob'] . '</td></tr>';
    echo '<tr><th>Gender</th><td>' . $row['gender'] . '</td></tr>';
    echo '<tr><th>Education Level</th><td>' . $row['education_level'] . '</td></tr>';
    echo '<tr><th>Institution</th><td>' . $row['institution'] . '</td></tr>';
    echo '<tr><th>Amount Requested</th><td>' . $row['amount_requested'] . '</td></tr>';
    echo '<tr><th>User Type</th><td>' . $row['user_type'] . '</td></tr>';
    echo '<tr><th>National ID</th><td>' . $row['national_id'] . '</td></tr>';
    echo '<tr><th>Death Certificate</th><td><a href="../../portal/uploads/' . $row['death_certificate'] . '" target="_blank">View Death Certificate</a></td></tr>';
    echo '<tr><th>Admission Letter</th><td><a href="../../portal/uploads/' . $row['admission_letter'] . '" target="_blank">View Admission Letter</a></td></tr>';
    echo '<tr><th>Bank Name</th><td>' . $row['bank_name'] . '</td></tr>';
    echo '<tr><th>Branch</th><td>' . $row['branch'] . '</td></tr>';
    echo '<tr><th>Account Number</th><td>' . $row['account_number'] . '</td></tr>';
    echo '<tr><th>Account Name</th><td>' . $row['account_name'] . '</td></tr>';
    echo '</table>';
} else {
        echo "No record found.";
    }
    ?>

</div>

</body>
</html>