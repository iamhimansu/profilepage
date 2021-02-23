<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" id="theme" href="http://localhost/ProfilePage/css/theme.min.css" class="" />
    <link rel="stylesheet" href="http://localhost/ProfilePage/css/app.min.css" />
    <link rel="stylesheet" href="http://localhost/ProfilePage/assets/fonts/bootstrap-icons/bootstrap-icons.css" />
</head>
<style>
    .custom-scroll::-webkit-scrollbar {
        width: 2px;
    }

    .custom-scroll::-webkit-scrollbar-thumb {
        background-color: #000;
    }
</style>

<body>
    <?php
    //Require controllers
    require_once 'controllers/database.php';
    require_once 'controllers/modules/Encryption.php';
    require_once 'controllers/modules/core.php';

    $handle = new CodeFlirt\Handlers;
    $fetch = new CodeFlirt\Fetch;
    include 'template/template.side-navbar.php';
    ?>
    <div class="main-content" style="overflow: hidden;">
        <div class="container-fluid my-0 py-0" style="padding:15px !important;">
            <div class="row list">
                <div class="col-md-7 col-lg">
                    <div class="card mb-3 rounded-xl">
                        <div class="row no-gutters">
                            <div class="col-4 px-0">
                                <ul class="nav nav-tabs nav-overflow px-3" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Anonymus</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Personal</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Filtered</a>
                                    </li>
                                </ul>
                                <div class="bg-white rounded-bottom p-2 mb-0">
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
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active custom-scroll" id="home" role="tabpanel" aria-labelledby="home-tab" style="height:calc(100vh - 150px);max-height: calc(100vh - 150px);overflow-y:scroll; overflow-x:hidden">
                                        <div class="p-3">
                                            <div class="list-group list-group-flush my-n3">
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">

                                                            <!-- Avatar -->
                                                            <a href="profile-posts.html" class="avatar">
                                                                <img src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                                                            </a>

                                                        </div>
                                                        <div class="col ml-n2">

                                                            <!-- Title -->
                                                            <h4 class="mb-1">
                                                                <a href="profile-posts.html">Dianna Smiley</a>
                                                            </h4>

                                                            <!-- Status -->
                                                            <p class="small mb-0">
                                                                <span class="text-success">●</span> Online
                                                            </p>

                                                        </div>
                                                        <div class="col-auto">

                                                            <!-- Button -->
                                                            <a href="#!" class="btn btn-sm btn-white">
                                                                Reply
                                                            </a>

                                                        </div>
                                                    </div> <!-- / .row -->
                                                </div>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">

                                                            <!-- Avatar -->
                                                            <a href="profile-posts.html" class="avatar">
                                                                <img src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                                                            </a>

                                                        </div>
                                                        <div class="col ml-n2">

                                                            <!-- Title -->
                                                            <h4 class="mb-1">
                                                                <a href="profile-posts.html">Dianna Smiley</a>
                                                            </h4>

                                                            <!-- Status -->
                                                            <p class="small mb-0">
                                                                <span class="text-success">●</span> Online
                                                            </p>

                                                        </div>
                                                        <div class="col-auto">

                                                            <!-- Button -->
                                                            <a href="#!" class="btn btn-sm btn-white">
                                                                Reply
                                                            </a>

                                                        </div>
                                                    </div> <!-- / .row -->
                                                </div>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">

                                                            <!-- Avatar -->
                                                            <a href="profile-posts.html" class="avatar">
                                                                <img src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                                                            </a>

                                                        </div>
                                                        <div class="col ml-n2">

                                                            <!-- Title -->
                                                            <h4 class="mb-1">
                                                                <a href="profile-posts.html">Dianna Smiley</a>
                                                            </h4>

                                                            <!-- Status -->
                                                            <p class="small mb-0">
                                                                <span class="text-success">●</span> Online
                                                            </p>

                                                        </div>
                                                        <div class="col-auto">

                                                            <!-- Button -->
                                                            <a href="#!" class="btn btn-sm btn-white">
                                                                Reply
                                                            </a>

                                                        </div>
                                                    </div> <!-- / .row -->
                                                </div>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">

                                                            <!-- Avatar -->
                                                            <a href="profile-posts.html" class="avatar">
                                                                <img src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                                                            </a>

                                                        </div>
                                                        <div class="col ml-n2">

                                                            <!-- Title -->
                                                            <h4 class="mb-1">
                                                                <a href="profile-posts.html">Dianna Smiley</a>
                                                            </h4>

                                                            <!-- Status -->
                                                            <p class="small mb-0">
                                                                <span class="text-success">●</span> Online
                                                            </p>

                                                        </div>
                                                        <div class="col-auto">

                                                            <!-- Button -->
                                                            <a href="#!" class="btn btn-sm btn-white">
                                                                Reply
                                                            </a>

                                                        </div>
                                                    </div> <!-- / .row -->
                                                </div>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">

                                                            <!-- Avatar -->
                                                            <a href="profile-posts.html" class="avatar">
                                                                <img src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                                                            </a>

                                                        </div>
                                                        <div class="col ml-n2">

                                                            <!-- Title -->
                                                            <h4 class="mb-1">
                                                                <a href="profile-posts.html">Dianna Smiley</a>
                                                            </h4>

                                                            <!-- Status -->
                                                            <p class="small mb-0">
                                                                <span class="text-success">●</span> Online
                                                            </p>

                                                        </div>
                                                        <div class="col-auto">

                                                            <!-- Button -->
                                                            <a href="#!" class="btn btn-sm btn-white">
                                                                Reply
                                                            </a>

                                                        </div>
                                                    </div> <!-- / .row -->
                                                </div>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">

                                                            <!-- Avatar -->
                                                            <a href="profile-posts.html" class="avatar">
                                                                <img src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                                                            </a>

                                                        </div>
                                                        <div class="col ml-n2">

                                                            <!-- Title -->
                                                            <h4 class="mb-1">
                                                                <a href="profile-posts.html">Dianna Smiley</a>
                                                            </h4>

                                                            <!-- Status -->
                                                            <p class="small mb-0">
                                                                <span class="text-success">●</span> Online
                                                            </p>

                                                        </div>
                                                        <div class="col-auto">

                                                            <!-- Button -->
                                                            <a href="#!" class="btn btn-sm btn-white">
                                                                Reply
                                                            </a>

                                                        </div>
                                                    </div> <!-- / .row -->
                                                </div>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">

                                                            <!-- Avatar -->
                                                            <a href="profile-posts.html" class="avatar">
                                                                <img src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                                                            </a>

                                                        </div>
                                                        <div class="col ml-n2">

                                                            <!-- Title -->
                                                            <h4 class="mb-1">
                                                                <a href="profile-posts.html">Dianna Smiley</a>
                                                            </h4>

                                                            <!-- Status -->
                                                            <p class="small mb-0">
                                                                <span class="text-success">●</span> Online
                                                            </p>

                                                        </div>
                                                        <div class="col-auto">

                                                            <!-- Button -->
                                                            <a href="#!" class="btn btn-sm btn-white">
                                                                Reply
                                                            </a>

                                                        </div>
                                                    </div> <!-- / .row -->
                                                </div>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">

                                                            <!-- Avatar -->
                                                            <a href="profile-posts.html" class="avatar">
                                                                <img src="assets/img/avatars/profiles/avatar-2.jpg" alt="..." class="avatar-img rounded-circle">
                                                            </a>

                                                        </div>
                                                        <div class="col ml-n2">

                                                            <!-- Title -->
                                                            <h4 class="mb-1">
                                                                <a href="profile-posts.html">Ab Hadley</a>
                                                            </h4>

                                                            <!-- Status -->
                                                            <p class="small mb-0">
                                                                <span class="text-success">●</span> Online
                                                            </p>

                                                        </div>
                                                        <div class="col-auto">

                                                            <!-- Button -->
                                                            <a href="#!" class="btn btn-sm btn-white">
                                                                Reply
                                                            </a>

                                                        </div>
                                                    </div> <!-- / .row -->
                                                </div>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">

                                                            <!-- Avatar -->
                                                            <a href="profile-posts.html" class="avatar">
                                                                <img src="assets/img/avatars/profiles/avatar-3.jpg" alt="..." class="avatar-img rounded-circle">
                                                            </a>

                                                        </div>
                                                        <div class="col ml-n2">

                                                            <!-- Title -->
                                                            <h4 class="mb-1">
                                                                <a href="profile-posts.html">Adolfo Hess</a>
                                                            </h4>

                                                            <!-- Status -->
                                                            <p class="small mb-0">
                                                                <span class="text-danger">●</span> Offline
                                                            </p>

                                                        </div>
                                                        <div class="col-auto">

                                                            <!-- Button -->
                                                            <a href="#!" class="btn btn-sm btn-white">
                                                                Reply
                                                            </a>

                                                        </div>
                                                    </div> <!-- / .row -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        ...</div>
                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                        ...</div>
                                </div>
                            </div>
                            <div class="col border-left">
                                <div class="p-2">
                                    <div class="progress mx-3 animate__animated animate__fadeIn" style="height: 5px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                                    </div>
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias molestias quas quis
                                    cumque
                                    quod voluptatum quia quam deserunt? Maiores optio cupiditate excepturi qui ut sed
                                    asperiores
                                    est, praesentium eos atque.
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-md-5 col-lg-3">
                    <!-- Card -->
                    <div class="card mb-0">
                        <div class="bg-white list-group list-group-flush custom-scroll" style="max-height: calc(100vh - 140px); overflow-y:scroll">
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
        </div>
    </div>
    <!-- Basic libraries-->
    <script src="<?php echo $handle->path('js/jquery.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/jquery-ui.js') ?>"></script>
    <script src="<?php echo $handle->path('js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/axios/axios.min.js') ?>"></script>
    <script src="<?php echo $handle->path('assets/plugins/selectjs/js/select2.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/snackbar/snackbar.min.js') ?>"></script>
    <script src="<?php echo $handle->path('js/serializeControls.js') ?>"></script>
    <script src="<?php echo $handle->path('js/listjs/list.min.js') ?>"></script>

</body>

</html>