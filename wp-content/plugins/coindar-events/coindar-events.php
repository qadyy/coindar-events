<?php
/**
 * Plugin Name: Coindar Events
 * Description: Display cryptocurrency events from Coindar API with filtering options
 * Version: 1.0.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit;
}

define('COINDAR_API_TOKEN', '80795:c7m3cCEQno1GXMCZVqc');
define('COINDAR_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('COINDAR_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once COINDAR_PLUGIN_PATH . 'includes/class-coindar-api.php';
require_once COINDAR_PLUGIN_PATH . 'includes/class-coindar-events.php';
require_once COINDAR_PLUGIN_PATH . 'includes/class-coindar-shortcode.php';

// Initialize the plugin
function coindar_events_init() {
    new Coindar_Events();
    new Coindar_Shortcode();
}
add_action('plugins_loaded', 'coindar_events_init');

// Enqueue scripts and styles
function coindar_enqueue_assets() {
    wp_enqueue_style(
        'coindar-events-style',
        COINDAR_PLUGIN_URL . 'assets/css/coindar-events.css',
        array(),
        '1.0.0'
    );

    wp_enqueue_script(
        'coindar-events-script',
        COINDAR_PLUGIN_URL . 'assets/js/coindar-events.js',
        array('jquery'),
        '1.0.0',
        true
    );

    wp_localize_script('coindar-events-script', 'coindarAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('coindar_events_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'coindar_enqueue_assets');