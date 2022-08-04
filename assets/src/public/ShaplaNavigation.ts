interface NavSettingsInterface {
	screenReaderText: {
		collapse: string;
		expand: string;
	}
}

const performToggle = (toggleElement: HTMLElement, args = {activeClass: 'toggled-on'}) => {
	// Get the target from the "data-target" attribute
	const targetEl = document.querySelector(toggleElement.dataset.target);

	// Add an initial values for the attribute.
	toggleElement.setAttribute('aria-expanded', 'false');
	targetEl.setAttribute('aria-expanded', 'false');

	toggleElement.addEventListener('click', () => {
		// Toggle the class on both the "#menu-toggle" and the "#site-navigation"
		toggleElement.classList.toggle(args.activeClass);
		targetEl.classList.toggle(args.activeClass);

		// Change area-expanded attribute value
		let ariaExpanded = targetEl.classList.contains('toggled-on') ? 'true' : 'false';
		toggleElement.setAttribute('aria-expanded', ariaExpanded);
		targetEl.setAttribute('aria-expanded', ariaExpanded);
	});
}

/**
 * Handle navigation dropdown toggle
 *
 * @param {HTMLElement} navElement
 * @param {object} args
 */
const handleDropdownToggle = (navElement: HTMLElement, args: NavSettingsInterface) => {
	const dropdownToggles = navElement.querySelectorAll('.dropdown-toggle');
	if (!dropdownToggles.length) {
		return;
	}
	dropdownToggles.forEach((buttonElement: HTMLButtonElement) => {
		buttonElement.addEventListener('click', event => {
			event.preventDefault();

			// Toggle class for this element
			buttonElement.classList.toggle('toggled-on');

			// Toggle class for .sub-menu
			buttonElement.nextElementSibling.classList.toggle('toggled-on');

			// Change area-expanded attribute value
			buttonElement.setAttribute(
				'aria-expanded',
				buttonElement.getAttribute('aria-expanded') === 'false' ? 'true' : 'false'
			);

			// Change screen reader text
			let screenReaderSpan = buttonElement.querySelector('.screen-reader-text');
			screenReaderSpan.textContent = (screenReaderSpan.textContent === args.screenReaderText.expand) ?
				args.screenReaderText.collapse : args.screenReaderText.expand;
		});
	});
}
const updateNavForMobile = (navElement: HTMLElement, args: NavSettingsInterface) => {
	let dropdownToggle = `<button class="dropdown-toggle" aria-expanded="false">
		<span class="screen-reader-text">${args.screenReaderText.expand}</span>
	</button>`;
	let parentItems = navElement.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a');

	// Insert toggle button before children items
	parentItems.forEach((el: HTMLAnchorElement) => {
		el.insertAdjacentHTML('afterend', dropdownToggle);
	});

	// Set the active submenu dropdown toggle button initial state.
	navElement.querySelectorAll('.current-menu-ancestor > button').forEach(el => {
		el.classList.add('toggled-on');
		el.setAttribute('aria-expanded', 'true');
		el.querySelector('.screen-reader-text').textContent = args.screenReaderText.collapse;
	});

	// Set the active submenu initial state.
	navElement.querySelectorAll('.current-menu-ancestor > .sub-menu').forEach(el => {
		el.classList.add('toggled-on');
	});

	// Add menu items with submenus to aria-haspopup="true".
	navElement.querySelectorAll('.menu-item-has-children').forEach(el => {
		el.setAttribute('aria-haspopup', 'true');
	});

	handleDropdownToggle(navElement, args);
}

class ShaplaNavigation {
	private readonly element: HTMLElement;
	private readonly toggleElement: HTMLElement;
	private readonly settings: NavSettingsInterface;

	/**
	 * ShaplaNavigation constructor
	 *
	 * @param {string} navSelector
	 * @param {string} toggleSelector
	 * @param config
	 */
	constructor(navSelector: string, toggleSelector: string, config: NavSettingsInterface) {
		this.element = document.querySelector(navSelector);
		this.toggleElement = document.querySelector(toggleSelector);
		this.settings = config;

		if (!this.element) {
			return;
		}

		// Each time a menu link is focused or blurred, toggle focus.
		this.element.querySelectorAll('a').forEach(anchor => {
			anchor.addEventListener('focus', ShaplaNavigation.toggleFocus, true);
			anchor.addEventListener('blur', ShaplaNavigation.toggleFocus, true);
		});

		if (this.toggleElement) {
			performToggle(this.toggleElement)
		}
		updateNavForMobile(this.element, this.settings);
		this.toggleFocusClassTouchScreen();
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
			parentLinks.forEach(function (anchor: HTMLAnchorElement) {
				anchor.addEventListener('touchstart', function (e) {
					let menuItem = this.parentNode as HTMLLIElement;

					if (!menuItem.classList.contains('focus')) {
						e.preventDefault();
						for (let i = 0; i < menuItem.parentNode.children.length; ++i) {
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
