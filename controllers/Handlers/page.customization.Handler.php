<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../modules/core.php';
require_once __DIR__ . '/../modules/Encryption.php';
require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/../modules/class.image.upload.php';

session_name("PP");
session_start();

$fetch = new CodeFlirt\Fetch;
$sanitize = new CodeFlirt\Sanitize;
$Encryption = new Encryption();

$User = new User();
$User->isAuthenticated();

$__tmp = array();
$update = array();

$currentDate  = new DateTime("now");
$folderName = $currentDate->format('d-m-Y');

//Push every data in temporary array
//Sanitize it
foreach ($_POST as $key => $value) {
    $__tmp[$key] = $sanitize->sanitize($value);
}
//No need of post data
unset($_POST);

if (count($__tmp) === 0) {
    return false;
}
if (isset($__tmp["page_bg_color"])) {
    $update["background-color"] = $__tmp["page_bg_color"];
}
if (isset($__tmp["page_fore_color"])) {
    $update["foreground-color"] = $__tmp["page_fore_color"];
}
if (isset($__tmp["page_font_color"])) {
    $update["font-color"] = $__tmp["page_font_color"];
}
if (isset($__tmp["page_image"])) {
    $update["page-image"] = $__tmp["page_image"];
}
if (isset($__tmp["page_bg_image"])) {
    $update["background-image"] = $__tmp["page_bg_image"];
}
if (isset($__tmp["page_transparency_level"])) {
    $update["section-transparency"] = $__tmp["page_transparency_level"];
}
if (isset($__tmp["background_attachment"])) {
    if ($__tmp["background_attachment"] === "fixed") {
        $update["background-attachment"] = $__tmp["background_attachment"];
    } else {
        $update["background-attachment"] = "absolute";
    }
}

if (count($update) > 0) {
    //Update user data
    $userID = $User->AuthID();
    $page_id = $_SESSION["PageID"];

    // mOVE UPOLOADED FILE
    if (isset($update["page-image"]) && !empty($update["page-image"])) {
        $upload = new Upload($update["page-image"]);
        $upload->target_directory = "../../usr/uploads/$folderName";
        $upload->overwrite = true;
        $upload->filename = "page-image-" . $page_id . "";
        $upload->process();
        if ($upload->success) {
            unset($update["page-image"]);
            $update["page-image"] = "usr/uploads/$folderName/$upload->fullname";
        }
    }
    // mOVE UPOLOADED FILE
    if (isset($update["background-image"]) && !empty($update["background-image"])) {
        $upload = new Upload($update["background-image"]);
        $upload->target_directory = "../../usr/uploads/$folderName";
        $upload->overwrite = true;
        $upload->filename = "background-image-" . $page_id . "";
        $upload->process();
        if ($upload->success) {
            unset($update["background-image"]);
            $update["background-image"] = "usr/uploads/$folderName/$upload->fullname";
        }
    }
    //Push user data
    $OldLinkConfigs = json_decode($fetch->data("links", "link_configs", "page_id = '$page_id' AND user_id = '$userID'"), true);
    if (isset($OldLinkConfigs) && count($OldLinkConfigs) > 0) {
        foreach ($update as $key => $value) {
            $OldLinkConfigs["page_configs"][$key] = $value;
        }
    } else {
        $OldLinkConfigs["page_configs"] = $update;
    }
    $updatedLinksConfigs = json_encode($OldLinkConfigs);
    // //Update user data in database
    $stmt = $dbh->prepare("UPDATE `links` SET `link_configs` = ?  WHERE `page_id` = ? AND `user_id` = ? LIMIT 1");

    //
    $stmt->bindParam(1, $updatedLinksConfigs);
    $stmt->bindParam(2, $page_id);
    $stmt->bindParam(3, $userID);

    //If Databse is updated
    //Stop execution

    if ($stmt->execute()) {
        exit;
    }
} else {

    return;
}
return;
