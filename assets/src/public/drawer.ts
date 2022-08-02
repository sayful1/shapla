const toggleSidenav = (drawerElement: HTMLElement) => {
	if (drawerElement.classList.contains('is-active')) {
		drawerElement.classList.remove('is-active');
		drawerElement.setAttribute('aria-hidden', 'true');
	} else {
		drawerElement.classList.add('is-active');
		drawerElement.removeAttribute('aria-hidden');
	}
}
const openSidenav = () => {
	const toggles = document.querySelectorAll('[data-toggle="drawer"]');
	if (!toggles.length) {
		return;
	}
	toggles.forEach((toggle: HTMLElement) => {
		toggle.addEventListener('click', () => {
			const drawerEl = document.querySelector(toggle.getAttribute('data-target')) as HTMLElement;
			if (drawerEl) {
				toggleSidenav(drawerEl);
			}
		})
	})
}
const closeSidenav = () => {
	document.querySelectorAll('.shapla-drawer').forEach((drawer: HTMLElement) => {
		const drawerBackground = drawer.querySelector('.shapla-drawer__background');

		// Close on background click
		drawerBackground.addEventListener('click', () => toggleSidenav(drawer))

		// Close on dismiss button click
		drawer.querySelectorAll('[data-dismiss="drawer"]').forEach((closeEL: HTMLElement) => {
			closeEL.addEventListener('click', () => toggleSidenav(drawer))
		})
	})

	// Close modal on escape key press.
	document.addEventListener('keyup', (event) => {
		if (event.keyCode === 27) {
			event.preventDefault();
			document.querySelectorAll('.shapla-drawer.is-active').forEach((element: HTMLElement) => {
				toggleSidenav(element);
			});
		}
	});
}

const drawer = () => {
	openSidenav();
	closeSidenav();
}

export default drawer;
