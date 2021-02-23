<?php

// error_reporting(0);

//Including neccessary modules
include '../database.php';
include '../modules/core.php';

// initializing Codeflirt
$sanitize = new CodeFlirt\Sanitize;
$handle = new CodeFlirt\Handlers;
$fetch = new CodeFlirt\Fetch;

function recursive($array)
{
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                return recursive($value);
            } else {
                return $value;
            }
        }
    } else {
        return $array;
    }
}
header('Content-Type: application/json');

if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {

    //Sanitizing parameters to avoid SQL injections or bad Requests
    $get_params = $sanitize->sanitize($_GET['request'], 'default', 2);
    $get_params = $sanitize->sanitize($get_params);

    //Creating an empty array for holding parameters
    $let_api_array = (array) null;

    $let_api_data_types = (array) null;

    $generate_request = (array) null;

    //Splitting different api requests
    $let_api_requests = explode(',', $get_params);

    //Storing into API array
    $let_api_array = $let_api_requests;

    //Iterating through each API requests and setting request data type
    foreach ($let_api_array as $key => $value) {

        //Separating and appending in array
        $data_requests = explode(':', $value);

        $data_key = $data_requests[0];

        if (isset($data_key)) {
            $data_value = $data_requests[1];
        }
        if (!isset($data_value)) {
            die('Bad request');
        }

        //Add in request array
        $let_api_data_types[$data_key] = $data_value;
    }
    // Fetch messages
    $message_from_id = $let_api_data_types["f_id"];
    $message_to_id = $let_api_data_types["t_id"];
    $message_of_page = $let_api_data_types["p_id"];

    //If request type not found trow error message
    if (!$message_from_id || !$message_to_id || !$message_of_page) {
        die('Cannot process request');
    }
    // print '<pre>';
    //Pagination is an Optional field
    if (isset($let_api_data_types["pg"])) {
        $get_pagination_number = $let_api_data_types["pg"];
    } else {
        $get_pagination_number = 'all';
    }
    if (empty($get_pagination_number)) {
        die('Cannot process request');
    }

    //Split pagination
    $pagination = explode('-', $get_pagination_number);

    //Get starting index
    $start_index = $pagination[0];

    //Get last index
    @$last_index = $pagination[1];


    //Try to fetch messages
    $fetch_messages = $fetch->data('page-anonymus-chats', 'chat_logs', "from_user_id = '$message_from_id' AND to_user_id = '$message_to_id' AND page_id = '$message_of_page'");

    //If everything is fine then proceed
    if ($fetch_messages) {

        //Convert json into array


        $fetch_messages = unserialize($fetch_messages);

        //Reformating pagination value
        if ($get_pagination_number === 'all') {
            $start_index = 0;
            $last_index = count($fetch_messages);
        }
        if ($get_pagination_number === 'last_one') {
            $start_index = count($fetch_messages) - 1;
            $last_index = count($fetch_messages);
        }
        //Probability is there that last index given is greater than the array lenght
        //Reassingning last index
        if ($last_index > count($fetch_messages)) {
            $last_index = count($fetch_messages);
        }
        for ($i = $start_index; $i < $last_index; $i++) {
            //Going deeper
            foreach ($fetch_messages[$i] as $key => $value) {
                $fetch_messages[$i][$key] = nl2br(html_entity_decode(htmlspecialchars_decode(recursive($value))));
                $fetch_messages[$i]["index"] = $i + 1;
            }
            if (isset($fetch_messages[$i]["time"])) {
                $fetch_messages[$i]["time"] = $handle->timeago('@' . $fetch_messages[$i]["time"]);
            } else {
                $fetch_messages[$i]["time"] = $handle->timeago('@' . time());
            }
            $generate_request[] = $fetch_messages[$i];
        }

        //Sorting array by descending order
        // // so that new messages are shown at beggining
        $sort = array();
        foreach ($generate_request as $k => $v) {
            $sort['index'][$k] = $v['index'];
        }

        if (count($generate_request) >= 1) {
            array_multisort($sort['index'], SORT_DESC, $generate_request);

            foreach ($generate_request as $k => $v) {
                //Removing replied messages
                if (array_key_exists("reply", $generate_request[$k])) {
                    unset($generate_request[$k]);
                }
            }

            // print '<pre>';
            echo json_encode($generate_request, JSON_PRETTY_PRINT);
        }

        // var_dump($generate_request);
    } else {
        return;
    }
    exit(0);
}
