class ShaplaNavigation {
	private readonly element: Element;
	private settings: Record<string, any>;

	/**
	 * ShaplaNavigation constructor
	 *
	 * @param selector
	 * @param config
	 */
	constructor(selector: string, config: Record<string, any>) {
		this.element = document.querySelector(selector);
		this.settings = config;

		if (!this.element) {
			return;
		}

		// Each time a menu link is focused or blurred, toggle focus.
		this.element.querySelectorAll('a').forEach(anchor => {
			anchor.addEventListener('focus', ShaplaNavigation.toggleFocus, true);
			anchor.addEventListener('blur', ShaplaNavigation.toggleFocus, true);
		});

		this.initHamburgerIcon();
		this.initMainNavigation();
		this.toggleFocusClassTouchScreen();
	}

	/**
	 * Enable menuToggle.
	 */
	initHamburgerIcon() {
		let toggleButtons = document.querySelectorAll('.menu-toggle');
		if (toggleButtons.length < 1) {
			return;
		}

		toggleButtons.forEach((menuToggle: HTMLElement) => {

			// Get the target from the "data-target" attribute
			const target = menuToggle.dataset.target;
			const $target = document.querySelector(target);

			// Add an initial values for the attribute.
			menuToggle.setAttribute('aria-expanded', 'false');
			$target.setAttribute('aria-expanded', 'false');

			menuToggle.addEventListener('click', () => {
				// Toggle the class on both the "#menu-toggle" and the "#site-navigation"
				menuToggle.classList.toggle('toggled-on');
				$target.classList.toggle('toggled-on');

				// Change area-expanded attribute value
				let ariaExpanded = $target.classList.contains('toggled-on') ? 'true' : 'false';
				menuToggle.setAttribute('aria-expanded', ariaExpanded);
				$target.setAttribute('aria-expanded', ariaExpanded);
			});

		});
	}

	/**
	 * Init main navigation
	 */
	initMainNavigation() {
		let dropdownToggle = `<button class="dropdown-toggle" aria-expanded="false"><span class="screen-reader-text">${this.settings.screenReaderText.expand}</span></button>`;
		let parentItems = this.element.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a');

		// Insert toggle button before children items
		parentItems.forEach(el => {
			el.insertAdjacentHTML('afterend', dropdownToggle);
		});

		// Set the active submenu dropdown toggle button initial state.
		this.element.querySelectorAll('.current-menu-ancestor > button').forEach(el => {
			el.classList.add('toggled-on');
			el.setAttribute('aria-expanded', 'true');
			el.querySelector('.screen-reader-text').textContent = this.settings.screenReaderText.collapse;
		});

		// Set the active submenu initial state.
		this.element.querySelectorAll('.current-menu-ancestor > .sub-menu').forEach(el => {
			el.classList.add('toggled-on');
		});

		// Add menu items with submenus to aria-haspopup="true".
		this.element.querySelectorAll('.menu-item-has-children').forEach(el => {
			el.setAttribute('aria-haspopup', 'true');
		});

		this.element.querySelectorAll('.dropdown-toggle').forEach(el => {
			el.addEventListener('click', event => {
				event.preventDefault();

				// Toggle class for this element
				el.classList.toggle('toggled-on');

				// Toggle class for .sub-menu
				el.nextElementSibling.classList.toggle('toggled-on');

				// Change area-expanded attribute value
				el.setAttribute('aria-expanded', el.getAttribute('aria-expanded') === 'false' ? 'true' : 'false');

				// Change screen reader text
				let screenReaderSpan = el.querySelector('.screen-reader-text');
				screenReaderSpan.textContent = (screenReaderSpan.textContent === this.settings.screenReaderText.expand) ?
					this.settings.screenReaderText.collapse : this.settings.screenReaderText.expand;
			});
		});
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	static toggleFocus(event: Event) {
		let self = event.target as HTMLElement;
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
	toggleFocusClassTouchScreen() {
		let parentLinks = this.element.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a');

		if ('ontouchstart' in window) {
			parentLinks.forEach(function (anchor) {
				anchor.addEventListener('touchstart', function (e) {
					let menuItem = this.parentNode, i;

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
	}
}

export default ShaplaNavigation
