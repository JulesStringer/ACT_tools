let g_mobile_menu = null;
let g_menu_button = null;

let upuri = '';
let downuri = '';

// Function to recursively replicate menu items
function replicate_menu_items($, $sourceList, $targetList, isubMenu) {
    $sourceList.children('li').each(function() {
        const $sourceItem = $(this);
        let cls = isubMenu ? 'act-menu-menuitem' : 'act-menu-item';
        const $targetItem = $('<li>').addClass(cls);

        // Copy a elements
        let link = '';
        let title = '';
        $sourceItem.children('a').each(function() {
            const $sourceLink = $(this);
            //const $targetLink = $('<a>').attr('href', $sourceLink.attr('href')).text($sourceLink.text());
            link = $sourceLink.attr('href');
            title = $sourceLink.text();
            //$targetItem.append($targetLink);
        });
        if ( !isubMenu ){
            const $div = $('<div>').addClass('act-menu-item-container');
            cls = 'act-menu-item-container-link';
            if ( $sourceItem.children('ul').first().length === 0){
                cls += ' act-menu-item-container-link-simple';
            }
            const linkhtml = '<a href="' + link + '" class="'  + cls + '" >' + title + '</a>';
            $div.append(linkhtml);
            if ( $sourceItem.children('ul').first().length){
                let html = '<button type="button" class="act-menu-expand-button" onclick="act_submenu_toggle(event);">';
                html += '<img class="act-menu-expand-button-img" alt="Down Arrow" src="' + downuri + '" />';
                html += '</button>';
                $div.append(html);
            }
            $targetItem.append($div);
        } else {
            const linkhtml = '<a href="' + link + '" >' + title + '</a>';
            $targetItem.append(linkhtml);
        }
        // Check for nested ul elements (submenus)
        const $sourceSubmenu = $sourceItem.children('ul').first();
        if ($sourceSubmenu.length) {
            // Copy button elements
            const $targetSubmenu = $('<ul>').addClass('act-menu-submenu');
            $targetSubmenu.css({display:'none'});
            replicate_menu_items($, $sourceSubmenu, $targetSubmenu, true);
            $targetItem.append($targetSubmenu);
        }

        $targetList.append($targetItem);    });
}
function create_popup_menu($){
    upuri = getuparrow();
    downuri = getdownarrow();
    const $header = $('header');
    const $nav = $header.find('nav');
    const $ul = $nav.find('ul');
    const $original_menu = $ul.first();
    if (!$original_menu.length) {
        console.error('No ul element found within the nav block.');
        return;
    }
    
    const act_menu = $('<nav>').addClass('act-menu');
    act_menu.attr('id','act-menu');
    act_menu.css({display:'none'});
    let act_menu_root = $('<ul>');
    // Replicate the menu items
    replicate_menu_items($, $original_menu, act_menu_root, false);
    act_menu.append(act_menu_root);
    // menu goes after heading rather than appended to div, this makes it appear underneath
    $header.append(act_menu);
    return $('#act-menu');
}
// Define the toggle function in the global scope
function act_menu_toggle() {
    jQuery(document).ready(function($){
        let act_menu = $('#act-menu');
        if ( !act_menu.get(0)){
            console.log('about to create_popup_menu');
            act_menu = create_popup_menu($);
            console.log('created popup menu');
        }
        console.log('Toggling small menu display was ' + act_menu.css('display') + ' get(0): ' + act_menu.get(0) + ' length: ' + act_menu.length);
        if (act_menu.css('display') == 'none') {
            //$mobileMenu.css({ display: 'block' });
            act_menu.css({ display: 'block', width: '100%' });
            console.log('On');
        } else {
            act_menu.css({ display: 'none' });
            console.log('Off');
        }
    });
}
function act_submenu_toggle(event){
    jQuery(document).ready(function ($) {
        let $target = $(event.target);
        let $div = $target.closest('div');
        let $button = $div.find('button');
        let $t = $button.parent().siblings('.act-menu-submenu');
        let $img = $button.find('img');
        console.log('Toggling submenu siblings length: ' + $t.length );
        console.log(' qualified siblings: ' + $t + ' display: ' + $t.css('display'));
        if ( $t.css('display') === 'none'){
            $('.act-menu-submenu').css({display:'none'});
            $('.act-menu-expand-button > img').attr('alt','downarrow');
            $('.act-menu-expand-button > img').attr('src', downuri);
            $t.css({display:'block'});
            $img.attr('alt','uparrow');
            $img.attr('src', upuri);
        } else {
            $t.css({display:'none'});
            $img.attr('src', downuri);
            $img.attr('alt', 'downarrow');
        }
    });
}
function getarrowcolor(color){
    // Get the root element
    let root = document.documentElement;
    // Get the computed style of the root element
    let style = getComputedStyle(root);
    // Get the value of the CSS variable
    return style.getPropertyValue(color);
}
function getdownarrow(){
    let color = 'black';
    color = getarrowcolor('--act-menu-button-text-color');
    let downarrow = '<svg width="48" height="24" viewBox="0 0 48 24" fill="none" xmlns="http://www.w3.org/2000/svg">';
    downarrow += '<path d="M14 12L24 22L34 12" stroke="'  + color + '" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
    downarrow += '</svg>';
    
    return 'data:image/svg+xml;utf8,' + encodeURIComponent(downarrow);
}
function getuparrow(){
    let color = 'black';
    color = getarrowcolor('--act-menu-button-text-color');
    let uparrow = '<svg width="48" height="24" viewBox="0 0 48 24" fill="none" xmlns="http://www.w3.org/2000/svg">';
    uparrow += '<path d="M34 12L24 2L14 12" stroke="' + color + '" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
    uparrow += '</svg>'
    
    return 'data:image/svg+xml;utf8,' + encodeURIComponent(uparrow);
}
