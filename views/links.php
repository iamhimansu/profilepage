<?php
$start = microtime(true);
// Load modules
require_once 'controllers/database.php';
require_once 'controllers/modules/core.php';
require_once 'controllers/modules/Encryption.php';
require_once 'controllers/functions.php';


//Pre assumed flags
//page exists in database = false 
$page_existance = false;

$page = '';

// use codeflirt
$fetch = new CodeFlirt\Fetch;
$handle = new CodeFlirt\Handlers;
$Encryption = new Encryption();
$Auth = new User();

// if (isset($_SESSION["anms.f.u.i"]) && !empty($_SESSION["anms.f.u.i"])) {
//     $from_user_id = $_SESSION["anms.f.u.i"] = $_SESSION["f.u.i"];
// } else {
//Create a new token
$from_user_id  = $_SESSION["anms.f.u.i"] = $_SESSION["f.u.i"] = 'ANMS-' . $handle->generate_token('alphanumeric', 20);
// }
//Modify condition if (pagename or subpage) name is available
$UserName = "$PageName-$UserName";

if (isset($PageName)) {
    $page = $fetch->data('links', 'page_name, page_id, user_id, link_configs', "page_name = '$UserName' OR page_name = '$PageName' OR page_id = '$UserName'");
} else {
    $page = $fetch->data('links', 'page_name, page_id, user_id, link_configs', "page_name = '$UserName' OR page_id = '$UserName' ");
}

//Get page name from database
$UserName = $page['page_name'];

$_SESSION["page_visit"] = $page["page_id"];
$owner_id = $_SESSION["owner_id"] = $page["user_id"];


if (!empty(trim($UserName))) {
    $page_existance = true;
} else {
    $page_existance = false;
    echo "Page does not exist";
    return;
}
// If page exists

