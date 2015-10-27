jQuery(document).ready(function() {
    //************************ Background scroll *****************************//

    jQuery(window).on('load', function() {
        jQuery('.parallax-section').each(function() {
            jQuery(this).parallax('center', 0.2, true);
        });
    });

    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > 100) {
            jQuery('.scrollup').fadeIn();
        } else {
            jQuery('.scrollup').fadeOut();
        }
    });

});