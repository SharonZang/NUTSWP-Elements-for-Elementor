<?php
/*
Plugin Name: NUTSWP Elements for Elementor
Description: 该插件由NUTSWP基于DeepSeek开发，实现添加一些实用小部件到Elementor中，包含Bilibili视频小部件
Version: 1.0
Author: NUTSWP
Author URI: https://nutswp.com/
License: GPL2
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// 注册小部件
function nutswp_register_elements($widgets_manager) {
    require_once(__DIR__ . '/widgets/bilibili-video-widget.php');
    $widgets_manager->register(new \Elementor_Bilibili_Video_Widget());
}
add_action('elementor/widgets/register', 'nutswp_register_elements');

// 加载CSS和JS
function nutswp_enqueue_scripts() {
    wp_enqueue_style('nutswp-elements', plugins_url('assets/css/nutswp-elements.css', __FILE__));
    wp_enqueue_script('nutswp-elements', plugins_url('assets/js/nutswp-elements.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'nutswp_enqueue_scripts');