<?php

namespace CodeFlirt;

// Import PDO within namespace
use PDO;

/**
 * Root directory of CodeFlirt
 * Pre-defined constants
 */
define('ROOT_PATH', preg_replace('/\\\\/', '/', dirname(dirname(__DIR__))));

/**
 * Logs are enabled by default
 * [important] Turn off logs in production mode
 *To turn off LOGS set true to false 
 */

define('LOGS', true);

/**
 * Base module
 * Required in every file 
 *
 * @author Himanshu Raj Aman.
 */

/**
 * CORE MODULES -> DATA RELATED
 */
/**
 * @param fetch data
 * @var $table The table to be fetched
 * @var $column The column to be fetched
 * @var $condition data to be fetched by these conditions
 */
class Fetch
{
    private static $dbh;

    public static function data()
    {
        // Temporary array of arguments
        $tmp = (array) null;

        //Looping through each array items 
        foreach (func_get_args() as $n) {
            $tmp[] .= $n;
        }

        // First argument [table name] up data//
        (string) @$table = $tmp[0];
        //Second argument [column name]
        (string) @$column =  $tmp[1];
        // Third argument [condition]
        (string) @$condition =  $tmp[2];

        (string) @$return_array = $tmp[3];

        if (empty($return_array) | !$return_array) {
            $return_array = 'one';
        }
        if (empty($table) || empty($column)) {
            return;
        }

        ($condition === null || empty($condition) || $condition == '') ?
            $condition = '1' : $condition;

        try {
            //Rename constants with your database configuration file
            self::$dbh = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD);

            if (!$condition || empty($condition)) {
                $cond = 1;
            } else {
                $cond = $condition;
            }
            if ($return_array === 'row') {
                $created_query = "SELECT $column FROM `$table` WHERE $cond";
            } else {
                $created_query = "SELECT $column FROM `$table` WHERE $cond LIMIT 1";
            }
            $execute_query = self::$dbh->prepare($created_query);
            if ($execute_query->execute()) {
                if ($execute_query->rowCount() >= 1) {

                    if ($return_array === 'row') {
                        $row = $execute_query->fetchAll(PDO::FETCH_ASSOC);
                        return $row;
                    }
                    if ($return_array === 'one') {
                        $row = $execute_query->fetch(PDO::FETCH_ASSOC);
                    }

                    //Check existence of multiple columns
                    if (strpos($column, ',') !== false) {
                        //Return array_data from database
                        return $row;
                        //
                    } else {
                        if ($row[$column] == "" || empty($row[$column])) {
                            die('');
                        } else {
                            //Return data from database
                            return $row[$column];
                        }
                    }
                } else {
                    /*You can redirect the user to logout page or hacked page where you can reset the 
                    connection as well as cookies and sessions */

                    //Return false if data not found / fetched in the database
                    return false;

                    /* page_redirect("404.php");*/
                }
            } else {

                /*Some logic*/
                echo "<b>$created_query</b>";
            }

            $dbh = null;
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

        // resetting all variables
        unset($tmp, $table, $column, $condition, $dbh, $created_query, $execute_query);
    }
}

