<?php

// Load modules
require_once 'controllers/database.php';
require_once 'controllers/modules/core.php';
require_once 'controllers/modules/Encryption.php';

//Pre assumed flags
//page exists in database = false 
$page_existance = false;

$page = '';

// Start codeflirt
$fetch = new CodeFlirt\Fetch;
$handle = new CodeFlirt\Handlers;
$Encryption = new Encryption();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" id="theme" href="<?php echo $handle->path('css/theme.min.css') ?>" class="" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="<?php echo $handle->path('assets/fonts/bootstrap-icons/bootstrap-icons.css') ?>" />
    <link rel="stylesheet" href="<?php echo $handle->path('css/app.min.css') ?>" />


</head>

<body>
    <div class="">
        <div class="header">

            <!-- Image -->
            <img src="assets/img/covers/profile-cover-1.jpg" class="header-img-top" alt="...">

            <div class="container-fluid">

                <!-- Body -->
                <div class="header-body mt-n5 mt-md-n6">
                    <div class="row align-items-end">
                        <div class="col-auto">

                            <!-- Avatar -->
                            <div class="avatar avatar-xxl header-avatar-top">
                                <img src="assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle border border-4 border-body">
                            </div>

                        </div>
                        <div class="col mb-3 ml-n3 ml-md-n2">

                            <!-- Pretitle -->
                            <h6 class="header-pretitle">
                                Members
                            </h6>

                            <!-- Title -->
                            <h1 class="header-title">
                                Dianna Smiley
                            </h1>

                        </div>
                        <div class="col-12 col-md-auto mt-2 mt-md-0 mb-md-3">

                            <!-- Button -->
                            <a href="#!" class="btn btn-primary d-block d-md-inline-block lift">
                                Subscribe
                            </a>

                        </div>
                    </div> <!-- / .row -->
                    <div class="row align-items-center">
                        <div class="col">

                            <!-- Nav -->
                            <ul class="nav nav-tabs nav-overflow header-tabs">
                                <li class="nav-item">
                                    <a href="profile-posts.html" class="nav-link active">
                                        Links
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="profile-groups.html" class="nav-link">
                                        Groups
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="profile-projects.html" class="nav-link">
                                        Projects
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="profile-files.html" class="nav-link">
                                        Files
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="profile-subscribers.html" class="nav-link">
                                        Subscribers
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div> <!-- / .header-body -->

            </div>
        </div>

    </div>
</body>

</html>