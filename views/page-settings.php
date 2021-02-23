<?php

//Require controllers
require_once 'controllers/database.php';
require_once 'controllers/modules/Encryption.php';
require_once 'controllers/modules/core.php';
require_once 'controllers/functions.php';

$User = new User();
$handle = new CodeFlirt\Handlers;
$fetch = new CodeFlirt\Fetch;
$Page = new Page();
$handle->trackUser();

session_name("PP");
session_start();

$User->isAuthenticated();

$Page->Find($PAGE_ID); // $PAGE_ID From Router
$PageDetails = $Page->Details();
$page_long_url = $handle->path("@" . $PageDetails['OwnerName'] . "/" . $PageDetails["PageName"] . "");
$page_short_url = $handle->path("" . $PageDetails["PageRefId"] . "");
$CurrentPage = "pages";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pages -Settings | ProfilePage</title>
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
    <div class="main-content">
        <div class="container-fluid">
            <div class="header">

                <!-- Body -->
                <div class="header-body">
                    <div class="row align-items-end">
                        <div class="col">

                            <!-- Pretitle -->
                            <h6 class="header-pretitle">
                                Pages / Settings
                            </h6>

                            <!-- Title -->
                            <h1 class="header-title text-truncate">
                                Settings / <?php echo $PageDetails["PageName"]; ?>
                            </h1>
                        </div>
                    </div> <!-- / .row -->
                </div> <!-- / .header-body -->

            </div>

            <div class="row">
                <div class="col">
                    <div class="block mb-2">
                        <div class="card mb-0 rounded">
                            <div class="card-header">
                                <h4 class="card-header-title">Security</h4>
                            </div>
                            <div class="card-body py-1 block-inputs">
                                <div class="mb-3">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="d-flex align-items-center justify-content-between px-0">
                                                <small>Secure your pages <i class="bi bi-info-circle ml-2" data-toggle="tooltip" title="Anyone visting your page will have to enter password that you have set."></i></small>
                                                <div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input toggle-input" id="filter_abuse" toggle-relative="securedPagePassword"> <label class="custom-control-label" for="filter_abuse"></label></div>
                                            </div>
                                            <div relative-id="securedPagePassword" style="display:none">
                                                <input class="form-control mt-3 mb-3" id="pagePassword" name="pagePassword" type="text" placeholder="Enter password for page">
                                                <button class="btn btn-white btn-block" id="save-page-password">Save</button>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5">
                    <div class="card border-0">
                        <div class="card-header">
                            <h4 class="card-header-title">QR Code</h4>
                        </div>
                        <div class="QR text-center">
                            <canvas id="page-qr" class="border-0 mx-auto d-block" style="max-height: 300px; max-width: 300px; height: 100% !important; width: 100%;">
                            </canvas>
                        </div>
                        <div class="card-body border-0">
                            <a href="javascript:void(0)" class="btn btn-white btn-block mb-3" id="download-page-qr"><i class="bi bi-upc-scan mr-2"></i>Download QR</a>
                            <div class="form-group">
                                <label for="long-url">Page url</label>
                                <input type="text" class="form-control" id="long-url" placeholder="<?php echo $page_long_url; ?>" value="<?php echo $page_long_url; ?>">
                            </div>
                            <div class="form-group">
                                <label for="short-url">Short url</label>
                                <input type="text" class="form-control" id="short-url" placeholder="<?php echo $page_short_url; ?>" value="<?php echo $page_short_url; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo $handle->path('js/jquery.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/jquery-ui.js') ?>"></script>
    <script src="<?php echo $handle->path('js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/axios/axios.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/snackbar/snackbar.min.js') ?>"></script>
    <script>
        $("[data-toggle]").tooltip();
        let toggle_related = document.querySelectorAll("[toggle-relative]");
        toggle_related.forEach(function(this_toggle) {
            this_toggle.addEventListener("click", function() {
                let toggle_relative_id = this_toggle.getAttribute("toggle-relative");
                let relative_id = document.querySelector(
                    '[relative-id="' + toggle_relative_id + '"]'
                );
                let relative_func_callback = relative_id.getAttribute(`relative-func`);
                // console.log(relative_func_callback_params);
                if (this_toggle.checked) {
                    if (relative_id === null && relative_func_callback === null) {
                        console.warn("relative-id [" + toggle_relative_id + '"] not found');
                        return;
                    }
                    if (relative_func_callback) {
                        let relative_func_name = relative_func_callback.split("(")[0];
                        let relative_func_callback_params = relative_func_callback
                            .split("(")[1]
                            .split(")")[0];

                        // eval(relative_func_callback);
                    }
                    relative_id.style["display"] = null;
                } else {
                    if (relative_id === null && relative_func === null) {
                        console.warn("relative-id #" + toggle_relative_id + " not found");
                        return;
                    }
                    relative_id.style["display"] = "none";
                }
            });
        });
        $("#save-page-password").on("click", function() {
            var pagePassword = "page-password=" + $("#pagePassword").val();
            // console.log(pagePassword);
            axios({
                method: 'post',
                url: '../../controllers/Handlers/page.password.php',
                data: pagePassword
            }).then(function(response) {
                console.log(response.data);
                if (response.data.length === 0) {
                    Snackbar.show({
                        pos: "top-center",
                        text: "Password changed",
                    });
                }
            }).catch(function(error) {
                console.log(error);
            })
        });
        var canvas = document.getElementById('page-qr'),
            ctx = canvas.getContext('2d');


        make_base();

        function make_base() {
            base_image = new Image();
            base_image.src = '../../controllers/modules/qrcode.php?s=qrh&d=<?php echo $page_long_url; ?>';
            base_image.onload = function() {
                ctx.drawImage(base_image, 0, 0, canvas.width, canvas.height);
            }
        };

        function resize() {
            var heightRatio = 1;
            canvas.height = canvas.width * heightRatio;
            ctx.drawImage(base_image, 0, 0, canvas.width, canvas.height);
        }
        $(document).ready(function() {
            resize();
            $(window).on("resize", function() {
                resize();
            });
        });
        $("#download-page-qr").on("click", function() {
            var pageQRCode = $("#page-qr");
            $(this).html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span> Preparing...'),
                $(this).attr("href", canvas.toDataURL()),
                $(this).attr("download", "<?php echo $PageDetails["PageName"] . "-QR"; ?>"),
                setTimeout(() => {
                    $(this).removeAttr("href");
                    $(this).html('<i class="bi bi-upc-scan mr-2"></i> Download');
                }, 100);
        });
    </script>
</body>

</html>