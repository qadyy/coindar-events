<?php
require_once COINDAR_PLUGIN_PATH . 'includes/utils/logger.php';

class Coindar_Error_Handler {
    public static function handle_api_error($error) {
        Coindar_Logger::error('API Error: ' . print_r($error, true));
        
        $error_message = self::get_user_friendly_message($error);
        
        return array(
            'success' => false,
            'message' => $error_message
        );
    }

    public static function render_error_message($message) {
        return sprintf(
            '<div class="coindar-error">%s</div>',
            esc_html($message)
        );
    }

    private static function get_user_friendly_message($error) {
        $known_errors = array(
            'invalid_token' => 'Authentication failed. Please check your API token.',
            'rate_limit' => 'Too many requests. Please try again in a few minutes.',
            'invalid_params' => 'Invalid request parameters.',
            'service_unavailable' => 'The service is temporarily unavailable.',
            'invalid_json' => 'Invalid response from the server.',
            'http_401' => 'Authentication failed. Please check your API token.',
            'http_403' => 'Access denied. Please check your API permissions.',
            'http_404' => 'The requested resource was not found.',
            'http_429' => 'Too many requests. Please try again in a few minutes.',
            'http_500' => 'Server error. Please try again later.',
            'http_503' => 'Service temporarily unavailable. Please try again later.'
        );

        foreach ($known_errors as $pattern => $message) {
            if (stripos($error, $pattern) !== false) {
                return $message;
            }
        }

        return 'An error occurred while fetching events. Please try again later.';
    }
}