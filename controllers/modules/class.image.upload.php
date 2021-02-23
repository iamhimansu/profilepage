<?php

/**
 * Handles image uploads
 * @param $file_data
 */
class Upload
{
    public $logs;
    public $filename;
    public $target_directory;
    public $allowed_files = array('jpg', 'jpeg', 'gif', 'png');
    public $file_data;
    public $safename = true;
    public $filepath;
    public $targetpath;
    public $filetype;
    public $filesize;
    public $uniqueid;
    public $overwrite = false;
    public $success = false;
    public $fullname;

    protected $started_time;
    protected $process_time;
    protected $end_time;
    protected $total_time;

    public function __construct($file_data)
    {
        $this->started_time = microtime(true);
        $this->file_data = $file_data;
        $this->filename = $this->sanitize($this->filename);
        $this->logs = "Initialized file upload...<br/>";
    }
    //Sanitize
    function sanitize($filename)
    {
        // remove HTML tags
        $filename = strip_tags($filename);
        // remove non-breaking spaces
        $filename = preg_replace("#\x{00a0}#siu", ' ', $filename);
        // remove illegal file system characters
        $filename = str_replace(array_map('chr', range(0, 31)), '', $filename);
        // remove dangerous characters for file names
        $chars = array(
            "?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "’", "%20",
            "+", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}", "%", "+", "^", chr(0)
        );
        $filename = str_replace($chars, '-', $filename);
        // remove break/tabs/return carriage
        $filename = preg_replace('/[\r\n\t -]+/', '-', $filename);
        // convert some special letters
        $convert = array(
            'Þ' => 'TH', 'þ' => 'th', 'Ð' => 'DH', 'ð' => 'dh', 'ß' => 'ss',
            'Œ' => 'OE', 'œ' => 'oe', 'Æ' => 'AE', 'æ' => 'ae', 'µ' => 'u'
        );
        $filename = strtr($filename, $convert);
        // remove foreign accents by converting to HTML entities, and then remove the code
        $filename = html_entity_decode($filename, ENT_QUOTES, "utf-8");
        $filename = htmlentities($filename, ENT_QUOTES, "utf-8");
        $filename = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $filename);
        // clean up, and remove repetitions
        $filename = preg_replace('/_+/', '_', $filename);
        $filename = preg_replace(array('/ +/', '/-+/'), '-', $filename);
        $filename = preg_replace(array('/-*\.-*/', '/\.{2,}/'), '.', $filename);
        // cut to 255 characters
        $length = 255 - strlen($this->target_directory) + 1;
        $filename = extension_loaded('mbstring') ? mb_strcut($filename, 0, $length, mb_detect_encoding($filename)) : substr($filename, 0, $length);
        // remove bad characters at start and end
        $filename = trim($filename, '.-_');
        return $filename;
    }


    public function process()
    {
        switch ($this->file_data) {
            case strpos($this->file_data, 'base64') !== false:
                $this->logs .= "Image is base64 encoded...<br/>";
                $this->logs .= "Using base64 algorithm for upload...<br/>";
                $this->filename = (!empty($this->filename)) ? $this->filename : "base64_image";
                $this->process_base64();
                break;

            default:
                // $this->process_default();
                $this->logs .= "Image is a normal file...<br/>";
                $this->logs .= "Using default algorithm for upload...<br/>";
                break;
        }
    }
    /**
     * Base64 upload
     */
    public function process_base64()
    {
        $this->process_time = round(microtime(true) - $this->started_time, 3);

        $this->logs .= "Started processing at ... " . time() . "<br/>";

        //
        $this->logs .= "Segmenting base64 data...<br/>";
        $this->logs .= " - base64 data length <b>" . strlen($this->file_data) . "</b><br/>";
        //
        if (preg_match('/^data:image\/(\w+);base64,/', $this->file_data, $type)) {
            $this->file_data = substr($this->file_data, strpos($this->file_data, ',') + 1);
            $this->filetype =  $type = strtolower($type[1]); // jpg, png, gif

            //Check if it is a valid file
            if (!in_array($this->filetype, $this->allowed_files)) {

                $this->logs .= "Invalid file type...<br/>";
                return;
                // throw new \Exception('invalid image type');
            }

            $this->file_data = str_replace(' ', '+', $this->file_data);
            $this->file_data = base64_decode($this->file_data);

            //If failed to decode
            //Throw error
            if ($this->file_data === false) {
                $this->logs .= "Failed to decode base64 data...<br/>";
                return;
                // throw new \Exception('base64_decode failed');
            }
        } else {
            $this->logs .= "Did not match data URI with image data <br/>";
            return;
            // throw new \Exception('did not match data URI with image data');
        }
        $this->save_data($this->target_directory);
        return;
    }
    public function save_data($target_directory)
    {

        $this->target_directory = $target_directory;
        if (!file_exists($this->target_directory)) {
            mkdir($this->target_directory, 0777, true);
            $this->logs .= "Target directory does not exists!<br>";
            $this->logs .= " - creating <b>" . $this->target_directory . "</b> <br/>";
        } else {
            $this->logs .= "Target directory exists, skipping creation.<br>";
        }
        //Checking for safename
        if ($this->safename === true) {
            $this->logs .= "Creating filename safely.<br>";
            $this->filename = $this->sanitize($this->filename);
        } else {
            $this->logs .= "<b>Alert: Safename disabled.</b><br>";
            $this->logs .= "<b> - skipping sanitization.</b><br>";
        }
        //
        $this->logs .= "Saving image data...<br>";
        $targetPath  = $this->target_directory . "/" . $this->filename . "." . $this->filetype;
        if ($this->overwrite === false) {
            if (file_exists($targetPath)) {
                $this->logs .= "File already exists, adding unique identity.<br>";
                $this->uniqueid = uniqid();
                $this->logs .= " - <b>uniqueid: " . $this->uniqueid . "</b>.<br>";
                $this->filename = $this->filename . "_" . $this->uniqueid;
            }
        } else {
            $this->logs .= "Overwrite set to <b>true</b><br>";
            $this->logs .= " - deleting <b>$targetPath</b><br>";
            @unlink($targetPath);
            $this->logs .= " - writing <b>$targetPath</b> ...<br>";
        }
        //targetpath
        $targetpath = $this->targetpath = realpath($this->target_directory);
        $this->logs .= "<b>targetpath: $targetpath</b><br/>";
        $filepath = $this->filepath = str_replace(array("/", "\\"), DIRECTORY_SEPARATOR, $this->targetpath . "/" . $this->filename . "." . $this->filetype);
        $this->fullname = $this->filename . "." . $this->filetype;
        $this->logs .= "<b>filename: " . $this->filename . "</b><br/>";
        $this->logs .= "<b>fullname: " . $this->fullname . "</b><br/>";
        $this->logs .= "<b>filepath:  $filepath</b><br/>";

        if (file_put_contents($filepath, $this->file_data)) {
            $this->filesize = $this->human_filesize(filesize($filepath));

            $this->logs .= "<b>filesize: " . $this->filesize . "</b> <br/>";

            $this->logs .= "Image saved... :-) <br/>";

            $this->end_time = round(microtime(true) - $this->started_time, 3);

            $this->total_time = $this->process_time + $this->end_time;

            $this->logs .= "<b>Total time: " . $this->total_time . "s</b> <br/>";

            $this->success = true;
            return;
        } else {
            $this->success = false;
            $this->logs .= "Could not save image :-( <br/>";
            return false;
        }
    }
    public function human_filesize($bytes, $dec = 2)
    {
        $size   = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor((strlen($bytes) - 1) / 3);

        return ucwords(sprintf("%.{$dec}f", $bytes / pow(1024, $factor)) . @$size[$factor]);
    }

    public function logs()
    {
        echo $this->logs;
    }
}
