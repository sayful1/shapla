/**
 * File navigation.js.
 *
 * @global Shapla
 *
 * Handles toggling the navigation menu for small screens and
 * enables TAB key navigation support for dropdown menus.
 */
(function () {
    "use strict";

    var menuToggle,
        container,
        screenReaderText = Shapla.screenReaderText;

    container = document.querySelector('#site-navigation');
    if (!container) {
        return;
    }

    menuToggle = document.querySelector('#menu-toggle');
    if (!menuToggle) {
        return;
    }

    /**
     * Enable menuToggle.
     */
    function initHamburgerIcon() {
        // Add an initial values for the attribute.
        menuToggle.setAttribute('aria-expanded', 'false');
        container.setAttribute('aria-expanded', 'false');

        menuToggle.addEventListener('click', function () {
            // Toggle the class on both the "#menu-toggle" and the "#site-navigation"
            menuToggle.classList.toggle('toggled-on');
            container.classList.toggle('toggled-on');

            // Change area-expanded attribute value
            var ariaExpanded = container.classList.contains('toggled-on') ? 'true' : 'false';
            menuToggle.setAttribute('aria-expanded', ariaExpanded);
            container.setAttribute('aria-expanded', ariaExpanded);
        });
    }

    /**
     * Init main navigation
     */
    function initMainNavigation() {
        // Insert toggle button before children items
        var dropdownToggle = '<button class="dropdown-toggle" aria-expanded="false"><span class="screen-reader-text">' +
            screenReaderText.expand + '</span></button>';
        container.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a').forEach(function (el) {
            el.insertAdjacentHTML('afterend', dropdownToggle);
        });

        // Set the active submenu dropdown toggle button initial state.
        container.querySelectorAll('.current-menu-ancestor > button').forEach(function (el) {
            el.classList.add('toggled-on');
            el.setAttribute('aria-expanded', 'true');
            el.querySelector('.screen-reader-text').textContent = screenReaderText.collapse;
        });

        // Set the active submenu initial state.
        container.querySelectorAll('.current-menu-ancestor > .sub-menu').forEach(function (el) {
            el.classList.add('toggled-on');
        });

        // Add menu items with submenus to aria-haspopup="true".
        container.querySelectorAll('.menu-item-has-children').forEach(function (el) {
            el.setAttribute('aria-haspopup', 'true');
        });

        container.querySelectorAll('.dropdown-toggle').forEach(function (el) {
            el.addEventListener('click', function (event) {
                event.preventDefault();

                // Toggle class for this element
                el.classList.toggle('toggled-on');

                // Toggle class for .sub-menu
                el.nextElementSibling.classList.toggle('toggled-on');

                // Change area-expanded attribute value
                el.setAttribute('aria-expanded', el.getAttribute('aria-expanded') === 'false' ? 'true' : 'false');

                // Change screen reader text
                var screenReaderSpan = el.querySelector('.screen-reader-text');
                screenReaderSpan.textContent = (screenReaderSpan.textContent === screenReaderText.expand) ?
                    screenReaderText.collapse : screenReaderText.expand;
            });
        });
    }


    /**
     * Sets or removes .focus class on an element.
     */
    function toggleFocus() {
        var self = this;
        // Move up through the ancestors of the current link until we hit .nav-menu.
        while (-1 === self.className.indexOf('primary-menu')) {
            // On li elements toggle the class .focus.
            if ('li' === self.tagName.toLowerCase()) {
                self.classList.toggle('focus');
            }
            self = self.parentElement;
        }
    }

    /**
     * Toggles `focus` class to allow submenu access on tablets.
     */
    function toggleFocusClassTouchScreen(e) {
        var menuItem = this.parentNode, i;

        if (!menuItem.classList.contains('focus')) {
            e.preventDefault();
            for (i = 0; i < menuItem.parentNode.children.length; ++i) {
                if (menuItem === menuItem.parentNode.children[i]) {
                    continue;
                }
                menuItem.parentNode.children[i].classList.remove('focus');
            }
            menuItem.classList.add('focus');
        } else {
            menuItem.classList.remove('focus');
        }
    }

    // Each time a menu link is focused or blurred, toggle focus.
    container.querySelectorAll('a').forEach(function (anchor) {
        anchor.addEventListener('focus', toggleFocus, true);
        anchor.addEventListener('blur', toggleFocus, true);
    });

    var parentLink = container.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a');
    if ('ontouchstart' in window) {
        parentLink.forEach(function (anchor) {
            anchor.addEventListener('touchstart', toggleFocusClassTouchScreen, false);
        });
    }

    initMainNavigation();
    initHamburgerIcon();
})();

(function () {
    'use strict';
    var productSearch = document.querySelector('.shapla-product-search');

    if (!productSearch) {
        return;
    }

    var searchLabel = productSearch.querySelector('.nav-search-label'),
        defaultLabel = searchLabel.getAttribute('data-default'),
        catList = productSearch.querySelector('.shapla-cat-list'),
        defaultVal = catList.value;

    if (defaultVal === '') {
        searchLabel.textContent = defaultLabel;
    } else {
        searchLabel.textContent = defaultVal;
    }

    catList.addEventListener('change', function () {
        var selectText = this.value;
        if (selectText === '') {
            searchLabel.textContent = defaultLabel;
        } else {
            searchLabel.textContent = selectText;
        }

        productSearch.querySelector('input[type="text"]').focus();
    });

})();
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
/**
 * File search.js
 * Search toggle.
 */
(function () {
    "use strict";
    var toggle = document.querySelector('#search-toggle'),
        menuSearch = document.querySelector('.shapla-main-menu-search');

    if (menuSearch !== null && toggle !== null) {
        toggle.addEventListener('click', function (event) {
            event.preventDefault();
            menuSearch.classList.toggle('shapla-main-menu-search-open');
            menuSearch.querySelector('input[name="s"]').focus();
        });
    }
})();
/**
 * File skip-link-focus-fix.js.
 * Helps with accessibility for keyboard only users.
 * Learn more: https://git.io/vWdr2
 */
(function () {
    var isWebkit = navigator.userAgent.toLowerCase().indexOf('webkit') > -1,
        isOpera = navigator.userAgent.toLowerCase().indexOf('opera') > -1,
        isIe = navigator.userAgent.toLowerCase().indexOf('msie') > -1;

    if (( isWebkit || isOpera || isIe ) && document.getElementById && window.addEventListener) {
        window.addEventListener('hashchange', function () {
            var id = location.hash.substring(1),
                element;

            if (!( /^[A-z0-9_-]+$/.test(id) )) {
                return;
            }

            element = document.getElementById(id);

            if (element) {
                if (!( /^(?:a|select|input|button|textarea)$/i.test(element.tagName) )) {
                    element.tabIndex = -1;
                }

                element.focus();
            }
        }, false);
    }
})();

/**
 * @global Shapla
 */
(function () {
    "use strict";

    var masthead, content, stuck, stickPoint, distance, offset;

    // Check if sticky header is enabled
    if (!Shapla.stickyHeader.isEnabled) {
        return;
    }

    document.addEventListener("DOMContentLoaded", function () {
        masthead = document.querySelector("#masthead");
        content = masthead.nextElementSibling;
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
                content.style.marginTop = masthead.offsetHeight + 'px';
                stuck = true;
            }
            else if (stuck && (offset <= stickPoint)) {
                masthead.classList.remove('is-sticky');
                content.style.marginTop = '';
                stuck = false;
            }
        });
    });
})();