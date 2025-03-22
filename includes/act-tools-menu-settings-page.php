<?php
// In your plugin's main file

// Register settings
function act_menu_register_settings() {
    register_setting('act_menu_settings_group', 'act_menu_bg_color', 'sanitize_hex_color');
    register_setting('act_menu_settings_group', 'act_menu_bg_hover_color', 'sanitize_hex_color');
    register_setting('act_menu_settings_group', 'act_menu_button_color', 'sanitize_hex_color');
    register_setting('act_menu_settings_group', 'act_menu_border_color', 'sanitize_hex_color');
    register_setting('act_menu_settings_group', 'act_menu_submenu_background', 'sanitize_hex_color');
    register_setting('act_menu_settings_group', 'act_menu_submenu_border_color', 'sanitize_hex_color');
    register_setting('act_menu_settings_group', 'act_menu_text_color', 'sanitize_hex_color');
    register_setting('act_menu_settings_group', 'act_menu_link_hover', 'sanitize_hex_color');
    register_setting('act_menu_settings_group', 'act_menu_button_text_color', 'sanitize_hex_color');
    register_setting('act_menu_settings_group', 'act_menu_cutoff_value', 'sanitize_text_field'); // For the cutoff value
    register_setting('act_menu_settings_group', 'act_menu_position', 'sanitize_text_field'); // Added position
    register_setting('act_menu_settings_group', 'act_menu_enable', 'sanitize_text_field'); // Added enable
}
add_action('admin_init', 'act_menu_register_settings');

