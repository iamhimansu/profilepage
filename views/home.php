<?php

//Require controllers
require_once 'controllers/database.php';
require_once 'controllers/modules/Encryption.php';
require_once 'controllers/modules/core.php';
require_once 'controllers/functions.php';

$User = new User();
$handle = new CodeFlirt\Handlers;
$handle->trackUser();

session_name("PP");
session_start();

$User->isAuthenticated();

$timezones = require_once 'controllers/modules/timezones.php';

$CurrentPage = "home";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Home</title>
  <link rel="stylesheet" id="theme" href="<?php echo $handle->path('css/theme.min.css') ?>" class="">
  <link rel="stylesheet" href="<?php echo $handle->path('css/app.min.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="<?php echo $handle->path('assets/fonts/bootstrap-icons/bootstrap-icons.css') ?>">
  <link rel="stylesheet" href="<?php echo $handle->path('js/snackbar/snackbar.css') ?>">
  <link href="<?php echo $handle->path('assets/plugins/selectjs/css/select2.min.css') ?>" rel="stylesheet">
</head>

<body> <?php
        // include navbar
        include 'template/template.side-navbar.php';
        include 'template/template.bottom-navbar.php';
        ?>
  <div class="modal" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body p-2">
          <div><img id="image" src="./assets/img/covers/auth-side-cover.jpg"></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> <button type="button" class="btn btn-primary">Understood</button></div>
      </div>
    </div>
  </div>
  <div class="main-content">
    <?php
    include 'template/template.top-navbar.php';
    ?>
    <div class="quick-preview bg-primary-soft text-primary sticky-top p-3 w-100 d-md-none">
      <div class="page-visit-link">Enter page name to get a visiting link</div>
    </div><!-- Publish page -->
    <!-- Modal -->
    <div class="modal animate__animated animate__zoomIn animate__faster p-0" id="publish_page" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="publish_page" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row no-gutters">
              <div class="col-md-4">
                <div class="justify-content-center">
                  <div class="position-absolute w-100 h-75">
                    <div class="d-flex w-100 h-100 justify-content-center align-items-center">
                      <div class="text-center p-2 rounded-circle bg-white" style="width:50px;height:50px"><i class="bi bi-whatsapp sz-24"></i></div>
                    </div>
                  </div>
                  <div class="page_qrcode"></div>
                  <h2 class="text-center">Scan me</h2>
                </div>
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h2 class="card-title">Page published at</h2>
                  <p class="card-text"><a href="http://localhost/profilepage/@Himanshu/klop">http://localhost/profilepage/@Himanshu/klop</a></p>
                  <p class="card-text"></p>
                  <div class="custom-control custom-switch m-0"><input type="checkbox" class="custom-control-input enable_secured_page" id="enable_secured_page" title="Secure page" value="enable_security"> <label class="custom-control-label" for="enable_secured_page">Password protected<br></label></div>
                  <div class="page_secured">To get instant access to my link use passcode : <?php echo $handle->split($handle->generate_token('alphanumeric', 12), '-', 4); ?> </div><button type="button" class="btn bg-white rounded-pill shadow-none border-light" data-dismiss="modal">Save</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-9 link_container my-4">
          <div class="card-body p-0 mb-4">
            <div class="">
              <div class="row align-items-center">
                <div class="col-md-auto col-sm-12">
                  <!-- Heading --> <button type="button" class="btn btn-white shadow-sm p-3 btn-block"><i class="bi bi-plus-circle-dotted sz-24"></i> <span class="h2 px-3">Add a new link
                      <!-- Badge --> <a class="add_new_link stretched-link" href="javascript:void(0)"></a>
                    </span><span class="badge badge-soft-primary ml-2 count_links rounded-pill">1</span></button>
                </div>
                <div class="col">
                  <div class="card p-2 mb-0 shadow-sm">
                    <div class="input-group"><input type="search" placeholder="Filter links... *Beta version" class="form-control search" id="filter-links">
                      <div class="input-group-append"><button type="button" class="btn btn-sm btn-white" id="sort-asc" title="Sort by ascending"><i class="bi bi-sort-alpha-up sz-18"></i></button> <button type="button" class="btn btn-sm btn-white" id="sort-desc" title="Sort by descending"><i class="bi bi-sort-alpha-down sz-18"></i></button> <button type="button" class="btn btn-sm btn-white" id="reset-sorting" title="Remove sorting"><i class="bi bi-sort-up-alt sz-18"></i></button></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <form class="send-request link_lists" id="send-request">
            <div class="blocks list">
              <div class="block mb-2" id="link_0">
                <div class="reorder-links">
                  <div class="card mb-0 rounded-xl">
                    <div class="card-body p-3 block-inputs">
                      <div class="row">
                        <div class="col-auto align-self-center p-0 h-100 d-none d-sm-block"><i class="bi bi-grip-vertical"></i></div>
                        <div class="col-auto align-self-center px-2 d-block d-sm-none" style="height:94px">
                          <div class="btn-group-vertical h-100"><button type="button" class="btn btn-white p-0 move-up"><i class="bi bi-chevron-up"></i></button> <button type="button" class="btn btn-white p-0 move-down"><i class="bi bi-chevron-down"></i></button></div>
                        </div>
                        <div class="col-auto pl-0">
                          <div class="d-flex flex-column justify-content-center align-items-center">
                            <div class="avatar avatar-md">
                              <div class="avatar-title font-size-lg bg-primary-soft rounded-circle text-primary rounded-pill mr-2 domain-icon" ref-icon="link_0"><i class="bi bi-link sz-24"></i></div><input type="file" class="d-none custom_domain_icon" name="link_0[custom_icon]">
                            </div>
                          </div>
                          <div class="custom-control custom-switch align-self-end mt-3"><input type="checkbox" class="custom-control-input toggle_thumbnail" id="thumbnail_toggle_0" title="Remove thumbnail" checked> <label class="custom-control-label" for="thumbnail_toggle_0"></label></div>
                        </div>
                        <div class="col ml-n3">
                          <!-- Input -->
                          <div class="input-group input-group-merge"><input type="text" class="form-control form-control-flush form-control-auto block_title" value="" placeholder="Title" id="link_title_0" name="link_0[link_title]">
                            <div class="input-group-prepend">
                              <div class="input-group-text bg-transparent p-0 px-1 border-0"><i class="bi bi-type sz-18"></i></div>
                            </div>
                          </div>
                          <div class="input-group input-group-merge mt-2"><input type="url" class="form-control form-control-flush form-control-auto link_box block_domain" value="" placeholder="Page url" id="link_address_0" name="link_0[link_address]">
                            <div class="input-group-prepend">
                              <div class="input-group-text bg-transparent p-0 px-1 border-0"><i class="bi bi-link-45deg sz-18"></i></div>
                            </div>
                          </div>
                          <div class="medium-screen-setting-menu d-none d-md-block mt-2">
                            <div class="d-flex">
                              <div class="dropdown rounded-pill mr-2 bg-primary-soft priority_link_container"><button type="button" class="btn btn-sm text-primary dropdown-toggle" data-toggle="dropdown" ref-animation-effect="headShake"><i class="bi bi-asterisk sz-sm"></i> <span class="priority_link">Priority</span></button>
                                <div class="dropdown-menu position-absolute" style="z-index:999">
                                  <h6 class="dropdown-header animation_list">Choose animations</h6><a class="dropdown-item anim_type" ref-effect="none" href="javascript:void(0)"><i class="bi bi-bezier2"></i> None</a> <a class="dropdown-item anim_type" ref-effect="headShake" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Default</a> <a class="dropdown-item anim_type" ref-effect="bounce" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Bounce</a> <a class="dropdown-item anim_type" ref-effect="flash" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Flash</a> <a class="dropdown-item anim_type" ref-effect="pulse" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Pulse</a> <a class="dropdown-item anim_type" ref-effect="rubberBand" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Rubberband</a> <a class="dropdown-item anim_type" ref-effect="shakeX" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Shake X</a> <a class="dropdown-item anim_type" ref-effect="shakeY" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Shake Y</a> <a class="dropdown-item anim_type" ref-effect="jello" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Jello</a> <a class="dropdown-item anim_type" ref-effect="tada" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Tada</a>
                                </div>
                              </div><button type="button" class="btn btn-sm bg-primary-soft text-primary rounded-pill mr-2 schedule_link">Schedule</button> <button type="button" class="btn btn-sm bg-primary-soft text-primary rounded-pill mr-2 forward_link">Leap</button> <button type="button" class="btn btn-sm btn-white rounded-pill disableBlock">Disable</button>
                            </div>
                          </div>
                          <div class="small-screen-setting-menu mt-2 d-flex d-block d-md-none">
                            <div class="dropdown rounded-pill mr-2 bg-primary-soft priority_link_container"><button type="button" class="btn btn-sm text-primary dropdown-toggle" data-toggle="dropdown" ref-animation-effect="headShake"><span class="priority_link">Priority</span></button>
                              <div class="dropdown-menu position-absolute" style="z-index:999">
                                <h6 class="dropdown-header animation_list">Choose animations</h6><a class="dropdown-item anim_type" ref-effect="none" href="javascript:void(0)"><i class="bi bi-bezier2"></i> None</a> <a class="dropdown-item anim_type" ref-effect="headShake" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Default</a> <a class="dropdown-item anim_type" ref-effect="bounce" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Bounce</a> <a class="dropdown-item anim_type" ref-effect="flash" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Flash</a> <a class="dropdown-item anim_type" ref-effect="pulse" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Pulse</a> <a class="dropdown-item anim_type" ref-effect="rubberBand" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Rubberband</a> <a class="dropdown-item anim_type" ref-effect="shakeX" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Shake X</a> <a class="dropdown-item anim_type" ref-effect="shakeY" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Shake Y</a> <a class="dropdown-item anim_type" ref-effect="jello" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Jello</a> <a class="dropdown-item anim_type" ref-effect="tada" href="javascript:void(0)"><i class="bi bi-bezier2"></i> Tada</a>
                              </div>
                            </div>
                            <div class="dropdown"><a class="btn btn-white dropdown-toggle btn-sm rounded-pill" href="javascript:void(0)" data-toggle="dropdown">Settings</a>
                              <div class="dropdown-menu">
                                <h6 class="dropdown-header">Select options</h6><a class="dropdown-item schedule_link" href="javascript:void(0)"><i class="mr-2 bi bi-calendar3-range"></i> Schedule link</a> <a class="dropdown-item forward_link" href="javascript:void(0)"><i class="mr-2 bi bi-arrow-return-right"></i> Leap</a> <a class="dropdown-item" href="javascript:void(0)"><i class="mr-2 bi bi-slash-circle"></i> <span class="disableBlock">Disable</span></a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-auto align-self-start">
                          <div class="text-muted"><button class="btn btn-sm btn-white-soft outline-none removeBlock" type="button"><i class="bi bi-x-circle sz-18"></i></button></div>
                        </div>
                      </div>
                      <div class="link-media-preview"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="col-md-3 justify-content-center ml-n3">
          <div class="right_panel sticky-top vh-100 border-left pl-3" style="z-index:inherit">
            <div class="row align-items-end">
              <div class="col">
                <ul class="nav nav-tabs justify-content-center mb-3" role="tablist">
                  <li class="nav-item"><a class="nav-link active py-3" id="layouts-tab" data-toggle="tab" href="#layouts"><i class="bi bi-layout-text-window-reverse"></i> Layouts</a></li>
                  <li class="nav-item text-small"><a class="nav-link py-3" id="profile-tab" data-toggle="tab" href="#profile"><i class="bi bi-eye-fill"></i> Preview</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="layouts" role="tabpanel" aria-labelledby="layouts-tab">
                    <div class="d-flex align-content-stretch flex-wrap">
                      <div class="card mb-3 col-md-12 layout-form"><a href="javascript:void(0)" class="stretched-link information_collector"></a>
                        <div class="p-3">
                          <div class="row align-items-center">
                            <div class="col">
                              <!-- Title -->
                              <h6 class="text-uppercase text-muted mb-2">Store data by adding</h6><!-- Heading --> <span class="h2 mb-0">Form</span>
                            </div>
                            <div class="col-auto">
                              <!-- Icon -->
                              <div class="avatar"><span class="avatar-title rounded-circle bg-primary-soft text-primary"><i class="bi bi-input-cursor-text sz-18"></i></span></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card col-md-12 mb-3 layout-feedback"><a href="javascript:void(0)" class="stretched-link feedback_collector"></a>
                        <div class="p-3">
                          <div class="row align-items-center">
                            <div class="col">
                              <!-- Title -->
                              <h6 class="text-uppercase text-muted mb-2">Know opinion's with</h6><!-- Heading --> <span class="h2 mb-0">Feedback</span>
                            </div>
                            <div class="col-auto">
                              <!-- Icon -->
                              <div class="avatar"><span class="avatar-title rounded-circle bg-primary-soft text-primary"><i class="bi bi-card-text sz-18"></i></span></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card col-md-12 layout-anonymus"><a href="javascript:void(0)" class="stretched-link chat_anonymously"></a>
                        <div class="p-3">
                          <div class="row align-items-center">
                            <div class="col">
                              <!-- Title -->
                              <h6 class="text-uppercase text-muted mb-2">Let people talk to you</h6><!-- Heading --> <span class="h2 mb-0">Anonymously</span>
                            </div>
                            <div class="col-auto">
                              <!-- Icon -->
                              <div class="avatar"><span class="avatar-title rounded-circle bg-primary-soft text-primary"><i class="bi bi-chat-square sz-18"></i></span></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="smartphone">
                      <div class="content bg-white-soft">
                        <div class="row justify-content-center">
                          <div class="col-12">
                            <div class="card-body text-center mb-0">
                              <div class="avatar avatar-xl mb-4 mx-auto">
                                <div class="avatar-title font-size-xxl bg-primary-soft rounded-circle text-primary rounded-pill mr-2"><img src="<?php echo $handle->path($User->photos($User->Details($User->AuthID()))); ?>" class="avatar-img rounded-circle img-thumbnail"></div>
                              </div>
                              <p class="h2"><?php echo $User->Details($User->AuthID())["user_name"]; ?></p><small><i class="d-md-block d-none"><small>Use CTRL + Q</small></i><br><i>Please note: this is just a reference view, actual page might look different</i></small>
                            </div>
                            <div class="live_preview p-2"></div>
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
      </div>
    </div>
  </div><!-- Basic libraries-->
  <script src="<?php echo $handle->path('js/jquery.min.js') ?>"></script>
  <script src="<?php echo $handle->path('js/jquery-ui.js') ?>"></script>
  <script src="<?php echo $handle->path('js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?php echo $handle->path('js/axios/axios.min.js') ?>"></script>
  <script src="<?php echo $handle->path('assets/plugins/selectjs/js/select2.min.js') ?>"></script>
  <script src="<?php echo $handle->path('js/snackbar/snackbar.min.js') ?>"></script>
  <script src="<?php echo $handle->path('js/serializeControls.js') ?>"></script>
  <script src="<?php echo $handle->path('js/listjs/list.min.js') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="<?php echo $handle->path('js/link.development.js') ?>"></script>
  <!--End libraries-->
  <script>
    Links();
  </script>
</body>

</html>