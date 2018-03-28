/**
 * Polyfill for Element.closest()
 *
 * For browsers that do not support Element.closest(), but carry support for
 * element.matches() (or a prefixed equivalent, meaning IE9+)
 */
if (!Element.prototype.matches) {
    Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector;
}

if (!Element.prototype.closest) {
    Element.prototype.closest = function (selector) {
        var el = this;
        if (!document.documentElement.contains(el)) return null;
        do {
            if (el.matches(selector)) return el;
            el = el.parentElement || el.parentNode;
        } while (el !== null && el.nodeType === 1);
        return null;
    };
}
