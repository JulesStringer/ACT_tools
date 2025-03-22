// act-toggle-tooltips.js
jQuery(document).ready(function ($) {
    const showText = actTooltipSettings.showText || "More...";
    const hideText = actTooltipSettings.hideText || "Less...";

    $(".toggle-button").on("click", function () {
        const button = $(this);
        const figure = button.closest("figure");
        const img = figure.find("img");
        const tooltipText = figure.find(".tooltip-text");
        const isExpanded = button.attr("aria-expanded") === "true";

        button.text(isExpanded ? showText : hideText);

        if (isExpanded) {
            tooltipText.hide();
        } else {
            let current_image_width = img[0].offsetWidth;
            let current_figure_height = figure[0].offsetHeight;
            let current_image_height = img[0].offsetHeight;

            tooltipText.css({
                display: 'block',
                bottom: (current_figure_height - current_image_height) + 'px',
                width: (current_image_width - 16) + 'px'
            });
        }
        button.attr("aria-expanded", !isExpanded);
    });
});
