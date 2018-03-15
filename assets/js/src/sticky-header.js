/**
 * @global Shapla
 */
(function () {
    "use strict";

    var masthead, stuck, stickPoint, distance, offset;

    // Check if sticky header is enabled
    if (!Shapla.stickyHeader.isEnabled) {
        return;
    }

    document.addEventListener("DOMContentLoaded", function () {
        masthead = document.querySelector("#masthead");
        stuck = false;
        stickPoint = masthead.offsetTop;

        document.addEventListener("scroll", function () {
            offset = window.pageYOffset;
            if (window.innerWidth < Shapla.stickyHeader.minWidth) {
                return;
            }
            distance = stickPoint - offset;
            if ((distance <= 0) && !stuck) {
                masthead.classList.add('is-sticky');
                stuck = true;
            }
            else if (stuck && (offset <= stickPoint)) {
                masthead.classList.remove('is-sticky');
                stuck = false;
            }
        });
    });
})();