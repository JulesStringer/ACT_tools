# ACT tools

This plugin contains widgets and other tools that are required by the ACT website:
+ [act-toggle-tooltips](#act-toggle-tooltips) (aka Image Toggle Tooltips) provides a button which toggles the alternate text on a sibling image to the button and changes the text of the button to reflect its function. 
+ [act-hamburger-menu]("#act-hamburger-menu") (aka Phone Navigation Menu) provides a menu for use with phones which replicates the navigation menu.

## act-toogle-tooltips {act-toggle-tooltips}
When enabled this function modifies the behaviour of tooltips on images to include a button to show/hide the tooltip for alt text.
It is configured via the ACT Tools -> Image Toggle Tooltips menu item
Where the attributes are as follows:

|Attribute|Contents|
|---------|--------|
|showtext|Text that is to be shown on the button when the tooltips are hidden, this should indicate the action the user needs to take, and could be either as shown here or symbol such as + or >|
|hidetext|Text that is shown on the button when the tooltips are shown, this should indicate the action the user needs to take, either as shown here of a symbol such as - or <|
|position|Controls the position of the button (left or right of the caption)|
|enable|When enabled the caption for each image (with caption) is modified to include a button which when pressed shows/hides the tooltip.|

## act-hamburger-menu {act-hamburger-menu}

Unlike other **menu plugins** this works with **navigation blocks** rather than classic menus

When enabled this function modifies the navigation when on narrow screen device so that initially a navigation button appears towards the top left of the screen. When the navigation button is pushed, the top level menu expands.
The top level menu spans the screen for each top level item, the majority of the bar when pressed links to the corresponding menu item, the portion to the right with the downarrow on it when pressed shows subordinate menu items.

It is configured via the ACT Tools -> Phone Navigation Menu menu item
Where the attributes are as follows:
|Attribute|Contents|
|---------|--------|
|Background Colour|Colour of the background of the top level menu|
|Background Hover Colour|Background when hovered over|
|Text Colour|Colour of text for top level menu|
|Link Hover Colour|Colour of text when hovered over|
|Border Colour|Colour of border of top level menu|
|Button Colour|colour of expand button|
|Button Text Colour|Colour of expand button for text/graphics|
|Submenu Background Colour|Colour of submenu item backgrounds|
|Submenu Border Colour|Colour of submenu borders|
|Cutoff Value|Point at which menu changes from navigation to hamburger button|
|Position|Position of the hamburger button on screen (right/centre/left)|
|Enabled|This tool must be enabled to work|

