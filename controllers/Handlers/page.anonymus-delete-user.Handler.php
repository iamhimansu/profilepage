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
if (empty($tmp["delete_user"]) || $tmp["delete_user"] == "") {
    return false;
}
// Set pre assumed values in array iff all checks passed

//Set page identity
$page_id = $tmp["page_id"] = $_SESSION["page_visit"];

$from_user_id = $tmp["delete_user"];

//Get user private key
$Auth = new User();

$to_user_id = $Auth->AuthID();

//Update the chat logs
$stmt = $dbh->prepare("DELETE FROM `page-anonymus-chats` WHERE `from_user_id` = '$from_user_id' AND `page_id` = '$page_id' AND to_user_id='$to_user_id'");

//Execute the statement
$stmt->execute();


// var_dump($requestMessageToDelete);
