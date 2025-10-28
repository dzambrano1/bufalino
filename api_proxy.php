<?php
require_once 'config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $input = file_get_contents('php://input');
        $userMessage = json_decode($input, true);

        if (!isset($userMessage['message'])) {
            throw new Exception('No message provided');
        }

        $data = [
            "model" => "deepseek-chat",
            "messages" => [
                ["role" => "user", "content" => $userMessage['message']]
            ],
            "temperature" => 0.7,
            "max_tokens" => 2000
        ];

        $ch = curl_init(DEEPSEEK_API_URL);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . DEEPSEEK_API_KEY,
                'Content-Type: application/json'
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if ($response === false) {
            throw new Exception('Curl error: ' . curl_error($ch));
        }
        
        if ($httpCode !== 200) {
            $errorData = json_decode($response, true);
            $errorMessage = isset($errorData['error']) ? $errorData['error']['message'] : 'Unknown error';
            throw new Exception("API Error ($httpCode): " . $errorMessage);
        }

        curl_close($ch);
        echo $response;

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            "error" => true,
            "message" => $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        "error" => true,
        "message" => "Method not allowed"
    ]);
}
