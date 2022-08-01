import skipLinkFocusFix from "./skip-link-focus-fix";
import searchToggle from './search-toggle'
import wooMenuCart from './woo-menu-cart'
import ShaplaNavigation from "./ShaplaNavigation";
import ShaplaBackToTop from "./ShaplaBackToTop";
import ShaplaStickyHeader from "./ShaplaStickyHeader";

// @ts-ignore
const config = window.Shapla || {};

skipLinkFocusFix();
searchToggle();
wooMenuCart();
new ShaplaNavigation('#site-navigation', config);
new ShaplaBackToTop('#shapla-back-to-top', config.BackToTopButton);
new ShaplaStickyHeader("#masthead", config.stickyHeader);
