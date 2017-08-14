(function () {
    "use strict";
    var masthead, content, stuck, stickPoint, distance, offset, adminbar;

    // Check if sticky header is enabled
    if (!Shapla.stickyHeader.isEnabled) {
        return;
    }

    function hasClass(el, className) {
        if (el.classList) {
            return el.classList.contains(className);
        }
        return !!el.className.match(new RegExp('(\\s|^)' + className + '(\\s|$)'));
    }

    function addClass(el, className) {
        if (el.classList) {
            el.classList.add(className)
        }
        else if (!hasClass(el, className)) {
            el.className += " " + className;
        }
    }

    function removeClass(el, className) {
        if (el.classList) {
            el.classList.remove(className)
        }
        else if (hasClass(el, className)) {
            var reg = new RegExp('(\\s|^)' + className + '(\\s|$)');
            el.className = el.className.replace(reg, ' ');
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        masthead = document.querySelector("#masthead");
        content = document.querySelector("#content");
        adminbar = document.querySelector("#wpadminbar");
        stuck = false;
        stickPoint = masthead.offsetTop;

        window.onscroll = function (e) {
            offset = window.pageYOffset;
            if (window.innerWidth < Shapla.stickyHeader.minWidth) {
                return;
            }
            distance = stickPoint - offset;
            if ((distance <= 0) && !stuck) {
                addClass(masthead, 'is-sticky');
                content.style.marginTop = masthead.offsetHeight + 'px';
                stuck = true;
            }
            else if (stuck && (offset <= stickPoint)) {
                removeClass(masthead, 'is-sticky');
                content.style.marginTop = '';
                stuck = false;
            }
        }
    });
})();