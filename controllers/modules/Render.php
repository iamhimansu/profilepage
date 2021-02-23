<?php

include_once __DIR__ . '/../database.php';
include_once __DIR__ . '/core.php';
include_once __DIR__ . '/../functions.php';

use CodeFlirt\Handlers;

/**    =====================================
 *    ||          R E N D E R             ||
 *    =====================================
 * 
 * Render is a templating script which renders links configurations
 * This helps to change/modify/adjust different elements when needed
 * This also helps in theming
 * 
 * NOTE: Include functions.php before including Render.php
 * 
 * include_once __DIR__.'/controllers/functions.php';
 * 
 * Render extends class to Page which is in functions.php
 * 
 * @param Render(string $Category, array $Configs);
 */

class Render extends Page
{

    public function __construct(string $Category = null, array &$Configs)
    {
        $this->Category = $Category;
        $this->Configs = $Configs;
        isset($_COOKIE["tz"]) ? $this->Timezone = $_COOKIE["tz"] : $this->Timezone = "Asia/Calcutta";
    }
    public function output()
    {
        switch ($this->Category) {
            case 'FORM':
                if (
                    isset($_SESSION[$_SESSION['PageID'] . ":submitted:response"])
                    && $_SESSION[$_SESSION['PageID'] . ":submitted:response"] === "response"
                ) {
                    $this->render_submission("<i class='bi bi-check-circle text-primary sz-64'></i>", "<h2 class='mb-0 mt-2'>Response submitted.</h2>");
                    return;
                }
                $is_priority = (isset($this->Configs['priority']['enabled'])) ? "class='animate__animated animate__" . $this->Configs['priority']['effect'] . " animate__infinite animate__slow'" : "";
                //Priority link

                echo "<section type='form' $is_priority>";
                echo "<form id='submit-response'>";
                echo "<div class='card ppage-card'>";
                echo "<div class='card-body'>";
                echo "<div class='row align-items-center'>";
                echo "<div class='col'>";
                $this->render_form();
                echo "</div>";
                echo "</div>";
                echo "<button type='button' class='btn btn-block rounded bg-primary-soft text-primary submit_form_response'>Submit</button>";
                echo "</div>";
                echo "</div>";
                echo "</form>";
                echo "</section>";
                break;

                //Anonymus Chat 
            case 'CHAT':
                $this->render_chat();
                break;

                //Scheduled links
            case 'SCHEDULED_LINK':
                $is_priority = (isset($this->Configs['priority']['enabled'])) ? "class='animate__animated animate__" . $this->Configs['priority']['effect'] . " animate__infinite animate__slow'" : "";
                echo "<section type='scheduled' $is_priority>";
                $this->handle_scheduled_links();
                echo "</section>";
                break;

                //General links
            case 'GENERAL_LINK':
                $is_priority = (isset($this->Configs['priority']['enabled'])) ? "class='animate__animated animate__" . $this->Configs['priority']['effect'] . " animate__infinite animate__slow'" : "";
                //Priority link

                echo "<section type='link' $is_priority>";
                $this->render_general_links();
                echo "</section>";
                break;

                //Feedback
            case 'FEEDBACK':
                if (
                    isset($_SESSION[$_SESSION['PageID'] . ":submitted:feedback"])
                    && $_SESSION[$_SESSION['PageID'] . ":submitted:feedback"] === "feedback"
                    && isset($_SESSION[$_SESSION['PageID'] . ":submitted:feedback:rating"])
                ) {
                    $total_ratings = "";
                    $get_total_ratings = (int) $_SESSION[$_SESSION['PageID'] . ":submitted:feedback:rating"];
                    for ($i = 0; $i < $get_total_ratings; $i++) {
                        $total_ratings .= "<i class='bi bi-star-fill text-primary sz-24'></i>";
                    }
                    $this->render_submission($total_ratings, "<h2 class='mb-0 mt-2'>Feedback submitted</h2>");
                    return;
                }
                $is_priority = (isset($this->Configs['priority']['enabled'])) ? "class='animate__animated animate__" . $this->Configs['priority']['effect'] . " animate__infinite animate__slow'" : "";
                //Priority link

                echo "<section type='feedback' $is_priority>";
                echo "<form id='submit-feedback'>";
                echo "<div class='card ppage-card'>";
                echo "<div class='progress feedback_bar_container' style='height: 15px;border-radius: 0;border-top-left-radius: 8px !important;border-top-right-radius: 8px !important;margin-top:-1px' hidden=''>
                <div class='progress-bar feedback_bar bg-primary rounded-0' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div>
                </div>";
                echo "<div class='card-body'>";
                $this->render_feedback();
                echo "<button type='button' class='btn btn-block bg-primary-soft submit_feedback text-primary'>Submit</button>";
                echo "</div>";
                echo "</div>";
                echo "</form>";
                echo "</section>";
                break;

            default:
                # code...
                break;
        }
    }
    function render_form()
    {
        foreach ($this->Configs["fields"] as $type => $data) {
            if ($type === "name") { ?>
                <div class="mb-3">
                    <h4 class="font-weight-light">
                        <?php echo isset($data['label']) && !empty($data['label']) ? $data['label'] : 'Name'; ?>
                    </h4>
                    <input type="text" class="form-control ppage-input" placeholder="<?php echo isset($data["placeholder"]) && !empty($data["placeholder"]) ? $data["placeholder"] : "Name"; ?>" name="responses[<?php echo isset($data['label']) && !empty($data['label']) ? $data['label'] : 'Name'; ?>]">
                </div>
            <?php }
            if ($type === "email") { ?>
                <div class="mb-3">
                    <h4 class="font-weight-light">
                        <?php echo isset($data['label']) && !empty($data['label']) ? $data['label'] : 'Email'; ?>
                    </h4>
                    <input type="text" class="form-control ppage-input" id="emailAddress" placeholder="<?php echo isset($data["placeholder"]) && !empty($data["placeholder"]) ? $data["placeholder"] : "Email"; ?>" name="responses[<?php echo isset($data['label']) && !empty($data['label']) ? $data['label'] : 'Email'; ?>]">
                </div>
            <?php }
            if ($type === "phone") { ?>
                <div class="mb-3">
                    <h4 class="font-weight-light">
                        <?php echo isset($data['label']) && !empty($data['label']) ? $data['label'] : 'Phone'; ?>
                    </h4>
                    <input type="text" class="form-control ppage-input" id="phoneNumber" placeholder="(xx) xxxxxxxxxx" name="responses[<?php echo isset($data['label']) && !empty($data['label']) ? $data['label'] : 'Phone'; ?>]">
                </div>
            <?php }
            if ($type === "dob") { ?>
                <div class="mb-3">
                    <h4 class="font-weight-light">
                        <?php echo isset($data['label']) && !empty($data['label']) ? $data['label'] : 'Date of birth'; ?>
                    </h4>
                    <input type="text" class="form-control ppage-input dob" placeholder="<?php echo isset($data["placeholder"]) && !empty($data["placeholder"]) ? $data["placeholder"] : "Date of birth"; ?>" name="responses[<?php echo isset($data['label']) && !empty($data['label']) ? $data['label'] : 'Date of birth'; ?>]">
                </div>
        <?php }
        }
    }
    function render_chat()
    {
        if (isset($this->Configs["features"]["delay_timer"])) {
            echo "<script>var message_time_delay = " . $this->Configs["features"]["delay_timer"] . ";</script>";
        } else {
            echo "<script>var message_time_delay = 5;</script>";
        }
        if (isset($this->Configs["features"]["force_login"])) {
            echo "<script>var force_login = true;</script>";
        } else {
            echo "<script>var force_login = false;</script>";
        }
        $from_user_id  = $_SESSION["anms.f.u.i"] = $_SESSION["f.u.i"] = 'ANMS-' . (new CodeFlirt\Handlers)->generate_token('alphanumeric', 20);
        $User = new User();
        $handle = new CodeFlirt\Handlers;
        $user_photo = $handle->path($User->photos($User->Details($_SESSION["OwnerID"])));

        ?>
        <div class="bg-white p-0 col-sm-6 col-md-5 col-lg-4 col-xs-12 card mb-0 shadow ml-auto chatbox-container animate__animated" id="chat-box-container" style="display: none;">
            <div class="h-100 d-flex flex-column">
                <div class="card-header rounded-0 pr-2">
                    <div class="row align-items-center text-truncate">
                        <div class="col">
                            <h4 class="mb-1 view-type">ASK</h4>
                            <?php
                            if (isset($this->Configs["features"]["show_my_username"])) {
                                echo "<span>" . $User->Details($_SESSION["OwnerID"])["user_name"] . "</span>";
                            } else {
                                echo "<span>User</span>";
                            }
                            ?>
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
                                            $from_user_id  = $_SESSION["anms.f.u.i"] = $_SESSION["f.u.i"] = 'ANMS-' . (new CodeFlirt\Handlers)->generate_token('alphanumeric', 20);
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
                        <div class="tab-pane fade custom-scroll" id="feeds-tab">
                            <div class="bg-white list-group list-group-flush">
                                <?php
                                $QualifiedFeeds = array();

                                $requestForFeeds = (new CodeFlirt\Fetch)->data('page-anonymus-chats', 'from_user_id,to_user_id, chat_logs', "to_user_id='" . $_SESSION['OwnerID'] . "' AND page_id='" . $_SESSION['PageID'] . "' ORDER BY `ayms-id` DESC", 'row');
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
                                                <div class="col-auto"><a href="#!" class="avatar avatar-sm"><img src="<?php echo $user_photo; ?>" alt="..." class="avatar-img rounded-circle"></a></div>
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
                                                                    <img src="<?php echo $handle->path($User->photos($User->Details($personal_user_id))); ?>" alt="..." class="avatar-img rounded-circle">
                                                                </div>
                                                            </div>
                                                            <div class="col" style="word-break:break-word">
                                                                <div class="text-wrap p-3 d-inline-block rounded" style="background-color: #f9fbfd;">
                                                                    <div class="d-flex flex-column">
                                                                        <b class="">
                                                                            <span class="text-body" href="../@<?php echo (new User())->Details($personal_user_id)["user_name"]; ?>"><?php echo (new User())->Details($personal_user_id)["user_name"]; ?></span>
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
                                                            <?php echo (new CodeFlirt\Handlers)->timeago('@' . $feed_response["reply_time"]);
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
                                                                                <?php echo (isset($feed_response["reactions"])) ? count($feed_response["reactions"]) : 0; ?>
                                                                            </small>
                                                                        </div>
                                                                    </div>

                                                                </div>
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
        <button type="button" class="btn ppage-card btn-md btn-circle btn-white border-0 bg-hover-primary-soft animate__animated chat-attention-seeker shadow" id="open-chat" style="position: fixed; bottom:50px;right:35px;z-index:2">
            <i class="bi bi-chat-text sz-24"></i>
        </button>
    <?php

    }

