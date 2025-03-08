<?php

/*
Plugin Name: QR Pay3
Plugin URI: https://example.com
Description: Đây là plugin thử nghiệm.
Version: 1.0
Author: HOANG
Author URI: https://example.com
License: GPL2
*/
// Thêm menu vào trang quản trị WordPress

ob_start();
// require_once(plugin_dir_path(__FILE__) . 'vnpay_php/config.php');
require_once(plugin_dir_path(__FILE__) . 'function/function.php');
require_once(plugin_dir_path(__FILE__) . 'function/ajax-function.php');
require_once(plugin_dir_path(__FILE__) . 'function/install.php');
require_once(plugin_dir_path(__FILE__) . 'function/un-install.php');

add_action('admin_menu', function () {
    // Tạo menu chính
    add_menu_page(
        'Trang Admin Plugin Test',  // Tiêu đề của trang
        'QR Pay',                   // Tên menu hiển thị
        'manage_options',           // Quyền truy cập (quản trị viên)
        'qr-pay',        // Slug của trang chính
        'display_admin_page',       // Hàm callback hiển thị nội dung trang chính
        'dashicons-admin-tools',    // Biểu tượng menu
        6                           // Vị trí menu
    );

    // Tạo mục con dưới menu "QR Pay"
    add_submenu_page(
        'qr-pay',        // Slug của menu chính
        'Lịch sử',                // Tiêu đề của mục con
        'Lịch sử',                // Tên mục con
        'manage_options',           // Quyền truy cập
        'qr-pay1',    // Slug của mục con
        'display_submenu_1'         // Hàm callback hiển thị nội dung mục con
    );

    // Tạo thêm các mục con khác (nếu cần)
    add_submenu_page(
        'qr-pay',        // Slug của menu chính
        'Cài Đặt',                // Tiêu đề của mục con
        'Cài Đặt',                // Tên mục con
        'manage_options',           // Quyền truy cập
        'qr-pay2',    // Slug của mục con
        'display_submenu_2'         // Hàm callback hiển thị nội dung mục con
    );
    add_submenu_page(
        'qr-pay',        // Slug của menu chính
        'Hoàn Tiền',                // Tiêu đề của mục con
        'Hoàn Tiền',                // Tên mục con
        'manage_options',           // Quyền truy cập
        'qr-pay3',    // Slug của mục con
        'display_submenu_3'         // Hàm callback hiển thị nội dung mục con
    );
});

// Hàm hiển thị nội dung trang quản trị chính
function display_admin_page()
{
    include plugin_dir_path(__FILE__) . 'include/admin-page.php'; // Đường dẫn tới file admin chính
}

// Hàm hiển thị nội dung của mục con 1
function display_submenu_1()
{
    include plugin_dir_path(__FILE__) . 'include/history-page.php';
}

// Hàm hiển thị nội dung của mục con 2
function display_submenu_2()
{
    include plugin_dir_path(__FILE__) . 'include/setup-page.php';
}
function display_submenu_3()
{
    include plugin_dir_path(__FILE__) . 'include/refund-page.php';
}

// Hàm để enqueue style và script
function enqueue_styles()
{

    wp_enqueue_style('style-local', plugin_dir_url(__FILE__) . 'css/style.css');
    // wp_enqueue_style('style-external', 'https://www.w3schools.com/w3css/4/w3.css');
    wp_enqueue_script('plugin-checkbox-handler', plugin_dir_url(__FILE__) . 'js/index.js', array('jquery'), null, true);

    // Đưa ajaxurl vào file JS
    // wp_localize_script('plugin-checkbox-handler', 'ajaxurl', admin_url('admin-ajax.php'));
}

// Hook vào trang admin của WordPress
add_action('admin_enqueue_scripts', 'enqueue_styles');
//
add_action('wp_ajax_checkbox_bank', 'checkbox_bank');
add_action('wp_ajax_nopriv_checkbox_bank', 'checkbox_bank');

add_action('wp_ajax_checkbox_detal', 'checkbox_detal');
add_action('wp_ajax_nopriv_checkbox_detal', 'checkbox_detal');

register_activation_hook(__FILE__, 'plugin_test_create_database');
register_uninstall_hook(__FILE__, 'plugin_test_delete_database');


add_action('init', 'plugin_handle_payment_form');
// Tạo trang khi kích hoạt plugin


// Tạo trang tùy chỉnh khi kích hoạt plugin
register_activation_hook(__FILE__, 'my_custom_page_create_page');

// Đăng ký template tùy chỉnh
add_filter('theme_page_templates', 'register_plugin_templates');
function register_plugin_templates($templates)
{
    $templates['my-custom-page.php'] = 'My Custom Page Template';
    return $templates;
}

// Load template từ plugin nếu được chọn
add_filter('template_include', 'load_plugin_template');
function load_plugin_template($template)
{
    if (get_page_template_slug() === 'my-custom-page.php') {
        $plugin_template = plugin_dir_path(__FILE__) . 'templates/my-custom-page.php';
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }
    return $template;
}

// Tạo trang và gán template tùy chỉnh
function my_custom_page_create_page()
{
    $page_check = get_page_by_path('my-custom-page');
    if (!$page_check) {
        $page_id = wp_insert_post(array(
            'post_title'    => 'My Custom Page',
            'post_name'     => 'my-custom-page',
            'post_status'   => 'publish',
            'post_type'     => 'page',
        ));

        // Gán template tùy chỉnh
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'my-custom-page.php');
        }
    }
}

// Thêm Rewrite Rule cho trang tùy chỉnh
add_action('init', 'custom_page_rewrite_rule');
function custom_page_rewrite_rule()
{
    add_rewrite_rule(
        '^my-custom-page/?$',
        'index.php?pagename=my-custom-page',
        'top'
    );
}

// Flush rewrite rules khi kích hoạt plugin
register_activation_hook(__FILE__, 'flush_rewrite_rules_on_activate');
function flush_rewrite_rules_on_activate()
{
    custom_page_rewrite_rule();
    flush_rewrite_rules();
}

// Flush rewrite rules khi hủy kích hoạt plugin
register_deactivation_hook(__FILE__, 'flush_rewrite_rules');
