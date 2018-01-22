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