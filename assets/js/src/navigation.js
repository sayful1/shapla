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
        var menuItem = this.parentNode, menuItems = menuItem.parentNode.children;

        if (!menuItem.classList.contains('focus')) {
            e.preventDefault();
            menuItems.forEach(function (el) {
                if (el !== menuItem) {
                    el.classList.remove('focus');
                }
            });
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
