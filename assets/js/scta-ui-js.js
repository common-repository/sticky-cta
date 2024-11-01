// scta UI jQuery
jQuery(function ($) {

    // Animation Slide
    var scta_panel = $('#scta-container'),
        scta_panel_w = scta_panel.width(),
        sbb_display_margin = 50,
        window_width = jQuery(window).width();

    scta_panel.css('z-index', scta_ui_data.z_index);

    if (scta_panel.hasClass('scta-btns-left') && (scta_panel.hasClass('scta-anim-slide') || scta_panel.hasClass('scta-anim-icons'))) {

        scta_panel.css('left', '-' + (scta_panel_w - sbb_display_margin) + 'px');

    } else if (scta_panel.hasClass('scta-btns-right') && (scta_panel.hasClass('scta-anim-slide') || scta_panel.hasClass('scta-anim-icons'))) {

        scta_panel.css('right', '-' + (scta_panel_w - sbb_display_margin) + 'px');

    }

    // Slide when hover
    if (window_width >= 768) {
        scta_panel.hover(function () {

            if (scta_panel.hasClass('scta-btns-left') && scta_panel.hasClass('scta-anim-slide')) {

                scta_panel.stop().animate({'left': 0}, 300);

            } else if (scta_panel.hasClass('scta-btns-right') && scta_panel.hasClass('scta-anim-slide')) {

                scta_panel.stop().animate({'right': 0}, 300);

            }

        }, function () {

            if (scta_panel.hasClass('scta-btns-left') && scta_panel.hasClass('scta-anim-slide')) {

                scta_panel.animate({'left': '-' + (scta_panel_w - sbb_display_margin) + 'px'}, 300);

            } else if (scta_panel.hasClass('scta-btns-right') && scta_panel.hasClass('scta-anim-slide')) {

                scta_panel.animate({'right': '-' + (scta_panel_w - sbb_display_margin) + 'px'}, 300);

            }

        });

    } else {
        scta_panel.click(function (e) {

            if (jQuery(this).hasClass('scta-open')) {
                jQuery(this).removeClass('scta-open');
                if (scta_panel.hasClass('scta-btns-left') && scta_panel.hasClass('scta-anim-slide')) {

                    scta_panel.animate({'left': '-' + (scta_panel_w - sbb_display_margin) + 'px'}, 300);

                } else if (scta_panel.hasClass('scta-btns-right') && scta_panel.hasClass('scta-anim-slide')) {

                    scta_panel.animate({'right': '-' + (scta_panel_w - sbb_display_margin) + 'px'}, 300);

                }
            } else {
                e.preventDefault();
                jQuery(this).addClass('scta-open');

                if (scta_panel.hasClass('scta-btns-left') && scta_panel.hasClass('scta-anim-slide')) {

                    scta_panel.stop().animate({'left': 0}, 300);

                } else if (scta_panel.hasClass('scta-btns-right') && scta_panel.hasClass('scta-anim-slide')) {

                    scta_panel.stop().animate({'right': 0}, 300);

                }
            }

        });
    }


});