class Handlers
{
    /**
     * Fixes broken paths
     * @param $path Path of file
     * Logs are enabled by default
     * 
     * Examples:
     * 1) __('path/to/file/file.php');
     */
    public static function __()
    {
        $params = (array) null;
        $indent = 0;
        $dir_path = ROOT_PATH;
        foreach (func_get_args() as $n) {
            $params[] = $n;
        }
        (string) @$path = $params[0];
        ($path === null || empty($path) || $path == '') ?
            $path = '.' : $path = implode('/', array_filter(explode('/', preg_replace('~\\\\~', '/', $path))));

        unset($n);
        $parent_path = dirname(dirname(__FILE__)) . '/' . $path;
        $valid_path =  preg_replace('~\\\\~', '/', $parent_path);

        // Cleaning any extra slashes
        $valid_path = implode('/', array_filter(explode('/', $valid_path)));
        if (file_exists($valid_path)) {
            unset($params);
            return $valid_path;
        } elseif (LOGS === true || LOGS === 1) {
            $parent_dirs = array_filter(explode('/', $path));
            //Parent directory
            echo  '<b><span style="color:#2f2fe2">' . explode('/', ROOT_PATH)[count(explode('/', ROOT_PATH)) - 1] . ' <a href="//' . $_SERVER['SERVER_NAME'] . '/' . explode('/', ROOT_PATH)[count(explode('/', ROOT_PATH)) - 1]  . '">[Parent Directory]</a></span></b><br>';
            foreach ($parent_dirs as $dir) {
                $indent += '20';
                $dir_path .= '/' . $dir; // Add new paths to old ones
                if (
                    is_dir($dir_path) || is_file($dir_path)
                    && realpath($dir_path) !== false
                ) {
                    echo '<b><span style="color:#0e9a40;padding-left:' . $indent . 'px"> --> ' . $dir . '</span></b><br>';
                } else {
                    echo '<b><span style="color:#c71111;padding-left:' . $indent . 'px"> --> ' . $dir . ' (x) (Not Found!)</span></b><br>';
                }
            }
            unset($params);
            // die('Could not find <b>' . $path . '</b> in ' . ROOT_PATH);
        } else {
            unset($params);
            return trim($path);
        }
    }

