<?php
//
session_name("PP");
session_start();
//
require_once __DIR__ . '/controllers/database.php';
require_once __DIR__ . '/controllers/modules/core.php';
require_once __DIR__ . '/controllers/modules/Encryption.php';
require_once __DIR__ . '/controllers/functions.php';

$fetch = new CodeFlirt\Fetch;
$sanitize = new CodeFlirt\Sanitize;
$User = new User();
$Page = new Page();

$OwnerId = $User->AuthID();

//
$reference_page = $sanitize->sanitize($_GET["page"]);
$response_type = $sanitize->sanitize($_GET["type"]);
$response_ext = @$sanitize->sanitize($_GET["ext"]);

//Validating 
if (!$reference_page || !$response_type) {
    exit(0);
}
//Get page name
$PageDetails = $Page->Find($reference_page);
$PageName = $Page->Details()["PageName"];

$extensions = ['csv', 'txt'];
if ($response_ext && !empty($response_ext) && in_array($response_ext, $extensions)) {
    $ext = $response_ext;
} else {
    $ext = 'csv';
}
//Filter export type
switch ($response_type) {
    case 'responses':
        $export_type = "page_response";
        $export_table = "page-responses";
        break;
    case 'feedbacks':
        $export_type = "page_feedback";
        $export_table = "page-feedbacks";
        break;

    default:
        exit(0);
        break;
}

//

$Fetch_Data_To_Export = $fetch->data("$export_table", "$export_type", "page_id='$reference_page' AND owner_id='$OwnerId'");

$exportData = unserialize($Fetch_Data_To_Export);

if ($exportData && count($exportData) > 0) {
    $lastData = $exportData[count($exportData) - 1];

    //
    foreach ($lastData as $key => $value) {
        $CSV_header[] = ucfirst($key);
    }
    //
    //Create data

    foreach ($exportData as $array_key => $response_data) {
        foreach ($response_data as $value) {
            $n_data[$array_key][] = $value;
        }
    }

    if ($ext === "txt") {
        $CSV_headers = implode("|", $CSV_header);
        //    
        foreach ($n_data as $key => $value) {
            $n_data[$key] = "[" . implode("|", $value) . "]";
        }
    } else {
        $CSV_headers = implode(",", $CSV_header);
        //
        foreach ($n_data as $key => $value) {
            $n_data[$key] = implode(",", $value);
        }
    }

    //
    //Reserve header
    $_CSV_[] = $CSV_headers;

    //Set data
    foreach ($n_data as $key => $value) {
        $_CSV_[]  = $value;
    }
    //
    // disable caching
    $now = date("D, d M Y H:i:s", strtotime("now"));
    $filedate = date("d-M-Y", strtotime("now"));
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$PageName}-{$response_type}-{$filedate}.{$ext}");
    header("Content-Transfer-Encoding: binary");

    //Write CSV DATA
    foreach ($_CSV_ as $key => $value) {
        echo $value . "\n";
    }
    return;
} else {
    die();
}
