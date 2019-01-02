import {ShaplaSkipLinkFocusFix} from "./ShaplaSkipLinkFocusFix";
import {ShaplaNavigation} from "./ShaplaNavigation";
import {ShaplaBackToTop} from "./ShaplaBackToTop";
import {ShaplaStickyHeader} from "./ShaplaStickyHeader";
import {ShaplaSearch} from "./ShaplaSearch";

const config = window.Shapla || {};

new ShaplaSkipLinkFocusFix();
new ShaplaNavigation(config);
new ShaplaBackToTop('#shapla-back-to-top', config.BackToTopButton);
new ShaplaStickyHeader("#masthead", config.stickyHeader);
new ShaplaSearch();
