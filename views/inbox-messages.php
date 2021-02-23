<?php
//Require controllers
require_once 'controllers/database.php';
require_once 'controllers/modules/Encryption.php';
require_once 'controllers/modules/core.php';
//Always Include Core above functions as function extends core
require_once 'controllers/functions.php';
session_name("PP");
session_start();

$handle = new CodeFlirt\Handlers;
$fetch = new CodeFlirt\Fetch;
$User = new User();
$Page = new Page();
$Page->Find($get_inbox_of);
$PageDetails = $Page->Details();

$User_ID = $User->AuthID();
$handle->trackUser();

$User->isAuthenticated();
$CurrentPage = "pages";
//Save page id in session
// $_SESSION["page_visit"] = $get_inbox_of;

//Request for Anonymus messages
$requestForAnmsMessages = $fetch->data('page-anonymus-chats', 'from_user_id,to_user_id,page_id,chat_logs', "to_user_id='$User_ID' AND page_id='$get_inbox_of' AND from_user_id LIKE 'ANMS-%' ORDER BY `ayms-id` DESC", 'row');

//Request for personal messages
$requestForPrslMessages = $fetch->data('page-anonymus-chats', 'from_user_id,to_user_id,page_id,chat_logs', "to_user_id='$User_ID' AND page_id='$get_inbox_of' AND from_user_id LIKE 'PRSL-%' ORDER BY `ayms-id` DESC", 'row');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inbox | ProfilePage</title>
    <link rel="stylesheet" id="theme" href="<?php echo $handle->path('css/theme.min.css') ?>" class="" />
    <link rel="stylesheet" href="<?php echo $handle->path('css/app.min.css') ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?php echo $handle->path('assets/fonts/bootstrap-icons/bootstrap-icons.css') ?>" />
    <link rel="stylesheet" href="<?php echo $handle->path('js/snackbar/snackbar.css') ?>" />
    <link href="<?php echo $handle->path('assets/plugins/selectjs/css/select2.min.css') ?>" rel="stylesheet" />
</head>

<style>
    .content-list::-webkit-scrollbar {
        width: 2px;
    }

    .custom-scroll::-webkit-scrollbar {
        width: 2px;
    }

    .custom-scroll::-webkit-scrollbar-thumb {
        background-color: #000;
    }

    .content-list::-webkit-scrollbar-thumb {
        background-color: #000;
    }
</style>

