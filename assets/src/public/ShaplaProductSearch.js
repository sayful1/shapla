class ShaplaProductSearch {
	/**
	 * Class constructor
	 */
	constructor() {
		ShaplaProductSearch.productSearch();
	}

	static productSearch() {
		let productSearch = document.querySelector('.shapla-product-search');
		if (!productSearch) return;

		let catList = productSearch.querySelector('.shapla-cat-list');
		if (!catList) return;

		let form = productSearch.querySelector('form'),
			searchInput = productSearch.querySelector('input[type="search"]'),
			searchLabel = productSearch.querySelector('.nav-search-label'),
			defaultLabel = searchLabel.getAttribute('data-default'),
			defaultVal = catList.value;

		if (defaultVal === '') {
			searchLabel.textContent = defaultLabel;
		} else {
			searchLabel.textContent = defaultVal;
		}

		catList.addEventListener('change', function () {
			let label = catList.options[catList.selectedIndex].text;
			let selectText = this.value;
			if (selectText === '') {
				searchLabel.textContent = defaultLabel;
			} else {
				searchLabel.textContent = label;
			}

			searchInput.focus();
		});

		searchInput.addEventListener('focus', () => {
			form.classList.add('is-focused');
		});

		searchInput.addEventListener('blur', () => {
			form.classList.remove('is-focused');
		});
	}
}
