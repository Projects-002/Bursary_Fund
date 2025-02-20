<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
require_once('../Database/db.php');

// Initialize an error message variable
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user inputs
    $first_name       = trim($_POST['first_name']);
    $last_name        = trim($_POST['last_name']);
    $email            = trim($_POST['email']);
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if the email is already registered
        $stmt = $conn->prepare("SELECT SN FROM scholarease WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Default avatar (you can customize this or allow user uploads)
            $avatar = "";

            // Insert the new user into the database
            $stmt = $conn->prepare("INSERT INTO scholarease (First_Name, Last_Name, Email, Avatar, Pass) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $first_name, $last_name, $email, $avatar, $hashed_password);

            if ($stmt->execute()) {
                // Registration successful, store user ID in session and redirect
                $_SESSION['google_auth'] = $stmt->insert_id;
                header("Location: http://localhost/Projects/Bursary_Fund/admin/index.php");
                exit();
            } else {
                $error = "Database insertion failed: " . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register with Email</title>
</head>
<body>
    <h2>Email Registration</h2>
    <?php if ($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form action="register.php" method="post">
        <label>First Name:</label><br>
        <input type="text" name="first_name" required><br><br>
        
        <label>Last Name:</label><br>
        <input type="text" name="last_name" required><br><br>
        
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        
        <label>Confirm Password:</label><br>
        <input type="password" name="confirm_password" required><br><br>
        
        <input type="submit" value="Register">
    </form>
</body>
</html>
