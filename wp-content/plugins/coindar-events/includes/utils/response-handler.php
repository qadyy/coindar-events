<?php
class Coindar_Response_Handler {
    public static function format_api_response($response) {
        if (!$response['success']) {
            return array(
                'success' => false,
                'message' => $response['message'],
                'data' => null
            );
        }

        return array(
            'success' => true,
            'data' => $response['data'],
            'pagination' => array(
                'current_page' => $response['data']->page ?? 1,
                'total_pages' => $response['data']->total_pages ?? 1
            )
        );
    }

    public static function send_json_response($data) {
        wp_send_json($data);
    }
}