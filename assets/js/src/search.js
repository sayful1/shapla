/**
 * File search.js
 * Search toggle.
 */
(function () {
    "use strict";
    var toggle = document.querySelector('#search-toggle'),
        menuSearch = document.querySelector('.shapla-main-menu-search'),
        menuSearchField = menuSearch.querySelector('input[name="s"]');

    if (menuSearch !== null && toggle !== null) {
        toggle.addEventListener('click', function (event) {
            event.preventDefault();
            menuSearch.classList.toggle('shapla-main-menu-search-open');
            menuSearchField.focus();
        });
    }
})();