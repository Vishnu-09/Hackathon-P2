from flask import Flask, render_template, request, jsonify
from google.generativeai import configure, GenerativeModel

# Configure the API key
configure(api_key="AIzaSyDE9qqkFCTe_d04iF9wOFC5oWTy3ng2yMA")  # Replace with your actual API key

# Initialize the model
model = GenerativeModel("gemini-1.5-pro")

app = Flask(__name__)

# Function to create a prompt for health advice
def create_health_prompt(symptoms):
    return f"""
    You are an AI health assistant. The user has the following symptoms:
    1. Tiredness: {symptoms['tiredness']}
    2. Dry Cough: {symptoms['dry_cough']}
    3. Difficulty in Breathing: {symptoms['difficulty_breathing']}
    4. Sore Throat: {symptoms['sore_throat']}
    5. Body Pains: {symptoms['body_pains']}
    
    Provide 5 concise precautions (20-30 words each) and suggest over-the-counter tablets. 
    Do not include filler sentences or any disclaimers.
    """

# Function to get health advice from the AI model
def get_health_advice(symptoms):
    try:
        prompt = create_health_prompt(symptoms)
        response = model.generate_content(prompt)
        return response.text.strip()
    except Exception as e:
        return f"Error getting health advice: {str(e)}"

# Function to get a straight answer from the chatbot based on a user question
def get_chatbot_response(question, precautions):
    try:
        prompt = f"You are a health assistant. Here are some precautions: {precautions}. Answer the following question concisely within 15 words: {question}"
        response = model.generate_content(prompt)
        return response.text.strip()
    except Exception as e:
        return f"Error getting chatbot response: {str(e)}"

@app.route('/')
def home():
    return render_template('index.html')

@app.route('/get_advice', methods=['POST'])
def get_advice():
    symptoms = request.json
    advice = get_health_advice(symptoms)
    return jsonify({"advice": advice})

@app.route('/chat', methods=['POST'])
def chat():
    data = request.json
    question = data['question']
    precautions = data['precautions']
    response = get_chatbot_response(question, precautions)
    return jsonify({"response": response})

if __name__ == "_main_":
    app.run(debug=True)