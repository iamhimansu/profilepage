<?php
session_name("PP");
session_start();

//Store page id in Session
// $ANALYTICID From Route

$_SESSION["analytic_id"]  = $ANALYTICID = $VIEW_ANALYTIC_ID;

//Require controllers
require_once 'controllers/database.php';
require_once 'controllers/modules/Encryption.php';
require_once 'controllers/modules/core.php';
require_once 'controllers/functions.php';
require_once 'controllers/modules/Analytics.php';

$fetch = new CodeFlirt\Fetch;
$handle = new CodeFlirt\Handlers;
$User = new User();
$Page = new Page();

$User->isAuthenticated();

$Page->Find($VIEW_ANALYTIC_ID);

$PAGE_DETAILS = $Page->Details();

//
$ANALYISIS_PAGE_NAME = $PAGE_DETAILS["PageName"];
$OWNERID = $PAGE_DETAILS["OwnerRefId"];

$analytics = new Analytics($ANALYTICID);
//
$analyze_links = $analytics->Analyze("LINKS");
//
$analyze_page = $analytics->Analyze("PAGE");
//
$analyze_response_count = $analytics->ResponseCount();
$analyze_feedback_count = $analytics->FeedbackCount();

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
</head>

<body>
    <?php
    include "template/template.side-navbar.php";
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
                                Analytics
                            </h6>

                            <!-- Title -->
                            <h1 class="header-title text-truncate">
                                <?php echo $ANALYISIS_PAGE_NAME; ?>
                            </h1>

                        </div>
                    </div> <!-- / .row -->
                </div> <!-- / .header-body -->

            </div>
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-3 col-xl">

                    <!-- Value  -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">

                                    <!-- Title -->
                                    <h6 class="text-uppercase text-muted mb-2">
                                        Total Page views
                                    </h6>

                                    <!-- Heading -->
                                    <span class="h2 mb-0">
                                        <?php echo $analytics->TotalPageViews(); ?>
                                    </span>
                                </div>
                                <div class="col-auto">

                                    <!-- Icon -->
                                    <span class="h1 bi bi-eye text-muted mb-0"></span>

                                </div>
                            </div> <!-- / .row -->
                        </div>
                    </div>

                </div>
                <div class="col-sm-6 col-md-6 col-lg-3 col-xl">

                    <!-- Hours -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">

                                    <!-- Title -->
                                    <h6 class="text-uppercase text-muted mb-2">
                                        Total links
                                    </h6>

                                    <!-- Heading -->
                                    <span class="h2 mb-0">
                                        <?php echo $analytics->TotalLinks(); ?>
                                    </span>
                                </div>
                                <div class="col-auto">

                                    <!-- Icon -->
                                    <span class="h1 bi bi-link text-muted mb-0"></span>

                                </div>
                            </div> <!-- / .row -->
                        </div>
                    </div>

                </div>
                <div class="col-sm-6 col-md-6 col-lg-3 col-xl">

                    <!-- Exit -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">

                                    <!-- Title -->
                                    <h6 class="text-uppercase text-muted mb-2">
                                        Form Responses
                                    </h6>

                                    <!-- Heading -->
                                    <span class="h2 mb-0">
                                        <?php echo $analyze_response_count; ?>

                                    </span>
                                </div>
                                <div class="col-auto">
                                    <?php
                                    if ($analyze_response_count > 0) {
                                    ?>
                                        <a class="mr-2" href="<?php echo $handle->path("export.php?page=$ANALYTICID&type=responses&ext=txt") ?>" title="Download as text file">
                                            <span class="h1 bi bi-fonts text-muted mb-0"></span>
                                        </a>
                                        <a href="<?php echo $handle->path("export.php?page=$ANALYTICID&type=responses") ?>" title="Downlaod as csv file">
                                            <span class="h1 bi bi-file-earmark-arrow-down text-muted mb-0"></span>
                                        </a>
                                    <?php } else { ?>
                                        <span class="h1 bi bi-ui-checks text-muted mb-0"></span>
                                    <?php } ?>
                                </div>
                            </div> <!-- / .row -->
                        </div>
                    </div>

                </div>
                <div class="col-sm-6 col-md-6 col-lg-3 col-xl">
                    <!-- Time -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">

                                    <!-- Title -->
                                    <h6 class="text-uppercase text-muted mb-2">
                                        Feedbacks
                                    </h6>

                                    <!-- Heading -->
                                    <span class="h2 mb-0">
                                        <?php echo $analyze_feedback_count; ?>
                                    </span>

                                </div>
                                <div class="col-auto">

                                    <?php
                                    if ($analyze_feedback_count > 0) {
                                    ?>
                                        <a class="mr-2" href="<?php echo $handle->path("export.php?page=$ANALYTICID&type=feedbacks&ext=txt") ?>" title="Download as text file">
                                            <span class="h1 bi bi-fonts text-muted mb-0"></span>
                                        </a>
                                        <a href="<?php echo $handle->path("export.php?page=$ANALYTICID&type=feedbacks") ?>">
                                            <span class="h1 bi bi-file-earmark-arrow-down text-muted mb-0"></span>
                                        </a>
                                    <?php } else { ?>
                                        <span class="h1 bi bi-star-fill text-muted mb-0"></span>
                                    <?php } ?>
                                </div>
                            </div> <!-- / .row -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">

                    <!-- Title -->
                    <h4 class="card-header-title">
                        Page analysis
                    </h4>



                    <!-- Button -->
                    <a href="#!" class="btn btn-sm btn-white" id="download_page_analytics">
                        <i class="bi bi-arrow-bar-down"></i> Download
                    </a>

                </div>


                <div class="card-body">

                    <!-- Chart -->
                    <div class="chart">
                        <canvas id="PageAnalytics" style=" height: 100% !important; width: 100%;"></canvas>
                    </div>

                </div>
            </div>

            <!-- Card -->
            <div class="card">
                <div class="card-header">

                    <!-- Title -->
                    <h4 class="card-header-title">
                        Link analysis
                    </h4>



                    <!-- Button -->
                    <a href="#!" class="btn btn-sm btn-white" id="download_analytics">
                        <i class="bi bi-arrow-bar-down"></i> Download
                    </a>

                </div>

                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">

                            <ul class="nav nav-tabs card-header-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="javascript:void(0)" id="todays_data">
                                        Today
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="javascript:void(0)" id="yesterdays_data">
                                        Yesterday
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-auto">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="last_year_analytics">
                                <label class="custom-control-label" for="last_year_analytics">Last year comparison</label>
                            </div>
                        </div>
                    </div> <!-- / .row -->
                </div>
                <div class="card-body">

                    <!-- Chart -->
                    <div class="chart">
                        <canvas id="linkAnalytics" style=" height: 100% !important; width: 100%;"></canvas>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo $handle->path('js/jquery.min.js') ?>"></script>

    <script src="<?php echo $handle->path('js/bootstrap.bundle.min.js') ?>"></script>

    <script src="<?php echo $handle->path('js/listjs/list.min.js') ?>"></script>

    <script src="<?php echo $handle->path('js/libs/chart/Chart.min.js') ?>"></script>
    <?php

    // create labels fir page views
    $page_analysise_data = $analytics->analyze_page();

    if (isset($page_analysise_data) && $page_analysise_data > 0) {

        foreach ($page_analysise_data as $key => $value) {
            $page_date_labels[] = "'" . date("dS, M Y", $key) . "'";
            $page_visit_counts[] = "'" . $value . "'";
        }
        $page_date_labels = implode(",", $page_date_labels);
        //page visits
        $page_visit_counts  = implode(",", $page_visit_counts);
    } else {
        $page_date_labels = null;
        //page visits
        $page_visit_counts  = 0;
    }
    if (isset($analytics->Analyze("PAGE")[strtotime("today")])) {
        $todays_page_visit_data = $analytics->Analyze("PAGE")[strtotime("today")];
    } else {
        $todays_page_visit_data = 0;
    }
    if (isset($analytics->Analyze("PAGE")[strtotime("today -1 day")])) {
        $yesterdays_page_visit_data = $analytics->Analyze("PAGE")[strtotime("today -1 day")];
        //
    } else {
        $yesterdays_page_visit_data = 0;
    }
    if (isset($analytics->Analyze("PAGE")[strtotime("today -1 year +1 day")])) {
        $lastyears_page_visit_data = $analytics->Analyze("PAGE")[strtotime("today -1 year +1 day")];
        //
    } else {
        $lastyears_page_visit_data = 0;
    }
    //
    //

    //Create labels for link
    $link_labels = $analytics->Analytics_labels();

    if (isset($link_labels) && count($link_labels) > 0) {

        $total_clicks_onday = 0;
        if (isset($analytics->Analyze("LINKS")[strtotime("today")])) {
            $todays_analytics = $analytics->Analyze("LINKS")[strtotime("today")];
            //
            foreach ($todays_analytics as $key => $value) {
                $todays_data[] = $value["visits"];
                $total_clicks_onday += $value["visits"];
            }
        } else {
            foreach ($link_labels as $value) {
                $todays_data[] = 0;
            }
        }
        //check for yesterdays data
        if (isset($analytics->Analyze("LINKS")[strtotime("today -1 day")])) {
            $yesterday_analytics = $analytics->Analyze("LINKS")[strtotime("today -1 day")];
            //
            foreach ($yesterday_analytics as $key => $value) {
                $yesterdays_data[] = $value["visits"];
            }
        } else {
            foreach ($link_labels as $key) {
                $yesterdays_data[] = 0;
            }
        }
        //check for last years data

        if (isset($analytics->Analyze("LINKS")[strtotime("today -1 year +1 day")])) {
            $lastyear_analytics = $analytics->Analyze("LINKS")[strtotime("today -1 year +1 day")];
            //
            foreach ($lastyear_analytics as $key => $value) {
                $lastyear_data[] = $value["visits"];
            }
        } else {
            foreach ($link_labels as $key) {
                $lastyear_data[] = 0;
            }
        }

        //
        $link_chart_labels = implode(",", $link_labels);
        $link_todays_analytics_data = implode(",", $todays_data);
        $link_yesterdays_analytics_data = implode(",", $yesterdays_data);
        $link_last_year_analytics_data = implode(",", $lastyear_data);
        //

    } else {
        $link_chart_labels = 0;
        $link_todays_analytics_data = 0;
        $total_clicks_onday = 0;
        $link_yesterdays_analytics_data = 0;
        $link_last_year_analytics_data = 0;
    }
    $last_year_analytics_date = date("dS, M Y", strtotime("today - 1 year"));
    //
    $todays_analytics_date = date("dS, M Y", strtotime("today"));
    $chart_data = <<<CHART_DATA
