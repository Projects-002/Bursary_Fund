<?php
session_start();
if (!isset($_SESSION['google_auth'])) {
   header('location: ../AUTH/signin.php');
   exit();
}

include('../Database/db.php');

// Check which session variable is set and get the user ID
$id = $_SESSION['google_auth'] ?? null;

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM users WHERE SN = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$details = $result->fetch_object();

$profileImage = htmlspecialchars($details->Avatar, ENT_QUOTES, 'UTF-8'); // Sanitize output
$name = htmlspecialchars($details->First_Name, ENT_QUOTES, 'UTF-8'); // Sanitize output
$email = htmlspecialchars($details->Email, ENT_QUOTES, 'UTF-8'); // Sanitize output

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KE430-Angata CDC</title>
    <link rel="stylesheet" href="style.css">
    <!-- material icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" />

</head>
<body>
    <div class="container">
         <aside>
            <div class="top">
                 <div class="logo">
                      <img src="Images/" alt="">
                      <h2>Scholar<span class="danger">Ease</span></h2>
                 </div>
                 <div class="close" id="close-btn">
                     <span class="material-icons-sharp">close</span>
                 </div>   
               </div>

               <div class="sidebar">
                  <a href="#">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Dashboard</h3>
                  </a>

                  <a href="#" class="active">
                    <span class="material-icons-sharp">person_outline</span>
                    <h3>Participants</h3>
                  </a>

                  <a href="Html/beneficiaries.html">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Beneficiary</h3>
                  </a>

                  <a href="#">
                    <span class="material-icons-sharp">mail_outline</span>
                    <h3>Messages</h3>
                    <span class="message-count">26</span>
                  </a>

                  <a href="#">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Health & Hygine</h3>
                  </a>


                  <a href="#">
                    <span class="material-icons-sharp">insights</span>
                    <h3>Academics</h3>
                  </a>

                  <a href="#">
                    <span class="material-icons-sharp">inventory</span>
                    <h3>Sponsor Gifts</h3>
                  </a>

                  <a href="#">
                    <span class="material-icons-sharp">receipt_long</span>
                    <h3>Fees Payment</h3>
                  </a>


                  <a href="#">
                    <span class="material-icons-sharp">receipt_long</span>
                    <h3>Cheque Register</h3>
                  </a>

                 
                  <a class="last" href="login.html" target="_self">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Logout</h3>
                  </a>
              </div>
         </aside>

         <!-- -----------END OF ASIDE ------------- -->

         <main>
            <h1>Dashboard</h1>

             <div class="date">
                <input type="date">
            </div>

            <div class="insights">
                 <div class="sales">
                  <span class="material-icons-sharp">analytics</span>
                  <div class="middle">
                     <div class="left">
                      <h3>Total Users</h3>
                      <h1>500</h1>
                     </div>
                     <div class="progress">
                       <svg>
                           <circle cx='38' cy='36'  r='36'></circle>
                       </svg>
                       <div class="number">
                        <p>81%</p>
                       </div>
                     </div>
                  </div>
                  <small class="text-muted">last 24hrs</small>
                </div>

                <!-- END OF FEE -->

               <div class="income">
                  <span class="material-icons-sharp">bar_chart</span>
                  <div class="middle">
                     <div class="left">
                      <h3>Sponsor gifts</h3>
                      <h1>$5,000</h1>
                     </div>
                     <div class="progress">
                       <svg>
                           <circle cx='38' cy='36' r='36'></circle>
                       </svg>
                       <div class="number">
                        <p>81%</p>
                       </div>
                     </div>
                  </div>
                  <small class="text-muted">last 24hrs</small>
                </div>

                <!-- END OF ACADEMICS -->

                <div class="expenses">
                  <span class="material-icons-sharp">stacked_line_chart</span>
                  <div class="middle">
                     <div class="left">
                      <h3>Total Fee</h3>
                      <h1>$5,000</h1>
                     </div>
                     <div class="progress">
                       <svg>
                           <circle cx='38' cy='36' r='36'></circle>
                       </svg>
                       <div class="number">
                        <p>61%</p>
                       </div>
                     </div>
                   </div>
                  <small class="text-muted">last 24hrs</small>
                </div>
                <!-- -------- End of Expenses-------- -->
            </div>   
            
            <!-- -----------------End of Insights------- -->

            <div class="recent-orders">

                <h2>Beneficiaries</h2>

                <table>
                   <thead>
                        <tr>
                           <th>Ben-No</th>
                           <th>Beneficiary Name</th>
                           <th>Gender</th>
                           <th>Status</th>
                           <th>DOB</th>
                           <th></th>
                        </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>KE043000001</td>
                        <td>EUCABETH CHELANGAT</td>
                        <td>Female</td>
                        <td class="warning">Active</td>
                        <td>11/06/2005</td>
                        <td class="primary">Details</td>
                     </tr>

                      <tr>
                        <td>KE043000002</td>
                        <td>Brian Kibet</td>
                        <td>Male</td>
                        <td class="warning">Active</td>
                        <td>04/12/2005</td>
                        <td class="primary">Details</td>
                      </tr>

                      <tr>
                        <td>KE043000003</td>
                        <td>Ezyline Chepkemoi</td>
                        <td>Female</td>
                        <td class="warning">Active</td>
                        <td>06/10/2002</td>
                        <td class="primary">Details</td>
                      </tr>


                      <tr>
                        <td>KE043000004</td>
                        <td>Wesley Kipkemoi</td>
                        <td>Male</td>
                        <td class="warning">Active</td>
                        <td>04/04/2002</td>
                        <td class="primary">Details</td>
                      </tr>

                      <tr>
                        <td>KE043000005</td>
                        <td>Samuel Choti</td>
                        <td>Male</td>
                        <td class="warning">Active</td>
                        <td>02/21/2007</td>
                        <td class="primary">Details</td>
                      </tr>

                      <tr>
                        <td>KE043000006</td>
                        <td>Viola Cherotich</td>
                        <td>Female</td>
                        <td class="warning">Active</td>
                        <td>08/12/2003</td>
                        <td class="primary">Details</td>
                      </tr>
                   </tbody>
                 </table>
              <a href="./Html/beneficiaries.html">Show All</a>
            </div>
         </main>
         <!-- ---------END OF MAIN ---------- -->

         <div class="right">
               <div class="top">
                    <button id="menu-btn">
                    <span class="material-icons-sharp">menu</span>
                    </button>

                 <div class="theme-toggler">
                      <span class="material-icons-sharp active">light_mode</span>
                      <span class="material-icons-sharp">dark_mode</span>                    
                  </div>
                  <div class="profile">
                  <div class="info">
                       <p>Hello, <b><?php echo $name ?></b></p>
                       <small class="text-muted">Admin</small>
                    </div>
                    <div class="profile-photo">
                      <img src="<?php echo $profileImage;  ?>" alt="">
                    </div>
               </div>
           </div>
           <!-- END OF TOP -->
           <div class="recent-updates">
             <h2>Recent Updates</h2>
                    <div class="updates">
                        <div class="update">
                            <div class="profile-photo">
                                 <img src="Images/hope.jpg" alt="">
                            </div>
                              <div class="message">
                                <p><b>Ismael Bett</b>Staff meeting on monday 24</p>
                                <small class="text-muted">2 Minutes Ago</small>
                              </div>
                        </div>
                        
                        <div class="update">
                            <div class="profile-photo">
                              <img src="Images/hope.jpg" alt="">
                            </div>
                            <div class="message">
                              <p><b>Isaac Koech</b>New employees to be hired</p>
                              <small class="text-muted">2 Minutes Ago</small>
                            </div>
                        </div>

                        <div class="update">
                              <div class="profile-photo">
                                <img src="<?php echo $profileImage; ?>" alt="">
                              </div>

                              <div class="message">
                                <p><b>Ismael Bett</b>All beneficiaries are required at school</p>
                                <small class="text-muted">2 Minutes Ago</small>                 
                         </div>
                      </div>
                  </div>
               </div> 
                <!-- END OF UPDATES --> 

                <div class="sales-analytics">
                     <h2>User analytics</h2>
                     <div class="item online">
                        <div class="icon">
                          <span class="material-icons-sharp">shopping_cart</span>
                        </div>
                        <div class="right">
                          <div class="info">
                            <h3>Active Users</h3>
                            <small class="text-muted">last 24hours</small>
                          </div>
                          <h5 class="success">+2%</h5>
                          <h3>3888</h3>
                        </div>
                    </div>

                    <div class="item offline">
                      <div class="icon">
                        <span class="material-icons-sharp">local_mall</span>
                      </div>
                      <div class="right">
                        <div class="info">
                          <h3>Retired/Inactive</h3>
                          <small class="text-muted">last 24hours</small>
                        </div>
                        <h5 class="danger">+2%</h5>
                        <h3>3888</h3>
                      </div>
                  </div>


                  <div class="item customers">
                    <div class="icon">
                      <span class="material-icons-sharp">shopping_cart</span>
                    </div>
                    <div class="right">
                      <div class="info">
                        <h3>New Participants</h3>
                        <small class="text-muted">last 24hours</small>
                      </div>
                      <h5 class="success">+25%</h5>
                      <h3>50</h3>
                    </div>
                </div>
                <div class="item add-product">
                  <div>
                    <span class="material-icons-sharp">add</span>
                    <h3>Add Participant</h3>
                  </div>
                </div>
              </div>
          </div>                                           
       </div>
       <script src="script.js"></script> 
       <script src="../Javascript/users.js"></script>   
    </body>
</html>

<!-- 1:23:28 -->