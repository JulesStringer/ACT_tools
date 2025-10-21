let g_mobile_menu = null;

let upuri = '';
let downuri = '';

// Function to recursively replicate menu items
function replicateMenuItems($, $sourceList, $targetList, isubMenu) {
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
            replicateMenuItems($, $sourceSubmenu, $targetSubmenu, true);
            $targetItem.append($targetSubmenu);
        }

        $targetList.append($targetItem);
    });
}
// Define the toggle function in the global scope
function act_menu_toggle() {
    jQuery(document).ready(function ($) {
        let $mobileMenu = $('#act-menu');
        console.log('Toggling small menu display was ' + $mobileMenu.css('display') + ' get(0): ' + $mobileMenu.get(0) + ' length: ' + $mobileMenu.length);
        if ($mobileMenu.css('display') == 'none') {
            //$mobileMenu.css({ display: 'block' });
            $mobileMenu.css({ display: 'block', width: '100%' });
            console.log('On');
        } else {
            $mobileMenu.css({ display: 'none' });
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
function createMenuStructure($, $ul, $button) {
    // Collect colours and symbols from :root
    upuri = getuparrow();
    downuri = getdownarrow();
    // Find the ul element within the nav block
    const $originalMenu = $ul.first();

    if (!$originalMenu.length) {
        console.error('No ul element found within the nav block.');
        return;
    }
    if ( jQuery('#act-mobile-menu').get(0)){
        return;
    }
    // Create a new container for the mobile menu
    const $mobileMenuContainer = $('<nav>').addClass('act-mobile-menu');
    $mobileMenuContainer.attr('id','act-mobile-menu');

    // Create a button to toggle the menu
    let html = '<div class="act-menu-toggle-div">';
    html += '<button type="button" class="act-menu-toggle" id="act-menu-toggle" onclick="act_menu_toggle();">';
    //html += 'A.Menu';
    html += '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">';
    html += '<rect width="20" height="2" fill="black"/>'
    html += '<rect y="8.5" width="20" height="2" fill="black"/>';
    html += '<rect y="17" width="20" height="2" fill="black"/>';
    html += '</svg>';
    html += '</button>';
    html += '</div>';
    $mobileMenuContainer.append(html);

    // Create a new ul element for the mobile menu

    let $mobileMenu = $('<ul>').addClass('act-menu');
    $mobileMenu.attr('id', 'act-menu');
    $mobileMenu.css({display:'none'});
    
    // Replicate the menu items
    replicateMenuItems($, $originalMenu, $mobileMenu, false);
    $mobileMenuContainer.append($mobileMenu);

    // Insert the mobile menu after the original nav block
console.log('About to $button.after $button.length ' + $button.length + ' element 0 ' + $button.get(0));
    $button.after($mobileMenuContainer);

    return $mobileMenuContainer;
}
let cutoff = 600;
function isHamburgerMenuButtonVisible() {
console.log('Window width: ' + window.innerWidth + ' Cutoff: ' + cutoff);
    let width = window.innerWidth;
    return width < cutoff;
}
function replaceHamburgerMenuContent($) {

    cutoff = actHamburgerSettings.cutoffValue;

    //const $navBlock = $('header > div > .wp-block-navigation'); // Or a more specific selector
    const $header = $('header');
    const $nav = $header.find('nav');
    const $ul = $nav.find('ul');
    const $button = $nav.find('button');
    if ( !$ul.get(0) ){
        console.log('Could not find a ul element under a nav');
    }
    if ( g_mobile_menu == null){
        g_mobile_menu = createMenuStructure($, $ul, $button);
        console.log('Created mobile menu');
    }
    if (isHamburgerMenuButtonVisible()) {
        console.log('HamburgerMenuButtonVisible');
        $button.css({display:'none'});
        g_mobile_menu.css({display:'inline-block'});
    } else {
        $button.css({display:'block'});
        $('.act-mobile-menu').css({display: 'none'});
        //console.log('Hamburger NOT visible');
    }
}
// Call the function on page load and resize (if needed)
jQuery(document).ready(function($){
    replaceHamburgerMenuContent($);
});
jQuery(window).on('resize', function(){
    replaceHamburgerMenuContent(jQuery);
});
