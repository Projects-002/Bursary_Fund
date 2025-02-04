<?php
use PHPMailer\PHPMailer\PHPMailer;// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\Exception;// Import PHPMailer classes into the global namespace
Use Dotenv\Dotenv;// Import Dotenv classes into the global namespace

// Load Composer's autoloader
include '../vendor/autoload.php';
require_once '../Database/db.php';

// Start the session
session_start();

// Load environment variables
$dotenv = Dotenv::createImmutable('../');
$dotenv->load();

// Signin With Google Account Start
$client = new Google\Client;

$client ->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();
// Google Auth End


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Portfolio Ready | Authethication-Page</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="styles.css">
    </head>
 <body>

    <!-- internal css -->
    <style>
        body {
            background-color: #f9f9f9;
        }

        .logo{
        background-image:url("../assets/img/logobg1.png");
        width: 150px;
        height: 150px;
        background-position:center;
        background-size:contain;
        background-repeat:no-repeat;
        }

        .card {
            border: none;
            border-radius: 10px;
        }

        .btn-outline-secondary {
            color: #555;
            border-color: #ddd;
        }

        .btn-outline-secondary:hover {
            background-color:rgb(184, 184, 184);
            border-color: #ccc;
        }

        .form-control {
            border-radius: 8px;
        }
    </style>

    <!-- Main Content -->
    <div class="container d-flex justify-content-center align-items-center flex-column" style="min-height: 100vh;">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
        
            <!-- Logo -->
             <p class="text-center">PortfolioReady</p>
             <!-- <div class="logo  d-flex justify-content-center align-items-center container p-0" style="background-image:url('../assets/images/gree.png');"></div> -->
            <h2 class="text-center font-weight-bold mb-4">Sign In</h2>
            
            <!-- Email Address Input -->
            <form id="signup-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?> ">
                
                <div class="form-group">
                    <label for="email">Email address<span class="text-danger">*</span></label>
                    <input type="email"  name="email" class="form-control py-2" id="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password<span class="text-danger">*</span></label>
                    <input type="password"  name="pass" class="form-control py-2" id="password" placeholder="Enter your password" required>
                </div>
             
                <div class="my-2">
                <small>Forgot Password? <a href="#" class="text-success" data-bs-toggle="modal" data-bs-target="#resetModal">Reset</a></small>
                </div>

                <button type="submit" name="login-email" class="btn btn-success btn-block">Continue</button>
            </form>

            <!-- Already have an account -->
            <div class="text-center my-3">
                <small>Don't have account yet? <a href="register.php" class="text-success">Register</a></small><br>
            </div>

            <!-- OR separator -->
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 border-top"></div>
                <span class="mx-2 text-muted">OR</span>
                <div class="flex-grow-1 border-top"></div>
            </div>

            <!-- Social Login Buttons -->
            <div class="mt-3">
                 <!-- Google auth link -->
                 <a href='<?= $url ?>' class="btn btn-outline-secondary btn-block mb-2 d-flex align-items-center justify-content-center">
                    <img src="google.png" width="20" class="mr-2">
                    Continue with Google Account
                 </a>
                 <!-- github auth link  -->
                 <a href="https://github.com/login/oauth/authorize?client_id=<?php echo$_ENV['GITHUB_CLIENT_ID']; ?>&scope=read:user user:email" class="btn btn-outline-secondary btn-block mb-2 d-flex align-items-center justify-content-center">
                    <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg" width="20" class="mr-2">  -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-github text-dark mr-2" viewBox="0 0 16 16">
                    <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8"/></svg>
                    Continue with Github Account
                 </a>
                 <!-- microsoft auth link -->
                 <a href="https://login.microsoftonline.com/common/oauth2/v2.0/authorize?client_id=<?php echo$MS_clientId;?>&response_type=code&redirect_uri= <?php echo$MS_redirectUri; ?>  &scope=openid profile email User.Read" class="btn btn-outline-secondary btn-block d-flex align-items-center justify-content-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg" width="20" class="mr-2">
                    Continue with Microsoft Account
                </a>
            </div>
        </div>
    </div>


    <!-- Reset Password Modal -->
    <div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5" id="resetModalLabel">Enter your Email address below to receive the reset link!</p>
                </div>
                <div class="modal-body">
                    <form id="reset-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group">
                            <label for="reset_email">Email address<span class="text-danger">*</span></label>
                            <input type="email" name="reset_email" class="form-control py-2" id="reset_email" placeholder="Enter your email" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" name="reset_password">Send Link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>


    <!-- reset password modal -->
    <div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <p class="modal-title fs-5" id="exampleModalLabel"> Enter your Email address below to receive the Registration link! </p>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">close</button> -->
        </div>
        <div class="modal-body">
            <form id="signup-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">
                        <label for="new_email">Email address<span class="text-danger">*</span></label>
                        <input type="email"  name="new_email" class="form-control py-2" id="email" placeholder="Enter your email" required>
            </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" name="reg_new">Send Link</button>
        </div>
        </form>
        </div>
    </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    
    <script>
        const myModal = document.getElementById('myModal')
        const myInput = document.getElementById('myInput')

        myModal.addEventListener('shown.bs.modal', () => {
        myInput.focus()
        })
    </script>

</body>
</html>