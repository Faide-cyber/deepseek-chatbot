(function($) {
    $(document).ready(function() {
        const container = $('#deepseek-chatbot-container');
        const chatBody = container.find('.chat-body');
        const inputField = container.find('input');
        const $sendButton = $('#send-message');
        
        let sessionId = localStorage.getItem('deepseek_session_id') || 
            `sess_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;
        localStorage.setItem('deepseek_session_id', sessionId);

        // 加载历史会话
        $.ajax({
            url: window.deepseek_params.ajax_url,
            method: 'POST',
            data: {
                action: 'deepseek_get_history',
                session_id: sessionId
            },
            success: function(response) {
                if (response.success && Array.isArray(response.data)) {
                    response.data.forEach(msg => {
                        const isUser = msg.role === 'user';
                        chatBody.append(`
                            <div class="${isUser ? 'user' : 'bot'}-message">
                                <div class="message-content">${msg.content}</div>
                            </div>
                        `);
                    });
                    chatBody.scrollTop(chatBody[0].scrollHeight);
                }
            }
        });

        $('#toggle-chat').click(function() {
            container.toggleClass('collapsed');
        });

        $('#send-message').click(sendMessage);
        inputField.keypress(e => e.which === 13 && sendMessage());

        function sendMessage() {
            const message = inputField.val().trim();
            if (!message) return;

            chatBody.append(`
                <div class="user-message">
                    <div class="message-content">${message}</div>
                </div>
            `);

            $.ajax({
                url: window.deepseek_params.ajax_url,
                method: 'POST',
                data: {
                    action: 'deepseek_chat',
                    message: message,
                    session_id: sessionId
                },
                beforeSend: () => {
                    inputField.val('');
                    $sendButton.prop('disabled', true);
                    chatBody.append('<div class="loading">思考中...</div>');
                },
                success: response => {
                    if (response.success) {
                        chatBody.append(`
                            <div class="bot-message">
                                <div class="message-content">${response.data}</div>
                            </div>
                        `);
                    } else {
                        chatBody.append(`<div class="error">服务器繁忙，请稍后再试。</div>`);
                    }
                },
                error: () => chatBody.append('<div class="error">服务器繁忙，请稍后再试。</div>'),
                complete: () => {
                    $('.loading').remove();
                    $sendButton.prop('disabled', false);
                    chatBody.scrollTop(chatBody[0].scrollHeight);
                }
            });
        }
    });
})(jQuery);
