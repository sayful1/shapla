(function () {
    'use strict';
    var target,
        modal,
        modals = document.querySelectorAll('[data-toggle="modal"]'),
        dismiss = document.querySelectorAll('[data-dismiss="modal"]');
    if (modals.length < 1) {
        return;
    }
    Array.prototype.forEach.call(modals, function (el, i) {
        el.addEventListener('click', function (event) {
            event.preventDefault();
            target = el.getAttribute('data-target');
            modal = document.querySelector(target);
            if (!modal) {
                return;
            }
            addClass(modal, 'is-active');
        });
    });
    if (dismiss.length < 1) {
        return;
    }
    Array.prototype.forEach.call(dismiss, function (el, i) {
        el.addEventListener('click', function (event) {
            event.preventDefault();
            var closestModal = el.closest('.modal');
            if (!closestModal) {
                return;
            }
            removeClass(modal, 'is-active');
        });
    });
    // polyfill for closest
    if (window.Element && !Element.prototype.closest) {
        Element.prototype.closest =
            function (s) {
                var matches = (this.document || this.ownerDocument).querySelectorAll(s),
                    i,
                    el = this;
                do {
                    i = matches.length;
                    while (--i >= 0 && matches.item(i) !== el) {
                    }
                    ;
                } while ((i < 0) && (el = el.parentElement));
                return el;
            };
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
})();
/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and
 * enables TAB key navigation support for dropdown menus.
 */
(function () {
    "use strict";

    var menuToggle, siteHeaderMenu, container, links, i, len;
    var screenReaderText = Shapla.screenReaderText;

    menuToggle = document.querySelector('#menu-toggle');
    siteHeaderMenu = document.querySelector('#site-header-menu');
    container = document.querySelector('#site-navigation');
    if (!menuToggle || !siteHeaderMenu || !container) {
        return;
    }

    /**
     * Check if DOM is ready
     */
    function ready(fn) {
        if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading") {
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }

    /**
     * Init main navigation
     */
    function initMainNavigation() {
        var dropdownToggle = '<button class="dropdown-toggle" aria-expanded="false"><span class="screen-reader-text">' + screenReaderText.expand + '</span></button>';

        // Insert toggle button before children items
        var hasChild = container.querySelectorAll('.menu-item-has-children > a');
        Array.prototype.forEach.call(hasChild, function (el, i) {
            el.insertAdjacentHTML('afterend', dropdownToggle);
        });

        // Toggle buttons items with active children menu items.
        var ancestorBtn = container.querySelectorAll('.current-menu-ancestor > button');
        Array.prototype.forEach.call(ancestorBtn, function (el, i) {
            el.classList.add('toggled-on');
        });

        // Toggle submenu items with active children menu items.
        var ancestorSubMenu = container.querySelectorAll('.current-menu-ancestor > .sub-menu');
        Array.prototype.forEach.call(ancestorSubMenu, function (el, i) {
            el.classList.add('toggled-on');
        });

        // Add menu items with submenus to aria-haspopup="true".
        var hasChild = container.querySelectorAll('.menu-item-has-children');
        Array.prototype.forEach.call(hasChild, function (el, i) {
            el.setAttribute('aria-haspopup', 'true');
        });

        var dropdownToggle = container.querySelectorAll('.dropdown-toggle');
        Array.prototype.forEach.call(dropdownToggle, function (el, i) {
            el.addEventListener('click', function (event) {
                event.preventDefault();

                // Toggle class for this element
                el.classList.toggle('toggled-on');

                // Toggle class for .sub-menu
                el.nextElementSibling.classList.toggle('toggled-on');

                // Change area-expanded attribute value
                var ariaExpanded = el.getAttribute('aria-expanded') === 'false' ? 'true' : 'false';
                el.setAttribute('aria-expanded', ariaExpanded);

                // Change screen reader text
                var screenReaderSpan = el.querySelector('.screen-reader-text');
                var screenReaderSpanText = screenReaderSpan.textContent === screenReaderText.expand ? screenReaderText.collapse : screenReaderText.expand;
                screenReaderSpan.textContent = screenReaderSpanText;
            });
        });
    }

    /**
     * Enable menuToggle.
     */
    function initMenuToggle() {
        // Add an initial values for the attribute.
        menuToggle.setAttribute('aria-expanded', 'false');
        container.setAttribute('aria-expanded', 'false');

        menuToggle.addEventListener('click', function (event) {
            event.preventDefault();
            siteHeaderMenu.classList.toggle('toggled-on');
            menuToggle.classList.toggle('toggled-on');

            // Change area-expanded attribute value
            var ariaExpanded = container.getAttribute('aria-expanded') === 'false' ? 'true' : 'false';
            menuToggle.setAttribute('aria-expanded', ariaExpanded);
            container.setAttribute('aria-expanded', ariaExpanded);
        });
    }

    // Get all the link elements within the menu.
    links = container.getElementsByTagName('a');

    // Each time a menu link is focused or blurred, toggle focus.
    for (i = 0, len = links.length; i < len; i++) {
        links[i].addEventListener('focus', toggleFocus, true);
        links[i].addEventListener('blur', toggleFocus, true);
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
                if (-1 !== self.className.indexOf('focus')) {
                    self.className = self.className.replace(' focus', '');
                } else {
                    self.className += ' focus';
                }
            }

            self = self.parentElement;
        }
    }

    /**
     * Toggles `focus` class to allow submenu access on tablets.
     */
    ( function (container) {
        var touchStartFn, i,
            parentLink = container.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a');

        if ('ontouchstart' in window) {
            touchStartFn = function (e) {
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
            };

            for (i = 0; i < parentLink.length; ++i) {
                parentLink[i].addEventListener('touchstart', touchStartFn, false);
            }
        }
    }(container) );

    ready(function () {
        initMainNavigation();
        initMenuToggle();
    });

})();
/**
 * File search.js
 * Search toggle.
 */
(function () {
    "use strict";
    var toggle = document.querySelector('#search-toggle');
    var closebtn = document.querySelector('#search-closebtn');
    var sidenav = document.querySelector('#search-sidenav');
    if (toggle !== null && closebtn !== null && sidenav !== null) {
        // Open search sidenav
        toggle.addEventListener('click', function (event) {
            event.preventDefault();
            sidenav.style.width = '320px';
            sidenav.querySelector('.search-field').focus();
        });
        // Close search sidenav
        closebtn.addEventListener('click', function (event) {
            event.preventDefault();
            sidenav.style.width = '0';
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

(function () {
    "use strict";
    var masthead, content, stuck, stickPoint, distance, offset, adminbar;

    // Check if sticky header is enabled
    if (!Shapla.stickyHeader) {
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
            if (window.innerWidth < 992) {
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