document.addEventListener('DOMContentLoaded', () => {
    // Define the breakpoint used in your CSS to ensure consistency
    const MOBILE_BREAKPOINT = 600; 

    // Select the button and the menu container
    const openButton = document.querySelector('.wp-block-navigation__responsive-container-open');
    const menuContainer = document.querySelector('.wp-block-navigation__responsive-container');

    if (openButton && menuContainer) {
        openButton.addEventListener('click', () => {
            
            // Only execute this logic when the screen is in the mobile range (W <= 599)
            if (window.innerWidth < MOBILE_BREAKPOINT) {
                
                // Use setTimeout to allow the native WordPress JavaScript (which toggles the .is-menu-open class) 
                // to execute first, or to capture the state change slightly after.
                setTimeout(() => {
                    const isMenuOpen = menuContainer.classList.contains('is-menu-open');
                    
                    if (isMenuOpen) {
                        // Menu is OPENING: Force inline style to show it. 
                        // The !important flag is essential to override inline styles applied by core/theme.
                        menuContainer.style.setProperty('display', 'block', 'important');
                        menuContainer.style.setProperty('visibility', 'visible', 'important');
                        
                    } else {
                        // Menu is CLOSING: Force inline style to hide it.
                        menuContainer.style.setProperty('display', 'none', 'important');
                        menuContainer.style.setProperty('visibility', 'hidden', 'important');
                    }
                }, 50); // A small delay of 50ms ensures the native JS runs first
            }
        });
    }
});