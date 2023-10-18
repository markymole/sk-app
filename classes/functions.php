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
            return $minutes . " minute" . ($minutes > 1 ? "s" : "") . " ago";
        } elseif ($difference < 86400) {
            $hours = floor($difference / 3600);
            return $hours . " hour" . ($hours > 1 ? "s" : "") . " ago";
        } elseif ($difference < 604800) {
            $days = floor($difference / 86400);
            return $days . " day" . ($days > 1 ? "s" : "") . " ago";
        } elseif ($difference < 2419200) {
            $weeks = floor($difference / 604800);
            return $weeks . " week" . ($weeks > 1 ? "s" : "") . " ago";
        } elseif ($difference < 4838400) {
            return "A month ago";
        } else {
            return date("M j, Y", $timestamp);
        }
    }



    public function messageDateFormat($timestamp)
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
            return $minutes . "m";
        } elseif ($difference < 86400) {
            $hours = floor($difference / 3600);
            return $hours . "h";
        } elseif ($difference < 604800) {
            $days = floor($difference / 86400);
            return $days . "d";
        } elseif ($difference < 2419200) {
            $weeks = floor($difference / 604800);
            return $weeks . "w";
        } elseif ($difference < 4838400) {
            $months = floor($difference / 2419200);
            return $months . "m";
        } elseif ($difference < 29030400) {
            return "1y";
        } else {
            return date("M j, Y", $timestamp);
        }
    }
}
