<?php
(new CodeFlirt\Handlers)->ForwardUser();

/**
 * 
 * INCLUDE controllers/database.php
 * INCLUDE controllers/modules/core.php
 * Before including functions.php
 * functions.php is dependent on core.php 
 * It uses objects of core.php
 */

//Get difference in dates
function date_difference($date1, $date2, $return_format)
{
    switch ($return_format) {
        case 'd':
            return (int)$date1->diff($date2)->format('%r%a');
            break;
        case 'h':
            return (int)$date1->diff($date2)->format('%r%h');
            break;
        case 'm':
            return (int)$date1->diff($date2)->format('%r%m');
            break;
        case 'i':
            return (int)$date1->diff($date2)->format('%r%i');
            break;

        default:
            return (int)($date1->getTimestamp() - $date1->getOffset()) - ($date2->getTimestamp() - $date2->getOffset());
            break;
    }
}

//Arguments flatpickr date [12-10-2021 09:10, 06-10-2022 07:55]
function schedule_time(string $date_time_array, string $set_timezone, string $user_timezone)
{
    if (empty($date_time_array) || empty($set_timezone) || empty($user_timezone)) {
        return;
    }
    $tz_data = [];
    $scheduled_date =  explode(',', $date_time_array);

    // date_s-> date start, date_e -> date end
    // time_s -> time start, time_e -> time end
    $date_s = trim($scheduled_date[0]);

    $date_e = trim($scheduled_date[1]);

    $time_s = trim(explode(' ', $date_s)[1]);

    $time_e = trim(explode(' ', $date_e)[1]);

    //Timezone
    $timezone = $set_timezone;

    //Reformat start date and end date with scheduled timezone
    $date_start = new DateTime($date_s, new DateTimeZone($timezone));
    $date_end = new DateTime($date_e, new DateTimeZone($timezone));

    // Get the time on user side
    $user_time = new DateTime(NULL, new DateTimeZone($user_timezone));

    // Convert schedule date to user side with their timezone
    $date_scheduled_start_object =  $date_start->setTimezone(new DateTimeZone($user_timezone));
    $date_scheduled_start = $date_scheduled_start_object->format('(D) d-M-Y g:i A');

    $date_scheduled_end_object = $date_end->setTimezone(new DateTimeZone($user_timezone));
    $date_scheduled_end = $date_scheduled_end_object->format('(D) d-M-Y g:i A');

    // Get diffrence in datetime
    $date_diff = date_difference($date_scheduled_start_object, $date_scheduled_end_object, 'd');

    //Get difference in date with timestamp
    $start_difference = date_difference($date_start, $user_time, '');
    $end_difference = date_difference($date_end, $user_time, '');


    $tz_data['date_start'] = $date_s;
    $tz_data['time_start'] = $time_s;
    $tz_data['date_end'] = $date_e;
    $tz_data['time_end'] = $time_e;
    $tz_data['timezone'] = $timezone;
    $tz_data['viewer_can_see_this_from'] = $date_scheduled_start;
    $tz_data['viewer_cannot_see_this_after'] = $date_scheduled_end;
    $tz_data['date_scheduled_difference'] = $date_diff;
    $tz_data['start_difference'] = $start_difference;
    $tz_data['end_difference'] = $end_difference;

    //Return data in array form
    return $tz_data;

    //Return data in json form
    // return json_encode($tz_data, JSON_PRETTY_PRINT);

    // print "<pre>";
    // echo json_encode($tz_data, JSON_PRETTY_PRINT);
    // print "</pre>";

}

// Join two CSV files
function joinFiles(array $files, $result)
{
    if (!is_array($files)) {
        throw new Exception('`$files` must be an array');
    }
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $result . '"');

    $wH = fopen('php://output', "wb");

    foreach ($files as $file) {
        $fh = fopen($file, "r");
        while (!feof($fh)) {
            fwrite($wH, fgets($fh));
        }
        fclose($fh);
        unset($fh);
        fwrite($wH, "\n"); //usually last line doesn't have a newline
    }
    fclose($wH);
    unset($wH);
}

// joinFiles(array('../_tmp/sample.csv', '../_tmp/sample (1).csv'), 'join3.csv');

require_once __DIR__ . '/libs/GeoIP/autoload.php';
require_once __DIR__ . '/libs/device-detector/autoload.php';

use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;
use GeoIp2\Database\Reader;

class Page
{
    protected $PageDetails;
    protected $pageConfigurations;

