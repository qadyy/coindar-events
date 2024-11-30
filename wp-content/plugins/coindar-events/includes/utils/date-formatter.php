<?php
class Coindar_Date_Formatter {
    public static function format_date($date_string) {
        $date = new DateTime($date_string);
        return $date->format('F j, Y');
    }

    public static function get_default_start_date() {
        return date('Y-m-d');
    }

    public static function get_default_end_date() {
        return date('Y-m-d', strtotime('+30 days'));
    }
}