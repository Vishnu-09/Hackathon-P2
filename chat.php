<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $question = $data['question'];
    $precautions = $data['precautions'];

    // Call the AI model here (replace this with actual API call)
    $response = get_chatbot_response($question, $precautions);

    echo json_encode(["response" => $response]);
}

function get_chatbot_response($question, $precautions) {
    // Simulate AI response for demo purposes
    return "For {$precautions}, consider seeing a doctor.";
}
?>