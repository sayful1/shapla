class ShaplaStickyHeader {

	/**
	 * ShaplaStickyHeader constructor
	 *
	 * @param selector
	 * @param settings
	 */
	constructor(selector, settings) {
		let masthead = document.querySelector(selector);

		if (!masthead || !settings.isEnabled) return;

		this.settings = settings;
		this.masthead = masthead;
		this.content = this.masthead.nextElementSibling;
		this.stickPoint = this.masthead.offsetTop;
		this.stuck = false;

		this.masthead.classList.add('is-fixed');
		this.content.style.paddingTop = this.getHeight() + 'px';

		window.addEventListener("scroll", () => {
			this.init();
		});
	}

	/**
	 * Init scroll
	 */
	init() {
		if (window.innerWidth < this.settings.minWidth) {
			return;
		}
		let offset = window.pageYOffset;
		let distance = this.stickPoint - offset;
		if (!this.stuck && (distance <= 0)) {
			this.masthead.classList.add('is-sticky');
			this.stuck = true;
		} else if (this.stuck && (offset <= this.stickPoint)) {
			this.masthead.classList.remove('is-sticky');
			this.stuck = false;
		}
	}

	/**
	 * Calculate content position from top
	 *
	 * @returns {number}
	 */
	getHeight() {
		let topHeight = this.masthead.offsetHeight;

		let compStyles = window.getComputedStyle(this.content),
			paddingTop = compStyles.getPropertyValue('padding-top').replace('px', '');

		if (paddingTop) {
			topHeight += parseInt(paddingTop);
		}

		return topHeight;
	}
}

export {ShaplaStickyHeader}
