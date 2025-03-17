<?php
add_action('admin_menu', 'deepseek_chatbot_settings_menu');
function deepseek_chatbot_settings_menu() {
    add_options_page(
        'DeepSeek Chatbot Settings',
        'DeepSeek Chatbot',
        'manage_options',
        'deepseek-chatbot-settings',
        'deepseek_chatbot_settings_page'
    );
}

function deepseek_chatbot_settings_page() {
    ?>
    <div class="wrap">
        <h2>DeepSeek Chatbot Settings</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('deepseek_chatbot_settings');
            do_settings_sections('deepseek_chatbot_settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', 'deepseek_chatbot_register_settings');
function deepseek_chatbot_register_settings() {
    register_setting('deepseek_chatbot_settings', 'deepseek_api_key', [
        'sanitize_callback' => 'sanitize_text_field',
        'default' => ''
    ]);

    register_setting('deepseek_chatbot_settings', 'deepseek_knowledge_base', [
        'sanitize_callback' => 'sanitize_textarea_field',
        'default' => ''
    ]);

    add_settings_section('main_section', 'API Settings', null, 'deepseek_chatbot_settings');

    add_settings_field('deepseek_api_key', 'API Key', function() {
        $api_key = get_option('deepseek_api_key');
        echo '<input type="text" name="deepseek_api_key" value="' . esc_attr($api_key) . '" style="width: 300px;">';
    }, 'deepseek_chatbot_settings', 'main_section');

    add_settings_field('deepseek_knowledge_base', 'Knowledge Base', function() {
        $knowledge = get_option('deepseek_knowledge_base');
        echo '<textarea name="deepseek_knowledge_base" rows="10" style="width: 100%;">' . esc_textarea($knowledge) . '</textarea>';
    }, 'deepseek_chatbot_settings', 'main_section');
}