// Settings page
function act_menu_settings_page() {
    ?>
    <div class="wrap">
        <h2>Act Menu Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('act_menu_settings_group'); ?>
            <?php do_settings_sections('act_menu_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Background Color</th>
                    <td><input type="text" name="act_menu_bg_color" value="<?php echo esc_attr(get_option('act_menu_bg_color', '#FFFFFF')); ?>"
                        class="act-color-picker"  data-alpha="true"  /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Background Hover Color</th>
                    <td><input type="text" name="act_menu_bg_hover_color" value="<?php echo esc_attr(get_option('act_menu_bg_hover_color', '#FFFFFF')); ?>"
                        class="act-color-picker"  data-alpha="true" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Text Color</th>
                    <td><input type="text" name="act_menu_text_color" value="<?php echo esc_attr(get_option('act_menu_text_color', 'black')); ?>"
                        class="act-color-picker"  data-alpha="true" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Link Hover Color</th>
                    <td><input type="text" name="act_menu_link_hover" value="<?php echo esc_attr(get_option('act_menu_link_hover', '#76B44E')); ?>"
                        class="act-color-picker"  data-alpha="true" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Border Color</th>
                    <td><input type="text" name="act_menu_border_color" value="<?php echo esc_attr(get_option('act_menu_border_color', 'black')); ?>"
                        class="act-color-picker"  data-alpha="true" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Button Color</th>
                    <td><input type="text" name="act_menu_button_color" value="<?php echo esc_attr(get_option('act_menu_button_color', '#F7F4D8')); ?>"
                        class="act-color-picker"  data-alpha="true" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Button Text Color</th>
                    <td><input type="text" name="act_menu_button_text_color" value="<?php echo esc_attr(get_option('act_menu_button_text_color', 'black')); ?>"
                        class="act-color-picker"  data-alpha="true" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Submenu Background Color</th>
                    <td><input type="text" name="act_menu_submenu_background" value="<?php echo esc_attr(get_option('act_menu_submenu_background', '#FFFFFF')); ?>"
                        class="act-color-picker"  data-alpha="true" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Submenu Border Color</th>
                    <td><input type="text" name="act_menu_submenu_border_color" value="<?php echo esc_attr(get_option('act_menu_submenu_border_color', '#A0A0A0')); ?>"
                        class="act-color-picker"  data-alpha="true" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Cutoff Value (px)</th>
                    <td><input type="text" name="act_menu_cutoff_value" value="<?php echo esc_attr(get_option('act_menu_cutoff_value', '600')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Position</th>
                    <td>
                        <select name="act_menu_position"> // Added position field
                            <option value="right" <?php selected(get_option('act_menu_position'), 'right'); ?>>Right</option>
                            <option value="left" <?php selected(get_option('act_menu_position'), 'left'); ?>>Left</option>
                            <option value="center" <?php selected(get_option('act_menu_position'), 'center'); ?>>Center</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Enable</th>
                    <td><input type="checkbox" name="act_menu_enable" <?php checked(get_option('act_menu_enable', 1), 1); ?> value="1" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Add settings page to admin menu
function act_menu_add_admin_menu() {
    add_options_page('Act Menu Settings', 'Act Menu', 'manage_options', 'act-menu-settings', 'act_menu_settings_page');
}
add_action('admin_menu', 'act_menu_add_admin_menu');

// Enqueue color picker
function act_menu_enqueue_admin_scripts($hook) {
    if ( $hook == 'act-tools_page_act-tools-menu-settings-page'){
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('act-color-picker-script', plugins_url('../assets/js/act-color-picker-script.js', __FILE__), array('wp-color-picker'), false, true);
    } else {
     //   echo "Hook did not match.  Current hook is: " . $hook;
    }
}
add_action('admin_enqueue_scripts', 'act_menu_enqueue_admin_scripts');

// Output custom CSS
function act_menu_output_custom_css() {
    $bg_color = get_option('act_menu_bg_color', '#FFFFFF');
    $bg_hover_color = get_option('act_menu_bg_hover_color', '#FFFFFF');
    $button_color = get_option('act_menu_button_color', '#F7F4D8');
    $border_color = get_option('act_menu_border_color', 'black');
    $submenu_background = get_option('act_menu_submenu_background', '#FFFFFF');
    $submenu_border_color = get_option('act_menu_submenu_border_color', '#A0A0A0');
    $text_color = get_option('act_menu_text_color', 'black');
    $link_hover = get_option('act_menu_link_hover', '#76B44E');
    $button_text_color = get_option('act_menu_button_text_color', 'black');
    $enable = get_option('act_menu_enable', 0); // Added get_option for enable
    $position = get_option('act_menu_position', 'right'); // Added get_option for position
    $position_mapping = array(
        'left' => 'flex-start',
        'center' => 'center',
        'right' => 'flex-end',
    );
    // Use a default value if the stored value is not valid
    $flex_position = isset($position_mapping[$position]) ? $position_mapping[$position] : 'flex-end';

    ?>
    <style type="text/css">
        :root {
            --act-menu-bg-color: <?php echo esc_attr($bg_color); ?>;
            --act-menu-bg-hover-color: <?php echo esc_attr($bg_hover_color); ?>;
            --act-menu-button-color: <?php echo esc_attr($button_color); ?>;
            --act-menu-border-color: <?php echo esc_attr($border_color); ?>;
            --act-menu-submenu-background: <?php echo esc_attr($submenu_background); ?>;
            --act-menu-submenu-border-color: <?php echo esc_attr($submenu_border_color); ?>;
            --act-menu-text-color: <?php echo esc_attr($text_color); ?>;
            --act-menu-link-hover: <?php echo esc_attr($link_hover); ?>;
            --act-menu-button-text-color: <?php echo esc_attr($button_text_color); ?>;
            --act-menu-position: <?php echo esc_attr($flex_position); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'act_menu_output_custom_css');

function act_menu_get_cutoff_value() {
    return intval(get_option('act_menu_cutoff_value', '600'));
}
// Function to set default options on plugin activation
function act_menu_set_default_options() {
    // Set default position to 'right'
    update_option('act_menu_position', 'right');
    update_option('act_menu_enable', 1); // Set enable to 1 on activation
}
register_activation_hook(__FILE__, 'act_menu_set_default_options');
?>
