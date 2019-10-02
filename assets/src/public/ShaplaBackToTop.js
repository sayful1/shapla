class ShaplaBackToTop {

	/**
	 * ShaplaBackToTop constructor
	 *
	 * @param selector
	 * @param config
	 */
	constructor(selector, config) {
		this.distance = 500;
		this.button = document.querySelector(selector);

		if (!config.isEnabled || !this.button) return;
		this.init();
	}

	/**
	 * Init class functionality
	 */
	init() {
		let element;

		window.addEventListener("scroll", () => {
			this.toggleButton();
		});

		this.button.addEventListener("click", () => {
			if (document.body.scrollTop) {
				// For Safari
				element = document.body;
			} else if (document.documentElement.scrollTop) {
				// For Chrome, Firefox, IE and Opera
				element = document.documentElement;
			}

			ShaplaBackToTop.scrollToTop(element, 300);
		});
	}

	/**
	 * Scroll to element
	 *
	 * @param element
	 * @param {Number} duration
	 */
	static scrollToTop(element, duration) {
		if (duration <= 0) return;
		let difference = 0 - element.scrollTop;
		let perTick = difference / duration * 10;

		setTimeout(() => {
			element.scrollTop = element.scrollTop + perTick;
			if (element.scrollTop === 0) return;
			ShaplaBackToTop.scrollToTop(element, duration - 10);
		}, 10);
	}

	/**
	 * Toggle button class
	 */
	toggleButton() {
		if (document.body.scrollTop > this.distance || document.documentElement.scrollTop > this.distance) {
			this.button.classList.add('is-active');
		} else {
			this.button.classList.remove('is-active');
		}
	}
}

export {ShaplaBackToTop}
