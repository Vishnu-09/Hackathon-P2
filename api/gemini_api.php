class GeminiAPI {
    private $api_key;
    
    public function __construct($api_key) {
        $this->api_key = $api_key;
    }
    
    private function createHealthPrompt($symptoms) {
        return "
            You are an AI health assistant. The user has the following symptoms:
            1. Tiredness: {$symptoms['tiredness']}
            2. Dry Cough: {$symptoms['dry_cough']}
            3. Difficulty in Breathing: {$symptoms['difficulty_breathing']}
            4. Sore Throat: {$symptoms['sore_throat']}
            5. Body Pains: {$symptoms['body_pains']}
            
            Provide 5 concise precautions (20-30 words each) and suggest over-the-counter tablets. 
            Do not include filler sentences or any disclaimers.
        ";
    }
    
    private function createChatPrompt($question, $precautions) {
        return "You are a health assistant. Here are some precautions: {$precautions}. Answer the following question concisely within 15 words: {$question}";
    }
    
    private function makeAPIRequest($prompt) {
        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];
        
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => GeminiConfig::API_URL . '?key=' . $this->api_key,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ],
            CURLOPT_POSTFIELDS => json_encode($data)
        ]);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            throw new Exception("cURL Error: $error");
        }
        
        $result = json_decode($response, true);
        
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            return $result['candidates'][0]['content']['parts'][0]['text'];
        } else {
            throw new Exception("Invalid API response format");
        }
    }
    
    public function getHealthAdvice($symptoms) {
        try {
            $prompt = $this->createHealthPrompt($symptoms);
            return $this->makeAPIRequest($prompt);
        } catch (Exception $e) {
            return "Error getting health advice: " . $e->getMessage();
        }
    }
    
    public function getChatResponse($question, $precautions) {
        try {
            $prompt = $this->createChatPrompt($question, $precautions);
            return $this->makeAPIRequest($prompt);
        } catch (Exception $e) {
            return "Error getting chatbot response: " . $e->getMessage();
        }
    }
}
