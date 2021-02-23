<?php
if (isset($_SESSION["ed"])) {
  session_name("PP");
  session_start();
  session_destroy();
}
//Require controllers
require_once 'controllers/database.php';
require 'controllers/modules/Encryption.php';
require 'controllers/modules/core.php';
require 'controllers/functions.php';

$User = new User();
$handle = new CodeFlirt\Handlers;
$fetch = new CodeFlirt\Fetch;
$sanitize = new CodeFlirt\Sanitize;
$error = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ProfilePage - Login</title>
  <link rel="stylesheet" href="./css/theme.min.css" />
  <link rel="stylesheet" href="./css/app.min.css" />
  <link rel="stylesheet" href="<?php echo $handle->path('assets/fonts/bootstrap-icons/bootstrap-icons.css') ?>" />

</head>

<body class="d-flex align-items-center bg-auth border-top border-top-2 border-primary">

  <!-- CONTENT
    ================================================== -->
  <div class="container">
    <div class="row align-items-center">
      <div class="col-12 col-md-6 offset-xl-2 offset-md-1 order-md-2 mb-5 mb-md-0">

        <!-- Image -->
        <div class="text-center">
          <img src="assets/img/illustrations/happiness.svg" alt="..." class="img-fluid">
        </div>

      </div>
      <div class="col-12 col-md-5 col-xl-4 order-md-1 my-5 d-none d-md-block">

        <!-- Heading -->
        <h1 class="display-4 text-center mb-3">
          ProfilePage
        </h1>

        <!-- Subheading -->
        <p class="text-muted text-center mb-5">
          Create your links now
        </p>
        <?php
        $user_is_valid = false;

        //If login button pressed
        if (isset($_POST["login"])) {
          //Grab user email address and Password
          $user_email_address = md5($_POST["l_u_email"]);
          $user_account_password = $_POST["l_u_password"];

          //Grab user from database
          //If record is matched then email address is valid--> proceed for authentication
          $find_user = "SELECT COUNT(*) FROM `users` WHERE `user_email_address` = '$user_email_address'";

          //If record is matched then email address is valid--> proceed for authentication
          if ($result = $dbh->query($find_user)) {

            //Check if column count is more than zero
            if ($result->fetchColumn() > 0) {

              //Initialize Encryption for decryption
              $Encryption = new Encryption();

              $GetUserPrivateKey = $fetch->data("users", "user_private_key", "user_email_address='$user_email_address'");
              if ($GetUserPrivateKey) {
                $GetUserDetails = $fetch->data("details", "user_details", "user_id='$GetUserPrivateKey'");
                if ($GetUserDetails && password_verify($user_account_password, $User->Details($GetUserPrivateKey)["password"])) {
                  if ($GetUserPrivateKey) {
                    //Set user is valid
                    $user_is_valid = true;
                  }
                } else {
                  $error = 1;
                  echo '<div class="card bg-danger-soft text-danger border"><div class="card-body p-3">No records found!</div></div>';
                }
              } else {
                return;
              }

              //Find and verify details from database
              if ($user_is_valid === true) {
                session_name("PP");
                //Save user in session, cookies
                session_start();

                //ed--> Email address
                $_SESSION["ed"] = $Encryption->encrypt($_POST["l_u_email"], '_ProfilePage_');
                // setcookie("ed", $Encryption->encrypt($_POST["l_u_email"], '_ProfilePage_'), time() + 24 * 60 * 60, '/');

                //Detect user
                $userID  = $User->AuthID();

                $DetectedUser = $User->DetectUser();

                $LoginHistory["preserve"]["login_history"] = "old_";
                // $LoginHistory["preserve"][""] = "test_";
                $LoginHistory["login_history"]  = $DetectedUser;
                //Get user Authentication ID

                //Push user data
                $PackedData = $User->pack($LoginHistory, 'details');

                // //Update user data in database
                $stmt = $dbh->prepare("UPDATE `details` SET `user_details` = ?  WHERE `user_id` = ? LIMIT 1");

                //
                $stmt->bindParam(1, $PackedData);
                $stmt->bindParam(2, $userID);
                $stmt->execute();

                //If verification is successfull GRANT permissions to user
                if (isset($_COOKIE["cf_track_user"]) && !empty($_COOKIE["cf_track_user"])) {
                  $user_has_come_from = $_COOKIE["cf_track_user"];
                  echo '
                            <META HTTP-EQUIV="Refresh" Content="0; URL=continue.php?continue=' . urldecode($user_has_come_from) . '">';
                } else {
                  header('location:home');
                }
              }
            } else {
              $error = 2;
              echo '<div class="card bg-info-soft text-info border"><div class="card-body p-3">Account does not exists! <a href="signup">create a new one now</a>?</div></div>';
            }
          }
        }
        if (isset($_GET["m"]) && $_GET["m"] === "acs" && !$error > 0) {
          echo '<div class="card bg-light border"><div class="card-body p-3">Account created successfully, please login.</div></div>';
        }
        ?>

        <!-- Form -->
        <form method="post">

          <!-- Email address -->
          <div class="form-group">

            <!-- Label -->
            <label>Email Address</label>

            <!-- Input -->
            <input type="email" class="form-control" id="l_u_email" name="l_u_email" placeholder="name@address.com" />

          </div>

          <!-- Password -->
          <div class="form-group">

            <div class="row">
              <div class="col">

                <!-- Label -->
                <label>Password</label>

              </div>
              <div class="col-auto">

                <!-- Help text -->
                <a href="forgot" class="form-text small text-muted">
                  Forgot password?
                </a>

              </div>
            </div> <!-- / .row -->

            <!-- Input group -->

            <div class="input-group input-group-merge">

              <!-- Input -->
              <input type="password" placeholder="Password" class="form-control form-control-appended" id="password" name="l_u_password" />

              <!-- Icon -->
              <div class="input-group-append">
                <span class="input-group-text py-0">
                  <button class="btn p-0 toggle_password_visiblitiy" type="button">
                    <i class="bi bi-eye sz-18"></i>
                  </button>
                </span>
              </div>

            </div>
          </div>

          <!-- Submit -->
          <button type="submit" class="btn btn-primary btn-block btn-lg mb-3" name="login">
            Login
          </button>

          <!-- Link -->
          <div class="text-center">
            <small class="text-muted text-center">
              Don't have an account yet? <a href="signup">Sign up</a>.
            </small>
          </div>

        </form>

      </div>
    </div> <!-- / .row -->
  </div> <!-- / .container -->

</body>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $handle->path('js/ifjs.js') ?>"></script>

<script>
  $('.toggle_password_visiblitiy').click(function() {
    if ($("#password").attr('type') === 'text') {
      $(this).html('<i class="bi bi-eye sz-18"></i>');
      $("#password").attr('type', 'password');
    } else {
      $("#password").attr('type', 'text');
      $(this).html('<i class="bi bi-eye-slash sz-18"></i>');
    }
  });
</script>
</body>

</html>