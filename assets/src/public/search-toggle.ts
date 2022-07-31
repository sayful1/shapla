const performToggle = (toggle: HTMLElement) => {
	const target = document.querySelector(toggle.dataset.toggleTarget);

	if (target.classList.contains('show-modal')) {
		// Hide the modal.
		target.classList.remove('active');

		setTimeout(() => {
			target.classList.remove('show-modal');
			toggle.focus();
		}, 250);
	} else {
		// Show the modal.
		target.classList.add('show-modal');

		setTimeout(() => {
			target.classList.add('active');

			if (toggle.dataset.setFocus) {
				const focusElement = document.querySelector(toggle.dataset.setFocus) as HTMLInputElement;

				if (focusElement) {
					const searchTerm = focusElement.value as string;
					focusElement.value = '';
					focusElement.focus();
					focusElement.value = searchTerm;
				}
			}
		}, 10);
	}
};

/**
 * Lock tabbing to the search form only.
 *
 * @param {KeyboardEvent} e
 */
const lockSearchFocus = (e: KeyboardEvent) => {
	// If the keypress isn't a tab or the search form isn't active, return
	if (e.keyCode !== 9 || !document.querySelector('.site-search.active')) {
		return;
	}

	// Current active element before it moves
	const activeElement = document.activeElement;

	// If we're on the input and shift+tab was pressed, override and focus on button.
	if (document.activeElement.classList.contains('search-form__input') && e.shiftKey) {
		setTimeout(function () {
			// Focus the correct button by only looking for it in the parent element
			(activeElement.parentElement.getElementsByClassName('search-input__button').item(0) as HTMLButtonElement).focus();
		}, 10);
	}

	// If we're on the button and tab was pressed, override and focus on input.
	if (document.activeElement.classList.contains('search-input__button') && !e.shiftKey) {
		setTimeout(function () {
			// Focus the correct input by only looking for it in the parent element
			(activeElement.parentElement.getElementsByClassName('search-form__input').item(0) as HTMLButtonElement).focus();
		}, 10);
	}
}

const searchToggle = () => {
	const searchToggleEl = document.getElementById('header__search-toggle');

	if (!searchToggleEl) {
		return;
	}
	document.querySelectorAll('*[data-toggle-target]').forEach((element: HTMLElement) => {
		element.addEventListener('click', (event) => {
			event.preventDefault();
			performToggle(element);
		});
	});

	// Close modal on escape key press.
	document.addEventListener('keyup', (event) => {
		if (event.keyCode === 27) {
			event.preventDefault();
			document.querySelectorAll('.search-modal.active').forEach((element: HTMLElement) => {
				performToggle(
					document.querySelector('*[data-toggle-target="' + element.dataset.modalTargetString + '"]')
				);
			});
		}
	});

	// Close modal on outside click.
	document.addEventListener('click', (event) => {
		const target = event.target;
		const modal = document.querySelector('.search-modal.active') as HTMLElement;

		if (target === modal) {
			performToggle(
				document.querySelector('*[data-toggle-target="' + modal.dataset.modalTargetString + '"]')
			);
		}
	});

	document.addEventListener('keydown', lockSearchFocus);
}

export default searchToggle;
