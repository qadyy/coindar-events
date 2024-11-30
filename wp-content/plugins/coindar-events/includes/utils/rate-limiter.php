<?php
class Coindar_Rate_Limiter {
    private static $rate_limit_key = 'coindar_rate_limit';
    private static $max_requests = 30; // Maximum requests per minute
    private static $window_size = 60; // Time window in seconds

    public static function check_rate_limit() {
        $current_time = time();
        $requests = get_transient(self::$rate_limit_key);

        if (!$requests) {
            $requests = array();
        }

        // Remove old requests
        $requests = array_filter($requests, function($timestamp) use ($current_time) {
            return $timestamp > ($current_time - self::$window_size);
        });

        // Add current request
        $requests[] = $current_time;

        // Store updated requests
        set_transient(self::$rate_limit_key, $requests, self::$window_size);

        return count($requests) <= self::$max_requests;
    }

    public static function get_remaining_limit() {
        $requests = get_transient(self::$rate_limit_key) ?: array();
        return max(0, self::$max_requests - count($requests));
    }

    public static function get_reset_time() {
        $requests = get_transient(self::$rate_limit_key) ?: array();
        if (empty($requests)) {
            return 0;
        }
        return min($requests) + self::$window_size - time();
    }
}