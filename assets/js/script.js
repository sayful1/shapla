(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory() :
    typeof define === 'function' && define.amd ? define(factory) :
    (factory());
}(this, (function () { 'use strict';

    var ShaplaSkipLinkFocusFix = function ShaplaSkipLinkFocusFix() {
        var isWebkit = navigator.userAgent.toLowerCase().indexOf('webkit') > -1,
            isOpera = navigator.userAgent.toLowerCase().indexOf('opera') > -1,
            isIe = navigator.userAgent.toLowerCase().indexOf('msie') > -1;

        if ((isWebkit || isOpera || isIe) && document.getElementById && window.addEventListener) {
            window.addEventListener('hashchange', function () {
                var id = location.hash.substring(1),
                    element;

                if (!(/^[A-z0-9_-]+$/.test(id))) {
                    return;
                }

                element = document.getElementById(id);

                if (element) {
                    if (!(/^(?:a|select|input|button|textarea)$/i.test(element.tagName))) {
                        element.tabIndex = -1;
                    }

                    element.focus();
                }
            }, false);
        }
    };

    var ShaplaNavigation = function ShaplaNavigation(config) {

        var container = document.querySelector('#site-navigation');
        if (!container) {
            return;
        }

        // Each time a menu link is focused or blurred, toggle focus.
        container.querySelectorAll('a').forEach(function (anchor) {
            anchor.addEventListener('focus', ShaplaNavigation.toggleFocus, true);
            anchor.addEventListener('blur', ShaplaNavigation.toggleFocus, true);
        });

        ShaplaNavigation.initHamburgerIcon(container);
        ShaplaNavigation.initMainNavigation(container, config);
        ShaplaNavigation.toggleFocusClassTouchScreen(container);
    };

    /**
     * Enable menuToggle.
     */
    ShaplaNavigation.initHamburgerIcon = function initHamburgerIcon (container) {
        var menuToggle = document.querySelector('#menu-toggle');

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
    };

    /**
     * Init main navigation
     */
    ShaplaNavigation.initMainNavigation = function initMainNavigation (container, config) {
        var dropdownToggle = "<button class=\"dropdown-toggle\" aria-expanded=\"false\"><span class=\"screen-reader-text\">" + (config.expand) + "</span></button>";

        // Insert toggle button before children items
        container.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a').forEach(function (el) {
            el.insertAdjacentHTML('afterend', dropdownToggle);
        });

        // Set the active submenu dropdown toggle button initial state.
        container.querySelectorAll('.current-menu-ancestor > button').forEach(function (el) {
            el.classList.add('toggled-on');
            el.setAttribute('aria-expanded', 'true');
            el.querySelector('.screen-reader-text').textContent = config.collapse;
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
                screenReaderSpan.textContent = (screenReaderSpan.textContent === config.expand) ? config.collapse : config.expand;
            });
        });
    };

    /**
     * Sets or removes .focus class on an element.
     */
    ShaplaNavigation.toggleFocus = function toggleFocus () {
        var self = this;
        // Move up through the ancestors of the current link until we hit .nav-menu.
        while (-1 === self.className.indexOf('primary-menu')) {
            // On li elements toggle the class .focus.
            if ('li' === self.tagName.toLowerCase()) {
                self.classList.toggle('focus');
            }
            self = self.parentElement;
        }
    };

    /**
     * Toggles `focus` class to allow submenu access on tablets.
     */
    ShaplaNavigation.toggleFocusClassTouchScreen = function toggleFocusClassTouchScreen (container) {
        var parentLinks = container.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a');

        if ('ontouchstart' in window) {
            parentLinks.forEach(function (anchor) {
                anchor.addEventListener('touchstart', function (e) {
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
                }, false);
            });
        }
    };

    var ShaplaBackToTop = function ShaplaBackToTop(selector, config) {
        var element,
            distance = 500,
            button = document.querySelector(selector);

        if (!config.isEnabled) { return; }

        if (!button) { return; }

        window.addEventListener("scroll", function () {
            ShaplaBackToTop.toggleButton(distance, button);
        });

        button.addEventListener("click", function () {
            if (document.body.scrollTop) {
                // For Safari
                element = document.body;
            } else if (document.documentElement.scrollTop) {
                // For Chrome, Firefox, IE and Opera
                element = document.documentElement;
            }

            ShaplaBackToTop.scrollToTop(element, 300);
        });
    };

    ShaplaBackToTop.scrollToTop = function scrollToTop (element, duration) {
        if (duration <= 0) { return; }
        var difference = 0 - element.scrollTop;
        var perTick = difference / duration * 10;

        setTimeout(function () {
            element.scrollTop = element.scrollTop + perTick;
            if (element.scrollTop === 0) { return; }
            ShaplaBackToTop.scrollToTop(element, duration - 10);
        }, 10);
    };

    ShaplaBackToTop.toggleButton = function toggleButton (distance, button) {
        if (document.body.scrollTop > distance || document.documentElement.scrollTop > distance) {
            button.classList.add('is-active');
        } else {
            button.classList.remove('is-active');
        }
    };

    var ShaplaStickyHeader = function ShaplaStickyHeader(selector, settings) {
        var masthead = document.querySelector(selector);

        if (!masthead) { return; }

        var content = masthead.nextElementSibling,
            stickPoint = masthead.offsetTop,
            stuck = false,
            distance,
            offset;

        // Check if sticky header is enabled
        if (!settings.isEnabled) { return; }

        window.addEventListener("scroll", function () {
            offset = window.pageYOffset;
            if (window.innerWidth < settings.minWidth) {
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
    };

    var ShaplaSearch = function ShaplaSearch() {
        ShaplaSearch.defaultSearch();
        ShaplaSearch.productSearch();
    };

    ShaplaSearch.defaultSearch = function defaultSearch () {
        var toggle = document.querySelector('#search-toggle'),
            menuSearch = document.querySelector('.shapla-main-menu-search');

        if (!menuSearch || !toggle) { return; }

        toggle.addEventListener('click', function (event) {
            event.preventDefault();
            menuSearch.classList.toggle('shapla-main-menu-search-open');
            menuSearch.querySelector('input[name="s"]').focus();
        });

        window.addEventListener('click', function (e) {
            if (!menuSearch.contains(e.target)) {
                menuSearch.classList.remove('shapla-main-menu-search-open');
            }
        });
    };

    ShaplaSearch.productSearch = function productSearch () {
        var productSearch = document.querySelector('.shapla-product-search');
        if (!productSearch) { return; }

        var catList = productSearch.querySelector('.shapla-cat-list');
        if (!catList) { return; }

        var searchLabel = productSearch.querySelector('.nav-search-label'),
            defaultLabel = searchLabel.getAttribute('data-default'),
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

            productSearch.querySelector('input[type="search"]').focus();
        });
    };

    var config = window.Shapla || {};

    new ShaplaSkipLinkFocusFix();
    new ShaplaNavigation(config);
    new ShaplaBackToTop('#shapla-back-to-top', config.BackToTopButton);
    new ShaplaStickyHeader("#masthead", config.stickyHeader);
    new ShaplaSearch();

})));
