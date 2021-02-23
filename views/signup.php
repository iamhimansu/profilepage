<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ProfilePage - Signup</title>

  <script src="js/moment/moment.min.js"></script>
  <script src="js/moment/moment-timezone-with-data.min.js"></script>
  <script src="js/cookies.min.js"></script>
  <link rel="stylesheet" href="./css/theme.min.css" />
  <link rel="stylesheet" href="./css/app.min.css" />
  <link rel="stylesheet" href="assets/fonts/bootstrap-icons/bootstrap-icons.css" />

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
      <div class="col-12 col-md-5 col-xl-4 order-md-1 my-5">

        <!-- Heading -->
        <h1 class="display-4 text-center mb-3">
          Sign up
        </h1>

        <!-- Subheading -->
        <p class="text-muted text-center mb-5">
          Create your free account now.
        </p>

        <p class="hints-container">
        </p>
        <!-- Form -->
        <form method="post" class="cond" id="data">

          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="l_u_name" placeholder="Name" />
          </div>
          <div class="form-group">
            <label for="l_u_email">Email</label>
            <input type="email" class="form-control" id="l_u_email" name="l_u_email" placeholder="name@address.com" />
          </div>

          <div class="form-group">
            <!-- Label -->
            <label for="password">
              Password
            </label>
            <div class="input-group input-group-merge">

              <!-- Input -->
              <input if-type="text:text|password" type="password" class="form-control form-control-appended" id="password" name="l_u_password" placeholder="Enter password" />
              <!-- Icon -->
              <div class="input-group-append">
                <span class="input-group-text py-0">
                  <button if-click="text|pass" class="btn p-0" type="button">
                    {<i class="bi bi-eye sz-18"></i>|<i class="bi bi-eye-slash sz-18"></i>}
                  </button>
                </span>
              </div>

              <small id="passwordHelpBlock" class="form-text text-muted">
                Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
              </small>
            </div>
          </div>
          <!-- Password -->
          <div class="form-group">

            <!-- Label -->
            <label for="confirm-password">
              Confirm password
            </label>

            <!-- Input -->
            <input if-type="text:text|password" type="password" id="confirm-password" class="form-control" name="l_ur_password" placeholder="Enter your password">

          </div>
          <div class="form-group">

            <!-- Label -->
            <label>
              Solve captcha
            </label>
            <div class="d-flex justify-content-between mb-3">
              <img class="img-thumbnail" src="controllers/modules/Captcha.php" alt="Captcha" id="captcha_holder">
              <a href="javascript:void(0)" class="btn btn-white btn-sm" id="reload_captcha"><i class="bi bi-arrow-repeat sz-18"></i></a>
            </div>
            <input type="text" class="form-control" name="captcha" placeholder="Enter what you see" autocomplete="off">
          </div>
          <!-- Submit -->
          <button type="button" class="btn btn-lg btn-block btn-primary mb-3" id="register" name="register">
            Sign up
          </button>

          <!-- Link -->
          <div class="text-center">
            <small class="text-muted text-center">
              Already have an account? <a href="login">Log in</a>.
            </small>
          </div>

        </form>
      </div>
    </div> <!-- / .row -->
  </div> <!-- / .container -->

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/axios/axios.min.js"></script>
  <script src="js/ifjs.min.js"></script>
  <script>
    $("#register").on("click", function() {
      let HintsCollector = function() {
        return '<div class="card bg-light border"><div class="card-body p-2"><ul class="small text-muted pl-4 mb-0 show-hints"></ul></div></div>';
      };
      const form = document.getElementById("data");
      const DataToParse = new FormData(form);
      axios({
        method: 'post',
        url: 'controllers/Handlers/signup/signup.Handler.php',
        data: DataToParse
      }).then(function(response) {
        if (response.data) {
          $(".hints-container").html(HintsCollector),
            $(".show-hints").html(response.data);
        } else {
          $(".hints-container").html('');
        }
      }).catch()
    });
    $("#reload_captcha").on('click', function() {
      $("#captcha_holder").attr("src", "controllers/modules/Captcha.php?c=" + Math.ceil(Math.random() * (1000000000 - 1) + 1));
    });
  </script>
</body>

</html>