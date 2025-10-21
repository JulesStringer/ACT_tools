<?php
function act_hamburger_menu_enqueue_scripts() {
    // Pass settings from the database to JavaScript
    if ( get_option('act_menu_enable', 0) == 0){
        return;
    }
    $hamburger_settings = array(
        'cutoffValue' => intval(get_option('act_menu_cutoff_value', '600')), // Get cutoff from new setting
    );
    wp_enqueue_script(
        'act-hamburger-menu',
        plugins_url('../assets/js/act-hamburger-menu.js', __FILE__),
        array('wp-element', 'wp-data', 'jquery', 'wp-dom-ready', 'wp-block-editor'),
        filemtime( plugin_dir_path( __FILE__ ) . '../assets/js/act-hamburger-menu.js'),
        true
    );
    wp_localize_script('act-hamburger-menu', 'actHamburgerSettings', $hamburger_settings);

    // Enqueue CSS -  Make sure this CSS file exists and contains general layout, not colors.
    wp_enqueue_style(
        'act-hamburger-menus-style',
        plugins_url('../assets/css/act-hamburger-menu.css',__FILE__),
        array(),
        filemtime( plugin_dir_path( __FILE__ ) . '../assets/css/act-hamburger-menu.css')
    );
}

add_action('wp_enqueue_scripts', 'act_hamburger_menu_enqueue_scripts');

?>
