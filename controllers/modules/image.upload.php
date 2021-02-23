<?php

//Register session name
//For validating user
session_name("PP");
session_start();

//Init required files
require_once '../../controllers/database.php';
require_once '../../controllers/modules/core.php';
require_once '../../controllers/modules/Encryption.php';
require_once '../../controllers/functions.php';

//
$handle = new CodeFlirt\Handlers;
$Auth = new User();

//Generate and store unique token for filename
$randomNumber = $handle->generate_token('alphanumeric', 20);

//Current date

$currentDate  = new DateTime("now");
$folderName = $currentDate->format('d-m-Y');

$DBFileLocation = "usr/photos/" . $folderName;
//Destination path directory
$dst_dir = __DIR__ . '/../../usr/photos/' . $folderName;

//Create folder recursively if folder do no exists
if (!file_exists($dst_dir)) {
    mkdir($dst_dir, 0777, true);
}

// Store file name
$fileName = uniqid() . str_shuffle(md5(time())) . $randomNumber;
$fileName = str_shuffle($fileName);

//Check if POST exists
if (isset($_POST["base64"])) {
    //Store data 
    $data = $_POST["base64"];

    //Build base64 data
    if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
        $data = substr($data, strpos($data, ',') + 1);
        $type = strtolower($type[1]); // jpg, png, gif

        //Check if it is a valid file
        if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
            throw new \Exception('invalid image type');
        }

        $data = str_replace(' ', '+', $data);
        $data = base64_decode($data);

        //If failed to decode
        //Throw error
        if ($data === false) {
            throw new \Exception('base64_decode failed');
        }
    } else {
        throw new \Exception('did not match data URI with image data');
    }

    //Put content in location
    $PhotoLocation = file_put_contents("$dst_dir/usr_$fileName" . '_photo' . ".{$type}", $data);


    //Check if Photo is stored successfully
    if ($PhotoLocation !== false) {

        //Create / update user profile picture in database
        $UpdateProfilePicture["preserve"]["profile_picture"] = "old_";
        // $UpdateProfilePicture["preserve"][""] = "test_";
        $UpdateProfilePicture["profile_picture"]  = "$DBFileLocation/usr_$fileName" . '_photo' . ".{$type}";
        //Get user Authentication ID
        $userID  = $Auth->AuthID();

        //Push user data
        $PackedData = $Auth->pack($UpdateProfilePicture, 'details');
        // //Update user data in database
        $stmt = $dbh->prepare("UPDATE `details` SET `user_details` = ?  WHERE `user_id` = ? LIMIT 1");

        //
        $stmt->bindParam(1, $PackedData);
        $stmt->bindParam(2, $userID);

        //If Databse is updated
        //Stop execution
        if ($stmt->execute()) {
            exit(0);
        }
    } else {
        exit(0);
    }
}
