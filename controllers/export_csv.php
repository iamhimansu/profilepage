<?php

require_once 'database.php';
require_once 'modules/core.php';

$fetch = new CodeFlirt\Fetch;

$jsondata = [];

$reference_page = $_GET['page_id'];
$response_type = $_GET['resp'];


//Fetching data by getting response type

$get_data_from = $response_type . 's';

$stmt = $dbh->prepare("SELECT `page_$response_type` FROM `page-$get_data_from` WHERE `page_id` = ?");

$stmt->bindParam(1, $reference_page);
$stmt->execute();

if ($stmt->execute()) {
    $rows = $stmt->fetchAll(PDO::FETCH_COLUMN, 'page_' . $response_type . '');

    $total_responses =  $stmt->rowCount();

    foreach ($rows as $key => $value) {

        $jd = json_decode($value, true);
        // $jd[0] = $jd['time'];


        $jsondata[0] =  array_keys($jd);
        $jsondata[] =  array_values($jd);
        // unset($jd['time']);
    }


    // var_dump($jsondata);

    // // print "<pre>";
    // header('Content-Type: text/csv');
    // header('Content-Disposition: attachment; filename="' . $reference_page . '-' . $response_type . '.' . md5(time()) . '.csv"');

    // // $user_CSV[0] = array('first_name', 'last_name', 'age');

    // // // very simple to increment with i++ if looping through a database result 
    // // $user_CSV[1] = array('Quentin', 'Del Viento', 34);
    // // $user_CSV[2] = array('Antoine', 'Del Torro', 55);
    // // $user_CSV[3] = array('Arthur', 'Vincente', 15);

    $fp = fopen('php://output', 'wb');
    foreach ($jsondata as $line) {
        // though CSV stands for "comma separated value"
        // in many countries (including France) separator is ";"
        fputcsv($fp, $line, ',');
    }
    fclose($fp);
} else {
    return;
}
