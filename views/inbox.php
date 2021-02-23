<?php

//Require controllers
require_once 'controllers/database.php';
require_once 'controllers/modules/Encryption.php';
require_once 'controllers/modules/core.php';
require_once 'controllers/functions.php';

$Auth = new User();
$handle = new CodeFlirt\Handlers;
$fetch = new CodeFlirt\Fetch;
$CurrentPage = "inbox";


$handle->trackUser();
session_name("PP");
session_start();
if (isset($_SESSION["ed"])) {
    $user_public_key = $_SESSION["ed"];

    $timezones = require_once 'controllers/modules/timezones.php';

    $Encryption = new Encryption();


    $user_email_address = $Encryption->decrypt($user_public_key, "_ProfilePage_");

    //Find and verify details from database 

    $get_user = $dbh->prepare("SELECT `user_private_key` FROM `users` WHERE `user_email_address` = '$user_email_address' LIMIT 1");

    $get_user->execute();
    $user = $get_user->fetch();

    //Get user private key for decryption and authentication 
    $user_private_key = $user['user_private_key'];

    // Check if encryption key matches then decrypt and verify user

    $get_user_details = $dbh->prepare("SELECT `user_details` FROM `details` WHERE `user_id` = '$user_private_key'");
    $get_user_details->execute();

    $user_details = $get_user_details->fetch();

    //If verification is successfull GRANT permissions to user 
    $decrypted = $Encryption->decrypt($user_details["user_details"], $user_private_key);

    $decode = json_decode($decrypted, true);

    // echo json_encode($decode, JSON_PRETTY_PRINT);
} else {
    return header("location:./login");
} //
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox | profilepage</title>
    <link rel="stylesheet" id="theme" href="<?php echo $handle->path('css/theme.min.css') ?>" class="" />
    <link rel="stylesheet" href="<?php echo $handle->path('css/app.min.css') ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?php echo $handle->path('assets/fonts/bootstrap-icons/bootstrap-icons.css') ?>" />
    <link rel="stylesheet" href="<?php echo $handle->path('js/snackbar/snackbar.css') ?>" />
    <link href="<?php echo $handle->path('assets/plugins/selectjs/css/select2.min.css') ?>" rel="stylesheet" />

</head>

<body>
    <?php
    // include navbar
    include 'template/template.side-navbar.php';
    include 'template/template.bottom-navbar.php';
    ?>
    <!-- main content -->
    <div class="main-content">


        <div class="container-fluid">
            <div class="my-4">
                <div class="row list">
                    <div class="col-md-7 col-lg-8">
                        <?php
                        $requestForPages = $fetch->data('links', ' page_id,page_name,user_id', "user_id='$user_private_key'", 'row');
                        if ($requestForPages) {
                            foreach ($requestForPages as $row) {
                                $page_name = explode('-', $row['page_name'])[0];
                                $owner_name = explode('-', $row["page_name"])[1];
                                $this_page_id = $row["page_id"];
                        ?>
                                <div class="card mb-3 rounded-xl">
                                    <div class="card-body">
                                        <a href="<?php echo "inbox/$this_page_id"; ?>" class="stretched-link"></a>
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <!-- Avatar -->
                                                <a href="project-overview.html" class="avatar avatar-lg avatar-4by3">
                                                    <img src="assets/img/avatars/projects/project-1.jpg" alt="..." class="avatar-img rounded">
                                                </a>

                                            </div>
                                            <div class="col ml-n2">

                                                <!-- Title -->
                                                <h4 class="mb-1 name">
                                                    <a href="<?php echo "@$owner_name/$page_name"; ?>" target="_blank"><?php echo $page_name; ?></a>
                                                </h4>

                                                <!-- Text -->
                                                <p class="card-text small text-muted mb-1">
                                                    <time datetime="2018-06-21">Published on 3rd October 2017</time>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="col-12 text-center">
                                <div class="card">
                                    <div class="card-body">Create pages to view messages. </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-md-5 col-lg-4">
                        <!-- Card -->
                        <div class="card mb-0">
                            <div class="card-body">

                                <!-- Title -->
                                <h6 class="text-uppercase text-center text-muted my-4">
                                    Basic plan
                                </h6>

                                <!-- Price -->
                                <div class="row no-gutters align-items-center justify-content-center">
                                    <div class="col-auto">
                                        <div class="h2 mb-0">$</div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="display-2 mb-0">19</div>
                                    </div>
                                </div> <!-- / .row -->

                                <!-- Period -->
                                <div class="h6 text-uppercase text-center text-muted mb-5">
                                    / month
                                </div>

                                <!-- Features -->
                                <div class="mb-3">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex align-items-center justify-content-between px-0">
                                            <small>Total messages</small> 80
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between px-0">
                                            <small>Replied</small> 15
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between px-0">
                                            <small>Members</small> <small>10 members</small>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center justify-content-between px-0">
                                            <small>Admins</small> <small>No access</small>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Button -->
                                <a href="#!" class="btn btn-block btn-light">
                                    Visit dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Basic libraries-->
    <script src="<?php echo $handle->path('js/jquery.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/jquery-ui.js') ?>"></script>
    <script src="<?php echo $handle->path('js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/axios/axios.min.js') ?>"></script>
    <script src="<?php echo $handle->path('assets/plugins/selectjs/js/select2.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/snackbar/snackbar.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/serializeControls.js') ?>"></script>
    <script src="<?php echo $handle->path('js/listjs/list.min.js') ?>"></script>

</body>

</html>