    public function Find($referencePage)
    {
        $getPageDetails = (new CodeFlirt\Fetch)->data("links", "page_id,page_name,user_id,link_configs", "page_id='$referencePage' OR page_name='$referencePage'");

        if ($getPageDetails) {
            //Set page id in current object
            $this->PageID = $getPageDetails["page_id"];
            $this->OwnerID = $getPageDetails["user_id"];
            $this->PageName = explode("@", $getPageDetails["page_name"])[0];
            $this->OwnerName = explode("@", $getPageDetails["page_name"])[1];
            $this->DefaultName = $getPageDetails["page_name"];
            //Get page configurations / customisations
            $customisation = json_decode($getPageDetails["link_configs"], true);
            //
            if (isset($customisation) && count($customisation) > 0) {
                if (isset($customisation["page_configs"])) {
                    $this->pageConfigurations = $customisation["page_configs"];
                }
            }
            if (isset($customisation["page_password"])) {
                $this->PageLockedWith = $customisation["page_password"];
            } else {
                $this->PageLockedWith = null;
            }
            $_SESSION["PageID"] = $this->PageID;
            $_SESSION["OwnerID"] = $this->OwnerID;
            return true;
        } else {
            return false;
        }
    }

    //Fetch details of the page
    public function Details()
    {
        if (isset($this->PageID) && isset($this->OwnerID)) {
            $this->PageDetails = [
                'PageRefId' => $this->PageID,
                'OwnerRefId' => $this->OwnerID,
                'PageName' => $this->PageName,
                'OwnerName' => $this->OwnerName,
                'DefaultName' => $this->DefaultName,
                'PageLocked' => $this->PageLockedWith
            ];
            return $this->PageDetails;
        } else {
            return false;
        }
    }
    public function Photo()
    {
        if (
            isset($this->pageConfigurations["page-image"]) &&
            file_exists($this->pageConfigurations["page-image"])
        ) {
            return $this->pageConfigurations["page-image"];
        } else {
            return false;
        }
    }
    //Return page photo if available 
    // Else return user profile photo
    // Else returns default photo
    public function SEO()
    {
        echo '
     <meta name="description" content="Linktree. Make your link do more." />
     <meta property="og:title" content="@sakaltimes" />
     <meta property="og:description" content="Linktree. Make your link do more." />
     <meta property="og:url" content="https://linktr.ee/sakaltimes" />
     <meta property="og:image"
         content="https://d1fdloi71mui9q.cloudfront.net/IwsFe6SGRIq8jRgAIWCp_c6d32bbdb3d3e8a1ada41d428fa89269" />
     <meta property="og:image:secure_url"
         content="https://d1fdloi71mui9q.cloudfront.net/IwsFe6SGRIq8jRgAIWCp_c6d32bbdb3d3e8a1ada41d428fa89269" />
     <meta property="profile:username" content="sakaltimes" />
     <meta name="twitter:title" content="@sakaltimes" />
     <meta name="twitter:description" content="Linktree. Make your link do more." />
     <meta name="twitter:image"
         content="https://d1fdloi71mui9q.cloudfront.net/IwsFe6SGRIq8jRgAIWCp_c6d32bbdb3d3e8a1ada41d428fa89269" />
     <link rel="canonical" href="https://linktr.ee/sakaltimes" />
     <link rel="preconnect" href="https://www.googletagmanager.com" crossorigin="" />
     <link rel="dns-prefetch" href="https://www.googletagmanager.com" crossorigin="" />
 
     ';
    }
}
class User
{
    //checks if user is logged in
    // else force login
    public function isAuthenticated()
    {
        if (!isset($_SESSION["ed"])) {
            echo '<meta http-equiv="refresh" content="0; url=' . (new CodeFlirt\Handlers)->path("login") . '">';
            exit(0);
        }
    }
    // // => User private key
    public static function AuthID()
    {
        if (!isset($_SESSION["ed"])) {
            (new CodeFlirt\Handlers)->trackUser();
            echo '<meta http-equiv="refresh" content="0; url=' . (new CodeFlirt\Handlers)->path("login") . '">';
            return false;
        }
        if (isset($_SESSION["ed"]) && !empty($_SESSION["ed"])) {
            //Import from Encryption
            $Encryption = new Encryption();

            $user_public_key = $_SESSION["ed"];

            //Here _Profilepage_ is a decryption key
            $user_email_address = md5($Encryption->decrypt($user_public_key, "_ProfilePage_"));

            $user_private_key = (new CodeFlirt\Fetch)->data('users', 'user_private_key', "user_email_address='$user_email_address'");

            if ($user_private_key == false) {
                echo '<meta http-equiv="refresh" content="0; url=' . (new CodeFlirt\Handlers)->path("login") . '">';
                return;
            } else {
                return $user_private_key;
            }
        } else {
            echo '<meta http-equiv="refresh" content="0; url=' . (new CodeFlirt\Handlers)->path("login") . '">';
            return;
        }
    }

