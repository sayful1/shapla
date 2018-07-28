class ShaplaStickyHeader {

    constructor(selector, settings) {
        let masthead = document.querySelector(selector),
            content = masthead.nextElementSibling,
            stickPoint = masthead.offsetTop,
            stuck = false,
            distance,
            offset;

        // Check if sticky header is enabled
        if (!settings.isEnabled) return;

        window.addEventListener("scroll", function () {
            offset = window.pageYOffset;
            if (window.innerWidth < settings.minWidth) {
                return;
            }
            distance = stickPoint - offset;
            if ((distance <= 0) && !stuck) {
                masthead.classList.add('is-sticky');
                content.style.marginTop = masthead.offsetHeight + 'px';
                stuck = true;
            }
            else if (stuck && (offset <= stickPoint)) {
                masthead.classList.remove('is-sticky');
                content.style.marginTop = '';
                stuck = false;
            }
        });
    }
}

export {ShaplaStickyHeader}