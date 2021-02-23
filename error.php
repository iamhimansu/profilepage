<?php
require_once 'controllers/modules/core.php';
$handle = new CodeFlirt\Handlers;
?>
<!doctype html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Libs CSS -->
    <link rel="stylesheet" href="<?php echo $handle->path('assets/fonts/feather/feather.css') ?>" />
    <!-- Theme CSS -->

    <link rel="stylesheet" href="<?php echo $handle->path('css/theme.min.css'); ?>">

    <!-- Title -->
    <title>Not found</title>

</head>

<body class="d-flex align-items-center bg-auth border-top border-top-2 border-danger">

    <!-- CONTENT
    ================================================== -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5 col-xl-4 my-5">

                <div class="text-center">

                    <!-- Preheading -->
                    <h5 class="text-uppercase text-muted mb-4">
                        404 error
                        <?php echo htmlentities($path); ?> Not found
                    </h5>

                    <!-- Heading -->
                    <h1 class="display-4 mb-3">
                        There’s no page here 😭
                    </h1>

                    <!-- Subheading -->
                    <p class="text-muted mb-4">
                        Looks like you ended up here by accident?
                    </p>

                    <!-- Button -->
                    <a href="<?php echo $handle->path('home'); ?>" class="btn btn-lg bg-white-soft border-primary">
                        Return to home
                    </a>

                </div>

            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
    <!-- / .container -->

    <!-- JAVASCRIPT
    ================================================== -->
    <!-- Libs JS -->

    <!-- Theme JS -->
    <!-- <script src="assets/js/theme.min.js"></script> -->
    <!-- <script src="assets/js/dashkit.min.js"></script> -->


</body>

<!-- Mirrored from dashkit.goodthemes.co/error-illustration.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 13 Sep 2020 03:55:03 GMT -->

</html>