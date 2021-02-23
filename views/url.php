<?php

/**
 * Counts link visits
 * Withing page
 */

session_name("PP");
session_start();
//Require controllers
require_once __DIR__ . '/../controllers/database.php';
require_once __DIR__ . '/../controllers/modules/Encryption.php';
require_once __DIR__ . '/../controllers/modules/core.php';
require_once __DIR__ . '/../controllers/functions.php';

$handle = new CodeFlirt\Handlers;
$fetch = new CodeFlirt\Fetch;
$User = new User();
$Page = new Page();

$new_analytics = [];
$old_analytics = [];
//Get date
$Todays_date = strtotime("today");

//Store page redirection url
$FORWARD = @$_GET["visit"];

$FORWARD = htmlentities($FORWARD);
//

// Link is opened from Internal page
// then update link counts
if (isset($_SESSION["PageID"])) {
    $PAGE_ID  = $_SESSION["PageID"];
    $Page->Find($PAGE_ID);
    $PAGE_DETAILS = $Page->Details();
}
if (isset($_GET["visit"])) {

    if (isset($PAGE_DETAILS) && count($PAGE_DETAILS) >= 4) {
        //
        $CurrentPageID = $PAGE_DETAILS["PageRefId"];
        $PageOwnerID = $PAGE_DETAILS["OwnerRefId"];
        $PageOwnerID = $PAGE_DETAILS["OwnerRefId"];
        $DefaultPageName = $PAGE_DETAILS["DefaultName"];

        //Check if the given link exists on the page
        // then update visits count
        //else forward to destination
        $link_validation = $fetch->data("links", "page_id, user_id, link_configs", "page_id='$CurrentPageID' AND user_id='$PageOwnerID' AND page_name='$DefaultPageName'");

        $get_links = json_decode($link_validation["link_configs"], true);
        //clean data
        $link_validation = null;

        //Check for link existance
        foreach ($get_links as $key => $value) {
            if (isset($value["link_address"])) {
                if ($FORWARD === $value["link_address"]) {
                    $link_existance = $key;
                }
            }
        }

        if ($link_existance === false) {
            //Just redirect user to the destination page
            header("location:$FORWARD");
            //Do not proceed further
            exit(0);
        }
        //Check if analytics is already available for current date i.e today
        $analytics_of_today_exists = $fetch->data("analytics", "page_id, user_id, date, analytics", "page_id='$CurrentPageID' AND user_id='$PageOwnerID' AND date='$Todays_date'");

        //
        //Prepare new analytics
        //grab link id
        $link_id = $get_links[$link_existance]["id"];
        $prepare_new_analytics["analysis"]["link"]["id"] = $link_id;
        // $prepare_new_analytics["analysis"]["link"]["url"] = $FORWARD;
        $prepare_new_analytics["analysis"]["link"]["visits"] = 1;
        //
        array_push($new_analytics, $prepare_new_analytics);
        //
        if ($analytics_of_today_exists && count($analytics_of_today_exists) > 0) {
            //
            $old_analytics_data = json_decode($analytics_of_today_exists["analytics"], true);
            //
            //
            //store old analytics to old_analytics array
            foreach ($old_analytics_data as $key => $value) {
                $old_analytics[] = $value;
            }

            //if analytics of today exists
            // then find the link and update its visits

            $data_existance_key = (array_search(
                $link_id,
                array_column(
                    array_column(
                        array_column($old_analytics, 'analysis'),
                        'link'
                    ),
                    'id'
                )
            ));
            //Update visits
            if ($data_existance_key !== false) {
                $old_analytics[$data_existance_key]["analysis"]["link"]["visits"] += 1;
            } else {
                array_push($old_analytics, $prepare_new_analytics);
            }
            //
            //convert to json
            $old_analytics = json_encode($old_analytics);
            //
            $stmt = $dbh->prepare("UPDATE `analytics` SET `analytics`= ? WHERE `page_id` = ? AND `user_id` = ? AND `date` = ?");
            //
            $stmt->bindParam(1, $old_analytics);
            $stmt->bindParam(2, $CurrentPageID);
            $stmt->bindParam(3, $PageOwnerID);
            $stmt->bindParam(4, $Todays_date);
            //
            // print_r($old_analytics);
        } else {
            $new_analytics = json_encode($new_analytics);

            $stmt = $dbh->prepare("INSERT INTO `analytics` 
                                (`page_id`,
                                `user_id`,
                                `date`,
                                `analytics`)
                        VALUES (?, ?, ?, ?)");

            $stmt->bindParam(1, $CurrentPageID);
            $stmt->bindParam(2, $PageOwnerID);
            $stmt->bindParam(3, $Todays_date);
            $stmt->bindParam(4, $new_analytics);
        }
        //
        if ($stmt->execute()) {
            header("location:$FORWARD");
            exit(0);
        }
    } else {
        //do no count visits
        header("location:$FORWARD");
        exit(0);
    }

    // echo "<pre>";
    // echo session_encode();
} else {
    return;
}
//
return;
