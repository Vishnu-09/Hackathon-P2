header('Content-Type: application/json');
require_once 'config.php';
require_once 'gemini_api.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gemini = new GeminiAPI(GeminiConfig::API_KEY);
    $question = $_POST['question'] ?? '';
    $precautions = $_POST['precautions'] ?? '';
    
    $response = $gemini->getChatResponse($question, $precautions);
    echo json_encode(['response' => $response]);
}