    protected $privateKey;

    //Get user details from private id
    public function Details($privateKey)
    {

        if (!isset($privateKey)) {
            return false;
        }
        $this->privateKey = $privateKey;
        $fetchUser = (new CodeFlirt\Fetch)->data('users', 'user_private_key', "user_private_key='$privateKey'");
        if ($fetchUser && $fetchUser === $privateKey) {
            $fetchUserDetails = (new CodeFlirt\Fetch)->data('details', 'user_details', "user_id='$fetchUser'");
            if ($fetchUserDetails) {

                //If verification is successfull GRANT permissions to user 
                return json_decode((new Encryption)->decrypt($fetchUserDetails, $fetchUser), true)["client"]["details"];
            }
        } else {
            return false;
        }
    }
    public function photos()
    {
        if (
            isset($this->Details($this->privateKey)["profile_picture"]) &&
            file_exists($this->Details($this->privateKey)["profile_picture"])
        ) {
            return $this->Details($this->privateKey)["profile_picture"];
        } else {
            return 'assets/images/no-photo.png';
        }
    }
    //
    public function pack(array $data, string $arrayColumn)
    {
        if (self::AuthID()) {
            $UserDetails = (new CodeFlirt\Fetch)->data('details', 'user_details', "user_id='" . self::AuthID() . "'");
            if ($UserDetails) {
                //If verification is successfull GRANT permissions to user 
                $decoded_data = (json_decode((new Encryption)->decrypt($UserDetails, self::AuthID()), true));
                //Append new data within coulmn
                $tmpPreserve = array();
                foreach ($data as $key => $value) {
                    if ($key === "preserve") {
                        // Preserving values 
                        if (is_array($value)) {
                            //Iterate through each preserve key
                            foreach ($value as $preserveKey => $preserveValue) {
                                //Check if preserve key is present in target array column
                                if (isset($decoded_data["client"][$arrayColumn][$preserveKey])) {
                                    //Check if data already exists with preserved key
                                    if (isset($decoded_data["client"][$arrayColumn][$preserveValue . $preserveKey])) {
                                        //If preserved key exists store all values in temporary array
                                        foreach ($decoded_data["client"][$arrayColumn][$preserveValue . $preserveKey] as $oldkey => $oldvalue) {
                                            $tmpPreserve[$preserveValue . $preserveKey][] = $oldvalue;
                                        }
                                        //Append updated value in temporary array
                                        $tmpPreserve[$preserveValue . $preserveKey][] = $decoded_data["client"][$arrayColumn][$preserveKey];
                                    } else {
                                        //If preserved ley is not present then create it
                                        //And add updated data
                                        $tmpPreserve[$preserveValue . $preserveKey][] = $decoded_data["client"][$arrayColumn][$preserveKey];
                                    }
                                }
                                //Delete old data and update new data
                                if (array_key_exists($preserveValue . $preserveKey, $decoded_data["client"][$arrayColumn]) !== false) {
                                    unset($decoded_data["client"][$arrayColumn][$preserveValue . $preserveKey]);
                                }
                            }
                        }
                    }
                    //Delete old keys and appen new key in array
                    if (array_key_exists($key, $decoded_data["client"][$arrayColumn]) !== false) {
                        unset($decoded_data["client"][$arrayColumn][$key]);
                    }
                }
                //Append new values in TARGETED Array column
                $decoded_data["client"][$arrayColumn] += $tmpPreserve;
                $decoded_data["client"][$arrayColumn] += $data;

                //Unset preserve key
                unset($decoded_data["client"][$arrayColumn]["preserve"]);

                // Encrypt data :-)
                return (new Encryption)->encrypt(json_encode($decoded_data), self::AuthID());
            }
        } else {
            return false;
        }
    }
    //Trace ip location
    public function DetectUser()
    {
        $dt = new DateTime("now");
        try {
            $reader = new Reader('controllers/libs/GeoIP/GeoLite2-City.mmdb');
            $record = $reader->city("106.67.108.94"); // $ip defined before, trying with 234.234.34.4
        } catch (Exception $e) {
            header('location: auth.php?x=unknown');
            return;
        }

        //
        AbstractDeviceParser::setVersionTruncation(AbstractDeviceParser::VERSION_TRUNCATION_NONE);

        $userAgent = $_SERVER['HTTP_USER_AGENT']; // change this to the useragent you want to parse

        $dd = new DeviceDetector($userAgent);
        $dd->discardBotInformation();
        $dd->parse();

        if ($dd->isBot()) {
            // handle bots,spiders,crawlers,...
            $botInfo = $dd->getBot();
            header('location: auth.php?x=' . $botInfo . '');
            return;
        } else {
            $clientInfo = $dd->getClient(); // holds information about browser, feed reader, media player, ...
            $device = $dd->getDeviceName();
            $brand = $dd->getBrandName();

            $generate_user_device_details["device"]["name"] = $device;
            $generate_user_device_details["device"]["browser"] = $clientInfo["name"];
            $generate_user_device_details["device"]["browser_version"] = $clientInfo["version"];
            $generate_user_device_details["device"]["brand"] = $brand;
            $generate_user_device_details["device"]["brand"] = $brand;

            //Client locations
            $generate_user_device_details["location"]["country"] = $record->country->name;
            $generate_user_device_details["location"]["country_iso"] = $record->country->isoCode;
            $generate_user_device_details["location"]["state"] = $record->mostSpecificSubdivision->name;
            $generate_user_device_details["location"]["state_iso"] = $record->mostSpecificSubdivision->isoCode;
            $generate_user_device_details["location"]["city"] = $record->city->name;


            $generate_user_device_details["logged_timestamp"] = $dt->getTimestamp();

            return $generate_user_device_details;
        }
    }
}


