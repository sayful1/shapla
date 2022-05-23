class ShaplaSearch {
	/**
	 * Class constructor
	 */
	constructor() {
		ShaplaSearch.defaultSearch();
	}

	static defaultSearch() {
		let toggle = document.querySelector('#search-toggle'),
			menuSearch = document.querySelector('.shapla-main-menu-search');

		if (!menuSearch || !toggle) return;

		toggle.addEventListener('click', function (event) {
			event.preventDefault();
			menuSearch.classList.toggle('shapla-main-menu-search-open');
			(menuSearch.querySelector('input[name="s"]') as HTMLElement).focus();
		});

		window.addEventListener('click', function (e) {
			if (!menuSearch.contains(e.target as HTMLElement)) {
				menuSearch.classList.remove('shapla-main-menu-search-open');
			}
		});
	}
}

export default ShaplaSearch
