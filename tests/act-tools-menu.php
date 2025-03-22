<?php
function act_tools_menu_generate() {
    $menu_name = '#menu1';
    $locations = get_nav_menu_locations();
    echo "In act_tools_menu_generate".PHP_EOL;
    var_dump($location);
    if (isset($locations[$menu_name])) {
        $menu_id = $locations[$menu_name];
        $menu_items = wp_get_nav_menu_items($menu_id);

        if ($menu_items) {
            $mobile_menu_html = '<nav aria-label="Mobile Menu"><ul role="menubar" id="act-menu-container" style="display: none;">';
            $top_level_items = array();
            $sub_menu_items = array();

            foreach ($menu_items as $menu_item) {
                if ($menu_item->menu_item_parent == 0) {
                    $top_level_items[] = $menu_item;
                } else {
                    $sub_menu_items[] = $menu_item;
                }
            }

            foreach($top_level_items as $top_level){
                $submenu_id = 'act-menu-submenu-' . $top_level->ID;
                $has_submenu = false;
                foreach($sub_menu_items as $sub_menu){
                    if($sub_menu->menu_item_parent == $top_level->ID){
                        $has_submenu = true;
                        break;
                    }
                }
                $aria_haspopup = $has_submenu ? 'true' : 'false';
                $aria_expanded = 'false'; // Initially closed

                $esced_url = esc_url($top_level->url);
                $esced_html = esc_html($top_level->title);

                $mobile_menu_html .= '<li role="menuitem" aria-haspopup="' . $aria_haspopup . '" aria-expanded="' . $aria_expanded . '" aria-controls="';
                $mobile_menu_html     . $submenu_id . '" class="act-menu-item">';
                $mobile_menu_html .= '<a href="' . $esced_url . '">' . $esced_html . '</a>';
                $mobile_menu_html .= '<span class="act-menu-expand-button" data-submenu="' . $submenu_id . '"></span>';
                $mobile_menu_html .= '<ul role="menu" aria-label="' . $esced_html . ' Submenu" class="act-menu-submenu" id="';
                $mobile_menu_html     . $submenu_id . '" style="display: none;">';

                foreach($sub_menu_items as $sub_menu){
                    if($sub_menu->menu_item_parent == $top_level->ID){
                        $mobile_menu_html .= '<li role="menuitem" class="act-menu-menuitem">';
                        $mobile_menu_html .= '<a href="' . esc_url($sub_menu->url) . '">' . esc_html($sub_menu->title) . '</a></li>';
                    }
                }
                $mobile_menu_html .= '</ul></li>';
            }
            $mobile_menu_html .= '</ul></nav>';
            echo $mobile_menu_html;
        }
    } else {
        var_dump($locations);
    }
}
//add_action('wp_footer', 'act_tools_menu_generate');

function act_tools_menu_enqueue_scripts(){
    // Enqueue CSS
    wp_enqueue_style(
        'act-tools-menu-style',
        plugin_dir_url(__FILE__) . '../assets/css/act-tools-menu.css'
    );
}
//add_action('wp_enqueue_scripts', 'act_tools_menu_enqueue_scripts');
?>
