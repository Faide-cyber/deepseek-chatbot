<?php
/*
Plugin Name: DeepSeek Chatbot
Description: Simple DeepSeek V3/R1 Chatbot for WordPress
Version: 1.0
Author: Faide-cyber
*/

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'includes/admin-settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/chatbot-frontend.php';

register_activation_hook(__FILE__, 'deepseek_chatbot_activate');
function deepseek_chatbot_activate() {
    add_option('deepseek_api_key', '');
    add_option('deepseek_knowledge_base', '');
}

add_action('init', function() {
    header("Access-Control-Allow-Origin: " . get_site_url());
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
});