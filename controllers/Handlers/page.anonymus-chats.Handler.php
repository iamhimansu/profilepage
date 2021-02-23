<?php
//TODOS: Fix from ip address
require_once '../../controllers/database.php';
require_once '../../controllers/modules/core.php';
require_once '../../controllers/modules/Encryption.php';

$handle = new CodeFlirt\Handlers;
$fetch = new CodeFlirt\Fetch;
$sanitize = new CodeFlirt\Sanitize;

session_name("PP");
session_start();

$page_id = @$_POST['page_name'];

$to_user_id = $fetch->data('links', 'user_id', "page_id = '$page_id'");

unset($_POST['page_name']);

$_POST['time'] = strtotime("now");
$_POST['id'] = str_shuffle(md5(time()));

$chat_logs = [];

$chat_data = array();

foreach ($_POST as $key => $value) {

  $key = $sanitize->sanitize($key);
  $value = htmlentities(htmlspecialchars($value));
  $chat_data[$key] = ($value);
  unset($value);
}

unset($_POST);

//f.u.i => From user id
if (@$chat_data["is_anonymus"] === '0') {

  if (isset($_SESSION["ed"]) && !empty($_SESSION["ed"])) {
    $Encryption = new Encryption();

    $user_public_key = $_SESSION["ed"];

    $user_email_address = $Encryption->decrypt($user_public_key, "_ProfilePage_");

    $user_private_key = $fetch->data('users', 'user_private_key', "user_email_address='$user_email_address'");

    $_SESSION["f.u.i"]  = $from_user_id  = "PRSL-" . $user_private_key;
  } else {

    //Something is not right 
    // Redirect to logout page
?>
    <meta http-equiv="refresh" content="0; url=logout">
<?php
    exit();
  }
} else {
  //If token exists
  //Then go ahead
  if (isset($_SESSION["anms.f.u.i"]) && !empty($_SESSION["anms.f.u.i"])) {
    $from_user_id = $_SESSION["f.u.i"] = $_SESSION["anms.f.u.i"];
  } else {

    //Create a new token
    $from_user_id = $_SESSION["f.u.i"] = $_SESSION["anms.f.u.i"] = 'ANMS-' . $handle->generate_token('alphanumeric', 20);
  }
}


//Now is_anonymus data is of no use
//cleaning it

unset($chat_data["is_anonymus"]);


//Proceed if token exists

// echo $from_user_id;
if (isset($from_user_id)) {

  // // $chat_data = json_decode($chat_data, true);

  array_push($chat_logs, $chat_data);
  $chat_logs = serialize($chat_logs);

  $chat_history_exists = $fetch->data('page-anonymus-chats', 'from_user_id, chat_logs', "from_user_id = '$from_user_id' AND page_id = '$page_id'");
  if ($chat_history_exists) {

    $get_previous_messages = $chat_history_exists["chat_logs"];

    $previous_msgs =  unserialize($get_previous_messages);

    array_push($previous_msgs, $chat_data);
    $append_messages = serialize($previous_msgs);

    $stmt = $dbh->prepare("UPDATE `page-anonymus-chats` SET `chat_logs` =?  WHERE `from_user_id` = '$from_user_id' AND `page_id` = '$page_id' LIMIT 1");
    $stmt->bindParam(1, $append_messages);

    unset($append_messages, $chat_data, $chat_logs);
  } else {
    // echo $file_data;

    $stmt = $dbh->prepare("INSERT INTO `page-anonymus-chats` (
                `from_user_id`,
                `to_user_id`,
                `page_id`,
                `chat_logs`
              ) VALUES (?,?,?,?)");

    //Binding parameters
    $stmt->bindParam(1, $from_user_id);
    $stmt->bindParam(2, $to_user_id);
    $stmt->bindParam(3, $page_id);
    $stmt->bindParam(4, $chat_logs);
    unset($chat_logs);
  }
  $stmt->execute();
  //Execute
}
