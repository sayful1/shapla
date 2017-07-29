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