if ($page_existance !== false) {

    //Get user timezone
    $user_timezone = $_COOKIE['tz'];

    //Get page id
    $PageDetails = $fetch->data('links', 'page_id, user_id', "page_name = '$UserName' OR page_name = '$PageName' OR page_id = '$UserName'");

    $page_id = $PageDetails["page_id"];
    // Get user private key
    $user_p_k = $PageDetails["user_id"];

    //Grab user details
    $user_details = $fetch->data('details', 'user_details', "user_id='$user_p_k'");

    //If verification is successfull GRANT permissions to user 
    $decrypted = $Encryption->decrypt($user_details, $user_p_k);

    //Decode encrypted data of user
    $decode = json_decode($decrypted, true);

    //Get user profile link
    $profile_path = $handle->path('@' . $decode['client']['details']['user_name']);

    //Get links configuration --> json
    $get_links = $page['link_configs'];

    //Convert json data to array
    $linkObject = json_decode($get_links, true);

    //
    $tmp = [];
    function compare_date($date1, $date2, $return)
    {
        switch ($return) {
            case 'd':
                return (int)$date1->diff($date2)->format('%r%a');
                break;
            case 'h':
                return (int)$date1->diff($date2)->format('%r%h');
                break;
            case 'm':
                return (int)$date1->diff($date2)->format('%r%m');
                break;
            case 'i':
                return (int)$date1->diff($date2)->format('%r%i');
                break;

            default:
                return (int)($date1->getTimestamp() - $date1->getOffset()) - ($date2->getTimestamp() - $date2->getOffset());
                break;
        }
    }
    // Removing faulty links

    foreach ($faulty_links = $linkObject as $key => $value) {
        if (array_key_exists($key, $linkObject)) {

            if (isset($value['disabled'])) {
                unset($linkObject[$key]);
            }

            //Removing empty links
            if (strpos($key, 'link_') !== false) {
                if (
                    trim($value['link_title']) == ''
                    || trim($value['link_address']) == ''
                ) {
                    unset($linkObject[$key]);
                }
            }

            //Removing invalid schedules
            if (isset($value['scheduled'])) {
                if (
                    trim($value['scheduled']['date']) == ''
                    || trim($value['scheduled']['timezone']) == ''
                ) {
                    unset($linkObject[$key]);
                }
            }

            // Check for forward links
            if (isset($value['forward'])) {

                $forward_timezone = schedule_time(
                    $value['forward']['date'],
                    $value['forward']['timezone'],
                    $user_timezone
                );

                if ( //Redirect usre if date is today
                    $forward_timezone['start_difference'] <= 0
                    && $forward_timezone['end_difference'] >= 0
                ) {
                    //Redirecting user
                    header("location:$value[link_address]");
                    return;
                }
            }
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <script src="<?php echo $handle->path('js/axios/axios.min.js') ?>"></script>
        <script src="<?php echo $handle->path('js/moment/moment.js'); ?>"></script>
        <script src="<?php echo $handle->path('js/moment/moment-timezone-with-data.js'); ?>"></script>
        <script type="text/javascript">
            var tz = '';

            try {
                // moment js + moment timezone
                tz = moment.tz.guess(),
                    axios({
                        url: '<?php echo $handle->path('timezone'); ?>',
                        method: 'post',
                        data: 'timezone=' + tz
                    })
                    .then(function(response) {
                        console.log('Timezonedata:', response);
                    });
            } catch (e) {
                console.log(e);
            }
        </script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo "@$PageName | ProfilePage"; ?></title>
        <link rel="stylesheet" id="theme" href="<?php echo $handle->path('css/theme.min.css') ?>" class="" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="<?php echo $handle->path('assets/fonts/bootstrap-icons/bootstrap-icons.css') ?>" />
        <link rel="stylesheet" href="<?php echo $handle->path('css/app.min.css') ?>" />
    </head>

    <body>
        <div class="bg-white p-0 col-sm-6 col-md-5 col-lg-4 col-xs-12 card mb-0 shadow ml-auto chatbox-container animate__animated" id="chat-box-container" style="display: none;">
            <div class="h-100 d-flex flex-column">
                <div class="card-header rounded-0 pr-2">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="mb-1 view-type">ASK</h4>
                            <p class="small mb-0"><span class="text-success">●</span> Last seen recently</p>
                        </div>
                    </div>
                    <div class="d-flex"><button class="btn btn-circle bg-hover-primary-soft btn-md" id="expanded-box"><i class="bi bi-fullscreen sz-18"></i></button> <button class="btn btn-circle bg-hover-primary-soft btn-md" id="close-chat-box"><i class="bi bi-x sz-24"></i></button></div>
                </div>
                <div class="chat-box position-relative flex-grow-1" style="height:calc(100% - 120px)">
                    <div class="chat-background bg-sohbet"></div>

                    <div class="tab-content chatbox-wrapper p-0">
                        <div class="tab-pane show active fade" id="message-tab">
                            <div class="d-flex m-3">
                                <div class="bg-primary-soft text-primary rounded w-100">
                                    <div class="p-3 text-center">
                                        <?php echo "User@" . substr(md5(explode('-', $from_user_id)[1] . ""), 0, 20); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="flex-grow-1 p-2 overflow-wrapper">
                                    <div class="chat-log">
                                    </div>
                                    <div class="message-status">
                                    </div>
                                    <div class="d-flex justify-content-center mb-3">
                                        <form method="post" action="">
                                            <button type="submit" class="btn btn-sm bg-primary-soft rounded-pill" name="restart_session">Reset session</button>
                                        </form>
                                        <?php if (isset($_POST["restart_session"])) {
                                            unset($_SESSION["f.u.i"], $_SESSION["anms.f.u.i"]);
                                            $from_user_id  = $_SESSION["anms.f.u.i"] = $_SESSION["f.u.i"] = 'ANMS-' . $handle->generate_token('alphanumeric', 20);
                                        ?>
                                            <meta http-equiv="refresh" content="0; url=<?php $_SERVER["PHP_SELF"]; ?>">

                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="card mb-2 p-3 mx-2 msg-tools">
                                    </div>
                                    <div class="list-group-item emojis-container bg-white-soft shadow p-0 w-100" style="display:none">
                                        <ul class="nav nav-tabs px-3 nav-overflow mx-2" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link py-2 active" data-toggle="tab" href="#faces">
                                                    😀
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link py-2" data-toggle="tab" href="#gestures">
                                                    👍
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link py-2" data-toggle="tab" href="#natures">
                                                    🐼
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link py-2" data-toggle="tab" href="#foods">
                                                    ☕️
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link py-2" data-toggle="tab" href="#places">
                                                    ⚽️
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link py-2" data-toggle="tab" href="#objects">
                                                    📆
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link py-2" data-toggle="tab" href="#symbols">
                                                    ❤️
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="emojis">
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="faces">
                                                    <div class="face_emojis p-3 px-0 d-flex flex-wrap align-content-stretch">
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="gestures">
                                                    <div class="gesture_emojis p-3 px-0 d-flex flex-wrap align-content-stretch">
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="natures">
                                                    <div class="nature_emojis p-3 px-0 d-flex flex-wrap align-content-stretch">
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="foods">
                                                    <div class="food_emojis p-3 px-0 d-flex flex-wrap align-content-stretch">
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="places">
                                                    <div class="place_emojis p-3 px-0 d-flex flex-wrap align-content-stretch">
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="objects">
                                                    <div class="object_emojis p-3 px-0 d-flex flex-wrap align-content-stretch">
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="symbols">
                                                    <div class="symbol_emojis p-3 px-0 d-flex flex-wrap align-content-stretch">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="feeds-tab">
                            <div class="bg-white list-group list-group-flush">
                                <?php
                                $QualifiedFeeds = array();
                                $requestForFeeds = $fetch->data('page-anonymus-chats', 'from_user_id, chat_logs', "to_user_id='" . $_SESSION['owner_id'] . "' AND page_id='" . $_SESSION['page_visit'] . "' ORDER BY `ayms-id` DESC", 'row');
                                if ($requestForFeeds) {
                                    foreach ($requestForFeeds as $row) {
                                        $chat_logs = unserialize($row["chat_logs"]);

                                        // // m_container => message_container
                                        foreach ($chat_logs as $key => $m_container) {

                                            if (
                                                isset($m_container["reply_time"])
                                                && isset($m_container["reply_id"])
                                                && isset($m_container["reply"])
                                            ) {
                                                $m_container["from_user_id"] = $row["from_user_id"];
                                                $QualifiedFeeds[] = $m_container;
                                            }
                                        }
                                    }
                                }

                                ?>
                                <?php
                                if (count($QualifiedFeeds) >= 1) {

                                    //Sorting by descending order by time
                                    $sort = array();
                                    foreach ($QualifiedFeeds as $k => $v) {
                                        $sort['time'][$k] = $v['time'];
                                    }

                                    array_multisort($sort['time'], SORT_DESC, $QualifiedFeeds);
                                }
                                foreach ($QualifiedFeeds as $feed_key => $feed_response) {
                                ?>
                                    <div class="p-3 list-group-item animate__animated animate__fadeIn animate__delay-1s Feed" id="<?php echo $feed_response["from_user_id"]; ?>">
                                        <div class="mb-0">
                                            <div class="row align-items-start">
                                                <div class="col-auto"><a href="#!" class="avatar avatar-sm"><img src="../assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle"></a></div>
                                                <div class="col ml-n2 mb-0">
                                                    <p>
                                                        <?php echo $feed_response["message"];
                                                        ?>
                                                    </p>
                                                    <div class="row align-items-start justify-content-start mr-2">
                                                        <?php if (strpos($feed_response["from_user_id"], "PRSL-") !== false) {
                                                            $personal_user_id = explode('-', $feed_response["from_user_id"])[1];
                                                        ?>
                                                            <div class="col-auto py-3">
                                                                <div class="avatar avatar-xs mr-n3">
                                                                    <img src="../assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                                                                </div>
                                                            </div>
                                                            <div class="col" style="word-break:break-word">
                                                                <div class="text-wrap p-3 d-inline-block rounded" style="background-color: #f9fbfd;">
                                                                    <div class="d-flex flex-column">
                                                                        <b class="">
                                                                            <a class="text-body" href="../@<?php echo $Auth->Details($personal_user_id)["user_name"]; ?>"><?php echo $Auth->Details($personal_user_id)["user_name"]; ?></a>
                                                                        </b>
                                                                        <?php echo $feed_response["reply"]; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="col" style="word-break:break-word">
                                                                <div class="text-wrap p-3 d-inline-block rounded" style="background-color: #f9fbfd;">
                                                                    <?php echo $feed_response["reply"]; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="replied-time my-1">
                                                        <small>
                                                            <?php echo $handle->timeago('@' . $feed_response["reply_time"]);
                                                            ?>
                                                        </small>
                                                    </div>
                                                    <div class="reactions">
                                                        <div class="row align-items-start justify-content-start">
                                                            <div class="col">
                                                                <div class="d-flex">
                                                                    <div class="d-flex flex-column align-items-center">
                                                                        <div class="mb-0 pb-0">
                                                                            <button class="btn pb-0 btn-circle bg-hover-red-soft btn-sm reaction_like" id="<?php echo $feed_response["reply_id"]; ?>"><i class="bi bi-heart sz-18"></i></button>
                                                                        </div>
                                                                        <div class="mt-n2">
                                                                            <small>
                                                                                43
                                                                            </small>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <button class="btn btn-circle bg-hover-primary-soft btn-sm"><i class="bi bi-trash sz-18"></i></button>
                                                                <button class="btn btn-circle bg-hover-primary-soft btn-sm"><i class="bi bi-box-arrow-up sz-18"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>


                            </div>
                            <div class="position-fixed" style="right:20px;bottom:4em">
                                <button class="btn btn-circle btn-sm btn-white shadow-sm" id="scroll_chat_to_last">
                                    <i class="bi bi-chevron-double-down sz-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-pills justify-content-center p-2 border-top" id="pills-tab">
                    <li class="nav-item"><a class="nav-link rounded-pill active" data-toggle="tab" href="#message-tab">Ask</a></li>
                    <li class="nav-item"><a class="nav-link rounded-pill" data-toggle="tab" href="#feeds-tab">Feeds</a></li>
                </ul>
            </div>
        </div>
        <!-- Chat button -->
        <button type="button" class="btn rounded-circle btn-white bg-primary-soft animate__animated chat-attention-seeker shadow" id="open-chat" style="position: fixed; bottom:50px;right:35px;z-index:2">
            <i class="bi bi-chat-square-text sz-24"></i>
        </button>

        <div class="container">
            <form class="send-request">
                <div class="row justify-content-center">
                    <div class="col-md-7">
                        <!-- Body -->
                        <div class="card-body text-center">

                            <!-- Image -->
                            <a href="#" class="avatar avatar-xxl card-avatar">

                                <img src="<?php echo $handle->path($Auth->photos($Auth->Details($owner_id))); ?>" class="avatar-img rounded-circle border border-4 border-card" alt="...">
                            </a>

                            <!-- Heading -->
                            <h2 class="card-title">

                                <?php echo "<a href='" . $profile_path . "'>@" . ($decode["client"]["details"]["user_name"]) . "</a> <i class='bi bi-dot mx-n2'></i> " . $PageName;
                                //Abhi k liye page name se kaam chala rhe hain 
                                ?>
                                <!-- TODO: Leaplink -->

                            </h2>

                            <!-- Text -->
                            <p class="small text-muted mb-3">
                                Hey there, welcome to my profile page.
                            </p>

                        </div>

                        <!-- section for links-->
                        <section>
                            <?php
                            if (count($linkObject) > 0 | $linkObject !== 0) {
                                foreach ($linkObject as $key => $link_data) {

                                    //priority effect
                                    $priority = (isset($link_data['priority']['enabled'])) ? "animate__animated animate__" . $link_data['priority']['effect'] . " animate__infinite animate__slow" : "";

                                    //Checking for Information collector
                                    if (
                                        strpos($key, 'information_collector') !== false
                                        && !isset($link_data['scheduled'])
                                    ) {

                                        echo "
                                    <div class='card mb-3 $priority'>
                                    <div class='card-body'>
                                    <div class='row align-items-center'>
                                    <div class='col'>
                                    ";
                                        foreach ($informations = $link_data['fields'] as $input => $fields) {
                                            if ($input === 'dob') {
                            ?>

                                                <div class="mb-3">
                                                    <h4 class="font-weight-light">
                                                        <?php echo ($fields['label'] ?: 'Date of birth'); ?>
                                                    </h4>
                                                    <input type="text" class="form-control dob" placeholder="<?php echo ($fields['placeholder'] ?: ''); ?>" name="responses[<?php echo $fields['label']; ?>]" data-toggle="flatpickr">
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="mb-3">
                                                    <h4 class="font-weight-light">
                                                        <?php echo ($fields['label'] ?: ''); ?>
                                                    </h4>
                                                    <input type="text" class="form-control" placeholder="<?php echo ($fields['placeholder'] ?: ''); ?>" name="responses[<?php echo $fields['label']; ?>]">
                                                </div>
                                        <?php
                                            }
                                        }

                                        echo "
                                    <button type='button' class='btn btn-block rounded bg-primary-soft text-primary submit_form_response'>Submit</button>
                                    </div>
                                    </div>
                                    </div>
                                    </div>";
                                        // Show Information collector box
                                        ?>
                                        <!-- <pre> -->
                                    <?php
                                    }
                                    if ($key === 'feedback_collector') {
                                    ?>
                                        <div class="card">
                                            <div class="card-body ">
                                                <div class="card-text">
                                                    <div class="form-group m-0">
                                                        <label for="feedback_message"><b>Feedback</b></label>
                                                        <div class="">
                                                            <input class="form-control mb-2" id="feedbacker" type="text" placeholder="<?php echo $link_data['name']; ?>" name="feedback[name]">
                                                            <input class="form-control mb-2" placeholder="<?php echo $link_data['email']; ?>" type="email" name="feedback[email]">
                                                            <textarea class="form-control mb-2 feedback_message" id="feedback_message" rows="5" placeholder="<?php echo $link_data['feebacker_message']; ?>" name="feedback[message]" resize="none"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <div class="card-text">
                                                            <div class="progress feedback_bar_container" style="height: 5px;" hidden="">
                                                                <div class="progress-bar feedback_bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                            <div class="mt-2 feeback_submit_message mb-0 d-flex-inline align-items-center">
                                                            </div>
                                                            <div class="rating d-flex align-items-center justify-content-center">
                                                                <i class="bi bi-star-fill sz-36 star" rate-value="1"></i>
                                                                <i class="bi bi-star-fill sz-36 star" rate-value="2"></i>
                                                                <i class="bi bi-star-fill sz-36 star" rate-value="3"></i>
                                                                <i class="bi bi-star-fill sz-36 star" rate-value="4"></i>
                                                                <i class="bi bi-star-fill sz-36 star" rate-value="5"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <button type="button" class="btn btn-block bg-primary-soft submit_feedback text-primary">
                                                    <i class="bi bi-chat-square mr-2"></i>Submit
                                                </button>

                                            </div>
                                        </div>
                                        <?php
                                    }
                                    if (
                                        //Checking for only link and not scheduled
                                        strpos($key, 'link') !== false
                                    ) {
                                        if (!isset($link_data['scheduled'])) {
                                        ?>
                                            <div class="card pp_links mb-3 <?php echo $priority; ?>">
                                                <div class="p-3">
                                                    <div class="row align-items-center">
                                                        <a class="stretched-link" target="_blank" rel="noopener" href="<?php echo urldecode($link_data['link_address']); ?>"></a>
                                                        <div class="col-auto">

                                                            <!-- Avatar -->
                                                            <?php
                                                            echo $thumbnail = (@$link_data['thumbnail_off']) ? '' : '<a href="#" class="avatar avatar-sm">
                                                        <img src=' . @$link_data["domain_icon"] . ' alt="..." class="avatar-img rounded-circle">
                                                    </a>';
                                                            ?>

                                                        </div>
                                                        <div class="col ml-n2 align-items-center">

                                                            <!-- Title -->
                                                            <h4 class="mb-0">
                                                                <a href="#"><?php echo $link_data['link_title']; ?></a>
                                                            </h4>

                                                        </div>
                                                        <div class="col-auto">
                                                            <span class="ml-auto mr-2"><i class="bi bi-chevron-right sz-18"></i></span>
                                                        </div>

                                                    </div> <!-- / .row -->
                                                </div> <!-- / .card-body -->
                                            </div>

                                            <?php
                                        } elseif (isset($link_data['scheduled'])) {

                                            $scheduled_timezone = schedule_time(
                                                $link_data['scheduled']['date'],
                                                $link_data['scheduled']['timezone'],
                                                $user_timezone
                                            );

                                            //Show scheduled template instead of link
                                            if (
                                                //Show if scheduled date is not today
                                                $scheduled_timezone['start_difference'] > 0
                                                && $scheduled_timezone['end_difference'] > 0
                                            ) {
                                            ?>
                                                <div class="card pp_scheduled_links mb-3 <?php echo $priority; ?>">
                                                    <div class="p-3">
                                                        <div class="row align-items-center">
                                                            <a class="stretched-link" href="#"></a>
                                                            <div class="col-auto">

                                                                <!-- <a href="#" class="avatar avatar-sm"> -->
                                                                <i class="bi bi-clock-history sz-24"></i>
                                                                <!-- <img src="<?php // echo $link['domain_icon'];
                                                                                ?>" alt="..." class="avatar-img rounded-circle"> -->
                                                                <!-- </a> -->

                                                            </div>
                                                            <div class="col ml-n2 align-items-center">

                                                                <!-- Title -->
                                                                <h4 class="mb-0">

                                                                    <span class="font-italic font-weight-light">This is a scheduled link
                                                                        available from

                                                                    </span>
                                                                </h4>
                                                                <p class="small text-muted mb-0">
                                                                    <?php echo $scheduled_timezone['viewer_can_see_this_from'] . ' to ' . $scheduled_timezone['viewer_cannot_see_this_after']; ?>
                                                                </p>

                                                            </div>
                                                            <div class="col-auto">
                                                                <span class="ml-auto mr-2"><i class="bi bi-chevron-right sz-18"></i></span>
                                                            </div>

                                                        </div> <!-- / .row -->
                                                    </div> <!-- / .card-body -->
                                                </div>
                                            <?php
                                            } elseif (
                                                //Show link if scheduled date is today
                                                $scheduled_timezone['start_difference'] <= 0
                                                && $scheduled_timezone['end_difference'] >= 0
                                            ) { ?>
                                                <div class="card pp_links mb-3 <?php echo $priority; ?>">
                                                    <div class="p-3">
                                                        <div class="row align-items-center">
                                                            <a class="stretched-link" target="_blank" rel="noopener" href="<?php echo urldecode($link_data['link_address']); ?>"></a>
                                                            <div class="col-auto">

                                                                <!-- Avatar -->
                                                                <?php
                                                                echo $thumbnail = (@$link_data['thumbnail_off']) ? '' : '<a href="#" class="avatar avatar-sm">
                                                        <img src=' . $link_data["domain_icon"] . ' alt="..." class="avatar-img rounded-circle">
                                                    </a>';
                                                                ?>

                                                            </div>
                                                            <div class="col ml-n2 align-items-center">

                                                                <!-- Title -->
                                                                <h4 class="mb-0">
                                                                    <a href="#"><?php echo $link_data['link_title']; ?></a>
                                                                </h4>

                                                            </div>
                                                            <div class="col-auto">
                                                                <span class="ml-auto mr-2"><i class="bi bi-chevron-right sz-18"></i></span>
                                                            </div>

                                                        </div> <!-- / .row -->
                                                    </div> <!-- / .card-body -->
                                                </div>
                            <?php
                                            }
                                            unset($time_s, $time_e, $date_s, $date_e, $timezone);
                                        }
                                    }

                                    // var_dump($link_data);
                                }
                                $arrtime = round(microtime(true) - $start, 3);
                            }
                            ?>
                            <!-- </pre> -->

                        </section>
                    </div>
                </div>
            </form>
            <div class="mt-5 ">
                <div class="owl-carousel text-center">
                    <div class="card lift rounded-xl">
                        <div class="card-body">lorem5</div>
                    </div>
                    <div class="card lift rounded-xl">
                        <div class="card-body">lorem5</div>
                    </div>
                    <div class="card lift rounded-xl">
                        <div class="card-body">lorem5</div>
                    </div>
                    <div class="card lift rounded-xl">
                        <div class="card-body">lorem5</div>
                    </div>
                    <div class="card lift rounded-xl">
                        <div class="card-body">lorem5</div>
                    </div>
                    <div class="card lift rounded-xl">
                        <div class="card-body">lorem5</div>
                    </div>
                    <div class="card lift rounded-xl">
                        <div class="card-body">lorem5</div>
                    </div>
                    <div class="card lift rounded-xl">
                        <div class="card-body">lorem5</div>
                    </div>
                    <div class="card lift rounded-xl">
                        <div class="card-body">lorem5</div>
                    </div>
                    <div class="card lift rounded-xl">
                        <div class="card-body">lorem5</div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo $handle->path('js/jquery.min.js'); ?>"></script>
        <script src="<?php echo $handle->path('js/bootstrap.bundle.min.js') ?>"></script>
        <script src="<?php echo $handle->path('js/ifjs.min.js') ?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <script>
            const init_ifjs = function() {
                return new IFJS();
            };
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
                                5
                            </div> 
                        </div>
                    </div>
                </div>
                `;
            }
            let msg_tool_template = function() {
                return `
                <label class="sr-only">Leave your message...</label><textarea class="form-control form-control-flush" id="message" data-toggle="autosize" rows="1" placeholder="Leave your message..." style="overflow:hidden;overflow-wrap:break-word;max-height:125px;height:125px"></textarea>

                <div class="d-flex align-items-center justify-content-between">
                    <?php if (isset($_SESSION["ed"])) { ?>
                        <div class="cond">
                            <div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" id="is_anonymus" value="true">
                                <label class="custom-control-label" for="is_anonymus" if-click="">{|<small class="font-weight-bold">by <?php echo ($Auth->Details($Auth->AuthID())["user_name"]); ?></small>}</label>
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
            }
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
            })
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
                        data: 'message=' + message + '&page_name=' + '<?php echo $page_id; ?>' +
                            '&is_anonymus=' + is_anonymus

                        // if the request is sent then update the messages
                    }).then(function(afterSend) {
                        console.log(afterSend.data);

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
                })
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
                    if (rating < 4) {
                        feeback_submit_message.innerHTML = (
                            `<div class="alert text-danger mb-0 p-0"><i class="bi bi-emoji-frown sz-18"></i> We are bad, we deserved ${rating} ${got_star}</div>`
                        );
                    } else {
                        feeback_submit_message.innerHTML = (
                            `<div class=""> <i class="bi bi-emoji-heart-eyes sz-18 pr-1"></i>Woohooo! you gave us ${rating} ${got_star} thankyou!</div>`
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
                        url: '../controllers/Handlers/feedback.Handler.php',
                        method: 'post',
                        data: $(".send-request").serialize() + '&page_name=' + '<?php echo $page_id; ?>' +
                            '&feedback[rating]=' + rating + '&address=' +
                            '<?php echo $_SERVER["REMOTE_ADDR"] ?>'
                    })
                    .then(function(response) {
                        console.log(response['data']);
                        // $(".send-request").trigger("reset");
                        feedback_bar_container.setAttribute("hidden", true);
                        $(feeback_submit_message).fadeTo(2000, 500).slideUp(500, function() {
                            $(feeback_submit_message).slideUp(500);
                        });
                        star.forEach((prevRating) => {
                            prevRating.classList.remove("rated")
                        });
                        /*NOT RESETTING RATING TO GET HIGH RATINGS*/
                        /*rating = 0;*/
                    })

            });
            $('.submit_form_response').on('click', function(e) {

                e.preventDefault();
                var form = document.querySelector('.send-request');

                const formData = new FormData(form);

                formData.append('page_name', '<?php echo $page_id; ?>');
                axios({
                    url: '../controllers/Handlers/page.responses.Handler.php',
                    method: 'post',
                    data: formData
                }).then(function(response) {
                    console.log(response.data);
                })
            });

            // flatpickr
            flatpickr(".dob", {

                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",

            });
        </script>
    </body>

    </html>




<?php

}
$istime = round(microtime(true) - $start, 3);

$totaltime = $arrtime + $istime;

echo "Page compiled in $totaltime s";
?>