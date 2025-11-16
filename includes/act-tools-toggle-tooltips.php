<?php
function act_toggle_tooltips_register_settings() {
    register_setting('act_toggle_tooltips_settings_group', 'act_toggle_tooltips_showtext');
    register_setting('act_toggle_tooltips_settings_group', 'act_toggle_tooltips_hidetext');
    register_setting('act_toggle_tooltips_settings_group', 'act_toggle_tooltips_position');
    register_setting('act_toggle_tooltips_settings_group', 'act_toggle_tooltips_enable_all');
}
add_action('admin_init', 'act_toggle_tooltips_register_settings');

function act_tools_toggle_tooltips() {
    ?>
        <div class="wrap">
            <h2>Image Toggle Tooltips Settings</h2>
            <form method="post" action="options.php">
                <?php
                    settings_fields('act_toggle_tooltips_settings_group');
                    do_settings_sections('act-tools-toggle-tooltips');
                    submit_button();
                ?>
            </form>
        </div>
    <?php
}
// Add settings fields to the page
function act_toggle_tooltips_settings_fields() {
    add_settings_section(
        'act_tools_main_section',
        'Tooltip Settings',
        null,
        'act-tools-toggle-tooltips'
    );

    add_settings_field(
        'act_toggle_tooltips_showtext',
        'Show Text:',
        'act_toggle_tooltips_showtext_callback',
        'act-tools-toggle-tooltips',
        'act_tools_main_section'
    );

    add_settings_field(
        'act_toggle_tooltips_hidetext',
        'Hide Text:',
        'act_toggle_tooltips_hidetext_callback',
        'act-tools-toggle-tooltips',
        'act_tools_main_section'
    );

    add_settings_field(
        'act_toggle_tooltips_position', // ID
        'Position:', // Label
        'act_toggle_tooltips_position_callback', // Callback function
        'act-tools-toggle-tooltips', // Page (must match the settings section's page)
        'act_tools_main_section' // Section (match the section where this field belongs)
    );

    add_settings_field(
        'act_toggle_tooltips_enable_all',
        'Enable for All Images (with captions):',
        'act_toggle_tooltips_enable_all_callback',
        'act-tools-toggle-tooltips',
        'act_tools_main_section'
    );
}
add_action('admin_init', 'act_toggle_tooltips_settings_fields');

// Callback Functions for Input Fields
function act_toggle_tooltips_showtext_callback() {
    $value = get_option('act_toggle_tooltips_showtext', 'more...');
    echo '<input type="text" name="act_toggle_tooltips_showtext" value="' . esc_attr($value) . '" />';
}

function act_toggle_tooltips_hidetext_callback() {
    $value = get_option('act_toggle_tooltips_hidetext', 'less...');
    echo '<input type="text" name="act_toggle_tooltips_hidetext" value="' . esc_attr($value) . '" />';
}
function act_toggle_tooltips_position_callback() {
    $position = get_option('act_toggle_tooltips_position', 'left'); // Retrieve stored options
///    $position = isset($options['position']) ? $options['position'] : 'left'; // Default to 'left'

    ?>
    <select name="act_toggle_tooltips_position">
        <option value="left" <?php selected($position, 'left'); ?>>left</option>
        <option value="right" <?php selected($position, 'right'); ?>>right</option>
    </select>
    <?php
}

function act_toggle_tooltips_enable_all_callback() {
    $checked = get_option('act_toggle_tooltips_enable_all', 0) ? 'checked' : '';
    echo '<input type="checkbox" name="act_toggle_tooltips_enable_all" value="1" ' . $checked . ' />';
}

function act_toggle_tooltips_enqueue_scripts() {
    wp_enqueue_script(
        'act-toggle-tooltips',
        plugins_url('../assets/js/act-toggle-tooltips.js', __FILE__),
        array('wp-element', 'wp-data', 'jquery', 'wp-dom-ready', 'wp-block-editor'),
        filemtime( plugin_dir_path( __FILE__ ) . '../assets/js/act-toggle-tooltips.js' ),
        true
    );
    // Pass settings from the database to JavaScript
    $tooltip_settings = array(
        'showText'  => get_option('act_toggle_tooltips_showtext', 'More...'),
        'hideText'  => get_option('act_toggle_tooltips_hidetext', 'Less...'),
        'position'  => get_option('act_toggle_tooltips_position', 'left'),
        'enableAll' => get_option('act_toggle_tooltips_enable_all', 0),
    );
    wp_localize_script('act-toggle-tooltips', 'actTooltipSettings', $tooltip_settings);

    // Enqueue CSS
    wp_enqueue_style(
        'act-toggle-tooltips-style',
        plugin_dir_url(__FILE__) . '../assets/css/act-toggle-tooltips.css'
    );
}
add_action('enqueue_block_assets', 'act_toggle_tooltips_enqueue_scripts');
add_action('wp_enqueue_scripts', 'act_toggle_tooltips_enqueue_scripts');

function act_tools_toggle_tooltips_image_block( $block_content, $block ) {
    if ( 'core/image' === $block['blockName'] && strlen($block_content) > 0 ) {
        $showText  = get_option('act_toggle_tooltips_showtext', 'More...');
        $hideText  = get_option('act_toggle_tooltips_hidetext', 'Less...');
        $position  = get_option('act_toggle_tooltips_position', 'left');
        $enableAll = get_option('act_toggle_tooltips_enable_all', 0);

        if ( isset( $block['attrs']['className'] ) && strpos( $block['attrs']['className'], 'toggle-tooltip' ) !== false || $enableAll === '1' ) {
            $dom = new DOMDocument();
            @$dom->loadHTML( mb_convert_encoding( $block_content, 'HTML-ENTITIES', 'UTF-8' ) );
            $figures = $dom->getElementsByTagName( 'figure' );

            if ( $figures->length > 0 ) {
                $figure = $figures->item( 0 );
                $images = $figure->getElementsByTagName( 'img' );
                $figcaptions = $figure->getElementsByTagName('figcaption');

                if ( $images->length > 0 && $figcaptions->length > 0) {
                    $image = $images->item( 0 );
                    $figcaption = $figcaptions->item(0);
                    $alt = $image->getAttribute( 'alt' );

                    if ( ! empty( $alt ) ) {
                        $button = $dom->createElement( 'button', $showText );
                        $button->setAttribute( 'class', 'toggle-button' );
                        $button->setAttribute( 'aria-expanded', 'false' );

                        $tooltipText = $dom->createElement( 'div', $alt );
                        $tooltipText->setAttribute( 'class', 'tooltip-text' );
                        $tooltipText->setAttribute( 'style', 'display: none;' );

                        $figure->setAttribute('style', 'position: relative;');
                        $figure->appendChild( $tooltipText );
                        if ($position === 'left'){
                            $figcaption->insertBefore($button, $figcaption->firstChild);
                        } else {
                            $figcaption->appendChild($button);
                        }

                        $block_content = $dom->saveHTML();
                    }
                }
            }
        }
    }
    return $block_content;
}

add_filter( 'render_block', 'act_tools_toggle_tooltips_image_block', 10, 2 );
?>