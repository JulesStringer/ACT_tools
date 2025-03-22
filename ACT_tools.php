<?php
/**
 * Plugin Name: ACT Tools
 * Plugin URI:  https://sites.stringerhj.co.uk/ACT/WP_plugins/ACT_tools/html/ACT_tools.html
 * Description: Various tools to provide custom facilities on the ACT website that cannot be provided by other means
 * Version: 1.0.0
 * Author: Julian Stringer
 * Author URI: // (Optional: URL to your website)
 */
// Ensure WordPress context
if (!defined('ABSPATH')) {
    exit;
}

// Include required files
include_once plugin_dir_path(__FILE__) . 'includes/act-tools-toggle-tooltips.php';
include_once plugin_dir_path(__FILE__) . 'includes/act-tools-hamburger-menu.php';
include_once plugin_dir_path(__FILE__) . 'includes/act-tools-menu-settings-page.php';
// Admin Menu

add_action( 'admin_menu', 'act_tools_menu' );
function act_tools_menu() {
    add_menu_page( 'ACT Tools', 'ACT Tools', 'manage_options', 'act-tools', 'act_tools_page', 'dashicons-list-view' ); // Top-level menu
    add_submenu_page('act-tools', 'Image Toggle Tooltips', 'Image Toggle Tooltips', 'manage_options', 'act-tools-toggle-tooltips','act_tools_toggle_tooltips');
    add_submenu_page('act-tools', 'Phone Navigation Menu', 'Phone Navigation Menu', 'manage_options', 'act-tools-menu-settings-page',   'act_menu_settings_page');
}
function act_tools_page() {
    // Top-level page content (can be empty or a welcome message)
    echo '<h2>ACT Tools</h2>';

    // Display links to the sub-menu pages (optional)
    echo '<ul>';
        echo '<li><a href="' . admin_url( 'admin.php?page=act-tools-toggle-tooltips') .'">Image Toggle Tooltips</a></li>';
        echo '<li><a href="' . admin_url( 'admin.php?page=act-tools-menu-settings-page').'">Phone Navigation Menu</a></li>';
    echo '</ul>';
}

// Register Blocks (Later)
/*
// enable this when Gutenberg blocks are enabled
function act_tools_register_blocks() {
//    register_block_type(__DIR__ . '/blocks/act-toggle-tooltips');
}
add_action('init', 'act_tools_register_blocks');
*/
 ?>