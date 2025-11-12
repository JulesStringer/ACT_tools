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
function act_menu_button( $atts ) {
    // Set up default attributes
    $atts = shortcode_atts(
        array(
        ),
        $atts,
        'act_menu_button'
    );
    // put popup_menu after the header
    // Build and return the HTML output
    $html = '<button type="button" class="act-menu-button" id="act-menu-button" onclick="act_menu_toggle();">';
    //html += 'A.Menu';
    $html .= '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">';
    $html .= '<rect width="20" height="2" fill="black"/>';
    $html .= '<rect y="8.5" width="20" height="2" fill="black"/>';
    $html .= '<rect y="17" width="20" height="2" fill="black"/>';
    $html .= '</svg>';
    $html .= '</button>';
    //$html .= '</div>';
    //button_html = create_menu_button(jQuery);
    //console.log('button_html: ' + button_html);

    return $html;
}
add_shortcode( 'act_menu_button', 'act_menu_button' );
?>
