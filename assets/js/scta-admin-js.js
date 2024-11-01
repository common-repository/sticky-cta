// Sticky Side Buttons JS
jQuery(function ($) {

    // Buttons accorion + sortable
    $('#scta-sortable-buttons')
        .accordion({
            header: "> li > header",
            active: false,
            collapsible: true,
            heightStyle: "content",
            activate: function (event, ui) {

                // scta action
                scta_action($(this));

            }
        })
        .sortable({
            axis: "y",
            update: function (event, ui) {

                // scta action
                scta_action($(this));

            }
        });

    // Add new button
    $('.scta-add-btn').click(function () {

        var li_count = ($('#scta-sortable-buttons li').length) - 1;
        var new_li = li_count + 1;
        var ul = $('#scta-sortable-buttons');
        var li = '<li id="scta_btn_' + new_li + '"><header><i class="fa fa-caret-down" aria-hidden="true"></i>New Button</header><div class="scta-btn-body"><div class="scta-body-left"><p><label for="button-text-' + new_li + '">Button Text</label><input type="text" id="button-text-' + new_li + '" class="widefat" name="scta_buttons[btns][' + new_li + '][btn_text]"></p><p class="scta-iconpicker-container"><label for="button-icon-' + new_li + '">Button icon</label><input type="text" id="button-icon-' + new_li + '" class="widefat scta-iconpicker" data-placement="bottomRight" name="scta_buttons[btns][' + new_li + '][btn_icon]"><span class="scta-icon-preview input-group-addon"></span></p><p><label for="button-link-' + new_li + '">link URL</label><input type="text" id="button-link-' + new_li + '" class="widefat" name="scta_buttons[btns][' + new_li + '][btn_link]"></p></div><div class="scta-body-right"><p><label for="button-color-' + new_li + '">Button Color</label><input type="text" id="button-color-' + new_li + '" class="widefat scta-colorpicker" name="scta_buttons[btns][' + new_li + '][btn_color]"></p><p><label for="button-font-color-' + new_li + '">font color</label><input type="text" id="button-font-color-' + new_li + '" class="widefat scta-colorpicker" name="scta_buttons[btns][' + new_li + '][btn_font_color]"></p></div><div class="scta-btn-controls"><a href="#" class="scta-remove-btn">Remove</a> | <a href="#" class="scta-close-btn">Close</a></div></div></li>';

        ul.prepend(li);

        $('#scta-sortable-buttons').accordion( "refresh" );

        $('.scta-iconpicker').iconpicker();

        $('.scta-colorpicker').wpColorPicker();

        scta_action('#scta-sortable-buttons');

        return false;

    });

    // scta Action
    function scta_action(el) {

        // Update sorting
        var btns_sort = $(el).sortable('serialize', {key: 'sort'});
        $('#scta-btns-order').val(btns_sort);

        // On click close
        $('.scta-close-btn').click(function () {
            $('#scta-sortable-buttons').accordion('option', {active: false});
            return false;
        });

        // On click remove
        $('.scta-remove-btn').click(function () {
            $('#scta-sortable-buttons').accordion('option', {active: false});
            $(this).parents('li').remove();
            return false;
        });

    }

    // Icon Picker
    $('.scta-iconpicker').iconpicker();

    // Color picker
    $('.scta-colorpicker').wpColorPicker();

});