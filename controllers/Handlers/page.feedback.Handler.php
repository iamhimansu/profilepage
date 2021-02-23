<?php

//TODOS: Fix from ip address

require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../modules/core.php';

$sanitize = new CodeFlirt\Sanitize;
$fetch = new CodeFlirt\Fetch;

function not_empty(array $data)
{
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $key => $value) {
                if (empty($value) | is_null($value)) {
                    return false;
                }
            }
        }
    }
    return true;
}
if (not_empty($_POST) === false) {
    return;
} else {
    session_name("PP");
    session_start();
    //
    $old_feedbacks = [];

    //
    $new_feedbacks = [];
    //
    $page_id = $_SESSION["PageID"];
    $owner_id = $_SESSION["OwnerID"];
    //
    if (!$page_id || !$owner_id) {
        exit(0);
    }
    if (isset($_SESSION["$page_id:submitted:feedback"]) && $_SESSION["$page_id:submitted:feedback"] = "feedback") {
        return;
    }

    $post_data = [];

    $time = date('g:i A \o\n l jS F Y eP', strtotime("now"));

    $post_data['time'] = $time;

    foreach ($_POST['feedback'] as $key => $value) {
        $post_data[htmlentities($key)] = $sanitize->sanitize($value);
    }

    unset($_POST);

    $page_feedback = $post_data;

    //Check if response exitst
    $feedback_exists = $fetch->data("page-feedbacks", "page_id, owner_id, page_feedback", "page_id='$page_id' AND owner_id='$owner_id'");
    //
    if ($feedback_exists) {
        $feedbacks = unserialize($feedback_exists["page_feedback"]);

        foreach ($feedbacks as $key => $feedback_data) {
            $old_feedbacks[] = $feedback_data;
        }
        //UPdate data
        array_push($old_feedbacks, $page_feedback);
        //Serialize
        $old_feedbacks = serialize($old_feedbacks);
        //Update database
        //Store details in database
        $stmt = $dbh->prepare("UPDATE `page-feedbacks` SET `page_feedback` = ? WHERE `page_id` = ? AND `owner_id` = ?");
        //Binding parameters
        $stmt->bindParam(1, $old_feedbacks);
        $stmt->bindParam(2, $page_id);
        $stmt->bindParam(3, $owner_id);
    } else {

        array_push($new_feedbacks, $page_feedback);
        $new_feedbacks = serialize($new_feedbacks);
        //Store details in database
        $stmt = $dbh->prepare("INSERT INTO `page-feedbacks` (
        `page_id`,
        `owner_id`,
        `page_feedback`
      ) VALUES (?, ?, ?)");

        //Binding parameters
        $stmt->bindParam(1, $page_id);
        $stmt->bindParam(2, $owner_id);
        $stmt->bindParam(3, $new_feedbacks);
    }

    //Executes
    if ($stmt->execute()) {
        //Set user in session
        $_SESSION["$page_id:submitted:feedback"] = "feedback";
        $_SESSION["$page_id:submitted:feedback:rating"] = $page_feedback["rating"];
    }
    return;
}
exit(0);
