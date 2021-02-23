<?php
// Private credentials
//DB connection infos
//AAWS PASS Ash7@gho903CNKJ@3$KCN*P::SJDWE)__JASKBDQ1~@
//AWS User = xSSF26_KnDnsXxCCba
$__KEYS = array();
$get_keys = file_get_contents(__DIR__ . "/xSSF26_KnDnsXxCCba.key");
$createKeys = explode(",", $get_keys);

foreach ($createKeys as $key => $value) {
    $explode_Keys = explode("->", $value);
    $__KEYS[trim($explode_Keys[0])] = trim($explode_Keys[1]);
}

if (count($__KEYS) > 0) {
    try {
        define('PDO_DSN', 'mysql:host=localhost;dbname=' . $__KEYS["DB_NAME"] . '');
        define('PDO_USER', '' . $__KEYS["DB_USER"] . '');
        define('PDO_PASSWORD', '' . $__KEYS["DB_PASSWORD"] . '');
        // Connect to the database with defined constants
        unset($__KEYS);
        $dbh = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD);
        date_default_timezone_set('Asia/Kolkata');
    } catch (Exception $e) {
        echo "Something went wrong!";
        die();
    }
} else {
    die();
}
