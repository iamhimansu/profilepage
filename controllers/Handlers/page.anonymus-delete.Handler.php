<?php
require_once '../../controllers/database.php';
require_once '../../controllers/modules/core.php';
require_once '../../controllers/modules/Encryption.php';
require_once '../../controllers/functions.php';

$handle = new CodeFlirt\Handlers;
$fetch = new CodeFlirt\Fetch;
$sanitize = new CodeFlirt\Sanitize;

session_name("PP");
session_start();

//Create a temporary array

$tmp = array();

// // Sanitize POST data
foreach ($_POST as $key => $value) {
    $tmp[$key] = $sanitize->sanitize($value, 'html', 3);
}

//Now POST data is not required 
// // Unset it
unset($_POST);

if (!isset($_SESSION["ed"])) {
    return false;
}
if (!isset($_SESSION["page_visit"])) {
    return false;
}
if (empty($tmp["trace_logs"]) || $tmp["trace_logs"] == "") {
    return false;
}
if (empty($tmp["message_from"]) || $tmp["message_from"] == "") {
    return false;
}
// Set pre assumed values in array iff all checks passed

//Set page identity
$page_id = $tmp["page_id"] = $_SESSION["page_visit"];

//Set user idedntity
$from_user_id = $tmp["message_from"];

//Get and store reply
$delete_id = $tmp["trace_logs"];

//Get user private key
$Auth = new User();

$to_user_id = $Auth->AuthID();

// Fetch data from database based on the above credentials

$requestMessageToDelete = $fetch->data('page-anonymus-chats', 'chat_logs', "from_user_id='$from_user_id' AND to_user_id='$to_user_id' AND page_id='$page_id'");

if ($requestMessageToDelete) {
    // // Unbind Chat logs
    $unbind_chat_logs = unserialize($requestMessageToDelete);

    //Search through chatlogs and find the index of replied given
    $get_delete_key = (array_search($delete_id, array_column($unbind_chat_logs, 'id')));

    // Update reply 

    //Bind the chat logs

    unset($unbind_chat_logs[$get_delete_key]);

    if (count($unbind_chat_logs) == 0) {
        $stmt = $dbh->prepare("DELETE FROM `page-anonymus-chats` WHERE `from_user_id` = '$from_user_id' AND `page_id` = '$page_id' AND to_user_id='$to_user_id'");
    } else {
        $bind_chat_logs = serialize($unbind_chat_logs);

        //Update the chat logs
        $stmt = $dbh->prepare("UPDATE `page-anonymus-chats` SET `chat_logs` =?  WHERE `from_user_id` = '$from_user_id' AND `page_id` = '$page_id' AND to_user_id='$to_user_id' LIMIT 1");
        $stmt->bindParam(1, $bind_chat_logs);
    }

    //Before executing unset all
    unset($bind_chat_logs);

    //Execute the statement
    $stmt->execute();
}

// var_dump($requestMessageToDelete);
