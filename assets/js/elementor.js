(function ($) {
    'use strict';

    var ShaplaHeroSlider = function ($scope, $) {
        var slider_elem = $scope.find('.hero-carousel').eq(0);
        var settings = slider_elem.data('settings');
        slider_elem.flickity({
            wrapAround: settings.wrapAround,
            prevNextButtons: settings.prevNextButtons,
            pageDots: settings.pageDots,
            rightToLeft: settings.rightToLeft,
            autoPlay: settings.autoPlay,
            pauseAutoPlayOnHover: settings.pauseAutoPlayOnHover
        });
    };

    // Make sure you run this code under Elementor..
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/hero-slider.default', ShaplaHeroSlider);
    });

})(jQuery);
