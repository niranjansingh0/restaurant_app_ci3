<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Chatbot API endpoint
     */
    public function chatbot() {
        header('Content-Type: application/json');

        // Read input
        $input = json_decode(file_get_contents('php://input'), true);
        $user_message = trim($input['message'] ?? '');

        if (empty($user_message)) {
            echo json_encode(['reply' => 'Please ask something 🙂']);
            return;
        }

        // API KEY
        $api_key = 'AIzaSyBTPM6bsQPVIVEqeu7xr2Ya7P6nyWTkttw';

        // API endpoint
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=$api_key";

        // Request payload
        $data = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        [
                            'text' => "You are a food ordering assistant for a restaurant website.
Answer only questions related to food, menu, prices, orders, delivery, restaurant timing.
If the question is unrelated, politely refuse.

User question: $user_message"
                        ]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 300
            ]
        ];

        // cURL call
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            echo json_encode(['reply' => 'Server error: ' . curl_error($ch)]);
            curl_close($ch);
            return;
        }

        curl_close($ch);

        // Decode response
        $result = json_decode($response, true);

        // Handle API errors
        if (isset($result['error'])) {
            echo json_encode(['reply' => 'API Error: ' . $result['error']['message']]);
            return;
        }

        // Extract text safely
        $reply = $result['candidates'][0]['content']['parts'][0]['text'] ?? "Sorry, I couldn't understand.";

        echo json_encode(['reply' => $reply]);
    }

    /**
     * List models endpoint
     */
    public function list_models() {
        header('Content-Type: application/json');
        
        // This is a placeholder - you can implement model listing if needed
        echo json_encode([
            'models' => ['gemini-2.5-flash'],
            'status' => 'ok'
        ]);
    }
}
