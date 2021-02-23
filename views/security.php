<?php
session_name("PP");
session_start();
//Require controllers
require_once 'controllers/database.php';
require_once 'controllers/modules/Encryption.php';
require_once 'controllers/modules/core.php';
require_once 'controllers/functions.php';

$handle = new CodeFlirt\Handlers;
$User = new User();

$User->isAuthenticated();

$CurrentPage = "settings";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings / Security</title>
    <link rel="stylesheet" id="theme" href="<?php echo $handle->path('css/theme.min.css') ?>" class="" />
    <link rel="stylesheet" href="<?php echo $handle->path('css/app.min.css') ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?php echo $handle->path('assets/fonts/bootstrap-icons/bootstrap-icons.css') ?>" />
    <link href="<?php echo $handle->path('assets/plugins/selectjs/css/select2.min.css') ?>" rel="stylesheet" />

</head>
<?php include 'template/template.side-navbar.php';
include 'template/template.bottom-navbar.php';
?>
<div class="main-content">

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">

                <!-- Header -->
                <div class="header mt-md-5">
                    <div class="header-body">
                        <div class="row align-items-center">
                            <div class="col">

                                <!-- Pretitle -->
                                <h6 class="header-pretitle">
                                    Overview
                                </h6>

                                <!-- Title -->
                                <h1 class="header-title">
                                    Account / Security
                                </h1>

                            </div>
                        </div> <!-- / .row -->
                        <div class="row align-items-center">
                            <div class="col">

                                <!-- Nav -->
                                <ul class="nav nav-tabs nav-overflow header-tabs">
                                    <li class="nav-item">
                                        <a href="settings" data-pjax class="nav-link">
                                            General
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="security" data-pjax class="nav-link active">
                                            Security
                                        </a>
                                    </li>

                                </ul>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-between align-items-center mb-5">
                    <div class="col-12 col-md-9 col-xl-7">

                        <!-- Heading -->
                        <h2 class="mb-2">
                            Change your password
                        </h2>

                        <!-- Text -->
                        <p class="text-muted mb-xl-0">
                            We will email you a confirmation when changing your password, so please expect that email after submitting.
                        </p>

                    </div>
                    <div class="col-12 col-xl-auto">

                        <!-- Button -->
                        <button class="btn btn-white">
                            Forgot your password?
                        </button>

                    </div>
                </div> <!-- / .row -->

                <div class="row">
                    <div class="col-12 col-md-6 order-md-2">

                        <!-- Card -->
                        <div class="hints-container">
                            <div class="card bg-light border ml-md-4">
                                <div class="card-body">

                                    <!-- Text -->
                                    <p class="mb-2">
                                        Password requirements
                                    </p>

                                    <!-- Text -->
                                    <p class="small text-muted mb-2">
                                        To create a new password, you have to meet all of the following requirements:
                                    </p>

                                    <!-- List group -->
                                    <ul class="small text-muted pl-4 mb-0 show-hints">
                                        <li>
                                            Minimum 8 character
                                        </li>
                                        <li>
                                            At least one special character
                                        </li>
                                        <li>
                                            At least one number
                                        </li>
                                        <li>
                                            Can’t be the same as a previous password
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 cond">

                        <!-- Form -->
                        <form id="update_form">

                            <!-- Password -->
                            <div class="form-group">

                                <!-- Label -->
                                <label>
                                    Current password
                                </label>

                                <!-- Input -->
                                <input if-type="text:text|password" type="password" class="form-control" name="user_password" placeholder="Your current password">

                            </div>

                            <!-- New password -->
                            <div class="form-group">

                                <!-- Label -->
                                <label>
                                    New password
                                </label>
                                <div class="input-group input-group-merge">
                                    <!-- Input -->
                                    <input if-type="text:text|password" type="password" class="form-control form-control-appended" name="new_password" placeholder="Enter a new password">

                                    <!-- Icon -->
                                    <div class="input-group-append">
                                        <span class="input-group-text py-0">
                                            <button if-click="text|pass" class="btn p-0" type="button">
                                                {<i class="bi bi-eye sz-18"></i>|<i class="bi bi-eye-slash sz-18"></i>}
                                            </button>
                                        </span>
                                    </div>

                                </div>

                            </div>
                            <!-- Confirm new password -->
                            <div class="form-group">
                                <!-- Label -->
                                <label>
                                    Confirm new password
                                </label>
                                <!-- Input -->
                                <input if-type="text:text|password" type="password" class="form-control" name="confirm_new_password" placeholder="Confirm new password">

                            </div>

                            <!-- Solve captcha -->
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
                            <button class="btn btn-block btn-primary" type="button" id="update_password">
                                Update password
                            </button>

                        </form>

                    </div>
                </div> <!-- / .row -->

                <!-- Divider -->
                <hr class="my-5">

                <div class="row justify-content-between align-items-center mb-5">
                    <div class="col-12 col-md-9 col-xl-7">

                        <!-- Heading -->
                        <h2 class="mb-2">
                            Device History
                        </h2>

                        <!-- Text -->
                        <p class="text-muted mb-xl-0">
                            If you find any suspicious device, change your password immediately.
                        </p>

                    </div>
                    <div class="col-12 col-xl-auto">

                        <!-- Button -->
                        <button class="btn btn-white" id="clear_devices">
                            Clear device history
                        </button>

                    </div>
                </div> <!-- / .row -->

                <!-- Card -->
                <div class="card">
                    <div class="card-body">

                        <!-- List group -->
                        <div class="list-group list-group-flush my-n3">
                            <?php

                            function device_icon($device_type)
                            {
                                $device_icon = null;
                                switch ($device_type) {
                                    case 'desktop':
                                    case 'Desktop':
                                    case 'laptop':
                                        $device_icon = "<i class='bi bi-laptop sz-36'></i>";
                                        break;
                                    case 'mobile':
                                    case 'Mobile':
                                        $device_icon = "<i class='bi bi-phone sz-36'></i>";

                                    default:
                                        $device_icon = "<i class='bi bi-laptop sz-36'></i>";
                                        break;
                                }
                                return $device_icon;
                            }
                            $current_login = $User->Details($User->AuthID())["login_history"];
                            $current_login_time  = new DateTime('@' . $current_login["logged_timestamp"]);
                            $CurrentDateTimezone = $current_login_time->setTimezone(new DateTimeZone($User->Details($User->AuthID())["user_timezone"]));
                            $format_current_time = $CurrentDateTimezone->format('dS M, Y \a\t h:i:s a');

                            ?>
                            <div class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar avatar-offline">
                                            <?php echo device_icon($current_login["device"]["name"]); ?>
                                        </div>
                                    </div>
                                    <div class="col ml-n2">
                                        <h4 class="mb-1">
                                            <?php echo "" . ucfirst($current_login["device"]["name"])
                                                . " <i class='bi bi-dot sz-18 mx-n1 px-0'></i> "
                                                . ucfirst($current_login["device"]["browser"]) . " <i class='bi bi-dot sz-18 mx-n1 px-0'></i> " . $current_login["location"]["country"] . ", " . $current_login["location"]["country_iso"] . ""; ?>
                                        </h4>

                                        <!-- Text -->
                                        <small class="text-muted">
                                            <?php echo "" . $current_login["location"]["state"] . ", " . $current_login["location"]["state_iso"] . "" ?> · <time><?php echo $format_current_time; ?></time>
                                        </small>
                                        <span class="badge bg-primary text-white ml-2">Recent</span>
                                    </div>
                                    <div class="col-auto">

                                        <!-- Button -->
                                        <a href="logout" class="btn btn-sm btn-white">
                                            Log out
                                        </a>

                                    </div>
                                </div>
                            </div>

                            <?php
                            if (isset($User->Details($User->AuthID())["old_login_history"])) {
                                $traced_logins = $User->Details($User->AuthID())["old_login_history"];
                                foreach (array_reverse($traced_logins) as $key => $loginTraces) {
                                    $old_login_time  = new DateTime('@' . $loginTraces["logged_timestamp"]);
                                    $CurrentDateTimezone = $old_login_time->setTimezone(new DateTimeZone($User->Details($User->AuthID())["user_timezone"]));
                                    $format_time = $CurrentDateTimezone->format('dS M, Y \a\t h:i:s a');
                            ?>
                                    <div class="list-group-item device-logs">
                                        <div class="row align-items-center">
                                            <div class="col-auto">

                                                <!-- Icon -->
                                                <?php echo device_icon($loginTraces["device"]["name"]); ?>

                                            </div>
                                            <div class="col ml-n2">

                                                <!-- Heading -->
                                                <h4 class="mb-1">
                                                    <?php echo "" . ucfirst($loginTraces["device"]["name"])
                                                        . " <i class='bi bi-dot sz-18 mx-n1 px-0'></i> "
                                                        . ucfirst($loginTraces["device"]["browser"]) . " <i class='bi bi-dot sz-18 mx-n1 px-0'></i> " . $loginTraces["location"]["country"] . ", " . $loginTraces["location"]["country_iso"] . ""; ?>
                                                </h4>

                                                <!-- Text -->
                                                <small class="text-muted">
                                                    <?php echo " " . $loginTraces["location"]["state"] . ", " . $loginTraces["location"]["state_iso"] . "" ?> · <time><?php echo $format_time; ?></time>
                                                </small>

                                            </div>
                                            <div class="col-auto">

                                                <!-- Button -->
                                                <button class="btn btn-sm btn-white">
                                                    Remove
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>

                    </div>
                </div>

                <br>

            </div>
        </div> <!-- / .row -->
    </div>

</div>
<!-- Basic libraries-->
<script src="<?php echo $handle->path('js/jquery.min.js') ?>"></script>
<script src="<?php echo $handle->path('js/jquery-ui.js') ?>"></script>
<script src="<?php echo $handle->path('js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?php echo $handle->path('js/axios/axios.min.js') ?>"></script>
<script src="<?php echo $handle->path('js/libs/Croppie/croppie.min.js') ?>"></script>
<script src="<?php echo $handle->path('js/libs/exif/exif.js') ?>"></script>
<script src="<?php echo $handle->path('js/snackbar/snackbar.min.js') ?>"></script>
<script src="<?php echo $handle->path('js/ifjs.min.js') ?>"></script>
<script src="<?php echo $handle->path('js/app.min.js') ?>"></script>
<!--End libraries-->

<script>
    $(function() {
        let formdata;

        function UpdateUserSecuritySettings(ongoing_process) {

            axios({
                method: 'post',
                url: 'controllers/Handlers/settings/account.security.php',
                data: formdata
            }).then(function(response) {
                console.log(response.data);
                processing_done($(".updating"), "update_password", "updating", "Update password");
                processing_done($(".clearing"), "clear_devices", "clearing", "Clear device history");
                if (response.data.length > 0) {
                    $(".hints-container").removeClass('d-none');
                    $(".show-hints").html(response.data);
                } else {
                    $(".hints-container").addClass('d-none');
                }
            }).catch(function(error) {});
        }
        $("#update_password").on('click', function() {
            processing_started($("#update_password"), "updating", "Changing...");
            const form = document.getElementById('update_form');
            formdata = new FormData(form);
            UpdateUserSecuritySettings();
        });
        $("#reload_captcha").on('click', function() {
            $("#captcha_holder").attr("src", "controllers/modules/Captcha.php?c=" + Math.ceil(Math.random() * (1000000000 - 1) + 1));
        });
        $("#clear_devices").on('click', function() {
            const form = document.getElementById('update_form');
            formdata = new FormData(form);
            formdata.append("clearDevices", true);
            processing_started($(this), "clearing", "Clearing...");
            UpdateUserSecuritySettings();
        });
    });
</script>