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

// // Sanitize POST data
foreach ($_POST as $key => $value) {
    $tmp[$key] = $sanitize->sanitize($value);
}

//Now POST data is not required 
// // Unset it
unset($_POST);

if (!isset($_SESSION["PageID"])) {
    return false;
}

if (empty($tmp["replied"]) || $tmp["replied"] == "") {
    return false;
}
if (empty($tmp["replied_to"]) || $tmp["replied_to"] == "") {
    return false;
}
if (empty($tmp["replied_on"]) || $tmp["replied_on"] == "") {
    return false;
}

// Set pre assumed values in array iff all checks passed

//Set page identity
$page_id = $tmp["page_id"] = $_SESSION["PageID"];

//Set user idedntity
$from_user_id = $tmp["replied_to"];

//Get and store reply
$reply = $tmp["replied"];

//The message on which reply is given is
$replied_on = $tmp["replied_on"];

//Get user private key
$Auth = new User();

$to_user_id = $Auth->AuthID();
// Fetch data from database based on the above credentials

$requestMessageToReply = $fetch->data('page-anonymus-chats', 'chat_logs', "from_user_id='$from_user_id' AND to_user_id='$to_user_id' AND page_id='$page_id'");

if ($requestMessageToReply) {
    // // Unbind Chat logs
    $unbind_chat_logs = unserialize($requestMessageToReply);

    //Search through chatlogs and find the index of replied given
    $get_replied_on = (array_search($replied_on, array_column($unbind_chat_logs, 'id')));

    // Update reply 

    //cretae unique reply id
    $dt = new DateTime("now");
    $unbind_chat_logs[$get_replied_on]["reply_time"] = $dt->getTimestamp();
    $unbind_chat_logs[$get_replied_on]["reply_id"] = str_shuffle(md5(time()));

    $unbind_chat_logs[$get_replied_on]["reply"] = $reply;

    //Bind the chat logs

    $bind_chat_logs = serialize($unbind_chat_logs);

    //Update the chat logs
    $stmt = $dbh->prepare("UPDATE `page-anonymus-chats` SET `chat_logs` =?  WHERE `from_user_id` = '$from_user_id' AND `page_id` = '$page_id' AND to_user_id='$to_user_id' LIMIT 1");
    $stmt->bindParam(1, $bind_chat_logs);

    //Before executing unset all
    unset($bind_chat_logs);

    //Execute the statement
    $stmt->execute();
    var_dump($page_id, $from_user_id, $to_user_id);
}

// var_dump($requestMessageToReply);