    function render_general_links()
    {
    ?>
        <div class="card mb-3 bg-hover-primary-soft ppage-card">
            <div class="p-3">
                <div class="row align-items-center">
                    <a class="stretched-link" target="_blank" rel="noopener" href="<?php echo (new Handlers)->path(("views/url.php?visit=" . @$this->Configs['link_address'])); ?>"></a>
                    <div class="col-auto">
                        <?php
                        echo (@$this->Configs['thumbnail_off']) ? '' : '<a href="#" class="avatar avatar-sm">
                        <img src=' . @$this->Configs["domain_icon"] . ' alt="Domain thumbnail" class="avatar-img rounded-circle">
                        </a>';
                        ?>
                    </div>
                    <div class="col ml-n2 align-items-center">
                        <h4 class="mb-0">
                            <span><?php echo @$this->Configs['link_title']; ?></span>
                        </h4>
                    </div>
                    <div class="col-auto">
                        <span class="ml-auto mr-2"><i class="bi bi-chevron-right sz-18"></i></span>
                    </div>
                </div>
            </div>
        </div>

    <?php
    }
    function render_feedback()
    {
    ?>
        <div class="card-text">
            <div class="form-group m-0">
                <label for="feedback_message"><b>Feedback</b></label>
                <input class="form-control ppage-input mb-2" id="feedback" type="text" placeholder="<?php echo isset($this->Configs["name"]) && !empty($this->Configs["name"]) ? $this->Configs["name"] : "Your name"; ?>" name="feedback[name]">
                <input class="form-control ppage-input mb-2" id="feedback_email" placeholder="<?php echo isset($this->Configs["email"]) && !empty($this->Configs["email"]) ? $this->Configs["email"] : "Your Email"; ?>" type="email" name="feedback[email]">
                <textarea class="form-control ppage-input mb-2 feedback_message" id="feedback_message" rows="5" placeholder="<?php echo isset($this->Configs["feebacker_message"]) && !empty($this->Configs["feebacker_message"]) ? $this->Configs["feebacker_message"] : "Your message"; ?>" name="feedback[message]" resize="none"></textarea>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <div class="card-text">
                    <div class="mt-2 feeback_submit_message mb-0 d-flex-inline align-items-center">
                    </div>
                    <div class="my-3 rating d-flex align-items-center justify-content-center">
                        <i class="bi bi-star-fill sz-36 star" rate-value="1"></i>
                        <i class="bi bi-star-fill sz-36 star" rate-value="2"></i>
                        <i class="bi bi-star-fill sz-36 star" rate-value="3"></i>
                        <i class="bi bi-star-fill sz-36 star" rate-value="4"></i>
                        <i class="bi bi-star-fill sz-36 star" rate-value="5"></i>
                    </div>
                </div>
            </div>
        </div>

    <?php
    }
    function handle_scheduled_links()
    {
        $this->scheduled_timezone =  $scheduled_timezone = schedule_time(
            $this->Configs['scheduled']['date'],
            $this->Configs['scheduled']['timezone'],
            $this->Timezone
        );
        if (
            //Show scheduled template instead of link
            //Show if scheduled date is not today
            $scheduled_timezone['start_difference'] > 0
            && $scheduled_timezone['end_difference'] > 0
        ) {
            $this->render_scheduled_template();
        } elseif (
            //Show link if scheduled date is today
            $scheduled_timezone['start_difference'] <= 0
            && $scheduled_timezone['end_difference'] >= 0
        ) {
            $this->render_scheduled_link();
        } else {
            /**
             * No need of else 
             * But keeping it for later use
             */
        }
    }
    function render_scheduled_template()
    { ?>
        <div enabled='false'>
            <div class="card pp_scheduled_links ppage-card mb-3">
                <div class="p-3">
                    <div class="row align-items-center">
                        <a class="stretched-link" href="#"></a>
                        <div class="col-auto">
                            <i class="bi bi-clock-history sz-24"></i>
                        </div>
                        <div class="col ml-n2 align-items-center">
                            <h4 class="mb-0">
                                <span class="font-italic font-weight-light">This is a scheduled link
                                    available from
                                </span>
                            </h4>
                            <p class="small text-muted mb-0">
                                <?php echo $this->scheduled_timezone['viewer_can_see_this_from'] . ' to ' . $this->scheduled_timezone['viewer_cannot_see_this_after']; ?>
                            </p>
                        </div>
                        <div class="col-auto">
                            <span class="ml-auto mr-2"><i class="bi bi-chevron-right sz-18"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    function render_scheduled_link()
    {
    ?>
        <div class="card bg-hover-primary-soft mb-3 ppage-card">
            <div class="p-3">
                <div class="row align-items-center">
                    <a class="stretched-link" target="_blank" rel="noopener" href="<?php echo urldecode($this->Configs['link_address']); ?>"></a>
                    <div class="col-auto">
                        <?php
                        echo (@$this->Configs['thumbnail_off']) ? '' : '<a href="#" class="avatar avatar-sm">
                                <img src=' . $this->Configs["domain_icon"] . ' alt="..." class="avatar-img rounded-circle">
                            </a>';
                        ?>
                    </div>
                    <div class="col ml-n2 align-items-center">
                        <h4 class="mb-0">
                            <a href="#"><?php echo $this->Configs['link_title']; ?></a>
                        </h4>
                    </div>
                    <div class="col-auto">
                        <span class="ml-auto mr-2"><i class="bi bi-chevron-right sz-18"></i></span>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    public function render_submission($title = null, $message = "Success")
    {
    ?>
        <section type="response-submitted">
            <div submitted='true'>
                <div class="card ppage-card mb-3">
                    <div class="card-body text-center">
                        <div class="d-flex flex-column">
                            <div class="mb-2">
                                <?php echo $title; ?>
                            </div>
                            <div class=""><?php echo $message; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


<?php
    }
}