class Messages extends User
{
    protected $message_type;
    // protected $message_of_page;
    protected $Messages;

    protected $ChatLogs = array();

    protected $AssignedName;

    protected $SenderID;

    function Get(string $message_type = "anonymus")
    {

        ($message_type === "anonymus") ? $this->message_type = $message_type = "ANMS-" :  $this->message_type = $message_type = "PRSL-";

        // $this->message_of_page = $message_of_page;

        $page_id = $_SESSION["page_visit"];

        $message_of_user = self::AuthID();

        /**
         * Fetch messages from database where user match is found
         */

        $RequestForMessages = (new CodeFlirt\Fetch)->data('page-anonymus-chats', 'from_user_id,to_user_id,page_id,chat_logs', "to_user_id='$message_of_user' AND page_id='$page_id' AND from_user_id LIKE '$message_type%' ORDER BY `ayms-id` DESC", 'row');

        // Return the rows from database
        return $this->Messages = $RequestForMessages;
    }

    public function UserName()
    {
        return $this->AssignedName;
    }
    /**Fetch chat logs
     * 
     */
    public function ChatLogs()
    {
        if (!is_array($this->Messages)) {
            return false;
        }

        foreach ($this->Messages as $row) {

            if (strpos($row["from_user_id"], "PRSL-") !== false) {
                $this->AssignedName = $this->Details(explode('-', $row["from_user_id"])[1])["user_name"];
                $this->SenderID = $SenderID = $row["from_user_id"];
            } else {
                $this->AssignedName = "Random user";
            }
            $this->ChatLogs[] = unserialize($row["chat_logs"]);
            /**
             * Apply filters
             * Remove replied messages
             */
            foreach ($this->ChatLogs as $key => $array) {

                if (
                    array_column($array, 'reply_time')
                    || array_column($array, 'reply_id')
                    || array_column($array, 'reply')
                ) {
                    unset($this->ChatLogs[$key]);
                }
            }
        }
        return (($this->ChatLogs));
    }

    /**
     * Get Sender id
     */
    public function SenderID()
    {
        return $this->SenderID();
    }
    public function CountMessages()
    {
        return count($this->transformValue($this->ChatLogs));
    }
    /**
     * Count number of users who have messaged
     */

    public function CountUsers()
    {
        return count($this->Messages);
    }

    /**
     * Rebuilding array from multi- multi dimensional 
     */
    public function transformValue($array = [])
    {
        $return = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $return = array_merge($return, $value);
            }
        }
        return $return;
    }
}
