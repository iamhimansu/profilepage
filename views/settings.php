<?php
session_name("PP");
session_start();
//Require controllers
require_once 'controllers/database.php';
require_once 'controllers/modules/Encryption.php';
require_once 'controllers/modules/core.php';
require_once 'controllers/functions.php';

$timezones = require_once 'controllers/modules/timezones.php';

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
    <title>Settings</title>
    <link rel="stylesheet" id="theme" href="<?php echo $handle->path('css/theme.min.css') ?>" class="" />
    <link rel="stylesheet" href="<?php echo $handle->path('css/app.min.css') ?>" />
    <link rel="stylesheet" href="<?php echo $handle->path('assets/fonts/bootstrap-icons/bootstrap-icons.css') ?>" />
    <link rel="stylesheet" href="<?php echo $handle->path('assets/plugins/selectjs/css/select2.min.css') ?>" />
    <link rel="stylesheet" href="<?php echo $handle->path('js/libs/Croppie/croppie.css') ?>" />
    <link rel="stylesheet" href="<?php echo $handle->path('js/snackbar/snackbar.css') ?>" />

</head>

<body>
    <?php include 'template/template.side-navbar.php';
    include 'template/template.bottom-navbar.php';

    ?>
    <div class="main-content">
        <div class="container-fluid">
            <form id="update_form">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-10 col-xl-8">
                        <!-- Header -->
                        <div class="header mt-md-4">
                            <div class="header-body">
                                <div class="row align-items-center">
                                    <div class="col">

                                        <!-- Pretitle -->
                                        <h6 class="header-pretitle">
                                            Overview
                                        </h6>

                                        <!-- Title -->
                                        <h1 class="header-title">
                                            Account
                                        </h1>

                                    </div>
                                </div> <!-- / .row -->
                                <div class="row align-items-center">
                                    <div class="col">

                                        <!-- Nav -->
                                        <ul class="nav nav-tabs nav-overflow header-tabs">
                                            <li class="nav-item">
                                                <a href="settings" data-ajax class="nav-link active">
                                                    General
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="security" data-ajax class="nav-link">
                                                    Security
                                                </a>
                                            </li>

                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form -->
                        <div class="col">
                            <div class="photoContainer d-none">
                            </div>
                        </div>
                        <div class="row justify-content-between align-items-center">
                            <div class="col">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar">
                                            <img class="avatar-img rounded-circle user-profile-picture" src="<?php echo $User->photos($User->Details($User->AuthID())); ?>" alt="<?php echo $User->Details($User->AuthID())["user_name"]; ?>">
                                        </div>
                                        <?php
                                        $old_profile_photos = $User->Details($User->AuthID());
                                        if (
                                            isset($old_profile_photos["old_profile_picture"])
                                            && count($old_profile_photos["old_profile_picture"]) > 0
                                        ) {
                                            for ($i = (count($old_profile_photos["old_profile_picture"]) - 1); $i >= 0; $i--) {
                                                /*do stuff*/

                                                if ($i === count($old_profile_photos["old_profile_picture"]) - 3) {
                                                    break;
                                                }
                                        ?>
                                                <div class="avatar ml-2">
                                                    <img class="avatar-img rounded-circle img-thumbnail" src="<?php echo $old_profile_photos["old_profile_picture"][$i]; ?>" alt="<?php echo $User->Details($User->AuthID())["user_name"]; ?>">
                                                </div>
                                            <?php

                                            }
                                            if (count($old_profile_photos["old_profile_picture"]) > 3) {
                                            ?>
                                                <div class="avatar ml-2">
                                                    <span class="avatar-title rounded-circle bg-primary-soft text-secondary">+<?php echo count($old_profile_photos["old_profile_picture"]) - 3; ?></span>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </div>

                                </div> <!-- / .row -->
                            </div>
                            <div class="col-auto">

                                <!-- Button -->
                                <input type="file" name="" id="profile-picture" accept="image/" hidden>
                                <button type="button" class="btn btn-sm btn-primary click-profile-picture">
                                    Upload
                                </button>

                            </div>
                        </div> <!-- / .row -->


                        <!-- Divider -->
                        <hr class="my-4">
                        <div class="hints-container">
                        </div>
                        <div class="row">
                            <div class="col-12">

                                <!-- First name -->
                                <div class="form-group">

                                    <!-- Label -->
                                    <label>
                                        <b>ProfilePage/@<?php echo $User->Details($User->AuthID())["user_name"]; ?></b>
                                    </label>
                                    <!-- Form text -->
                                    <small class="form-text text-muted">
                                        <span class="badge badge-primary">Note:</span> your user name is immutable thus it cannot be updated or changed.
                                    </small>
                                </div>

                            </div>
                            <div class="col-12 col-md-6">

                                <!-- First name -->
                                <div class="form-group">

                                    <!-- Label -->
                                    <label>
                                        First name
                                    </label>
                                    <!-- Input -->
                                    <input type="text" name="first_name" class="form-control" value="<?php echo $User->Details($User->AuthID())["first_name"]; ?>" placeholder="First name">

                                </div>

                            </div>
                            <div class="col-12 col-md-6">

                                <!-- Last name -->
                                <div class="form-group">

                                    <!-- Label -->
                                    <label>
                                        Last name
                                    </label>

                                    <!-- Input -->
                                    <input type="text" name="last_name" class="form-control" value="<?php echo $User->Details($User->AuthID())["last_name"]; ?>" placeholder="Last name">

                                </div>

                            </div>
                            <div class="col-12">

                                <!-- Last name -->
                                <div class="form-group">

                                    <!-- Label -->
                                    <label>
                                        Write about yourself
                                        <small> <b> in about <span id="bio-word-limit">150</span> words.</b></small>
                                    </label>

                                    <div class="row bg-white-soft border mx-0 rounded">
                                        <div class="col px-0">
                                            <textarea class="form-control border-0" id="bio" name="bio" data-toggle="autosize" rows="1" placeholder="Add your bio..." style="overflow: hidden; overflow-wrap: break-word; min-height: 65px; background: transparent;resize: none;"><?php echo $User->Details($User->AuthID())["user_bio"]; ?></textarea>
                                        </div>
                                        <div class="col-auto align-self-end">

                                            <!-- Icons -->
                                            <div class="text-muted mb-2">

                                                <a class="text-reset emojis" href="#!" data-toggle="tooltip" title="" data-original-title="Emoji">
                                                    <i class="bi bi-emoji-smile sz-24"></i>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-12">

                                <!-- Email address -->
                                <div class="form-group">

                                    <!-- Label -->
                                    <label class="mb-1">
                                        Email address
                                    </label>

                                    <!-- Form text -->
                                    <small class="form-text text-muted">
                                        This contact will be shown to others publicly, so choose it carefully.
                                    </small>

                                    <!-- Input -->
                                    <input type="email" name="email_address" class="form-control" value="<?php echo $User->Details($User->AuthID())["email"]; ?>" placeholder="Your email...">

                                </div>

                            </div>

                            <div class="col-12">

                                <!-- Email address -->
                                <div class="form-group">

                                    <!-- Label -->
                                    <label class="mb-1">
                                        Your timezone
                                    </label>

                                    <!-- Form text -->
                                    <small class="form-text text-muted">
                                        This will help to show right content at right time. </small>
                                    <select class="timezone" name="timezone" style="height: 10px !important;">
                                        <option></option>
                                        <?php
                                        $user_TimeZone = $User->Details($User->AuthID())["user_timezone"];
                                        foreach ($timezones as $zones => $zone) {
                                            $selected = ($zone === $user_TimeZone) ? "selected" : "";
                                            print "<option value='$zone' $selected>$zones </option>";
                                        } ?>
                                    </select>
                                </div>

                            </div>
                        </div> <!-- / .row -->


                        <!-- Button -->
                        <button type="button" class="btn btn-primary" id="update_information">
                            Save changes
                        </button>

                        <!-- Divider -->
                        <hr class="my-5">

                        <div class="row">
                            <div class="col-12 col-md-6">

                                <!-- Public profile -->
                                <div class="form-group">

                                    <!-- Label -->
                                    <label class="mb-1">
                                        Show my pages in footer
                                    </label>

                                    <!-- Form text -->
                                    <small class="form-text text-muted">
                                        Turning this on will include pages created by you in the footer section publically, that means anyone can see it.
                                    </small>

                                    <div class="row">
                                        <div class="col-auto">

                                            <!-- Switch -->
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="show_my_pages" id="include_my_pages" <?php echo (isset($User->Details($User->AuthID())["include_my_pages"]) && $User->Details($User->AuthID())["include_my_pages"] === 1) ? "checked" : ''; ?>>
                                                <label class="custom-control-label" for="include_my_pages"></label>
                                            </div>

                                        </div>
                                        <div class="col ml-n2">

                                            <!-- Help text -->
                                            <small class="text-muted">
                                                You can choose which pages to show in your page settings.
                                            </small>

                                        </div>
                                    </div> <!-- / .row -->
                                </div>

                            </div>
                            <div class="col-12 col-md-6">

                                <!-- Allow for additional Bookings -->
                                <div class="form-group">

                                    <!-- Label -->
                                    <label class="mb-1">
                                        Allow for related pages
                                    </label>

                                    <!-- Form text -->
                                    <small class="form-text text-muted">
                                        Related pages will be automatically added in the footer section.
                                    </small>

                                    <div class="row">
                                        <div class="col-auto">

                                            <!-- Switch -->
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="show_related_pages" id="include_related_pages" <?php echo (isset($User->Details($User->AuthID())["include_related_pages"]) && $User->Details($User->AuthID())["include_related_pages"] === 1) ? "checked" : ''; ?>>
                                                <label class="custom-control-label" for="include_related_pages"></label>
                                            </div>

                                        </div>
                                        <div class="col ml-n2">

                                            <!-- Help text -->
                                            <small class="text-muted">
                                                Currently invisible
                                            </small>

                                        </div>
                                    </div> <!-- / .row -->
                                </div>

                            </div>
                        </div> <!-- / .row -->

                        <!-- Divider -->
                        <hr class="mt-4 mb-5">

                        <div class="row justify-content-between mb-5">
                            <div class="col-12 col-md-6">

                                <!-- Heading -->
                                <h4>
                                    Delete your account
                                </h4>

                                <!-- Text -->
                                <p class="small text-muted mb-md-0">
                                    Please note, deleting your account is a permanent action and will no be recoverable once completed.
                                </p>

                            </div>
                            <div class="col-auto">

                                <!-- Button -->
                                <button class="btn btn-danger">
                                    Delete
                                </button>

                            </div>
                        </div> <!-- / .row -->
                    </div>
                </div>
            </form>
        </div>

    </div>
    <!-- Basic libraries-->
    <script src="<?php echo $handle->path('js/jquery.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/jquery-ui.js') ?>"></script>
    <script src="<?php echo $handle->path('js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/axios/axios.min.js') ?>"></script>
    <script src="<?php echo $handle->path('assets/plugins/selectjs/js/select2.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/libs/Croppie/croppie.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/libs/exif/exif.js') ?>"></script>
    <script src="<?php echo $handle->path('js/snackbar/snackbar.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/app.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/emojium.js') ?>"></script>
    <!--End libraries-->
    <script>
        $(function() {
            emojium(".emojis", $("#bio"));
            $("#bio").on("keydown", function() {
                if (150 - $("#bio").val().length <= 0) {
                    $("#bio-word-limit").html("0");
                    var trimmedString = $("#bio").val().substr(0, 150);
                    $("#bio").val(trimmedString);
                } else {
                    $("#bio-word-limit").html(150 - $("#bio").val().length);
                }
            });
            let ProfilePhotoContainer = function() {
                return '<div id="photo"><div class="image-is-loading d-flex align-items-center justify-content-center position-absolute" style="top: calc(100% - 18em);z-index: 10;width: 100%;"><div style="position: absolute; left: 48%;width:10em"><div style="position: relative; left: -50%;"><div class="progress" id="image-is-loading"><div class="indeterminate"></div></div></div></div></div></div><div class="d-flex justify-content-center"><button class="btn bg-primary-soft mr-2" id="save"><i class="bi bi-save"></i> Save</button> <button class="btn btn-white" id="discard">Discard</button></div><pre><div id="log"></div></pre><hr class="my-5">';
            };
            let HintsCollector = function() {
                return '<div class="card bg-light border"><div class="card-body"><ul class="small text-muted pl-4 mb-0 show-hints"></ul></div></div>';
            };
            $(".timezone").select2({
                placeholder: "Select your timezone"
            });
            $(".click-profile-picture").on("click", function() {
                $("#profile-picture").click();
            });

            function UploadPicture(input) {
                let ProfilePhoto = $("#photo");

                function readFile() {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            ProfilePhoto.croppie("bind", {
                                url: e.target.result
                            }).then(function(e) {
                                $(".image-is-loading").remove();
                            });
                        };
                        $(".click-profile-picture").addClass("d-none"),
                            $(".photoContainer").removeClass("d-none"),
                            reader.readAsDataURL(input.files[0]);
                    } else {
                        alert("Sorry - you're browser doesn't support the FileReader API");
                    }
                }
                readFile();
                ProfilePhoto.croppie({
                    enforceBoundary: true,
                    viewport: {
                        width: 200,
                        height: 200,
                        type: "circle"
                    },
                    boundary: {
                        width: 100 + "%",
                        height: 250
                    },
                    enableOrientation: true,
                    enableExif: true,
                });
                $("#save").on("click", function(ev) {
                    processing_started($("#save"), "save", "Saving...");
                    ProfilePhoto.croppie("result", {
                        type: "base64",
                        size: "viewport",
                        circle: false,
                    }).then(function(base64) {
                        axios({
                                method: "post",
                                url: "controllers/modules/image.upload.php",
                                data: "base64=" + base64,
                            })
                            .then(function(response) {
                                Snackbar.show({
                                    pos: "top-center",
                                    text: "Profile picture updated. 😊",
                                });
                                /*$("#log").html(response.data);*/
                                reset();
                                processing_done($(".save"), "save", "save", "Save");
                                $(".user-profile-picture").attr("src", base64);
                            })
                            .catch(function(error) {});
                    });
                });

                function reset() {
                    $("#profile-picture").val(""),
                        $(".photoContainer").html(""),
                        $(".click-profile-picture").removeClass("d-none"),
                        $(".photoContainer").addClass("d-none");
                    return;
                }
                $("#discard").on("click", function() {
                    reset();
                });
            }
            $("#profile-picture").on("change", function() {
                $(".photoContainer").removeClass("d-none");
                $(".photoContainer").html(ProfilePhotoContainer);
                UploadPicture(this);
            });
            $("#update_form").submit(function(evt) {
                evt.preventDefault();
            });

            function UpdateUserGeneralSettings() {
                const form = document.getElementById("update_form");
                const formdata = new FormData(form);
                axios({
                        method: "post",
                        url: "controllers/Handlers/settings/account.general.php",
                        data: formdata,
                    })
                    .then(function(response) {
                        processing_done(
                            $(".updating"),
                            "update_information",
                            "updating",
                            "Save changes"
                        );
                        if (response.data.length > 0) {
                            $(".hints-container").html(HintsCollector);
                            $(".show-hints").html(response.data);
                        } else {
                            $(".hints-container").html();
                        }
                    })
                    .catch(function(error) {});
            }
            $("#update_information").on("click", function() {
                processing_started($("#update_information"), "updating", "Updating...");
                UpdateUserGeneralSettings();
            });
            $("#include_my_pages, #include_related_pages").on("change", function() {
                UpdateUserGeneralSettings();
            });
        });
    </script>
</body>

</html>