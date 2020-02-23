class ShaplaSearch {
	constructor() {
		ShaplaSearch.defaultSearch();
		ShaplaSearch.productSearch();
	}

	static defaultSearch() {
		let toggle = document.querySelector('#search-toggle'),
			menuSearch = document.querySelector('.shapla-main-menu-search');

		if (!menuSearch || !toggle) return;

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

export {ShaplaSearch}
