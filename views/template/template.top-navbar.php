<nav class="navbar navbar-expand-md border-bottom navbar-light bg-transparent" id="topbar">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-start vw-100 d-md-flex">
            <div class="col-sm-12 col-md-6">
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control form-control-prepended form-control-appended link_page_name" placeholder="Page name">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="ml-2">
                                @<?php echo $User->Details($User->AuthID())["user_name"]; ?> /
                            </span>
                        </span>
                    </div>
                    <div class="input-group-append">
                        <div class="input-group-text py-0">
                            <button class="btn btn-sm py-0 bg-primary-soft publish_page text-primary rounded-pill mr-2" type="button">Publish</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-none d-md-block">
                <div class="page-link page-visit-link rounded" style="cursor: pointer;">
                    Enter page name to get a visiting link
                </div>
            </div>
        </div>
    </div>
</nav>