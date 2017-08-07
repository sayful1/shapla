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