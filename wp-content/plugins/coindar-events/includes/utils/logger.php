<?php
class Coindar_Logger {
    private static $log_enabled = WP_DEBUG;

    public static function log($message, $type = 'info') {
        if (!self::$log_enabled) {
            return;
        }

        $log_message = sprintf(
            '[%s] [%s] %s',
            current_time('Y-m-d H:i:s'),
            strtoupper($type),
            is_string($message) ? $message : print_r($message, true)
        );

        error_log($log_message);
    }

    public static function error($message) {
        self::log($message, 'error');
    }

    public static function info($message) {
        self::log($message, 'info');
    }

    public static function debug($message) {
        self::log($message, 'debug');
    }
}