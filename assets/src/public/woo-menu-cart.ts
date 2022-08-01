const menuObject = document.getElementById('header__cart-toggle');
const siteOverlay = document.querySelector('.site-nav-overlay');
const sideNav = document.querySelector('.site-nav');
const sideNavBody = document.querySelector('.site-nav-body');
const sideNavClose = document.getElementById('site-close-handle');

const wooMenuCart = () => {
	if (null === menuObject || null === siteOverlay || null === sideNavClose) {
		return;
	}

	document.body.classList.add('has-woo-cart-slideout');

	menuObject.addEventListener('click', function (event) {
		toggleSideNavVisibility();
	});

	siteOverlay.addEventListener('click', toggleSideNavVisibility);
	sideNavClose.addEventListener('click', toggleSideNavVisibility);
};

const toggleSideNavVisibility = () => {
	siteOverlay.classList.toggle('is-active');
	sideNavBody.classList.toggle('is-active');
	document.body.classList.toggle('sidebar-move');
};

export default wooMenuCart;
