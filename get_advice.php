<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $symptoms = json_decode(file_get_contents('php://input'), true);

    // Call the AI model here (replace this with actual API call)
    $advice = get_health_advice($symptoms);
    
    echo json_encode(["advice" => $advice]);
}

function get_health_advice($symptoms) {
    // Simulate AI response for demo purposes
    return "1. Rest well.\n2. Stay hydrated.\n3. Use cough syrup.\n4. Take pain relief medication.\n5. Consult a doctor if symptoms persist.";
}
?>