<body>
    <?php
    include 'template/template.side-navbar.php';
    ?>
    <div class="main-content bg-white">
        <div class="row no-gutters vh-100 justify-content-center">
            <div class="col-4 bg-white" id="users">
                <ul class="nav nav-tabs nav-overflow" id="myTab" role="tablist">
                    <li class="nav-item ml-3" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Anonymus <span class="badge badge-soft-primary rounded-xl"><?php echo ($requestForAnmsMessages) ? count($requestForAnmsMessages) : 0 ?></span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Personal <span class="badge badge-soft-primary rounded-xl"><?php echo ($requestForPrslMessages)  ? count($requestForPrslMessages) : 0; ?></span></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Filtered</a>
                    </li>
                </ul>
                <div class="bg-white rounded-bottom p-2 mb-0 shadow-sm">
                    <div class="input-group">
                        <input type="search" placeholder="Search messages... *Beta version" class="form-control search" id="filter-users">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-sm btn-white sort" data-sort="name" title="Sort by time">
                                <i class="bi bi-sort-alpha-up sz-18"></i>
                            </button>

                            <button type="button" class="btn btn-sm btn-white sort" data-sort="time" title="Sort by name">
                                <i class="bi bi-sort-up-alt sz-18"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="tab-content p-2 custom-scroll list" style="height: calc(100vh - 8rem);overflow-y:scroll">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="list-group shadow-sm listUsers">
                            <?php
                            $assigned_name = 'Random user';
                            //TODO: Fix message fetching... *
                            if ($requestForAnmsMessages) {
                                foreach ($requestForAnmsMessages as $row) {
                                    $get_json_chat_logs = unserialize($row["chat_logs"]);
                                    // foreach ($get_json_chat_logs as $key => $value) {
                                    //     if (array_key_exists("reply", $get_json_chat_logs[$key])) {
                                    //         unset($get_json_chat_logs[$key]);
                                    //     }
                                    // }
                                    if (count($get_json_chat_logs) >= 1) {

                            ?>
                                        <div class="list-group-item p-3 bg-hover-primary-soft reply_to" id="<?php echo $row["from_user_id"]; ?>">
                                            <div class="row align-items-start start_chat">
                                                <div class="col-auto mr-n2">
                                                    <div class="avatar avatar-sm">
                                                        <span class="avatar-title rounded-circle bg-primary-soft text-primary">
                                                            <i class="bi bi-person sz-24"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col text-truncate">
                                                    <h4 class="mb-1 name">
                                                        <?php echo $assigned_name; ?>
                                                        <span class="badge badge-soft-primary rounded-circle"><?php echo count($get_json_chat_logs); ?></span>
                                                    </h4>

                                                    <!-- Text -->
                                                    <div class="small text-truncate msg" style="max-height:38px !important;">
                                                        <?php echo $get_json_chat_logs[count($get_json_chat_logs) - 1]["message"]; ?>
                                                    </div>
                                                    <p class="small text-muted mb-0 font-weight-normal time">
                                                        <?php echo $handle->timeago('@' . $get_json_chat_logs[count($get_json_chat_logs) - 1]["time"]); ?>
                                                    </p>
                                                    <div class="d-flex align-items-center justify-content-start">
                                                        <button class="btn btn-sm btn-circle bg-hover-primary-soft start_chat flip_H" title="Reply..."><i class="bi bi-reply-all sz-18"></i></button>
                                                        <button class="btn btn-sm btn-circle bg-hover-red-soft delete_user" title="Delete user"><i class="bi bi-trash sz-18"></i></button>
                                                        <button class="btn btn-sm btn-circle bg-hover-primary-soft" title="Report user"><i class="bi bi-flag sz-18"></i></button>
                                                        <button class="btn btn-sm btn-circle bg-hover-primary-soft" title="Block user"><i class="bi bi-person-x sz-18"></i></button>
                                                    </div>
                                                </div>

                                            </div> <!-- / .row -->
                                        </div>
                            <?php
                                    }
                                }
                            }
                            ?>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="list-group list-group-flush">
                            <?php
                            // $random_user_number = range(9999, rand(9999, 99999), 9);
                            // $random_length = count($random_user_number);
                            // $assigned_name = 'User ' . 
                            // $assigned_name = 'User' . ($random_user_number[rand(0, $random_length - 1)]);
                            //TODO: Fix message fetching... *
                            if ($requestForPrslMessages) {
                                foreach ($requestForPrslMessages as $row) {
                                    $get_json_chat_logs = unserialize($row["chat_logs"]);
                                    // foreach ($get_json_chat_logs as $key => $value) {
                                    //     if (array_key_exists("reply", $get_json_chat_logs[$key])) {
                                    //         unset($get_json_chat_logs[$key]);
                                    //     }
                                    // }
                                    if (count($get_json_chat_logs) >= 1) {
                            ?>
                                        <div class="list-group-item card p-2 px-3 rounded shadow-sm border-0 mb-1 reply_to" id="<?php echo $row["from_user_id"]; ?>">
                                            <div class="row align-items-start">
                                                <div class="col-xs-3 col-sm-auto text-center">
                                                    <div class="avatar avatar-sm">
                                                        <span class="avatar-title rounded-circle bg-primary-soft text-primary">
                                                            <i class="bi bi-person sz-24"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8 text-truncate">
                                                    <!-- Title -->
                                                    <h4 class="mb-1 name">
                                                        <?php echo $User->Details(explode('-', $row["from_user_id"])[1])["user_name"];; ?>
                                                        <span class="badge badge-soft-primary rounded-circle"><?php echo count($get_json_chat_logs); ?></span>
                                                    </h4>

                                                    <!-- Text -->
                                                    <div class="small text-truncate msg" style="max-height:38px !important;">
                                                        <?php echo $get_json_chat_logs[count($get_json_chat_logs) - 1]["message"]; ?>
                                                    </div>
                                                    <p class="small text-muted mb-0 font-weight-normal time">
                                                        <?php echo $handle->timeago('@' . $get_json_chat_logs[count($get_json_chat_logs) - 1]["time"]); ?>
                                                    </p>
                                                    <div class="d-flex align-items-center justify-content-start">
                                                        <button class="btn btn-sm btn-circle bg-hover-primary-soft start_chat flip_H" title="Reply..."><i class="bi bi-reply-all sz-18"></i></button>
                                                        <button class="btn btn-sm btn-circle bg-hover-red-soft delete_user" title="Delete user"><i class="bi bi-trash sz-18"></i></button>
                                                        <button class="btn btn-sm btn-circle bg-hover-primary-soft" title="Report user"><i class="bi bi-flag sz-18"></i></button>
                                                        <button class="btn btn-sm btn-circle bg-hover-primary-soft" title="Block user"><i class="bi bi-person-x sz-18"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            <?php
                                    }
                                }
                            }
                            ?>

                        </div>

                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                </div>
            </div>
            <div class="col custom-scroll border-left content-container" style="max-height:100vh; overflow-y:scroll;">
                <div class="card-header rounded-0 pr-2">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-chat sz-24 mr-2 d-inline-block d-md-none"></i>
                                <h4 class="mb-1 view-type-reply">Reply</h4>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex cond">
                        <button class="btn btn-circle bg-hover-primary-soft btn-md minimize_container" if-click="">
                            {<i class="bi bi-dash sz-24"></i>|<i class="bi bi-plus sz-24"></i>}
                        </button>
                    </div>

                </div>
                <div class="progress-indicator h-auto">
                </div>
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col">
                            <div class="chat-log my-3">
                                <div class="d-flex justify-content-center align-items-center my-n3 flex-column" style="height:90vh;">
                                    <div>
                                        <i class="bi bi-chat-square-text sz-64 mb-3"></i>
                                    </div>
                                    <div class="lead">
                                        Select a user to see replies
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col custom-scroll border-left content-container" style="max-height:100vh; overflow-y:scroll;">
                <div class="bg-white list-group list-group-flush">
                    <div class="card-header rounded-0 pr-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="mb-1 view-type">Feeds</h4>
                                <p class="small mb-0"><span class="text-primary">●</span> Updating...</p>
                            </div>
                        </div>
                        <div class="d-flex cond">
                            <button class="btn btn-circle bg-hover-primary-soft btn-md minimize_container" if-click="">
                                {<i class="bi bi-dash sz-24"></i>|<i class="bi bi-plus sz-24"></i>}
                            </button>
                        </div>
                    </div>
                    <?php
                    $QualifiedFeeds = array();
                    $requestForFeeds = $fetch->data('page-anonymus-chats', 'from_user_id, chat_logs', "to_user_id='$User_ID' AND page_id='$get_inbox_of' ORDER BY `ayms-id` DESC", 'row');
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
                                                                <a class="text-body" href="../@<?php echo $User->Details($personal_user_id)["user_name"]; ?>"><?php echo $User->Details($personal_user_id)["user_name"]; ?></a>
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
                                                            <div class="mb-0 pb-0 cond">
                                                                <button if-click="" class="btn pb-0 btn-circle bg-hover-red-soft btn-sm reaction_like" id="<?php echo $feed_response["reply_id"]; ?>">
                                                                    {<i class="bi bi-heart sz-18"></i>|<i class="bi bi-heart-fill text-danger sz-18 animate__animated animate__zoomInUp"></i>}
                                                                </button>
                                                            </div>
                                                            <div class="mt-n2">
                                                                <small class="likes-collected">
                                                                    <?php echo (isset($feed_response["reactions"])) ? count($feed_response["reactions"]) : 0; ?>
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


            </div>
        </div>

    </div>
    <!-- Basic libraries-->
    <script src="<?php echo $handle->path('js/ifjs.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/jquery.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/jquery-ui.js') ?>"></script>
    <script src="<?php echo $handle->path('js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/axios/axios.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/snackbar/snackbar.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/listjs/list.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!--End libraries-->
    <script>
        var options = {
            valueNames: ['name', 'msg', 'time']
        };

        var userList = new List('users', options);


        const sendRequest = function() {
            return axios({
                method: 'get',
                url: '../controllers/api/api.anonymus-chats.php',
                params: {
                    request: 'f_id:' + open_chat_with_id +
                        ',t_id:<?php echo $User_ID; ?>,p_id:<?php echo $get_inbox_of; ?>'
                },
                timeout: 180000,
            })
        };
        let open_chat_with_id = '';
        const loading_reply = function() {
            return `
            <div class="progress rounded-0 animate__animated animate__fadeIn" style="height: 8px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated rounded-0" role="progressbar" style="width: 100%"></div>
            </div>
            `;
        };

        $(".reaction_like").click(function() {
            let likesCollected = Number($(this).closest(".reactions").find(".likes-collected").html());
            if ($(this).hasClass("liked")) {
                $(this).closest(".reactions").find(".likes-collected").html(likesCollected - 1);
                $(this).removeClass("liked");

            } else {
                $(this).closest(".reactions").find(".likes-collected").html(likesCollected + 1);
                $(this).addClass("liked");
            }
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
        $(".start_chat").click(function() {
            document.querySelectorAll(".reply_to").forEach(function(thisreply) {
                thisreply.classList.remove("bg-primary-soft");
            });
            $(this).closest(".reply_to").addClass("bg-primary-soft");
            open_chat_with_id = $(this).closest(".reply_to").attr('id');
            $(".progress-indicator").html(loading_reply);
            $(".view-type-reply").html("Loading...");

            sendRequest().then(function(fetchMessages) {
                var msgObj = fetchMessages.data;
                console.clear();
                $(".no_previous_chats").remove(),
                    $('.messages_loader').fadeOut(800),
                    $('.messages_loader').remove(800);
                if (open_chat_with_id != $(".chats-container").attr('id')) {
                    $(".chat-log").html('');
                }
                let chats = '';
                for (var key in msgObj) {
                    if (msgObj.hasOwnProperty(key)) {
                        let val = msgObj[key];
                        if (val.message === undefined) {
                            delete msgObj[key];
                        } else {
                            chats += `
                        <div class="card mb-2 message shadow-sm animate__animated animate__fadeIn" id="${val.id}">
                        <div class="p-3">
                        <div class="row">
                          <div class="col-auto">

                            <!-- Avatar -->
                            <div class="avatar avatar-sm">
                            <div class="avatar-title font-size-lg bg-primary-soft rounded-circle text-primary">
                                <i class="bi bi-person"></i>
                              </div>
                              </div>

                          </div>
                          <div class="col ml-n2">
                            <!-- Heading -->
                            <div class="mb-1" style="word-break:break-word">
                                <div class="text-wrap p-3 d-inline-block rounded" style="background-color: #f9fbfd;">
                                ${val.message}
                                </div>                            
                            </div>

                            <!-- Text -->
                            <p class="small text-gray-700 mb-0">
                              Asked ${val.time}
                            </p>
                              <textarea class="form-control form-control-flush form-control-auto reply" placeholder="Reply..."></textarea>

                            <!-- Footer -->
                            <div class="row align-items-start">
                              
                              <div class="col">
                                <button class="btn btn-sm bg-primary-soft reply_user">
                                  Reply
                                </button>
                                <button class="btn btn-sm bg-danger-soft delete_message">
                                  Delete
                                </button>
                                <button class="btn btn-sm bg-secondary-soft reply_user">
                                  Block
                                </button>
                                <button class="btn btn-sm btn-white" type="submit">
                                  Clear
                                </button>

                              </div>
                            </div>                    
                    </div>
                        </div>
                      </div>
                      </div>
                      `;
                        }
                    }
                    console.log(msgObj.length);
                };
                $(".view-type-reply").html(msgObj.length + " Message(s)");
                $(".chat-log").append(`
                    <div class="messages">
                        ${chats}
                    </div>
                    `);

                // //TODOS: Fix auto scroll
                // $(".chat-box").scrollTop($(".chat-box")[0].scrollHeight);

                $(".chats-container").attr('id', open_chat_with_id),
                    setTimeout(function() {
                        $(".progress-bar").removeClass('animate__fadeIn'),
                            $(".progress-bar").addClass('animate__fadeOut'),
                            $(".progress-indicator").html('');
                    }, 1000);



            }).catch(function(error) {
                if (error.response) {
                    sendRequest();
                    console.log(error.request);
                    return;
                }
            })
        });
        $("body").on("click", ".reply_user", function() {
            let reply = $(this).closest(".message").find(".reply").val();
            let replied_on = $(this).closest(".message").attr("id");
            if (reply.length > 0) {
                axios({
                    method: 'post',
                    url: '../controllers/Handlers/page.anonymus-reply.Handler.php',
                    data: 'replied=' + reply + '&replied_to=' + open_chat_with_id + '&replied_on=' +
                        replied_on
                }).then(function(submitted_reply) {
                    console.log(submitted_reply);
                })
            } else {
                return;
            };
            $("#" + replied_on).addClass("animate__animated animate__backOutRight");
            setTimeout(function() {
                $("#" + replied_on).remove();
            }, 1000);
        });
        $("body").on("click", ".delete_message", function() {
            let trace_logs = $(this).closest(".message").attr("id");
            axios({
                method: 'post',
                url: '../controllers/Handlers/page.anonymus-delete.Handler.php',
                data: 'trace_logs=' + trace_logs + '&message_from=' + open_chat_with_id
            }).then(function(submitted_delete) {});
            $("#" + trace_logs).addClass("animate__animated animate__backOutRight");
            setTimeout(function() {
                $("#" + trace_logs).remove();
            }, 1000);
        });
        $(".delete_user").click(function() {
            let delete_user = $(this).closest(".reply_to").attr("id");
            axios({
                method: 'post',
                url: '../controllers/Handlers/page.anonymus-delete-user.Handler.php',
                data: 'delete_user=' + delete_user
            }).then(function(after_delete) {});
            $(this).closest(".reply_to").fadeOut(200);
        });
        $(".minimize_container").on("click", function() {
            $(this).closest('.content-container').toggleClass(
                "minimize-container card animate__animated animate__fadeInUp shadow");
            if ($(".minimize-container").length > 1) {
                $(".minimize-container")[0].style["bottom"] = "85px";
            } else {
                $(".content-container")[0].style["bottom"] = null;
            }
        })
    </script>
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

</body>

</html>