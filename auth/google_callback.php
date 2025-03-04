<?php
require '../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Dotenv\Dotenv;

session_start();

if (!isset($_GET["code"])) {
    exit("Login failed: Missing authorization code");
}

// Load .env file
$dotenv = Dotenv::createImmutable('../');
$dotenv->load();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$client = new Client();
$apiUrl = 'https://oauth2.googleapis.com/token';

$data = [
    'client_id' => $_ENV['GOOGLE_CLIENT_ID'],
    'client_secret' => $_ENV['GOOGLE_CLIENT_SECRET'],
    'code' => $_GET['code'],
    'grant_type' => 'authorization_code',
    'redirect_uri' => $_ENV['GOOGLE_REDIRECT_URI'],
];

try {
    $response = $client->post($apiUrl, [
        'form_params' => $data,
        'headers' => [
            'Accept' => 'application/json'
        ]
    ]);

    if ($response->getStatusCode() == 200) {
        $tokenData = json_decode($response->getBody()->getContents(), true);
        $accessToken = $tokenData['access_token'];

        // Get user information from Google API
        $userResponse = $client->get('https://www.googleapis.com/oauth2/v1/userinfo?alt=json', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Accept' => 'application/json'
            ]
        ]);

        if ($userResponse->getStatusCode() == 200) {
            $userinfo = json_decode($userResponse->getBody()->getContents(), true);
            $givenName = htmlspecialchars($userinfo['given_name'], ENT_QUOTES, 'UTF-8');
            $familyName = htmlspecialchars($userinfo['family_name'], ENT_QUOTES, 'UTF-8');
            $email = htmlspecialchars($userinfo['email'], ENT_QUOTES, 'UTF-8');
            $picture = htmlspecialchars($userinfo['picture'], ENT_QUOTES, 'UTF-8');

            // Include database connection
            include('../Database/db.php');

            if (!$conn) {
                exit("Database connection failed.");
            }

            // Check if user exists using a prepared statement
           // $stmt = $conn->prepare("SELECT * FROM users WHERE Email = ?");
           $stmt = $conn->prepare("SELECT * FROM users WHERE Email = ?");

            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                $id = $row['SN'];
                $_SESSION['google_auth'] = $id;
                header("Location: ../portal/index.php");
                exit();
            } else {
                // Insert user into database securely
            $stmt = $conn->prepare("INSERT INTO users (First_Name, Last_Name, Email, Avatar, Pass, Reg_Date) VALUES (?, ?, ?, ?, ?, NOW())");
            
            $password = password_hash("Alex234", PASSWORD_DEFAULT);
            $stmt->bind_param("sssss", $givenName, $familyName, $email, $picture, $password);
                // $stmt->bind_param("sssss", $first_name, $last_name, $email, $avatar, $password);

              if ($stmt->execute()) {
                    $id = $stmt->insert_id;
                    $_SESSION['google_auth'] = $id;
                    header("Location: ../portal/index.php");
                    exit();
                } else {
                    exit("Database insertion failed: " . $stmt->error);
                }
            }
        } else {
            exit("Failed to get user information");
        }
    } else {
        $errorResponse = json_decode($response->getBody()->getContents(), true);
        exit("Failed to get access token: " . $errorResponse['error_description']);
    }
} catch (RequestException $e) {
    exit('Request Exception: ' . $e->getMessage()); 
}
?>
