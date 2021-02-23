<?php

/**
 * CORE Files are being used from Router
 */
include_once __DIR__ . '/../controllers/modules/Render.php';
// include_once __DIR__ . '/../controllers/modules/PageViews.php';

$PAGENAME = $PageName; // From Router
$PAGEID = $_SESSION["PageID"];
$OWNERID = $_SESSION["OwnerID"];

$User = new User();
$fetch = new CodeFlirt\Fetch();
$handle = new CodeFlirt\Handlers();

include_once __DIR__ . "/../controllers/modules/PageViews.php";
/**
 * Including MOMENT JS to detect user time zone
 * Helps in converting timezones
 * |========================================|
 * |=============MOMENTJS===================|
 * |========================================|
 */
?>
<script src="<?php echo $handle->path('js/moment/moment.min.js'); ?>"></script>
<script src="<?php echo $handle->path('js/moment/moment-timezone-with-data.min.js'); ?>"></script>
<script src="<?php echo $handle->path('js/cookies.min.js'); ?>"></script>

<?php
//
$PAGE_RESOURCES = array();
//Converting json into array
$__TMP_PAGE_RESOURCES = json_decode($fetch->data("links", "link_configs", "page_id='$PAGEID'"), true);
//
//Check if page is locked
if (isset($__TMP_PAGE_RESOURCES["page_password"])) {
    $_SESSION["locked-key"] = $__TMP_PAGE_RESOURCES["page_password"];
}
if (isset($_POST["page-password"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION["input-key"] = $_POST["page-password"];
}
//Saving page configs 
if (isset($__TMP_PAGE_RESOURCES["page_configs"])) {
    $__PAGE_CONFIGS = $__TMP_PAGE_RESOURCES["page_configs"];
}
// echo '<pre>';

//Removing empty elements
$__TMP_PAGE_RESOURCES = @array_map('array_filter', $__TMP_PAGE_RESOURCES);
$__TMP_PAGE_RESOURCES = array_filter($__TMP_PAGE_RESOURCES);

//dividing PAGE RESOURCES in different categories
foreach ($__TMP_PAGE_RESOURCES as $key => $value) {
    //Removing disabled links
    if (isset($value["disabled"])) {
        // fix disabled links
        unset($__TMP_PAGE_RESOURCES[$key]);
    } else {
        //Separating feedback
        if ($key === "feedback_collector") {
            $PAGE_RESOURCES[]["FEEDBACK"] = $value;
        }
        // separating form
        if ($key === "information_collector") {
            $PAGE_RESOURCES[]["FORM"] = $value;
        }
        // separating anonymus chat
        if ($key === "chat") {
            $PAGE_RESOURCES[]["CHAT"] = $value;
        }
        //separating general link
        if (strpos($key, "link_") !== false && !isset($value["scheduled"])) {
            $PAGE_RESOURCES[]["GENERAL_LINK"] = $value;
        }
        // separating scheduled links
        if (isset($value["scheduled"])) {
            $PAGE_RESOURCES[]["SCHEDULED_LINK"] = $value;
        }
        // separating forward links
        if (isset($value["forward"])) {
            $PAGE_RESOURCES[]["FORWARD_LINK"] = $value;
        }
        // Check for forward links
        if (isset($value['forward'])) {

            //IF forward link is present then redirecting to the link
            $forward_timezone = schedule_time(
                $value['forward']['date'],
                $value['forward']['timezone'],
                $_COOKIE["tz"]
            );

            if ( //Redirect usre if date is today
                $forward_timezone['start_difference'] <= 0
                && $forward_timezone['end_difference'] >= 0
            ) {
                //Redirecting user
                header("location:$value[link_address]");
                exit();
            }
        }
    }
}

// no need of temporary page resources
unset($__TMP_PAGE_RESOURCES);

//Creating custom stylesheet set by user 
$style = array();
if (isset($__PAGE_CONFIGS["background-image"])) {
    $style[".ppage"]["background-image"] = 'url("' . $handle->path($__PAGE_CONFIGS["background-image"]) . '")';
    $style[".ppage"]["background-repeat"] = "no-repeat";
    $style[".ppage"]["background-size"] =    "cover";
    $style[".ppage"]["background-attachment"] =  "fixed";
}
if (isset($__PAGE_CONFIGS["background-color"])) {
    // unset($style[".ppage"]);
    $style[".ppage"]["background-color"] = "" . $__PAGE_CONFIGS["background-color"] . "";
}

if (isset($__PAGE_CONFIGS["foreground-color"])) {
    $style[".ppage section"]["border-radius"] =  "10px";
    $style[".ppage section"]["background-color"] =  "" . $__PAGE_CONFIGS["foreground-color"] . "";
    $style[".ppage section .ppage-card"]["background-color"] = "transparent";
    $style[".ppage section .ppage-card"]["border"] = "0";
}
if (isset($__PAGE_CONFIGS["font-color"])) {
    $style[".ppage"]["color"] = "" . $__PAGE_CONFIGS["font-color"] . "";
    $style[".ppage section"]["color"] = "" . $__PAGE_CONFIGS["font-color"] . "";
    $style[".ppage .text-muted"]["color"] = "" . $__PAGE_CONFIGS["font-color"] . "";
}
if (isset($__PAGE_CONFIGS["section-transparency"])) {
    $style[".ppage section"]["background-color"] = "" . $__PAGE_CONFIGS["section-transparency"] . "";
    $style[".ppage section .ppage-card"]["background-color"] = "" . $__PAGE_CONFIGS["section-transparency"] . "";
    $style[".ppage .btn-white"]["background-color"] = "" . $__PAGE_CONFIGS["section-transparency"] . " !important";
    $style[".ppage section .ppage-input"]["background-color"] = "" . $__PAGE_CONFIGS["section-transparency"] . "";
}
$style[".ppage section"]["border-radius"] = "10px";
//Rendering links
// echo "<pre>";
// print_r($PAGE_RESOURCES);
// echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "@$PAGENAME | ProfilePage"; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" id="theme" href="<?php echo $handle->path('css/theme.min.css') ?>" class />
    <link rel="stylesheet" href="<?php echo $handle->path('css/app.min.css') ?>" />
    <link rel="stylesheet" href="<?php echo $handle->path('assets/fonts/bootstrap-icons/bootstrap-icons.css') ?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?php echo $handle->path('js/snackbar/snackbar.min.css') ?>" />
</head>

<body>
    <div class="wrapper">
        <?php
        //Check if password is set        
        if (
            isset($_SESSION["locked-key"]) &&
            !password_verify(@$_SESSION["input-key"], $_SESSION["locked-key"])
        ) {
        ?>
            <div class="container-sm">
                <div class="vh-100">
                    <div class="h-100">
                        <div class="text-center">
                            <div class="d-flex text-muted justify-content-center align-items-center h-100 flex-column">
                                <div class="mb-3">
                                    <i class="bi bi-shield-lock sz-64 text-primary"></i>
                                </div>
                                <div>
                                    <h1 class="font-weight-normal mb-5">
                                        <b><?php echo $PAGENAME; ?></b> is locked
                                    </h1>
                                </div>
                                <div>
                                    <?php if (isset($_SESSION["input-key"]) && !password_verify($_SESSION["input-key"], $_SESSION["locked-key"])) { ?>
                                        <div class="card bg-danger-soft text-danger border">
                                            <div class="card-body p-3">Sorry, password is incorrect</div>
                                        </div>
                                    <?php } ?>
                                    <small>PLease enter the desired password</small>
                                    <form action="" method="post">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="bi bi-key sz-18"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="page-password" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn bg-primary-soft btn-block">Unlock</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            exit(0);
        }
        if (isset($__PAGE_CONFIGS) && count($__PAGE_CONFIGS) > 0) {

        ?>
            <style type="text/css">
                <?php foreach ($style as $key => $selector) {
                    echo "$key{ ";
                    foreach ($selector as $property => $value) {
                        echo "$property:$value;";
                    }
                    echo "}";
                }; ?>
            </style>
        <?php }
        ?>
        <div class="ppage">
            <div class="container" id="container">
                <div class="row justify-content-center">
                    <div class="col-md-7">
                        <div class="card-body text-center">
                            <a href="#" class="avatar avatar-xxl card-avatar">
                                <img src="<?php
                                            if ($Page->photo()) {
                                                echo $handle->path($Page->photo());
                                            } else {
                                                echo $handle->path($User->photos($User->Details($OWNERID)));
                                            } ?>" class="avatar-img rounded-circle border border-4 border-card page-image" alt="">
                            </a>
                            <h2 class="card-title text-truncate">
                                <?php echo "<a href='#" . $User->Details($OWNERID)["user_name"] . "'>@" . $User->Details($OWNERID)["user_name"] . "</a> <i class='bi bi-dot mx-n2'></i> " . $PAGENAME;
                                ?>
                            </h2>
                            <p class="small text-muted mb-3">
                                <?php echo isset($User->Details($OWNERID)["user_bio"]) ? $User->Details($OWNERID)["user_bio"] : "Hey there, welcome to my profile page."; ?>
                            </p>
                        </div>

                        <?php

                        /**
                         * Rendering Page configurations
                         */
                        foreach ($PAGE_RESOURCES as $key) {
                            if (is_array($key)) {
                                foreach ($key as $Category => $Configs) {
                                    (new Render($Category, $Configs))->output();
                                }
                            }
                        }

                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <footer class="card-footer mt-5">
        <div class="container">
            <h4 class="font-weight-bold">
                Profile Page
            </h4>
            <div class="row">
                <div class="col-md-4">
                    <p class="text-small">Notebook nation, an initiative by experienced intellectuals hailing from the reputed institutions, IIT, IIM, DU, and NIT</p>
                    <p>
                        <a href="http://www.twitter.com/" class="uk-link-reset">
                            <span uk-icon="icon:twitter;ratio:.8" class="uk-icon"><svg width="16" height="16" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="twitter">
                                    <path d="M19,4.74 C18.339,5.029 17.626,5.229 16.881,5.32 C17.644,4.86 18.227,4.139 18.503,3.28 C17.79,3.7 17.001,4.009 16.159,4.17 C15.485,3.45 14.526,3 13.464,3 C11.423,3 9.771,4.66 9.771,6.7 C9.771,6.99 9.804,7.269 9.868,7.539 C6.795,7.38 4.076,5.919 2.254,3.679 C1.936,4.219 1.754,4.86 1.754,5.539 C1.754,6.82 2.405,7.95 3.397,8.61 C2.79,8.589 2.22,8.429 1.723,8.149 L1.723,8.189 C1.723,9.978 2.997,11.478 4.686,11.82 C4.376,11.899 4.049,11.939 3.713,11.939 C3.475,11.939 3.245,11.919 3.018,11.88 C3.49,13.349 4.852,14.419 6.469,14.449 C5.205,15.429 3.612,16.019 1.882,16.019 C1.583,16.019 1.29,16.009 1,15.969 C2.635,17.019 4.576,17.629 6.662,17.629 C13.454,17.629 17.17,12 17.17,7.129 C17.17,6.969 17.166,6.809 17.157,6.649 C17.879,6.129 18.504,5.478 19,4.74"></path>
                                </svg></span>
                        </a>
                        <a href="http://www.facebook.com/" class="uk-link-reset">
                            <span uk-icon="icon:facebook;ratio:.8" class="uk-icon"><svg width="16" height="16" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="facebook">
                                    <path d="M11,10h2.6l0.4-3H11V5.3c0-0.9,0.2-1.5,1.5-1.5H14V1.1c-0.3,0-1-0.1-2.1-0.1C9.6,1,8,2.4,8,5v2H5.5v3H8v8h3V10z"></path>
                                </svg></span>
                        </a>
                        <a href="https://www.instagram.com/" class="uk-link-reset">
                            <span uk-icon="icon:instagram;ratio:.8" class="uk-link-reset uk-icon"><svg width="16" height="16" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="instagram">
                                    <path d="M13.55,1H6.46C3.45,1,1,3.44,1,6.44v7.12c0,3,2.45,5.44,5.46,5.44h7.08c3.02,0,5.46-2.44,5.46-5.44V6.44 C19.01,3.44,16.56,1,13.55,1z M17.5,14c0,1.93-1.57,3.5-3.5,3.5H6c-1.93,0-3.5-1.57-3.5-3.5V6c0-1.93,1.57-3.5,3.5-3.5h8 c1.93,0,3.5,1.57,3.5,3.5V14z"></path>
                                    <circle cx="14.87" cy="5.26" r="1.09"></circle>
                                    <path d="M10.03,5.45c-2.55,0-4.63,2.06-4.63,4.6c0,2.55,2.07,4.61,4.63,4.61c2.56,0,4.63-2.061,4.63-4.61 C14.65,7.51,12.58,5.45,10.03,5.45L10.03,5.45L10.03,5.45z M10.08,13c-1.66,0-3-1.34-3-2.99c0-1.65,1.34-2.99,3-2.99s3,1.34,3,2.99 C13.08,11.66,11.74,13,10.08,13L10.08,13L10.08,13z"></path>
                                </svg></span>
                        </a>
                        <a href="" class="uk-link-reset">
                            <span uk-icon="icon:google;ratio:.8" class="uk-icon"><svg width="16" height="16" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="google">
                                    <path d="M17.86,9.09 C18.46,12.12 17.14,16.05 13.81,17.56 C9.45,19.53 4.13,17.68 2.47,12.87 C0.68,7.68 4.22,2.42 9.5,2.03 C11.57,1.88 13.42,2.37 15.05,3.65 C15.22,3.78 15.37,3.93 15.61,4.14 C14.9,4.81 14.23,5.45 13.5,6.14 C12.27,5.08 10.84,4.72 9.28,4.98 C8.12,5.17 7.16,5.76 6.37,6.63 C4.88,8.27 4.62,10.86 5.76,12.82 C6.95,14.87 9.17,15.8 11.57,15.25 C13.27,14.87 14.76,13.33 14.89,11.75 L10.51,11.75 L10.51,9.09 L17.86,9.09 L17.86,9.09 Z"></path>
                                </svg></span>
                        </a>
                    </p>
                </div>
                <div class="col">
                    <div class="row">

                        <?php
                        if (
                            isset($User->Details($OWNERID)["include_my_pages"])
                            && $User->Details($OWNERID)["include_my_pages"] === 1
                        ) {
                        ?>
                            <div class="col border-left">
                                <div class="text-small font-weight-light">
                                    <span class="font-weight-bold text-uppercase">
                                        Pages by <?php echo $User->Details($OWNERID)["user_name"]; ?>
                                    </span>
                                    <div class="d-flex justify-content-start flex-wrap">
                                        <?php
                                        $OWNERPAGES = $fetch->data('links', 'page_id,page_name', "user_id='$OWNERID'", 'row');
                                        foreach ($OWNERPAGES as $FOOTER_PAGE) {
                                        ?>
                                            <span class="m-2">
                                                <a class="text-truncate btn btn-white rounded p-2" href="<?php echo $handle->path("@" . explode('@', $FOOTER_PAGE["page_name"])[1] . "/" . explode('@', $FOOTER_PAGE["page_name"])[0] . ""); ?>">
                                                    <?php echo explode('@', $FOOTER_PAGE["page_name"])[0]; ?>
                                                </a>
                                            </span>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <?php
                        if (
                            isset($User->Details($OWNERID)["include_related_pages"])
                            && $User->Details($OWNERID)["include_related_pages"] === 1
                        ) { ?>
                            <div class="col border-left">
                                <span class="font-weight-bold text-uppercase">
                                    Related pages
                                </span>
                                <div class="d-flex justify-content-start flex-wrap flex-column">
                                    <?php
                                    $RELATED_PAGES = $fetch->data('links', 'page_id,page_name', "page_name LIKE '%$PAGENAME%'", 'row');
                                    foreach ($RELATED_PAGES as $FOOTER_RELATEDPAGE) {
                                    ?> <a class="text-truncate" href="<?php echo $handle->path("@" . explode('@', $FOOTER_RELATEDPAGE["page_name"])[1] . "/" . explode('@', $FOOTER_RELATEDPAGE["page_name"])[0] . ""); ?>">
                                            <?php echo explode('@', $FOOTER_RELATEDPAGE["page_name"])[0]; ?>
                                        </a>
                                    <?php
                                    }

                                    ?>
                                </div>
                            </div>
                        <?php }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="<?php echo $handle->path('js/jquery.min.js'); ?>"></script>
    <script src="<?php echo $handle->path('js/jquery-mask/jquery.mask.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/ifjs.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="<?php echo $handle->path('js/axios/axios.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/snackbar/snackbar.min.js') ?>"></script>

    <script>
        let feedback_bar = document.querySelector(".feedback_bar");
        let feedback_bar_container = document.querySelector(".feedback_bar_container");
        let star = document.querySelectorAll(".star");
        let feeback_submit_message = document.querySelector(".feeback_submit_message");
        let rating = 0;
        let got_star;
        star.forEach((thisStar) => {
            thisStar.addEventListener("mouseover", () => {
                star.forEach((ii) => {
                    ii.classList.remove('rated')
                });
                for (var i = thisStar.getAttribute("rate-value") - 1; i >= 0; i--) {
                    star[i].classList.add("rated");
                    /* CREATING HOVER EFFECT */
                    if (star[i].classList.contains("rated")) {
                        thisStar.classList.remove("rated");
                    }
                }
            });
            thisStar.addEventListener("click", () => {
                // thisStar.classList.add("rated");
                rating = thisStar.getAttribute("rate-value");
                let currentRating = thisStar.getAttribute("rate-value") - 1;
                feedback_bar_container.removeAttribute("hidden");
                feedback_bar.setAttribute("style", `width: ${currentRating*20+20}%`);
                // console.log(currentRating);
                feeback_submit_message.removeAttribute("style");
                if (rating == 1) {
                    got_star = "star"
                } else {
                    got_star = "stars";
                }
                if (rating < 2) {
                    feeback_submit_message.innerHTML = (
                        `<div class="alert text-danger mb-0 p-0"> 😊 We will try to improve from ${rating} ${got_star} to 5 stars</div>`
                    );
                } else {
                    feeback_submit_message.innerHTML = (
                        `<div class=""> 😍 Woohooo! you gave us ${rating} ${got_star} thankyou!</div>`
                    );
                }
                star.forEach((prevRating) => {
                    prevRating.classList.remove("rated")
                });
                for (var i = currentRating; i >= 0; i--) {
                    star[i].classList.add("rated");
                    // console.log(star[i]);
                }
            });
        });
        $(".submit_feedback").click(function(e) {
            e.preventDefault();
            if (rating < 4) {
                feeback_submit_message.innerHTML = (
                    `<div class="alert text-danger pt-2 p-0" role="alert"><i class="fal fa-frown"></i> You rated ${rating} stars, Thankyou for your feedback!</div>`
                );
            } else {
                feeback_submit_message.innerHTML = (
                    '<div class="alert pt-2 p-0" role="alert"> <i class="fal fa-smile-wink pr-1"></i>Thankyou for your valuable feedback!</div>'
                );
            }
            axios({
                    url: '../controllers/Handlers/page.feedback.Handler.php',
                    method: 'post',
                    data: $("#submit-feedback").serialize() + '&feedback[rating]=' + rating
                })
                .then(function(response) {
                    // $(".send-request").trigger("reset");
                    feedback_bar_container.setAttribute("hidden", true);
                    $(feeback_submit_message).fadeTo(2000, 500).slideUp(500, function() {
                        $(feeback_submit_message).slideUp(500);
                    });
                    star.forEach((prevRating) => {
                        prevRating.classList.remove("rated")
                    });
                    if (response.data.length === 0) {
                        $("body").find("#submit-feedback").closest("section").fadeOut(),
                            Snackbar.show({
                                pos: "top-center",
                                text: "Feedback submitted. 😊",
                            });
                    } else {
                        Snackbar.show({
                            pos: "top-center",
                            text: "Something went wrong, your request was not submitted",
                        });
                    }
                    /*NOT RESETTING RATING TO GET HIGH RATINGS*/
                    /*rating = 0;*/
                })

        });

        $('.submit_form_response').on('click', function(e) {
            var form = document.querySelector('#submit-response');

            const formData = new FormData(form);
            axios({
                url: '../controllers/Handlers/page.responses.Handler.php',
                method: 'post',
                data: formData
            }).then(function(response) {
                if (response.data.length === 0) {
                    $("body").find("#submit-response").closest("section").fadeOut(),
                        Snackbar.show({
                            pos: "top-center",
                            text: "Your response has been submitted. 😊",
                        });
                } else {
                    Snackbar.show({
                        pos: "top-center",
                        text: "Something went wrong, your request was not submitted",
                    });
                }
            })
        });
        flatpickr(".dob", {
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "d-m-Y",

        });
        //MASKING
        $('#phoneNumber').mask("(99) 9999999999");
        $('#emailAddress,#feedback_email').mask("A", {
            translation: {
                "A": {
                    pattern: /[\w@\-.+]/,
                    recursive: true
                }
            }
        });

        /**CHAT BOX
         * 
         */
        const init_ifjs = function() {
            return new IFJS();
        };
        $(function() {
            let MessageStatus = {
                status: function(content, time) {
                    $('.message-status').html('<div class="bg-primary-soft p-3 mx-2 my-2 rounded animate__animated animate__fadeInUp message_status_content d-flex align-items-center">' + content + '</div>');
                    setTimeout(function() {
                        $(".message-status > .message_status_content").removeClass("animate__fadeInUp");
                        $(".message-status > .message_status_content").addClass("animate__fadeOutUp");
                    }, 4000);
                    if (time) {
                        setTimeout(function() {
                            $('.message-status').html('');
                        }, time);
                    }
                }
            };
            let msg_delay_template = function() {
                return `
                <div class="msg_delay_timer">
                    <div class="bg-white p-2 mb-0 bg-primary-soft text-primary rounded">
                        <div class="p-2 text-center">
                            <div class="h2 mb-0" id="countdown">
                                ${message_time_delay}
                            </div> 
                        </div>
                    </div>
                </div>
                `;
            };
            let msg_tool_template = function() {
                return `
                <label class="sr-only">Leave your message...</label><textarea class="form-control form-control-flush" id="message" data-toggle="autosize" rows="1" placeholder="Leave your message..." style="overflow:hidden;overflow-wrap:break-word;max-height:125px;height:125px"></textarea>

                <div class="d-flex align-items-center justify-content-between">
                    <?php if (isset($_SESSION["ed"])) { ?>
                        <div class="cond">
                            <div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" id="is_anonymus" value="true">
                                <label class="custom-control-label" for="is_anonymus" if-click="">{|<small class="font-weight-bold">by <?php echo ($User->Details($User->AuthID())["user_name"]); ?></small>}</label>
                            </div>
                        </div>
                    <?php } ?>
                <div class="ml-auto align-self-end">
                    <div class="text-muted mb-2">
                        <button class="btn btn-circle bg-hover-primary-soft btn-md" id="open_emoji_panel"><i class="bi bi-emoji-smile sz-24"></i></button>
                        <button class="btn btn-circle bg-hover-primary-soft btn-md" id="send-msg"><i class="bi bi-telegram sz-24"></i></button>
                    </div>
                </div>

                </div>
                `;
            };
            $(".msg-tools").html(msg_tool_template);
            init_ifjs();

            let emoticons_face_emojis =
                '😀 😃 😄 😁 😆 😅 😂 🤣 😊 😇 🙂 🙃 😉 😌 😍 🥰 😘 😗 😙 😚 😋 😛 😝 😜 🤪 🤨 🧐 🤓 😎 🤩 🥳 😏 😒 😞 😔 😟 😕 🙁 ☹️ 😣 😖 😫 😩 🥺 😢 😭 😤 😠 😡 🤬 🤯 😳 🥵 🥶 😱 😨 😰 😥 😓 🤗 🤔 🤭 🤫 🤥 😶 😐 😑 😬 🙄 😯 😦 😧 😮 😲 🥱 😴 🤤 😪 😵 🤐 🥴 🤢 🤮 🤧 😷 🤒 🤕 🤑 🤠 😈 👿 👹 👺 🤡 💩 👻 💀 ☠️ 👽 👾 🤖 🎃 😺 😸 😹 😻 😼 😽 🙀 😿 😾';
            let emoticons_hand_gestures =
                '👋 🤚 🖐 ✋ 🖖 👌 🤏 ✌️ 🤞 🤟 🤘 🤙 👈 👉 👆 🖕 👇 ☝️ 👍 👎 ✊ 👊 🤛 🤜 👏 🙌 👐 🤲 🤝 🙏 ✍️ 💅 🤳 💪 🦾 🦵 🦿 🦶 👣 👂 🦻 👃 🧠 🦷 🦴 👀 👁 👅 👄 💋 🩸';
            let emoticons_animal_nature =
                '🐶 🐱 🐭 🐹 🐰 🦊 🐻 🐼 🐻‍❄️ 🐨 🐯 🦁 🐮 🐷 🐽 🐸 🐵 🙈 🙉 🙊 🐒 🐔 🐧 🐦 🐤 🐣 🐥 🦆 🦅 🦉 🦇 🐺 🐗 🐴 🦄 🐝 🪱 🐛 🦋 🐌 🐞 🐜 🪰 🪲 🪳 🦟 🦗 🕷 🕸 🦂 🐢 🐍 🦎 🦖 🦕 🐙 🦑 🦐 🦞 🦀 🐡 🐠 🐟 🐬 🐳 🐋 🦈 🐊 🐅 🐆 🦓 🦍 🦧 🦣 🐘 🦛 🦏 🐪 🐫 🦒 🦘 🦬 🐃 🐂 🐄 🐎 🐖 🐏 🐑 🦙 🐐 🦌 🐕 🐩 🦮 🐕‍🦺 🐈 🐈‍⬛ 🪶 🐓 🦃 🦤 🦚 🦜 🦢 🦩 🕊 🐇 🦝 🦨 🦡 🦫 🦦 🦥 🐁 🐀 🐿 🦔 🐾 🐉 🐲 🌵 🎄 🌲 🌳 🌴 🪵 🌱 🌿 ☘️ 🍀 🎍 🪴 🎋 🍃 🍂 🍁 🍄 🐚 🪨 🌾 💐 🌷 🌹 🥀 🌺 🌸 🌼 🌻 🌞 🌝 🌛 🌜 🌚 🌕 🌖 🌗 🌘 🌑 🌒 🌓 🌔 🌙 🌎 🌍 🌏 🪐 💫 ⭐️ 🌟 ✨ ⚡️ ☄️ 💥 🔥 🌪 🌈 ☀️ 🌤 ⛅️ 🌥 ☁️ 🌦 🌧 ⛈ 🌩 🌨 ❄️ ☃️ ⛄️ 🌬 💨 💧 💦 ☔️ ☂️ 🌊 🌫';
            let emoticons_food_drink =
                '🍏 🍎 🍐 🍊 🍋 🍌 🍉 🍇 🍓 🫐 🍈 🍒 🍑 🥭 🍍 🥥 🥝 🍅 🍆 🥑 🥦 🥬 🥒 🌶 🫑 🌽 🥕 🫒 🧄 🧅 🥔 🍠 🥐 🥯 🍞 🥖 🥨 🧀 🥚 🍳 🧈 🥞 🧇 🥓 🥩 🍗 🍖 🦴 🌭 🍔 🍟 🍕 🫓 🥪 🥙 🧆 🌮 🌯 🫔 🥗 🥘 🫕 🥫 🍝 🍜 🍲 🍛 🍣 🍱 🥟 🦪 🍤 🍙 🍚 🍘 🍥 🥠 🥮 🍢 🍡 🍧 🍨 🍦 🥧 🧁 🍰 🎂 🍮 🍭 🍬 🍫 🍿 🍩 🍪 🌰 🥜 🍯 🥛 🍼 🫖 ☕️ 🍵 🧃 🥤 🧋 🍶 🍺 🍻 🥂 🍷 🥃 🍸 🍹 🧉 🍾 🧊 🥄 🍴 🍽 🥣 🥡 🥢 🧂';
            let emoticons_travel_places =
                '⚽️ 🏀 🏈 ⚾️ 🥎 🎾 🏐 🏉 🥏 🎱 🪀 🏓 🏸 🏒 🏑 🥍 🏏 🪃 🥅 ⛳️ 🪁 🏹 🎣 🤿 🥊 🥋 🎽 🛹 🛼 🛷 ⛸ 🥌 🎿 ⛷ 🏂 🪂 🏋️‍♀️ 🏋️ 🏋️‍♂️ 🤼‍♀️ 🤼 🤼‍♂️ 🤸‍♀️ 🤸 🤸‍♂️ ⛹️‍♀️ ⛹️ ⛹️‍♂️ 🤺 🤾‍♀️ 🤾 🤾‍♂️ 🏌️‍♀️ 🏌️ 🏌️‍♂️ 🏇 🧘‍♀️ 🧘 🧘‍♂️ 🏄‍♀️ 🏄 🏄‍♂️ 🏊‍♀️ 🏊 🏊‍♂️ 🤽‍♀️ 🤽 🤽‍♂️ 🚣‍♀️ 🚣 🚣‍♂️ 🧗‍♀️ 🧗 🧗‍♂️ 🚵‍♀️ 🚵 🚵‍♂️ 🚴‍♀️ 🚴 🚴‍♂️ 🏆 🥇 🥈 🥉 🏅 🎖 🏵 🎗 🎫 🎟 🎪 🤹 🤹‍♂️ 🤹‍♀️ 🎭 🩰 🎨 🎬 🎤 🎧 🎼 🎹 🥁 🪘 🎷 🎺 🪗 🎸 🪕 🎻 🎲 ♟ 🎯 🎳 🎮 🎰 🧩';
            let emoticons_objects_fig =
                ' 📮 📯 📜 📃 📄 📑 🧾 📊 📈 📉 🗒 🗓 📆 📅 🗑 📇 🗃 🗳 🗄 📋 📁 📂 🗂 🗞 📰 📓 📔 📒 📕 📗 📘 📙 📚 📖 🔖 🧷 🔗 📎 🖇 📐 📏 🧮 📌 📍 ✂️ 🖊 🖋 ✒️ 🖌 🖍 📝 ✏️ 🔍 🔎 🔏 🔐 🔒 🔓';
            let emoticons_symbols_misc =
                '❤️ 🧡 💛 💚 💙 💜 🖤 🤍 🤎 💔 ❣️ 💕 💞 💓 💗 💖 💘 💝 💟 ☮️ ✝️ ☪️ 🕉 ☸️ ✡️ 🔯 🕎 ☯️ ☦️ 🛐 ⛎ ♈️ ♉️ ♊️ ♋️ ♌️ ♍️ ♎️ ♏️ ♐️ ♑️ ♒️ ♓️ 🆔 ⚛️ 🉑 ☢️ ☣️ 📴 📳 🈶 🈚️ 🈸 🈺 🈷️ ✴️ 🆚 💮 🉐 ㊙️ ㊗️ 🈴 🈵 🈹 🈲 🅰️ 🅱️ 🆎 🆑 🅾️ 🆘 ❌ ⭕️ 🛑 ⛔️ 📛 🚫 💯 💢 ♨️ 🚷 🚯 🚳 🚱 🔞 📵 🚭 ❗️ ❕ ❓ ❔ ‼️ ⁉️ 🔅 🔆 〽️ ⚠️ 🚸 🔱 ⚜️ 🔰 ♻️ ✅ 🈯️ 💹 ❇️ ✳️ ❎ 🌐 💠 Ⓜ️ 🌀 💤 🏧 🚾 ♿️ 🅿️ 🛗 🈳 🈂️ 🛂 🛃 🛄 🛅 🚹 🚺 🚼 ⚧ 🚻 🚮 🎦 📶 🈁 🔣 ℹ️ 🔤 🔡 🔠 🆖 🆗 🆙 🆒 🆕 🆓 0️⃣ 1️⃣ 2️⃣ 3️⃣ 4️⃣ 5️⃣ 6️⃣ 7️⃣ 8️⃣ 9️⃣ 🔟 🔢 #️⃣ *️⃣ ⏏️ ▶️ ⏸ ⏯ ⏹ ⏺ ⏭ ⏮ ⏩ ⏪ ⏫ ⏬ ◀️ 🔼 🔽 ➡️ ⬅️ ⬆️ ⬇️ ↗️ ↘️ ↙️ ↖️ ↕️ ↔️ ↪️ ↩️ ⤴️ ⤵️ 🔀 🔁 🔂 🔄 🔃 🎵 🎶 ➕ ➖ ➗ ✖️ ♾ 💲 💱 ™️ ©️ ®️ 〰️ ➰ ➿ 🔚 🔙 🔛 🔝 🔜 ✔️ ☑️ 🔘 🔴 🟠 🟡 🟢 🔵 🟣 ⚫️ ⚪️ 🟤 🔺 🔻 🔸 🔹 🔶 🔷 🔳 🔲 ▪️ ▫️ ◾️ ◽️ ◼️ ◻️ 🟥 🟧 🟨 🟩 🟦 🟪 ⬛️ ⬜️ 🟫 🔈 🔇 🔉 🔊 🔔 🔕 📣 📢 👁‍🗨 💬 💭 🗯 ♠️ ♣️ ♥️ ♦️ 🃏 🎴 🀄️ 🕐 🕑 🕒 🕓 🕔 🕕 🕖 🕗 🕘 🕙 🕚 🕛 🕜 🕝 🕞 🕟 🕠 🕡 🕢 🕣 🕤 🕥 🕦 🕧';

            let emoticons_face = emoticons_face_emojis.split(' ');
            let emoticons_gestures = emoticons_hand_gestures.split(' ');
            let emoticons_nature = emoticons_animal_nature.split(' ');
            let emoticons_foods = emoticons_food_drink.split(' ');
            let emoticons_places = emoticons_travel_places.split(' ');
            let emoticons_objects = emoticons_objects_fig.split(' ');
            let emoticons_symbols = emoticons_symbols_misc.split(' ');

            let is_anonymus = 1;
            // console.log(emoticons);

            let emoji_template = function(embed_emoji) {
                return `
                <div class="emoticon"><button class="btn bg-transparent p-0 m-0">${embed_emoji.trim()}</button></div>
                `;
            };
            emoticons_face.forEach(emoji_faces => {
                $(".face_emojis").append(emoji_template(emoji_faces));
            });
            emoticons_gestures.forEach(emoji_gestures => {
                $(".gesture_emojis").append(emoji_template(emoji_gestures));
            });
            emoticons_nature.forEach(emoji_nature => {
                $(".nature_emojis").append(emoji_template(emoji_nature));
            });
            emoticons_foods.forEach(emoji_food => {
                $(".food_emojis").append(emoji_template(emoji_food));
            });
            emoticons_places.forEach(emoji_place => {
                $(".place_emojis").append(emoji_template(emoji_place));
            });
            emoticons_objects.forEach(emoji_object => {
                $(".object_emojis").append(emoji_template(emoji_object));
            });
            emoticons_symbols.forEach(emoji_symbol => {
                $(".symbol_emojis").append(emoji_template(emoji_symbol));
            });
            $("body").on('click', '.emoticon', function() {
                // console.log($(this));
                $('#message').val($('#message').val() + $(this).text()),
                    $("#message").focus();

                // $("#message").textContent = $(this).innerHTML;
            });
            $(".reaction_like").click(function() {
                user_id = $(this).closest(".Feed").attr('id');
                reaction_like_id = $(this).attr('id');
                axios({
                    method: 'post',
                    url: '../controllers/Handlers/page.anonymus-likes.Handler.php',
                    data: 'feed_id=' + reaction_like_id + '&reply_id=' + user_id
                }).then(function(submitted_like) {
                    console.log(submitted_like.data);
                })
            });
            $("body").on("click", "#open_emoji_panel", function() {
                $(".emojis-container").fadeToggle();
                $(".chat-box").animate({
                    scrollTop: $(".chat-box")[0].scrollHeight
                }, 1000);
            });
            $(".chat-box").animate({
                scrollTop: $(".chat-box")[0].scrollHeight
            }, 1000);

            $("#open-chat").click(function() {
                $("#open-chat").fadeOut(),
                    $("#chat-box-container").css("display", "block"),
                    $("#chat-box-container").removeClass('animate__fadeOutDown'),
                    $("#chat-box-container").addClass('animate__fadeInUp'),
                    $("#message").focus(),
                    $(".chat-box").animate({
                        scrollTop: $(".chat-box")[0].scrollHeight
                    }, 200);
            });

            $("#close-chat-box").click(function() {
                $("#open-chat").fadeIn(),
                    $("#chat-box-container").removeClass('animate__fadeInUp'),
                    $("#chat-box-container").addClass('animate__fadeOutDown');
            });
            $("#expanded-box").click(function() {
                console.log("kloopppp");
                $(".chatbox-container").toggleClass('chatbox-maximized');
                if ($(this).hasClass('maximized')) {
                    $(this).html('<i class="bi bi-fullscreen sz-18"></i>'),
                        $(this).removeClass('maximized'),
                        $("#message").focus();
                } else {
                    $(this).addClass('maximized'),
                        $(this).html('<i class="bi bi-fullscreen-exit sz-18"></i>'),
                        $("#message").focus();
                }
            }), $(".chatbox-wrapper").scroll(function() {
                if ($('.chatbox-wrapper').scrollTop() < ($('.chatbox-wrapper')[0].scrollHeight) - ($(
                        '.chatbox-wrapper').outerHeight(true) + 50)) {
                    $('#scroll_chat_to_last')[0].style["display"] = 'inline-block';
                } else {
                    $('#scroll_chat_to_last')[0].style["display"] = 'none';
                }
            }), $("#scroll_chat_to_last").click(function() {
                $(".chatbox-wrapper").animate({
                    scrollTop: $(".chatbox-wrapper")[0].scrollHeight
                }, 1e3);
                $(".chat-log").animate({
                    scrollTop: $(".chat-log")[0].scrollHeight
                }, 1e3);
            });

            $("body").on('change', "#is_anonymus", function() {
                if (this.checked) {
                    is_anonymus = 0;

                } else {
                    is_anonymus = 1;
                }
            });
            $("body").on("click", "#send-msg", function() {

                //If message is empty do not allow user to sent message
                let message = $("#message").val().trim();

                if (message.length > 0) {

                    MessageStatus.status(`<i class="bi bi-arrow-bar-up sz-18 mr-2"></i> Sending...`);

                    //Set delay timer if message is send
                    $(".msg-tools").html(msg_delay_template);

                    //Reinit IFJS
                    init_ifjs();

                    //Send the POST request
                    axios({
                        method: 'post',
                        url: '../controllers/Handlers/page.anonymus-chats.Handler.php',
                        data: 'message=' + message + '&page_name=' + '<?php echo $PAGEID; ?>' +
                            '&is_anonymus=' + is_anonymus

                        // if the request is sent then update the messages
                    }).then(function(afterSend) {

                        if (afterSend.data.length === 0) {
                            MessageStatus.status(`<i class="bi bi-check2-all sz-18 mr-2"></i> Message sent.`, 5000);
                        }

                        //Scroll to bottom
                        $(".chatbox-wrapper").animate({
                                scrollTop: $(".chatbox-wrapper")[0].scrollHeight
                            }, 1000),
                            $("#message").val('');

                    }).catch(function(error) {
                        if (error) {
                            // console.log(error.response.data);
                            // console.log(error.response.status);
                            // console.log(error.response.headers);
                            MessageStatus.status(`<i class="bi bi-x-circle sz-18 mr-2"></i> Failed to send.`, 5000);
                        }
                    });
                    is_anonymus = 1;

                    //Again start the delay timer
                    let delay_time = document.getElementById("countdown").textContent;

                    let countdown = setInterval(function() {
                        delay_time--;
                        document.getElementById("countdown").textContent = new Date(delay_time * 1000)
                            .toISOString().substr(11, 8);
                        if (delay_time <= 0) {

                            //Clear the timeout
                            clearInterval(countdown);

                            $(".msg-tools").html(msg_tool_template),

                                //Reinit IFJS
                                init_ifjs();

                            //Focus on message box
                            $("#message").focus();

                        };
                    }, 1000);

                }
            });

            function message_template(message) {
                return `
                <div class="msg-2 mb-2">
                    <div class="d-flex flex-column align-items-end">
                        <div class="msg">
                        ${message}
                        </div>
                        <div class="text-muted small chat-details mr-2">
                            <i class="bi bi-check2-all text-primary"></i>
                            You - <?php echo time(); ?>
                        </div>
                    </div>
                </div>
                `;
            }
        });
    </script>
</body>

</html>