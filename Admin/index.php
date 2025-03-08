
<?php
session_start();
if (!isset($_SESSION['google_auth'])) {
   header('location: ../AUTH/signin.php');
   exit();
}

include('../Database/db.php');

// Assuming db.php establishes a connection and assigns it to $conn
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check which session variable is set and get the user ID
$id = $_SESSION['google_auth'] ?? null;

if ($id !== null) {
    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE SN = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $details = $result->fetch_object();

    $profileImage = htmlspecialchars($details->Avatar, ENT_QUOTES, 'UTF-8'); // Sanitize output
    $name = htmlspecialchars($details->First_Name, ENT_QUOTES, 'UTF-8'); // Sanitize output
    $email = htmlspecialchars($details->Email, ENT_QUOTES, 'UTF-8'); // Sanitize output
} else {
    // Handle the case where $id is null
    // Redirect to an error page or show an error message
    header('location: ../AUTH/signin.php');
    exit();
}

$profileImage = htmlspecialchars($details->Avatar, ENT_QUOTES, 'UTF-8'); // Sanitize output
$name = htmlspecialchars($details->First_Name, ENT_QUOTES, 'UTF-8'); // Sanitize output
$email = htmlspecialchars($details->Email, ENT_QUOTES, 'UTF-8'); // Sanitize output

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="d-flex flex-column align-items-center justify-content-center" style="height:100vh; width:100vw;">


 <img class="rounded-circle" src="<?php echo $profileImage ?>" alt=""><br><br>
 <p>Hello! <?php echo $name ?> </p><br><br>
 <p><?php echo $email ?></p>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>