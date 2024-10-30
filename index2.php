<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Health Assistant</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="title">AI DIAGNOSIS</h1>
        
        <!-- Symptom Input Form -->
        <div id="symptoms-form">
            <h2>Enter Your Symptoms</h2>
            <label>Tiredness: <input type="text" id="tiredness"></label><br>
            <label>Dry Cough: <input type="text" id="dry_cough"></label><br>
            <label>Difficulty Breathing: <input type="text" id="difficulty_breathing"></label><br>
            <label>Sore Throat: <input type="text" id="sore_throat"></label><br>
            <label>Body Pains: <input type="text" id="body_pains"></label><br>
            <button id="get-advice">Get Advice</button>
        </div>

        <!-- Advice and Chat Section -->
        <div id="advice-section" style="display:none;">
            <div class="advice-container">
                <h2>Precautions and Suggested Tablets</h2>
                <div id="advice-text" class="formatted-text"></div>
            </div>

            <!-- Chatbot Interaction Section -->
            <div class="chat-container">
                <h3>Chat with AI</h3>
                <input type="text" id="user-question" placeholder="Type your question..." class="input-field">
                <button id="ask-question" class="button">Ask</button>
                <button id="stop-chat" class="button stop">Stop Chat</button>
                <div id="chat-responses" class="chat-box"></div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>