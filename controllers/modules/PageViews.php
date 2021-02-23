<?php

// include_once __DIR__ . "/../database.php";
// include_once __DIR__ . "/../modules/core.php";
// include_once __DIR__ . "/../modules/Encryption.php";
// include_once __DIR__ . "/../functions.php";

// $fetch = new CodeFlirt\Fetch;
// $User = new User();


// $PAGEID = @$_SESSION["PageID"];
// $OWNERID = @$_SESSION["OwnerID"];
//

$new_analytics = [];
$old_analytics = [];
//
//Check if view is logged in
if (isset($_SESSION["ed"])) {
    $viewer_id = $User->AuthID();
}
//Check if owner is visiting the page
//If none is set then register as Anonymus user
else {
    $viewer_id = "Anonymus";
}
//Just update the page count in the beggining
//
//Later on when site grows 
//Set session for each page visit
//and only update new visits

$Todays_date = strtotime("today");
//
if (isset($PAGEID) && !empty($PAGEID)) {
    //Check if analytics of today exists
    $pageview_of_today_exists = $fetch->data("page_views", "page_id, date, analytics", "page_id='$PAGEID' AND date='$Todays_date'");
    //if analytics exists
    //Update page view into todays analytics
    //Create a new analytics
    $prepare_new_page_analytics["analysis"]["page"]["user_id"] = $viewer_id;
    //
    array_push($new_analytics, $prepare_new_page_analytics);

    if ($pageview_of_today_exists && count($pageview_of_today_exists) > 0) {
        $old_pageview_analytic_data = json_decode($pageview_of_today_exists["analytics"], true);
        //
        //
        //store old analytics to old_analytics array
        foreach ($old_pageview_analytic_data as $key => $value) {
            $old_analytics[] = $value;
        }
        array_push($old_analytics, $prepare_new_page_analytics);
        //
        //convert to json
        $old_analytics = json_encode($old_analytics);
        //
        $stmt = $dbh->prepare("UPDATE `page_views` SET `analytics`= ? WHERE `page_id` = ?  AND `date` = ?");
        //
        $stmt->bindParam(1, $old_analytics);
        $stmt->bindParam(2, $PAGEID);
        $stmt->bindParam(3, $Todays_date);
        //
    } else {
        //else
        //Create a new analytics for page views
        $new_analytics = json_encode($new_analytics);

        $stmt = $dbh->prepare("INSERT INTO `page_views` 
                            (`page_id`,
                            `date`,
                            `analytics`)
                    VALUES (?, ?, ?)");

        $stmt->bindParam(1, $PAGEID);
        $stmt->bindParam(2, $Todays_date);
        $stmt->bindParam(3, $new_analytics);
    }
    //If Successfull
    //Attempt to insert into database
    $stmt->execute();
}
