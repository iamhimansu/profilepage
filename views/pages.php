<?php
session_name("PP");
session_start();
//Require controllers
require_once 'controllers/database.php';
require_once 'controllers/modules/Encryption.php';
require_once 'controllers/modules/core.php';
require_once 'controllers/functions.php';

$handle = new CodeFlirt\Handlers;
$fetch = new CodeFlirt\Fetch;
$User = new User();

$User->isAuthenticated();
/**
 * Get total pages of user
 */
$GET_TOTAL_PAGES = $fetch->data("links", "page_id,page_name,created_on,link_configs", "user_id='" . $User->AuthID() . "'", 'row');
$TOTAL_PAGES = $GET_TOTAL_PAGES;
unset($GET_TOTAL_PAGES);
$CurrentPage = "pages";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pages | ProfilePage</title>
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
        <div class="container-fluid vh-100">
            <?php if (!$TOTAL_PAGES) { ?>
                <div class="vh-100 py-5">
                    <div class="card h-100 border-2">
                        <div class="card-body text-center">
                            <div class="d-flex text-muted justify-content-center align-items-center h-100 flex-column">
                                <div class="mb-3">
                                    <i class="bi bi-file-ppt sz-64"></i>
                                </div>
                                <div>
                                    <h1 class="font-weight-normal">
                                        You have not created any pages
                                    </h1>
                                </div>
                                <div>
                                    <small> <a href="home" class="btn-link">Create a page now</a>, it's simple. </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="header">

                    <!-- Body -->
                    <div class="header-body">
                        <div class="row align-items-end">
                            <div class="col">

                                <!-- Pretitle -->
                                <h6 class="header-pretitle">
                                    Appearance
                                </h6>

                                <!-- Title -->
                                <h1 class="header-title text-truncate">
                                    Pages (<?php echo ($TOTAL_PAGES) ? count($TOTAL_PAGES) : 0; ?>) </h1>

                            </div>
                        </div> <!-- / .row -->
                    </div> <!-- / .header-body -->

                </div>
                <div id="pagelist">
                    <div class="row mb-4">
                        <div class="col">

                            <!-- Form -->
                            <form>
                                <div class="input-group input-group-md input-group-merge">

                                    <!-- Input -->
                                    <input type="text" class="form-control form-control-prepended search" placeholder="Search">

                                    <!-- Prepend -->
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="bi bi-search"></span>
                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="row page-list">
                        <div class="col">
                            <div class="card border-0">
                                <div class="list-group">
                                    <?php
                                    $User_Photo = $handle->path($User->photos($User->Details($User->AuthID())));
                                    $User_Name = $User->Details($User->AuthID())["user_name"];
                                    foreach ($TOTAL_PAGES as $row) {
                                        $PAGE_URL = "@$User_Name/" . explode('@', $row["page_name"])[0] . "";
                                    ?>
                                        <div class="list-group-item pagename">
                                            <div class="row align-items-center">
                                                <div class="col-auto">

                                                    <!-- Avatar -->
                                                    <a href="<?php echo $PAGE_URL; ?>" class="avatar">
                                                        <img src="<?php
                                                                    $custom_photo = json_decode($row["link_configs"], true);
                                                                    if (isset($custom_photo) && count($custom_photo) > 0) {
                                                                        if (isset($custom_photo["page_configs"]["page-image"])) {
                                                                            echo $handle->path($custom_photo["page_configs"]["page-image"]);
                                                                        } else {
                                                                            echo $User_Photo;
                                                                        }
                                                                    }
                                                                    ?>" alt="<?php echo $row["page_name"]; ?>" class="avatar-img rounded-circle img-thumbnail">
                                                    </a>

                                                </div>
                                                <div class="col ml-n2 text-truncate">

                                                    <!-- Title -->
                                                    <h4 class="mb-1">
                                                        <a href="<?php echo $PAGE_URL; ?>">
                                                            <?php echo explode('@', $row["page_name"])[0]; ?>
                                                        </a>
                                                    </h4>

                                                    <!-- Time -->
                                                    <p class="card-text small text-muted">
                                                        <time datetime="2018-05-24">
                                                            <?php $created_on  = new DateTime('@' . $row["created_on"]);
                                                            $CurrentDateTimezone = $created_on->setTimezone(new DateTimeZone($User->Details($User->AuthID())["user_timezone"]));
                                                            $format_current_time = $CurrentDateTimezone->format('dS M, Y \a\t h:i:s a');
                                                            echo "<i class='bi bi-clock mr-2'></i>" . $format_current_time; ?>
                                                        </time>
                                                    </p>

                                                </div>
                                                <div class="col-auto align-items-center px-sm-4">
                                                    <a href="<?php echo $handle->path('pages/customize/' . $row["page_id"] . ''); ?>" class="btn btn-sm btn-white rounded-pill mx-1" data-ajax=""> <i class="bi bi-brush"></i> Customize</a>
                                                    <a href="<?php echo $handle->path('pages/settings/' . $row["page_id"] . ''); ?>" class="btn btn-sm btn-white rounded-pill mx-1" data-ajax=""> <i class="bi bi-gear"></i> Settings</a>
                                                    <a href="<?php echo $handle->path('inbox/' . $row["page_id"] . ''); ?>" class="btn btn-sm btn-white rounded-pill mx-1" data-ajax=""> <i class="bi bi-inboxes"></i> Inbox</a>
                                                    <a href="<?php echo $handle->path('pages/delete/' . $row["page_id"] . ''); ?>" class="btn btn-sm btn-white rounded-pill mx-1"> <i class="bi bi-trash"></i> Delete</a>
                                                </div>
                                            </div> <!-- / .row -->
                                        </div>
                                    <?php }

                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <script src="<?php echo $handle->path('js/jquery.min.js') ?>"></script>

    <script src="<?php echo $handle->path('js/bootstrap.bundle.min.js') ?>"></script>

    <script src="<?php echo $handle->path('js/listjs/list.min.js') ?>"></script>


    <script>
        var options = {
            valueNames: ['pagename'],
            listClass: "page-list"
        };
        var pageList = new List('pagelist', options);
    </script>
</body>

</html>