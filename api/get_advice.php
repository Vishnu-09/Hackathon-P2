header('Content-Type: application/json');
require_once 'config.php';
require_once 'gemini_api.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gemini = new GeminiAPI(GeminiConfig::API_KEY);
    $symptoms = $_POST;
    
    $response = $gemini->getHealthAdvice($symptoms);
    echo json_encode(['advice' => $response]);
}