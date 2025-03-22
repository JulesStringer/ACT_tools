jQuery(document).ready(function($) {
    $('.act-color-picker').wpColorPicker({
        change: function(event, ui) {
            var colorString = ui.color.toString();
            $(this).closest('.wp-picker-container').find('.wp-color-result-text').text(colorString);
        },
        clear: function(event){
            $(this).closest('.wp-picker-container').find('.wp-color-result-text').text('Select Colour');
        },
        create: function(event, ui){  //ADDED THIS
            var initialColor = $(this).val();
            $(this).closest('.wp-picker-container').find('.wp-color-result-text').text(initialColor);
        },
        alpha: true // enable alpha channel
    });
});