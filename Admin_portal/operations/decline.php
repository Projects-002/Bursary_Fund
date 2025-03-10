<?php



$conn = new mysqli('localhost', 'root', 'alex', 'scholarease'); // Initialize the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$id = $_GET['id'];

$sql = "UPDATE applications SET status = 'declined' WHERE id = ?";
$stmt = $conn->prepare($sql);   
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: ../index.php");

?>