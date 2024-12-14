<?php
// chatbot.php

header('Content-Type: application/json');

// Replace 'YOUR_GROK_API_KEY_HERE' with your actual Grok API key
$api_key = 'xai-xPXNERKG13wdMZPVxMVuGhwxHLemskSiOyVM1OpdwA1SQCji1F5ONr7o3Fwuf8nz1XGsMi5MdfwOWmpW'; // Ideally, retrieve this from a secure location

// Grok API endpoint
$api_url = 'https://api.x.ai/v1/chat/completions';

// Get the POST data from the frontend
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['message'])) {
    echo json_encode(['reply' => 'Invalid request.']);
    exit;
}

$user_message = $input['message'];

// Prepare the data for the API request
$data = [
    "messages" => [
        [
            "role" => "system",
            "content" => "You are a test assistant."
        ],
        [
            "role" => "user",
            "content" => $user_message
        ]
    ],
    "model" => "grok-beta",
    "stream" => false,
    "temperature" => 0
];

// Encode the data to JSON
$jsonData = json_encode($data);

// Initialize cURL
$ch = curl_init($api_url);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $jsonData,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer $api_key"
    ],
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_VERIFYPEER => true
]);

// Execute the API request
$response = curl_exec($ch);

// Check for cURL errors
if ($response === false) {
    echo json_encode(['reply' => 'Error communicating with the API.']);
    curl_close($ch);
    exit;
}

curl_close($ch);

// Decode the API response
$response_data = json_decode($response, true);

// Adjust the response parsing based on Grok's API response structure
if (isset($response_data['choices'][0]['message']['content'])) {
    $bot_reply = trim($response_data['choices'][0]['message']['content']);
    echo json_encode(['reply' => $bot_reply]);
} else {
    echo json_encode(['reply' => 'Sorry, I could not understand that.']);
}
?>
