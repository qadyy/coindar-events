<?php
class Coindar_Sanitizer {
    public static function sanitize_params($params) {
        return array(
            'page' => isset($params['page']) ? intval($params['page']) : 1,
            'filter_date_start' => isset($params['start_date']) ? sanitize_text_field($params['start_date']) : date('Y-m-d'),
            'filter_date_end' => isset($params['end_date']) ? sanitize_text_field($params['end_date']) : date('Y-m-d', strtotime('+30 days')),
            'tags' => isset($params['tags']) ? sanitize_text_field($params['tags']) : '',
            'sort' => isset($params['sort']) ? sanitize_text_field($params['sort']) : 'date_start'
        );
    }
}