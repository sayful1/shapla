class ShaplaStickyHeader {
	private settings: Record<string, any>;
	private masthead: HTMLElement;
	private readonly stickPoint: number;
	private stuck: boolean;

	/**
	 * ShaplaStickyHeader constructor
	 *
	 * @param selector
	 * @param settings
	 */
	constructor(selector: string, settings: Record<string, any>) {
		let masthead = document.querySelector(selector) as HTMLElement;

		if (!masthead || !settings.isEnabled) return;

		this.settings = settings;
		this.masthead = masthead;
		this.stickPoint = this.masthead.offsetTop;
		this.stuck = false;

		// Update css class on dom ready
		this.updateClass();
		this.init();

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
		let offset = window.scrollY;
		let distance = this.stickPoint - offset;
		if (!this.stuck && (distance <= -50)) {
			this.masthead.classList.add(this.settings.classes.notTop);
			this.masthead.classList.remove(this.settings.classes.top);
			this.stuck = true;
		} else if (this.stuck && (offset <= this.stickPoint)) {
			this.masthead.classList.remove(this.settings.classes.notTop);
			this.masthead.classList.add(this.settings.classes.top);
			this.stuck = false;
		}
	}

	/**
	 * Update fixed class
	 */
	updateClass() {
		let body = document.querySelector('body');
		if (window.innerWidth < this.settings.minWidth) {
			this.masthead.classList.remove(this.settings.classes.initial);
			body.classList.remove(this.settings.classes.body);
			body.style.setProperty("--body-pt", '');
		} else {
			this.masthead.classList.add(this.settings.classes.initial);
			body.classList.add(this.settings.classes.body);
			body.style.setProperty("--body-pt", this.masthead.offsetHeight + 'px');
		}
	}
}

export default ShaplaStickyHeader
