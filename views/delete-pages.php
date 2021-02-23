<?php

session_name("PP");
session_start();

require_once 'controllers/database.php';
require_once 'controllers/modules/Encryption.php';
require_once 'controllers/modules/core.php';
require_once 'controllers/functions.php';

$User = new User();
$fetch = new CodeFlirt\Fetch();
$handle = new CodeFlirt\Handlers();
$Page = new Page();

$User->isAuthenticated();
$OwnerId = $User->AuthID();
$PAGEID = $PAGE_ID; //FROM ROUTER

if ($Page->Find($PAGEID)) {
    $PageDetails = $Page->Details();
    $PAGENAME = $PageDetails["PageName"];
} else {
    echo '<meta http-equiv="refresh" content="0; url=' . $handle->path("pages") . '">';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "@$PAGENAME - Delete | ProfilePage"; ?></title>
    <link rel="stylesheet" id="theme" href="<?php echo $handle->path('css/theme.min.css') ?>" class />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?php echo $handle->path('assets/fonts/bootstrap-icons/bootstrap-icons.css') ?>" />
    <link rel="stylesheet" href="<?php echo $handle->path('css/app.min.css') ?>" />
    <link rel="stylesheet" href="<?php echo $handle->path('js/snackbar/snackbar.css') ?>" />
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-8">
                <div class="card border">
                    <div class="card-header">
                        <div class="card-header-title">
                            Are you sure you want to delete <b>/<?php echo @$PAGENAME; ?></b>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-text">
                            <ul>
                                <li>
                                    Deleting a page is an irreversible step, that means you cannot restore your page again.
                                </li>
                                <li>
                                    However you can create a new page with same name after deleting.
                                </li>
                            </ul>
                            <div class="lead m-3">

                                <?php
                                if (isset($_POST) && $_SERVER["REQUEST_METHOD"] === "POST") {
                                    //
                                    //Delete user pages from databases
                                    $stmt = $dbh->prepare("DELETE FROM `links` WHERE `page_id` = ?");
                                    //Binding parameters
                                    $stmt->bindParam(1, $PAGEID);
                                    if ($stmt->execute()) {
                                        //
                                        //Delete user pages from databases
                                        $stmt = $dbh->prepare("DELETE FROM `page-anonymus-chats` WHERE `page_id` = ?");
                                        //Binding parameters
                                        $stmt->bindParam(1, $PAGEID);
                                        if ($stmt->execute()) {

                                            //
                                            //Delete user pages from databases
                                            $stmt = $dbh->prepare("DELETE FROM `page-feedbacks` WHERE `page_id` = ?");
                                            //Binding parameters
                                            $stmt->bindParam(1, $PAGEID);
                                            if ($stmt->execute()) {

                                                //
                                                //Delete user pages from databases
                                                $stmt = $dbh->prepare("DELETE FROM `page-resopnses` WHERE `page_id` = ?");
                                                //Binding parameters
                                                $stmt->bindParam(1, $PAGEID);
                                                if ($stmt->execute()) {
                                                    //
                                                    //
                                                    //Delete user pages from databases
                                                    $stmt = $dbh->prepare("DELETE FROM `page_views` WHERE `page_id` = ?");
                                                    //Binding parameters
                                                    $stmt->bindParam(1, $PAGEID);
                                                    if ($stmt->execute()) {
                                                    }
                                                }
                                            }
                                        }
                                        echo "Page was deleted successfully";
                                    } else {
                                        echo '<meta http-equiv="refresh" content="0; url=' . $handle->path("pages") . '">';
                                    }
                                    //
                                    //
                                }
                                ?>
                            </div>
                            <form action="" method="post">
                                <div class="btn-group">
                                    <a href="<?php echo $handle->path('pages'); ?>" class="btn btn-white">No</a>
                                    <button type="submit" class="btn btn-danger" name="confirm_delete">Yes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>