    /**
     * Absolute url
     * 
     */
    public static function path($path)
    {
        // output: /myproject/index.php
        $currentPath = $_SERVER['PHP_SELF'];

        // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
        $pathInfo = pathinfo($currentPath);

        // output: localhost
        $hostName = $_SERVER['HTTP_HOST'];

        // output: http://
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https' ? 'https' : 'http';

        // return: http://localhost/myproject/
        $abs_url =  ($protocol . '://' . $hostName . $pathInfo['dirname'] . "/" . $path);

        return $abs_url;
    }
    /**
     * To check if string is empty
     */
    // Function for basic field validation (present and neither empty nor only white space)
    public static function is_not_empty($str)
    {
        return (!isset($str) || trim($str) === '');
    }
    /**
     * @param Timeago 
     * Gives details of time
     * 
     */
    function timeago()
    {
        $params = (array) null;
        foreach (func_get_args() as $n) {
            $params[] = $n;
        }

        (int) @$time = $params[0];
        (string) @$time_format = $params[1];

        ($time_format === null || empty($time_format) || $time_format == '') ?
            $time_format = 'short' : $time_format;

        $now = new \DateTime;

        $ago = new \DateTime($time);

        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if ($time_format === "short") {
            $string = array_slice($string, 0, 1);
        }
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    /**
     * @param string Returns User Initial letters of name
     * @param int $initials_letter 
     * 
     * (1) : Only first letter of the name (Default),
     * 
     * (2) : First and last letter of the name,
     * 
     * (3) : All letters 
     * 
     * @param string Takes a string
     * 
     * @param format $format Converts into upper or lowercase
     */
    public static function user_initials(string $string, int $initials_letter = 1, $format = 'A')
    {
        //Default parameters
        $initials = null;
        $split_name = (array) null;

        //Splitting string with space in between
        $split_word = explode(' ', $string);

        //Storing in aother variable
        $split_name = $split_word;

        //Counting name length
        // $name_length =  count($split_name);

        //Initial letters
        /**
         * int $initials_letter 
         * 1 => Only first letter of the name (Default)
         * 2 => First and last letters of the name
         * 3 => All letters of the name
         */
        switch ($initials_letter) {
            case 1:
                $name_length = 1;
                break;
            case 3:
                $name_length = count($split_name);
                break;
            default:
                $name_length = count($split_name);
                break;
        }
        if ($initials_letter === 2 && count($split_name) > 1) {

            //Check if initials letters is 2
            $initials = $split_name[0][0];
            $initials .= $split_name[$name_length - 1][0];

            //Check for format
            if ($format === 'A') {
                echo strtoupper($initials);
            } else {
                echo strtolower($initials);
            }

            //Prevent function to run further
            return;
            //
        } else {
            for ($i = 0; $i < $name_length; $i++) {

                //Else return default initials
                @$initials = $split_name[$i][0];
                //Check for format
                if ($format === 'A') {
                    echo strtoupper($initials);
                } else {
                    echo strtolower($initials);
                }
            }
        }
        unset($initials, $split_name, $string, $split_word);
        return;
    }

    /**
     * @param string Returns Picked string 
     * @param array $positions
     * 
     * f | l | f2 | l2 | m | mr | ml | random | e | o
     * 
     * f: first character | l: last character 
     * 
     * f1: first two chars. | l2: last two chars.
     * 
     * m:  middle character | (mr|ml: middle right | middle left) 
     * 
     *  e: even character | o:  odd characters
     */
    public static function pick_out(string $string, array $positions = ['all'])
    {
        $initials = null;
        $broked_letters = (array) null;
        $tmp = (array) null;

        $final_char = (array) null;

        $pick_word = (array) null;
        if (empty($string) || $string == "") {
            return;
        }

        $tmp = array_filter(explode(' ', trim($string)));

        foreach ($tmp as $indexes) {
            $broked_letters[] .= trim($indexes);
        }

        $tmp = [];

        $broked_letters_length = count($broked_letters);

        $middle_term = ($broked_letters_length + 1) / 2;

        if (!$positions || empty($positions)) {
            $pick_word =  'all';
        }

        $pick_word = $positions;
        foreach ($pick_word as $value) {
            switch ($value) {
                case 'f':
                    $final_char[] .= $broked_letters[0];
                    break;
                case 'l';
                    $final_char[] .= ($broked_letters[$broked_letters_length - 1]);
                    break;
                case 'f2':
                    if ($broked_letters_length >= 2) {
                        $final_char[] .= $broked_letters[0];
                        $final_char[] .= $broked_letters[1];
                    }
                    break;
                case 'l2':
                    if ($broked_letters_length >= 2) {
                        $final_char[] .= $broked_letters[$broked_letters_length - 2];
                        $final_char[] .= $broked_letters[$broked_letters_length - 1];
                    }
                    break;
                case 'm':
                    if (($broked_letters_length % 2) === 0 && $broked_letters_length >= 2) {
                        //for even
                        $final_char[] .= $broked_letters[(($broked_letters_length / 2) - 1)];
                        $final_char[] .= $broked_letters[(($broked_letters_length + 2) / 2) - 1];
                    } else {
                        //For odd
                        $final_char[] .= $broked_letters[$middle_term - 1];
                    }
                    break;
                case 'mr':
                    if ($broked_letters_length >= 2) {
                        $final_char[] .= $broked_letters[$middle_term];
                    }
                    break;
                case 'ml':
                    if ($broked_letters_length >= 2) {
                        $final_char[] .= $broked_letters[$middle_term - 2];
                    }
                    break;
                case 'evens':
                    $evens = 1;
                    while ($evens <= $broked_letters_length - 1) {
                        $final_char[] .= $broked_letters[$evens];
                        $evens += 2;
                    }
                    break;
                case 'odds':
                    $evens = 0;
                    while ($evens <= $broked_letters_length - 1) {
                        $final_char[] .= $broked_letters[$evens];
                        $evens += 2;
                    }
                    break;
                case 'random':
                    foreach ($broked_letters as $random_chars) {
                        $rand_int = rand(0, $broked_letters_length - 1);
                        $final_char[] .= $broked_letters[$rand_int];
                        unset($random_chars, $rand_int);
                    }
                    break;
                case 'all':
                    array_push($final_char, $string);
                    break;
                default:
                    break;
            }
        }
        echo implode(' ', $final_char);
        unset(
            $initials,
            $initials_letter,
            $string,
            $broked_letters,
            $final_char,
            $pick_word,
            $evens,
            $tmp
        );
        return;
    }

    /**
     * @param string Tracks user previous location
     * @var $remember_token Cookie to be set in browser
     */

    public $UserLastVisit;
    public $ForwardUser;

    public function trackUser($remember_token = 'cf_track_user')
    {
        $this->UserLastVisit = $remember_token;

        $host = "http://$_SERVER[HTTP_HOST]";
        $currentPageUrl = $_SERVER['REQUEST_URI'];
        $absolute_path = $host . $currentPageUrl;
        if (strpos('login', $currentPageUrl) !== false) {
            $this->ForwardUser;
        } else {
            setcookie($this->UserLastVisit, $absolute_path, time() + 1 * 60, '/');
        }
        // return "Current url = ".createValidUrl($currentPageUrl);
    }
    public function forwardUser()
    {
        if (isset($_COOKIE[$this->UserLastVisit]) && !empty($_COOKIE[$this->UserLastVisit])) {
            $this->ForwardUser = $_COOKIE[$this->UserLastVisit];
            echo '<META HTTP-EQUIV="Refresh" Content="0; URL=continue.php?continue=' . urldecode($this->ForwardUser) . '">';
        } else {
            // $this->trackUser();
        }
    }

    /**
     *
     * Avoid giving length less than 10-12 chars to prevent repetition
     * 
     * @param $token_type Type of token: numeric, alphabets, alphanumeric, default
     * 
     * @param $token_length Length of token
     * 
     * 
     * Example: 
     * 1) $token = generate_token() //Default token;
     * 2) $token = generate_token('numeric', 15) //Numeric token;
     * 3) $token = generate_token('alphabets', 20) //Alphabetical token;
     * 4) $token = generate_token('alphanumeric', 12) //Alphanumeric Token;
     * 5) $token = generate_token('default', 15) //Default token with 15 chars;
     */
    public static function generate_token()
    {
        $params = (array) null;
        foreach (func_get_args() as $n) {
            $params[] .= $n;
        }

        // Default parameters
        (string) @$token_type = $params[0];
        (int) @$length = $params[1];

        ($token_type === null || empty($token_type) || $token_type == '') ?
            $token_type = 'default' : $token_type;

        ($length === null || empty($length) || $length == '') ?
            $length = 12 : $length;

        //A1uwlP5G20Kwm8cbp
        $small_abc = 'abcdefghijklmnopqrstuvwxyz';
        $big_abc = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $digits = '0123456789';
        $special = '_@$%&-';
        $time = time();
        $tmp = (array) null;
        $token = null;
        //generate_token(['alphanumeric', 'small', 'hard']);

        $sm_array = array();
        $big_array = array();
        $dg_array = array();
        $sp_array = array();

        $sm_array = str_split($small_abc, 1);
        $big_array = str_split($big_abc, 1);
        $dg_array = str_split($digits, 1);
        $sp_array = str_split($special, 1);

        for ($i = 0; $i < $length; $i++) {
            if ($token_type === 'numeric') {
                $tmp[] .= $dg_array[rand(0, count($dg_array) - 1)];
                shuffle($tmp);
                $tmp[] .= ceil(log($i + 1, 2));
            }
            if ($token_type === 'alphabets') {
                $tmp[] .= $sm_array[rand(0, count($sm_array) - 1)];
                $tmp[] .= $big_array[rand(0, count($big_array) - 1)];
                shuffle($tmp);
            }
            if ($token_type === 'alphanumeric') {
                $tmp[] .= $dg_array[rand(0, count($dg_array) - 1)];
                $tmp[] .= $sm_array[rand(0, count($sm_array) - 1)];
                $tmp[] .= $big_array[rand(0, count($big_array) - 1)];
                shuffle($tmp);
            }
            if ($token_type === 'default') {
                $tmp[] .= $dg_array[rand(0, count($dg_array) - 1)];
                $tmp[] .= $sm_array[rand(0, count($sm_array) - 1)];
                $tmp[] .= $big_array[rand(0, count($big_array) - 1)];
                $tmp[] .= $sp_array[rand(0, count($sp_array) - 1)];
                $tmp[] .= $time[rand(0, count($sp_array) - 1)];
                shuffle($tmp);
            }
        }
        $tmp_y_gen =  implode('', $tmp);
        $rand_int = rand(0, $length - 1);

        //Repeats selecting if token length is less than given length
        do {
            //Randomly selecting tokens to increase randomness
            $token =  substr($tmp_y_gen, $rand_int, $length);

            str_shuffle($token);

            //Reset random integer to create a new one
            $rand_int = null;
        } while (strlen($token) < $length);

        unset($tmp, $tmp_y_gen, $rand_int);
        return $token;
    }

    /**
     * @param string splits and joins given string with given parameters
     * 
     */
    public static function split(string $char, $split_with = '-', int $spaces = 4)
    {
        $output_char = null;
        if (strlen($char) > 0) {
            $output_char = implode($split_with, str_split($char, $spaces));
            return $output_char;
        }
        return;
    }
}
/**
 * @param Sanitizes string
 * @example : Sanitize($input, $type, optional $depth);
 * @var $input The data to be Sanitized
 * @var $type  email, name, string, int, array, default, html, script, url;
 * @var $depth Depth of sanitize
 */
class Sanitize
{

