$(document).ready(function() {
    let isChatting = true;

    $('#get-advice').click(function() {
        const symptoms = {
            tiredness: $('#tiredness').val(),
            dry_cough: $('#dry_cough').val(),
            difficulty_breathing: $('#difficulty_breathing').val(),
            sore_throat: $('#sore_throat').val(),
            body_pains: $('#body_pains').val(),
        };

        $.ajax({
            url: '/api.php/get_advice',  // Ensure this URL is correct
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(symptoms),
            success: function(response) {
                $('#advice-text').text(response.advice);
                $('#advice-section').show();
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                alert("An error occurred while fetching advice. Please try again.");
            }
        });
    });

    $('#ask-question').click(function() {
        if (isChatting) {
            const question = $('#user-question').val();
            const precautions = $('#advice-text').text();

            $.ajax({
                url: '/api.php/chat',  // Ensure this URL is correct
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ question: question, precautions: precautions }),
                success: function(response) {
                    $('#chat-responses').append(<p><strong>You:</strong> ${question}</p><p><strong>AI:</strong> ${response.response}</p>);
                    $('#user-question').val('');
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert("An error occurred while fetching the chatbot response. Please try again.");
                }
            });
        }
    });

    $('#stop-chat').click(function() {
        isChatting = false;
        $('#chat-responses').append("<p><strong>Chat ended.</strong> Thank you for using the AI Health Assistant!</p>");
    });
});