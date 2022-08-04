import skipLinkFocusFix from "./skip-link-focus-fix";
import drawer from "./drawer";
import ShaplaNavigation from "./ShaplaNavigation";
import ShaplaBackToTop from "./ShaplaBackToTop";
import ShaplaStickyHeader from "./ShaplaStickyHeader";

// @ts-ignore
const config = window.Shapla || {};

skipLinkFocusFix();
drawer();
new ShaplaBackToTop('#shapla-back-to-top', config.BackToTopButton);
new ShaplaStickyHeader("#masthead", config.stickyHeader);

const copyNavToDrawer = () => {
	return new Promise(resolve => {
		const siteNav = document.querySelector('#site-navigation')
		const siteMobileNav = document.querySelector('#site-mobile-navigation')
		siteMobileNav.innerHTML = siteNav.innerHTML;
		resolve(true);
	})
}
copyNavToDrawer().then(() => {
	new ShaplaNavigation('#site-navigation', '#site-navigation-toggle', config);
	new ShaplaNavigation('#site-mobile-navigation', '#site-mobile-navigation-toggle', config);
})
