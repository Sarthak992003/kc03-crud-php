<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$prompt = $data['prompt'] ?? '';

if (!$prompt) {
  echo json_encode(["reply" => "Error: Empty prompt"]);
  exit;
}

$apiKey = 'AIzaSyDTx2dV0Xa53FHtFSl2qdHtg3dI8TB273Y'; // 🔁 Replace with your actual key

// ✅ Correct version & endpoint:
$endpoint = "https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key=$apiKey";

$payload = json_encode([
  "contents" => [
    [
      "parts" => [
        ["text" => $prompt]
      ]
    ]
  ]
]);

$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
  echo json_encode(["reply" => "Curl error: $error"]);
  exit;
}

$result = json_decode($response, true);

if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
  echo json_encode(["reply" => $result['candidates'][0]['content']['parts'][0]['text']]);
} else {
  echo json_encode(["reply" => "Gemini API error: " . json_encode($result)]);
}
