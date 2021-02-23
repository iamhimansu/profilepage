<?php
session_name("PP");
session_start();

require_once '../../controllers/database.php';
require_once '../../controllers/modules/core.php';
require_once '../../controllers/modules/Encryption.php';
require_once '../../controllers/functions.php';

$handle = new CodeFlirt\Handlers;
$fetch = new CodeFlirt\Fetch;
$sanitize = new CodeFlirt\Sanitize;
$User = new User();

$User->isAuthenticated();

//Create a temporary array

$tmp = array();
$Likes = array();
$newLike = array();

// // Sanitize POST data
foreach ($_POST as $key => $value) {
    $tmp[$key] = $sanitize->sanitize($value, 'html', 3);
}

//Now POST data is not required 
// // Unset it
unset($_POST);

if (!isset($_SESSION["ed"])) {
    echo "<script>alert('Please login to like');</script>";
    return false;
}
if (!isset($_SESSION["PageID"])) {
    return false;
}
if (empty($tmp["feed_id"]) || $tmp["feed_id"] == "") {
    return false;
}
if (empty($tmp["reply_id"]) || $tmp["reply_id"] == "") {
    return false;
}


// Set pre assumed values in array iff all checks passed

//Set page identity
$page_id = $_SESSION["PageID"];

$owner = $_SESSION["OwnerID"];

//Set user idedntity
$from_user_id = $tmp["reply_id"];

//The message on which reply is given is
$liked_on = $tmp["feed_id"];

//Get user private key
$Auth = new User();

$to_user_id = $Auth->AuthID();

// Fetch data from database based on the above credentials

$requestMessageToLike = $fetch->data('page-anonymus-chats', 'chat_logs', "from_user_id='$from_user_id' AND to_user_id='$owner' AND page_id='$page_id'");

if ($requestMessageToLike) {
    // // Unbind Chat logs

    $unbind_chat_logs = unserialize($requestMessageToLike);

    //Search through chatlogs and find the index of replied given
    $get_liked_on = (array_search($liked_on, array_column($unbind_chat_logs, 'id')));

    //Create a time stamp for given like for later use
    $dt = new DateTime("now");
    $newLike["liked_time"] = $dt->getTimestamp();
    $newLike["like_id"] = str_shuffle(str_shuffle(md5(str_shuffle(time() . $to_user_id))));
    $newLike["liked_by"] = $to_user_id;

    //Pushing previous likes
    if (isset($unbind_chat_logs[$get_liked_on]["reactions"])) {
        foreach ($unbind_chat_logs[$get_liked_on]["reactions"] as $key => $like_details) {
            //Stores likes to array
            $Likes[$key] = $like_details;
        }
    }

    //Check if user has already liked it
    $like_exists = (array_search($to_user_id, array_column($Likes, 'liked_by')));

    if ($like_exists !== false) {
        unset($Likes[$like_exists]);
    } else {
        array_push($Likes, $newLike);
    }
    // Reindex array
    $unbind_chat_logs[$get_liked_on]["reactions"] = array_values($Likes);

    //Bind the chat logs
    $bind_chat_logs = serialize($unbind_chat_logs);

    // var_dump($unbind_chat_logs);

    //Update the chat logs
    $stmt = $dbh->prepare("UPDATE `page-anonymus-chats` SET `chat_logs` =?  WHERE `from_user_id` = '$from_user_id' AND `page_id` = '$page_id' AND to_user_id='$owner' LIMIT 1");
    $stmt->bindParam(1, $bind_chat_logs);

    //Before executing unset all
    unset($bind_chat_logs, $newLike, $Likes, $requestMessageToLike);

    //Execute the statement
    $stmt->execute();

    exit(0);
}

// var_dump($requestMessageToReply);
