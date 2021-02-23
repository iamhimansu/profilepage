<?php
session_name("PP");
session_start();
//Require controllers
require_once 'controllers/database.php';
require_once 'controllers/modules/Encryption.php';
require_once 'controllers/modules/core.php';
require_once 'controllers/functions.php';

$fetch = new CodeFlirt\Fetch;
$handle = new CodeFlirt\Handlers;
$User = new User();

$User->isAuthenticated();

$GET_TOTAL_PAGES = $fetch->data("links", "page_id,page_name,created_on", "user_id='" . $User->AuthID() . "'", 'row');
$TOTAL_PAGES = $GET_TOTAL_PAGES;
unset($GET_TOTAL_PAGES);

$CurrentPage = "analytics";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics</title>
    <link rel="stylesheet" id="theme" href="<?php echo $handle->path('css/theme.min.css') ?>" class="" />
    <link rel="stylesheet" href="<?php echo $handle->path('css/app.min.css') ?>" />
    <link rel="stylesheet" href="<?php echo $handle->path('assets/fonts/bootstrap-icons/bootstrap-icons.css') ?>" />
    <link rel="stylesheet" href="<?php echo $handle->path('assets/plugins/selectjs/css/select2.min.css') ?>" />
    <link rel="stylesheet" href="<?php echo $handle->path('js/libs/Croppie/croppie.css') ?>" />
    <link rel="stylesheet" href="<?php echo $handle->path('js/snackbar/snackbar.css') ?>" />
    <link rel="stylesheet" href="<?php echo $handle->path('js/libs/chart/Chart.min.css') ?>" />

</head>

<body>
    <?php
    include "template/template.side-navbar.php";
    include 'template/template.bottom-navbar.php';

    ?>
    <div class="main-content">
        <div class="container-fluid">
            <?php if (!$TOTAL_PAGES) { ?>
                <div class="vh-100 py-5">
                    <div class="card h-100 border-2">
                        <div class="card-body text-center">
                            <div class="d-flex text-muted justify-content-center align-items-center h-100 flex-column">
                                <div class="mb-3">
                                    <i class="bi bi-bar-chart sz-64"></i>
                                </div>
                                <div>
                                    <h1 class="font-weight-normal">
                                        Create a page to view analytics. ;-)
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
                                    Overview
                                </h6>

                                <!-- Title -->
                                <h1 class="header-title">
                                    Dashboard
                                </h1>

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
                        <div class="col-auto d-none d-md-block">

                            <!-- Navigation (button group) -->
                            <div class="nav btn-group">
                                <button class="btn btn-md btn-white active py-0" id="grid-view">
                                    <i class="bi bi-grid"></i>
                                </button>
                                <button class="btn btn-md btn-white" id="list-view">
                                    <i class="bi bi-list"></i>
                                </button>
                            </div> <!-- / .nav -->

                        </div>
                    </div>
                    <div class="row page-list">
                        <?php
                        $User_Photo = $handle->path($User->photos($User->AuthID()));
                        $User_Name = $User->Details($User->AuthID())["user_name"];
                        foreach ($TOTAL_PAGES as $row) {
                            $PAGE_URL = "@$User_Name/" . explode('@', $row["page_name"])[0] . "";
                        ?>
                            <div class="col-12 col-md-4 col-xl-3 page-view">

                                <!-- Card -->
                                <div class="card">

                                    <!-- Body -->
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col">

                                                <!-- Title -->
                                                <h4 class="mb-2 pagename">
                                                    <a href="<?php echo $PAGE_URL; ?>">
                                                        <?php echo explode('@', $row["page_name"])[0]; ?>
                                                    </a>
                                                </h4>

                                                <!-- Subtitle -->
                                                <p class="card-text small text-muted">
                                                    <?php $created_on  = new DateTime('@' . $row["created_on"]);
                                                    $CurrentDateTimezone = $created_on->setTimezone(new DateTimeZone($User->Details($User->AuthID())["user_timezone"]));
                                                    $format_current_time = $CurrentDateTimezone->format('dS M, Y \a\t h:i:s a');
                                                    echo $format_current_time;
                                                    ?>
                                                </p>
                                            </div>
                                            <div class="col-auto">

                                                <!-- Dropdown -->
                                                <div class="dropdown">
                                                    <a href="javascript:void(0)" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="pages/customize/<?php echo $row["page_id"]; ?>" class="dropdown-item">
                                                            <i class="bi bi-brush"></i> Customize
                                                        </a>
                                                        <a href="pages/delete/<?php echo $row["page_id"]; ?>" class="dropdown-item">
                                                            <i class="bi bi-trash"></i> Delete
                                                        </a>
                                                        <a href="javascript:void(0)" class="dropdown-item">
                                                            <i class="bi bi-gear"></i> Settings
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div> <!-- / .row -->
                                    </div>

                                    <!-- Footer -->
                                    <div class="card-footer py-3 bg-hover-primary-soft">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <div class="row align-items-center no-gutters">
                                                    <div class="col">
                                                        <!-- Value -->
                                                        <a href="analytics/<?php echo explode('-', $row["page_id"])[0]; ?>" class="stretched-link"></a>
                                                        <div class="small mr-2">View analytics</div>
                                                    </div>

                                                </div> <!-- / .row -->
                                            </div>
                                            <div class="col-auto">
                                                <i class="bi bi-chevron-right"></i>
                                            </div>
                                        </div> <!-- / .row -->
                                    </div>
                                </div>

                            </div>
                        <?php } ?>
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
        $("#list-view").on("click", function() {
            $(this).addClass("active");
            $("#grid-view").removeClass("active");
            $(".page-view").removeClass("col-md-4 col-xl-3");
        });
        $("#grid-view").on("click", function() {
            $(this).addClass("active");
            $("#list-view").removeClass("active");
            $(".page-view").addClass("col-md-4 col-xl-3");
        });
    </script>
</body>

</html>