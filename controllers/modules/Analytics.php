<?php

/**
 *  ==========================================
 * ||||||       A N A L Y T I C S       ||||||
 * ==========================================
 * 
 * Include controllers/database.php
 * Include controllers/modules/core.php
 * Include controllers/functions.php 
 * before including Analytics.php
 * Analytics.php is dependent upon functions.php
 * As it uses Page Class to find page details such as 
 * *Owner ID, *Page Id, *Page name, *Owner name
 * 
 */

// session_name("PP");
// session_start();

// include_once __DIR__ . "/../database.php";
// include_once __DIR__ . "/core.php";
// include_once __DIR__ . "/Encryption.php";
// include_once __DIR__ . "/../functions.php";

// $handle = new CodeFlirt\Handlers;
// $User = new User();

class Analytics extends User
{
    protected $pageid;
    protected $userid;
    protected $category;
    protected $analysis_data;
    protected $labels;
    protected $total_links;
    protected $total_link_clicks;
    protected $page_analysis_data;
    protected $total_page_views = 0;
    protected $page_visit_labels;
    protected $total_clicks_onday = 0;
    //RESPONSES
    protected $response_count = 0;
    protected $feedback_count = 0;

    /**
     * @param mix $pageid
     *  
     */
    //
    public function __construct($pageid)
    {
        $this->pageid = $pageid;
        $this->userid = self::AuthID();
    }

    /**
     * @param $category sucs as links, page, chat, response
     */
    public function Analyze(string $category)
    {
        $this->category = $category;

        switch ($this->category) {
            case 'LINKS':
                return $this->analyze_links();
                break;
            case 'PAGE':
                return $this->analyze_page();
                break;

            default:
                # code...
                break;
        }
        return;
    }

    //Analyze links
    public function analyze_links()
    {
        //Request ANALYTICS data
        $this->analysis_data = (new CodeFlirt\Fetch)->data("analytics", "date, analytics", "page_id='" . $this->pageid . "' AND user_id='" . $this->userid . "'", "row");
        //Request Links configs
        $fetch_link_configs = (new CodeFlirt\Fetch)->data("links", "link_configs", "page_id='" . $this->pageid . "' AND user_id='" . $this->userid . "'");
        //
        $fetch_link_configs = json_decode($fetch_link_configs, true);
        //
        foreach ($fetch_link_configs as $key => $value) {
            if (strpos($key, "link_") !== false) {
                $this->labels[] = "'" . $value["link_title"] . "'";
            }
        }
        $prepare_analytic_data = array();
        //
        $data = $this->analysis_data;
        //clean up
        $this->analysis_data = null;
        //
        $tmp = array(); //temporarily store analytics data
        if ($data && count($data) > 0) {

            foreach ($data as $row) {
                $analytics = json_decode($row["analytics"], true);
                $this->total_clicks_onday = count($analytics);
                //
                foreach ($analytics as $x => $data_value) {
                    $tmp[$row["date"]][$data_value["analysis"]["link"]["id"]] = $data_value["analysis"]["link"]["visits"];
                    //
                    foreach ($fetch_link_configs as $key => $value) {
                        if (strpos($key, "link_") !== false) {
                            //Create labels
                            if (isset($tmp[$row["date"]][$value["id"]])) {
                                $value["visits"] = $tmp[$row["date"]][$value["id"]];
                                //
                                $this->total_link_clicks += 1;
                                //
                            } else {
                                $value["visits"] = 0;
                                $this->total_link_clicks += 0;
                            }
                            $prepare_analytic_data[] = $value;
                        }
                    }
                    $this->analysis_data[$row["date"]] = $prepare_analytic_data;
                    $prepare_analytic_data = null;
                }
            }
            //sort by ascending order
            ksort($this->analysis_data);
            return ($this->analysis_data);
        } else {
            return false;
        }
    }
    public function TotalClicksOnday()
    {
        return $this->total_clicks_onday;
    }
    public function Analytics_labels()
    {
        return $this->labels;
    }
    public function TotalLinks()
    {
        if ($this->labels && count($this->labels) > 0) {
            return count($this->labels);
        } else {
            return 0;
        }
    }
    public function TotalLinkClicks()
    {
        return ($this->total_link_clicks);
    }
    //
    //Page analytics
    public function analyze_page()
    {
        //Request ANALYTICS data
        $this->page_analysis_data = (new CodeFlirt\Fetch)->data("page_views", "date, analytics", "page_id='" . $this->pageid . "'", "row");
        if ($this->page_analysis_data && count($this->page_analysis_data) > 0) {

            $page_data = $this->page_analysis_data;
            //cleanup
            $this->page_analysis_data = null;
            foreach ($page_data as $row) {
                //
                // set page_visit data labels
                $page_views = json_decode($row["analytics"], true);
                //
                foreach ($page_views as $views) {
                    $this->page_analysis_data[$row["date"]] = count($page_views);
                    //Add to page views
                    $this->total_page_views += 1;
                }
            }
            //Sort by Ascending
            ksort($this->page_analysis_data);
        } else {
            $this->page_analysis_data = 0;
        }
        return $this->page_analysis_data;
    }
    public function TotalPageViews()
    {
        if (($this->total_page_views) > 0) {
            return $this->abreviateTotalCount($this->total_page_views);
        } else {
            return 0;
        }
    }
    public function Analytics_page_labels()
    {
        ksort($this->page_visit_labels);
        return $this->page_visit_labels;
    }
    function abreviateTotalCount($value)
    {

        $abbreviations = array(12 => 'T', 9 => 'B', 6 => 'M', 3 => 'K', 0 => '');

        foreach ($abbreviations as $exponent => $abbreviation) {

            if ($value >= pow(10, $exponent)) {

                return round(floatval($value / pow(10, $exponent)), 1) . $abbreviation;
            } else if ($value < 10) {
                return "0" . $value;
            }
        }
    }

    /**
     * RESPONSE ANALYTICS
     */
    public function ResponseCount()
    {
        /**
         * Fetch Responses for current analytics page
         * 
         */
        $fetch_responses = (new CodeFlirt\Fetch)->data("page-responses", "page_response", "page_id='" . $this->pageid . "'");
        //Since now we have data
        //Just count and return total responses
        $unbind_responses = unserialize($fetch_responses);
        if ($fetch_responses && count($unbind_responses) > 0) {
            $this->response_count = count($unbind_responses);
        } else {
            $this->response_count = 0;
        }
        return $this->abreviateTotalCount($this->response_count);
    }

    /**
     * FEEDBACK ANALYTICS
     */
    public function FeedbackCount()
    {
        /**
         * Fetch Responses for current analytics page
         * 
         */
        $fetch_feedback = (new CodeFlirt\Fetch)->data("page-feedbacks", "page_feedback", "page_id='" . $this->pageid . "'");
        //Since now we have data
        //Just count and return total responses
        $unbind_feedbacks = unserialize($fetch_feedback);
        if ($fetch_feedback && count($unbind_feedbacks) > 0) {
            $this->feedback_count = count($unbind_feedbacks);
        } else {
            $this->feedback_count = 0;
        }
        return $this->abreviateTotalCount($this->feedback_count);
    }
}