    public function sanitizeSingle($string)
    {
        if (get_magic_quotes_gpc()) {
            $string = stripslashes($string);
        }

        return trim(htmlspecialchars($string, ENT_QUOTES));
    }

    public function sanitize($string)
    {
        if (is_array($string)) {
            foreach ($string as $k => $v) {
                if (is_array($v)) {
                    $string[$k] = $this->sanitize($v);
                } else {
                    $string[$k] = $this->sanitizeSingle($v);
                }
            }
        } else {
            $string = $this->sanitizeSingle($string);
        }

        return $string;
    }

    public function desanitize($string)
    {
        return trim(htmlspecialchars_decode($string, ENT_QUOTES));
    }
}
class SanitizerCodeFlirt
{
    public function sanitize()
    {
        $str_pattern = '/[^A-Za-z ]/';
        $int_pattern = '/[^0-9 ]/';
        $email_pattern = '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^';
        $url_pattern = '%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu';
        $script_pattern = array('/[<]/', '/[?]/', '/[>]/');
        $script_replace = array('&lt;', '?', '&gt;');

        $tmp = (array) null;
        foreach (func_get_args() as $n) {
            $tmp[] .= $n;
        }

        // Getting input argument
        (string) @$input = $tmp[0];
        //Second argument [type]
        (string) @$type =  $tmp[1];
        // Third argument [depth]
        (int) @$depth =  $tmp[2];


        if (empty($input)) {
            echo $input;
            return;
        }

        ($type === null || empty($type) || $type == '') ?
            $type = 'default' : $type;

        ($depth === null || empty($depth) || $depth == '') ?
            $depth = 1 : $depth;

        switch ($depth) {
            case $depth >= 2:
                $str_pattern = '/[^A-Za-z]/';
                $int_pattern = '/[^0-9]/';
                break;
            default:
                $str_pattern = '/[^A-Za-z ]/';
                $int_pattern = '/[^0-9 ]/';
                break;
        }
        if ($type === "string" || $type === "name") {
            // Clean tmp array to store new values
            $tmp = [];
            // Selecting only strings
            $input = preg_replace($str_pattern, "", $input);
            // Reformatting spacings
            $tmp = explode(' ', $input);
            // Imploding complete string as output
            $input = implode(' ', array_filter($tmp));
        }
        if ($type === "int" || $type === "number" || $type === "num") {
            // Clean tmp array to store new values
            $tmp = [];
            // Selecting only integers
            $input = preg_replace($int_pattern, "", $input);
            // Reformatting spacings
            $tmp = explode(' ', $input);
            // Imploding complete number as output
            $input = implode(' ', array_filter($tmp));
            if (empty($input) || $input === "" || strlen($input) === 0)
                echo 'false';
            return;
        }
        if ($type === "email" || $type === "mail") {
            // Clean tmp array to store new values
            $tmp = [];
            // Reformatting spacings
            $tmp = explode(' ', $input);
            // Imploding complete email as output
            $input = implode('', array_filter($tmp));
            if (!preg_match($email_pattern, $input)) {
                return "false";
            }
        }
        if ($type === "url" || $type === "link") {
            // Clean tmp array to store new values
            $tmp = [];
            // Reformatting spacings
            $tmp = explode(' ', $input);
            // Imploding complete email as output
            $input = implode('', array_filter($tmp));
            if (!preg_match($url_pattern, $input)) {
                return "false";
            }
        }
        if ($type === "script" || $type === "html") {
            // Clean tmp array to store new values
            $tmp = [];
            $input = preg_replace($script_pattern, $script_replace, $input);
            $input = nl2br($input);
        }
        if ($type === "default") {
            // Clean tmp array to store new values
            $tmp = [];

            $input = preg_replace($script_pattern, $script_replace, $input);
            $input = trim($input);
            $input = nl2br($input);
        }
        return $input;
    }
}
