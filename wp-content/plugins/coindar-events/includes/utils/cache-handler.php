<?php
class Coindar_Cache_Handler {
    private static $cache_group = 'coindar_events';
    private static $cache_time = 300; // 5 minutes

    public static function get_cache_key($params) {
        return 'coindar_' . md5(serialize($params));
    }

    public static function get($key) {
        return get_transient($key);
    }

    public static function set($key, $data) {
        set_transient($key, $data, self::$cache_time);
    }

    public static function delete($key) {
        delete_transient($key);
    }

    public static function flush_cache() {
        global $wpdb;
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_coindar_%'");
    }
}