<?php
add_action('wp_footer', 'deepseek_chatbot_interface');
function deepseek_chatbot_interface() {
    wp_enqueue_style('deepseek-chatbot-style', plugins_url('assets/style.css', __FILE__));
    wp_enqueue_script('deepseek-chatbot-script', plugins_url('assets/script.js', __FILE__), ['jquery'], null, true);
    
    wp_localize_script('deepseek-chatbot-script', 'deepseek_params', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);

    echo '
    <div id="deepseek-chatbot-container">
        <div class="chat-header">
            <span>AI助手</span>
            <button id="toggle-chat">−</button>
        </div>
        <div class="chat-body"></div>
        <div class="chat-input">
            <input type="text" placeholder="输入问题...">
            <button id="send-message">发送</button>
        </div>
    </div>';
}

add_action('wp_ajax_deepseek_chat', 'handle_deepseek_chat');
add_action('wp_ajax_nopriv_deepseek_chat', 'handle_deepseek_chat');
function handle_deepseek_chat() {
    $api_key = get_option('deepseek_api_key');
    $knowledge = get_option('deepseek_knowledge_base');
    $session_id = sanitize_text_field($_POST['session_id']);
    $message = sanitize_text_field($_POST['message']);

    // 获取当前会话历史（若无则为空数组）
    $history = get_transient("deepseek_session_{$session_id}") ?: [];
    
    // 如果是首次会话，则加入系统消息（这里对知识库内容进行截断，防止内容过长）
    if (empty($history)) {
        // 可根据需要修改截断长度（例如 6000 个字符）deepseek api最多输入文字为6.4k左右 
	// 相关文档https://api-docs.deepseek.com/zh-cn/quick_start/pricing
        $trimmed_knowledge = mb_substr($knowledge, 0, 7000);

	// 提示内容可选 推荐content整个字段放入后台 以下为案例
        array_push($history, [
            'role' => 'system',
            'content' => "你是是由深度求索（DeepSeek）公司开发的智能助手DeepSeek-V3。扮演的角色是一名高校辅导员知识助手，请严格根据以下知识库内容回答问题：使用文本格式进行回答，不需要返回 markdown 格式。\n{$trimmed_knowledge}\n如果问题不在知识库范围内，请回答：'该问题不在我的知识范围内,请试试提问别的问题吧～'，但请注意，如果提问的问题在知识库范围内，则不能输出该句话。"
        ]);
    }

    // 添加用户最新消息
    array_push($history, ['role' => 'user', 'content' => $message]);

    // 裁剪对话历史：保留系统消息和最近几轮对话，防止token超限（这里以字符数简单估算，可根据实际情况调整）
    $max_chars = 8000; // 此处上限根据DeepSeek API的token限制调整 答案输出最大可设置（max_tokens） 8K tokens。
    $history = trim_conversation_history($history, $max_chars);

    // 构造请求payload，设置合适的temperature 相关文档:https://api-docs.deepseek.com/zh-cn/quick_start/parameter_settings
    $payload = [
        'model' => 'deepseek-chat',
        'messages' => $history,
        'stream' => false,
        'temperature' => 0.7,
    ];

    $response = wp_remote_post('https://api.deepseek.com/chat/completions', [
        'headers' => [
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $api_key
        ],
        'body'    => json_encode($payload),
        'timeout' => 30
    ]);

    if (is_wp_error($response)) {
        wp_send_json_error($response->get_error_message());
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    $answer = $body['choices'][0]['message']['content'];

    // 将助手回复加入会话历史并保存
    array_push($history, ['role' => 'assistant', 'content' => $answer]);
    set_transient("deepseek_session_{$session_id}", $history, 12 * HOUR_IN_SECONDS);
    wp_send_json_success($answer);
}

/**
 * 裁剪对话历史
 * 保留第一条系统消息，并从后往前累计最近的用户和助手消息，
 * 直到总字符数达到上限。既保证系统指令始终存在，又能控制传输内容的长度。
 *
 * @param array $history 当前对话历史
 * @param int   $max_chars 最大字符数限制
 * @return array 裁剪后的对话历史
 */
function trim_conversation_history($history, $max_chars) {
    if (empty($history)) {
        return $history;
    }
    
    // 保留第一条系统消息
    $system_message = $history[0];
    $trimmed_history = [$system_message];
    $total_chars = mb_strlen($system_message['content']);
    
    // 从后往前累计最新的用户和助手消息
    $other_messages = array_slice($history, 1);
    $reversed = array_reverse($other_messages);
    $accumulated = [];
    
    foreach ($reversed as $msg) {
        $msg_length = mb_strlen($msg['content']);
        if ($total_chars + $msg_length <= $max_chars) {
            $accumulated[] = $msg;
            $total_chars += $msg_length;
        } else {
            break;
        }
    }
    
    // 逆序添加，再恢复正序
    $accumulated = array_reverse($accumulated);
    
    return array_merge([$system_message], $accumulated);
}

add_action('wp_ajax_deepseek_get_history', 'handle_get_history');
add_action('wp_ajax_nopriv_deepseek_get_history', 'handle_get_history');
function handle_get_history() {
    $session_id = sanitize_text_field($_POST['session_id']);
    $history = get_transient("deepseek_session_{$session_id}") ?: [];
    // 仅返回用户与助手对话部分，系统消息不展示
    $filtered_history = array_values(array_filter($history, function($msg) {
        return in_array($msg['role'], ['user', 'assistant']);
    }));
    wp_send_json_success($filtered_history);
}
?>
