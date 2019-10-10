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
		this.stickPoint = this.masthead.offsetTop;
		this.stuck = false;

		this.updateClass();

		window.addEventListener('resize', () => {
			this.updateClass();
		});

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
		if (!this.stuck && (distance <= -50)) {
			this.masthead.classList.add('is-sticky');
			this.stuck = true;
		} else if (this.stuck && (offset <= this.stickPoint)) {
			this.masthead.classList.remove('is-sticky');
			this.stuck = false;
		}
	}

	/**
	 * Update fixed class
	 */
	updateClass() {
		let body = document.querySelector('body');
		if (window.innerWidth < this.settings.minWidth) {
			this.masthead.classList.remove('is-fixed-top');
			body.style.paddingTop = '';
		} else {
			this.masthead.classList.add('is-fixed-top');
			body.style.paddingTop = this.masthead.offsetHeight + 'px';
		}
	}
}

export {ShaplaStickyHeader}
