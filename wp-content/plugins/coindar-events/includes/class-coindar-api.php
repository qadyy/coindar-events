<?php
class Coindar_API {
    private $api_token;
    private $api_base_url = 'https://coindar.org/api/v2/';

    public function __construct() {
        $this->api_token = COINDAR_API_TOKEN;
    }

    public function get_events($params = array()) {
        $default_params = array(
            'page' => 1,
            'page_size' => 30,
            'filter_date_start' => date('Y-m-d'),
            'filter_date_end' => date('Y-m-d', strtotime('+30 days')),
            'sort_by' => 'date_start',
            'order_by' => 0
        );

        $params = wp_parse_args($params, $default_params);
        
        // Map internal param names to API param names
        $api_params = array(
            'access_token' => $this->api_token,
            'page' => $params['page'],
            'page_size' => $params['page_size'],
            'filter_date_start' => $params['filter_date_start'],
            'filter_date_end' => $params['filter_date_end'],
            'filter_tags' => !empty($params['tags']) ? $params['tags'] : '',
            'sort_by' => $params['sort_by'],
            'order_by' => $params['order_by']
        );
        
        $url = add_query_arg($api_params, $this->api_base_url . 'events');
        
        $response = wp_remote_get($url);

        if (is_wp_error($response)) {
            return array(
                'success' => false,
                'message' => $response->get_error_message()
            );
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body);

        if (!$data) {
            return array(
                'success' => false,
                'message' => 'Invalid response from API'
            );
        }

        return array(
            'success' => true,
            'data' => $data
        );
    }

    public function get_tags() {
        $url = add_query_arg(array(
            'access_token' => $this->api_token
        ), $this->api_base_url . 'tags');

        $response = wp_remote_get($url);

        if (is_wp_error($response)) {
            return array(
                'success' => false,
                'message' => $response->get_error_message()
            );
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (!$data) {
            return array(
                'success' => false,
                'message' => 'Invalid response from API'
            );
        }

        $formatted_tags = array();
        foreach ($data as $tag) {
            $formatted_tags[] = (object) array(
                'id' => $tag['id'],
                'name' => $tag['name']
            );
        }

        return array(
            'success' => true,
            'data' => $formatted_tags
        );
    }
}