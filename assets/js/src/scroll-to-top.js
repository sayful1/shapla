/**
 * @global Shapla
 */
(function () {
    "use strict";

    var element,
        config = Shapla.BackToTopButton,
        button = document.querySelector('#shapla-back-to-top'),
        distance = 500;

    if (!config.isEnabled) return;

    if (!button) return;


    function showOrHideButton() {
        if (document.body.scrollTop > distance || document.documentElement.scrollTop > distance) {
            button.classList.add('is-active');
        } else {
            button.classList.remove('is-active');
        }
    }

    function scrollToTop(element, duration) {

        if (duration <= 0) return;
        var difference = 0 - element.scrollTop;
        var perTick = difference / duration * 10;

        setTimeout(function () {
            element.scrollTop = element.scrollTop + perTick;
            if (element.scrollTop === 0) return;
            scrollToTop(element, duration - 10);
        }, 10);
    }

    document.addEventListener("DOMContentLoaded", function () {
        window.addEventListener("scroll", function () {
            showOrHideButton();
        });
    });

    button.addEventListener("click", function () {
        if (document.body.scrollTop) {
            // For Safari
            element = document.body;
        } else if (document.documentElement.scrollTop) {
            // For Chrome, Firefox, IE and Opera
            element = document.documentElement;
        }

        scrollToTop(element, 300);
    });

})();