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