<script>
var page_todays_visits = [{$todays_page_visit_data}];
var page_yesterday_visits = [{$yesterdays_page_visit_data}];
var lastyears_page_visit_data = [{$lastyears_page_visit_data}];
var page_visit_labels = [{$page_date_labels}];
var page_visit_counts = [{$page_visit_counts}];
var link_chart_labels = [{$link_chart_labels}];
var link_todays_analytics = [{$link_todays_analytics_data}];
var todays_total_clicks_analytics = [{$total_clicks_onday}];
var todays_analytics_date = '{$todays_analytics_date}';
var link_yesterdays_analytics = [{$link_yesterdays_analytics_data}];
var lastyear_analytics = [{$link_last_year_analytics_data}];
</script>
CHART_DATA;
    echo $chart_data;
    ?>
    <script>
        function abbreviateNumber(value) {
            var newValue = value;
            if (value >= 1000) {
                var suffixes = ["", "k", "m", "b", "t"];
                var suffixNum = Math.floor(("" + value).length / 3);
                var shortValue = '';
                for (var precision = 2; precision >= 1; precision--) {
                    shortValue = parseFloat((suffixNum != 0 ? (value / Math.pow(1000, suffixNum)) : value).toPrecision(precision));
                    var dotLessShortValue = (shortValue + '').replace(/[^a-zA-Z 0-9]+/g, '');
                    if (dotLessShortValue.length <= 2) {
                        break;
                    }
                }
                if (shortValue % 1 != 0) shortValue = shortValue.toFixed(1);
                newValue = shortValue + suffixes[suffixNum];
            }
            return newValue;
        };
        //page analytics
        var ctx = document.getElementById('PageAnalytics').getContext('2d');
        var pageAnalytics = new Chart(ctx, {
            // The type of chart we want to create
            type: 'bar',

            // The data for our dataset
            data: {
                labels: page_visit_labels,
                datasets: [{
                    label: 'Total visits (' + page_visit_counts + ')',
                    backgroundColor: 'rgba(7, 191, 69, 0.7)',
                    borderColor: 'rgba(7, 191, 69, 0.7)',
                    data: page_visit_counts
                }, {
                    label: 'Total Clicks (' + todays_total_clicks_analytics + ')',
                    backgroundColor: 'rgba(44, 123, 229, 0.7)',
                    borderColor: 'rgba(44, 123, 229, 0.7)',
                    data: todays_total_clicks_analytics
                }, ]
            },

            // Configuration options go here
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontStyle: 'bold',
                            fontSize: 14,
                            precision: 0,
                            callback: function(value, index, values) {
                                return abbreviateNumber(value);
                            }
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Total visits / Total clicks',
                            fontStyle: 'bold'
                        }
                    }],
                },
                "animation": {
                    "onComplete": function() {
                        var chartInstance = this.chart,
                            ctx = chartInstance.ctx;
                        // ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                        ctx.fillStyle = Chart.defaults.global.defaultFontColor;
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';

                        this.data.datasets.forEach(function(dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            meta.data.forEach(function(bar, index) {
                                var data = dataset.data[index];
                                data = abbreviateNumber(data);
                                ctx.fillText(data, bar._model.x, bar._model.y);
                            });
                        });
                    }

                }

            }
        });

        var analytics_data = {
            labels: link_chart_labels,
            datasets: [{
                    label: 'Shift',
                    data: link_todays_analytics,
                    backgroundColor: 'rgba(7, 191, 69, 0.2)',
                    borderColor: 'rgba(7, 191, 69, 0.2)',
                    borderWidth: 5,
                    pointRadius: 8,
                    type: 'line',
                },
                {
                    label: 'Today',
                    data: link_todays_analytics,
                    backgroundColor: "rgba(7, 191, 69, 0.7)",
                    borderColor: 'rgba(7, 191, 69, 0.6)',
                    borderWidth: 2
                },

            ]
        };


        ////link analytics
        var ctx = document.getElementById('linkAnalytics').getContext('2d');
        var linkAnalytics = new Chart(ctx, {
            type: 'bar',
            data: analytics_data,
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontStyle: 'bold',
                            fontSize: 14,
                            precision: 0,
                            callback: function(value, index, values) {
                                return abbreviateNumber(value);
                            }
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Total clicks on ' + todays_analytics_date,
                            fontStyle: 'bold'
                        }
                    }],
                },
                "animation": {
                    "onComplete": function() {
                        var chartInstance = this.chart,
                            ctx = chartInstance.ctx;
                        // ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                        ctx.fillStyle = Chart.defaults.global.defaultFontColor;
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';

                        this.data.datasets.forEach(function(dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            meta.data.forEach(function(bar, index) {
                                var data = dataset.data[index];
                                data = abbreviateNumber(data);
                                ctx.fillText(data, bar._model.x, bar._model.y);
                            });
                        });
                    }

                }
            }
        });

        function addData(chart, data) {
            // chart.data.labels.push(label);
            chart.data.datasets.push(data);
            chart.update();
        };

        function removeData(chart) {
            chart.data.datasets.pop();
            chart.update();
        };

        $("#todays_data").on("click", function() {
            if (linkAnalytics.data.datasets.length >= 3) {
                removeData(linkAnalytics);
            } else {
                return;
            }
        });
        $("#yesterdays_data").on("click", function() {
            var yesterdayDataset = {
                label: 'Yesterday\'s visit',
                data: link_yesterdays_analytics,
                borderWidth: 2,
                backgroundColor: 'rgba(44, 123, 229, 0.2)',
                borderColor: 'rgba(44, 123, 229, 0.2)',
            };
            if (linkAnalytics.data.datasets.length >= 3) {
                removeData(linkAnalytics);
            } else {
                addData(linkAnalytics, yesterdayDataset);
                return;
            }
        });
        $("#last_year_analytics").on("click", function() {
            if (this.checked) {
                var lastYearDataset = {
                    label: 'Last year visits (<?php echo $last_year_analytics_date ?>)',
                    data: lastyear_analytics,
                    borderWidth: 2,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 0.2)',
                };
                addData(linkAnalytics, lastYearDataset);
            } else {
                if (linkAnalytics.data.datasets.length > 2) {
                    removeData(linkAnalytics);
                    return;
                } else {
                    return;
                }
            }
        });
        $(".nav-link").on("click", function() {
            $(".nav-link").removeClass("active");
            $(this).toggleClass("active");
        });
        $("#download_analytics").on("click", function() {
            $(this).html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span> Preparing...'),
                $(this).attr("href", linkAnalytics.toBase64Image()),
                $(this).attr("download", "<?php echo "$ANALYISIS_PAGE_NAME-analytics"; ?>"),
                setTimeout(() => {
                    $(this).removeAttr("href");
                    $(this).html('<i class="bi bi-arrow-bar-down"></i> Download');
                }, 100);
        });
        $("#download_page_analytics").on("click", function() {
            $(this).html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span> Preparing...'),
                $(this).attr("href", pageAnalytics.toBase64Image()),
                $(this).attr("download", "<?php echo "$ANALYISIS_PAGE_NAME-page-analytics"; ?>"),
                setTimeout(() => {
                    $(this).removeAttr("href");
                    $(this).html('<i class="bi bi-arrow-bar-down"></i> Download');
                }, 100);
        });
    </script>
</body>

</html>