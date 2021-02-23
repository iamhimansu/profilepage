<?php
require_once 'controllers/database.php';
require_once 'controllers/modules/core.php';
require_once 'controllers/modules/Encryption.php';
require_once 'controllers/functions.php';

session_name("PP");
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" id="theme" href="css/theme.min.css" class="" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="assets/fonts/bootstrap-icons/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/app.min.css" />

</head>

<body>
    <div class="bg-white p-0 col-sm-6 col-md-5 col-lg-3 col-xs-12 card mb-0 shadow ml-auto chatbox-container">
        <div class="h-100 d-flex flex-column">
            <div class="card-header rounded-0 pr-2 draggable">
                <!-- Title -->
                <div class="row align-items-center">
                    <div class="col">

                        <!-- Title -->
                        <h4 class="mb-1 view-type">
                            ASK
                        </h4>

                        <!-- Status -->
                        <p class="small mb-0">
                            <span class="text-success">●</span> Last seen recently
                        </p>
                    </div>
                </div>
                <div class="d-flex">
                    <button class="btn btn-circle bg-hover-primary-soft btn-md" id="expanded-box">
                        <i class="bi bi-fullscreen sz-18"></i>
                    </button>
                    <button class="btn btn-circle bg-hover-primary-soft btn-md" id="close-chat-box">
                        <i class="bi bi-x sz-24"></i>
                    </button>
                </div>
            </div>

            <div class="chat-box position-relative flex-grow-1" style="height: calc(100% - 120px);">
                <div class="chat-background bg-sohbet"></div>
                <div class="tab-content chatbox-wrapper p-0">
                    <div class="tab-pane show active fade" id="message-tab">
                        <div class="d-flex flex-column">
                            <div class="chat-log flex-grow-1 p-2">

                            </div>
                        </div>
                        <div class="card p-3 mx-3">
                            <div class="row">
                                <div class="col">

                                    <!-- Input -->
                                    <label class="sr-only">Leave your message...</label>
                                    <textarea class="form-control form-control-flush" id="message" data-toggle="autosize" rows="1" placeholder="Leave your message..." style="overflow: hidden; overflow-wrap: break-word; max-height: 100px;"></textarea>
                                </div>
                                <div class="col-auto align-self-end">
                                    <div class="text-muted mb-2">
                                        <button class="btn btn-circle bg-hover-primary-soft btn-md" id="open_emoji_panel">
                                            <i class="bi bi-emoji-smile sz-24"></i>
                                        </button>
                                        <button class="btn btn-circle bg-hover-primary-soft btn-md" id="send-msg">
                                            <i class="bi bi-telegram sz-24"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <?php if (isset($_SESSION["ed"])) {
                            ?>
                                <div class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                        <label class="custom-control-label" for="customSwitch1">Include my information</label>
                                    </div>
                                </div>

                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="feeds-tab">
                        <div class="bg-white list-group list-group-flush">
                            <div class="p-3 list-group-item">
                                <!-- Header -->
                                <div class="mb-0">
                                    <div class="row align-items-start">
                                        <div class="col-auto">

                                            <!-- Avatar -->
                                            <a href="#!" class="avatar avatar-sm">
                                                <img src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                                            </a>

                                        </div>
                                        <div class="col ml-n2 mb-0">
                                            <p>
                                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quod facere aspernatur, eius vel cumque, veniam iusto dicta deleniti, voluptatem vitae ullam aut fugiat maxime sed laborum rerum.
                                            </p>

                                            <!-- Body -->
                                            <div class="comment-body rounded-sm p-3">
                                                <p class="comment-text">
                                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nihil quis alias eum atque iure porro esse voluptatem, fuga recusandae ut. Illum, iure?
                                                </p>
                                            </div>
                                            <div class="replied-time my-1">
                                                <small class="">himanshu replie 6 day ago</small>
                                            </div>
                                            <div class="reactions">
                                                <div class="row">
                                                    <div class="col">

                                                        <!-- Reaction -->
                                                        <button class="btn btn-circle bg-hover-red-soft btn-sm">
                                                            <i class="bi bi-heart sz-18"></i>
                                                        </button>
                                                        <button class="btn btn-circle bg-hover-primary-soft btn-sm">
                                                            <i class="bi bi-chat sz-18"></i>
                                                        </button>
                                                    </div>

                                                    <div class="col-auto">
                                                        <button class="btn btn-circle bg-hover-primary-soft btn-sm">
                                                            <i class="bi bi-box-arrow-up sz-18"></i>
                                                        </button>
                                                    </div>
                                                </div> <!-- / .row -->

                                            </div>
                                        </div>
                                    </div> <!-- / .row -->

                                </div>
                            </div>
                            <div class="p-3 list-group-item">
                                <!-- Header -->
                                <div class="mb-0">
                                    <div class="row align-items-start">
                                        <div class="col-auto">

                                            <!-- Avatar -->
                                            <a href="#!" class="avatar avatar-sm">
                                                <img src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                                            </a>

                                        </div>
                                        <div class="col ml-n2 mb-0">
                                            <p>
                                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quod facere aspernatur, eius vel cumque, veniam iusto dicta deleniti, voluptatem vitae ullam aut fugiat maxime sed laborum rerum.
                                            </p>

                                            <!-- Body -->
                                            <div class="comment-body rounded-sm p-3">
                                                <p class="comment-text">
                                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nihil quis alias eum atque iure porro esse voluptatem, fuga recusandae ut. Illum, iure?
                                                </p>
                                            </div>
                                            <div class="replied-time my-1">
                                                <small class="">himanshu replie 6 day ago</small>
                                            </div>
                                            <div class="reactions">
                                                <div class="row">
                                                    <div class="col">

                                                        <!-- Reaction -->
                                                        <button class="btn btn-circle bg-hover-red-soft btn-sm">
                                                            <i class="bi bi-heart sz-18"></i>
                                                        </button>
                                                        <button class="btn btn-circle bg-hover-primary-soft btn-sm">
                                                            <i class="bi bi-chat sz-18"></i>
                                                        </button>
                                                    </div>

                                                    <div class="col-auto">
                                                        <button class="btn btn-circle bg-hover-primary-soft btn-sm">
                                                            <i class="bi bi-box-arrow-up sz-18"></i>
                                                        </button>
                                                    </div>
                                                </div> <!-- / .row -->

                                            </div>
                                        </div>
                                    </div> <!-- / .row -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <ul class="nav nav-pills justify-content-center p-2 border-top" id="pills-tab">
                <li class="nav-item">
                    <a class="nav-link rounded-pill active" data-toggle="tab" href="#message-tab">Ask</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-pill" data-toggle="tab" href="#feeds-tab">Feeds</a>
                </li>
                <li class="position-fixed" style="right:20px">
                    <button class="btn btn-circle btn-sm btn-white shadow-sm" id="scroll_chat_to_last" style="display:none; margin-right:20px">
                        <i class="bi bi-chevron-double-down sz-sm"></i>
                    </button>

                </li>
            </ul>

        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/gsap/gsap.min.js"></script>
    <script src="js/gsap/Draggable.min.js"></script>

    <script>
        $("#expanded-box").click(function() {
            $('.chatbox-container').toggleClass('chatbox-maximized');
        });
        $('.chatbox-wrapper').scroll(function() {
            console.log($('.chatbox-wrapper').scrollTop(), ($('.chat-box')[0].scrollHeight) - ($('#message-tab').outerHeight(true)));
            if ($('.chatbox-wrapper').scrollTop() < ($('.chat-box')[0].scrollHeight) - ($('#message-tab').outerHeight(true) + 100)) {
                $('#scroll_chat_to_last')[0].style["display"] = 'inline-block';
            } else {
                $('#scroll_chat_to_last')[0].style["display"] = 'none';
            }

        });
        $("#scroll_chat_to_last").click(function() {
            $(".chatbox-wrapper").animate({
                scrollTop: $(".chatbox-wrapper")[0].scrollHeight
            }, 1000);
        });
    </script>
</body>

</html>