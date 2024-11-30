<?php
class Coindar_Events {
    private $api;

    public function __construct() {
        $this->api = new Coindar_API();
        add_action('wp_ajax_get_coindar_events', array($this, 'ajax_get_events'));
        add_action('wp_ajax_nopriv_get_coindar_events', array($this, 'ajax_get_events'));
    }

    public function ajax_get_events() {
        check_ajax_referer('coindar_events_nonce', 'nonce');

        $params = array(
            'page' => isset($_GET['page']) ? intval($_GET['page']) : 1,
            'filter_date_start' => isset($_GET['filter_date_start']) ? sanitize_text_field($_GET['filter_date_start']) : date('Y-m-d'),
            'filter_date_end' => isset($_GET['filter_date_end']) ? sanitize_text_field($_GET['filter_date_end']) : date('Y-m-d', strtotime('+30 days')),
            'filter_tags' => isset($_GET['filter_tags']) ? sanitize_text_field($_GET['filter_tags']) : '',
            'sort_by' => isset($_GET['sort_by']) ? sanitize_text_field($_GET['sort_by']) : 'date_start',
            'order_by' => isset($_GET['order_by']) ? intval($_GET['order_by']) : 0
        );

        $response = $this->api->get_events($params);
        wp_send_json($response);
    }

    public function get_tags() {
        $response = $this->api->get_tags();
        return $response['success'] ? $response['data'] : array();
    }
}