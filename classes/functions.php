<?php
class General
{
    // Other functions and properties...

    public function formatDate($timestamp)
    {

        date_default_timezone_set('Asia/Manila');

        $currentTimestamp = time();
        $timestamp = is_numeric($timestamp) ? intval($timestamp) : strtotime($timestamp);
        $difference = $currentTimestamp - $timestamp;

        if ($difference < 60) {
            return "Just now";
        } elseif ($difference < 120) {
            return "A minute ago";
        } elseif ($difference < 3600) {
            $minutes = floor($difference / 60);
            return $minutes . " minutes ago";
        } elseif ($difference < 86400) {
            $hours = floor($difference / 3600);
            return $hours . " hours ago";
        } elseif ($difference < 604800) {
            $days = floor($difference / 86400);
            return $days . " days ago";
        } elseif ($difference < 2419200) {
            $weeks = floor($difference / 604800);
            return $weeks . " weeks ago";
        } elseif ($difference < 4838400) {
            return "A month ago";
        } else {
            return date("M j, Y", $timestamp);
        }
    }
}
