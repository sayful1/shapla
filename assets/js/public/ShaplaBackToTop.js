class ShaplaBackToTop {

    constructor(selector, config) {
        let element;
        let distance = 500;
        let button = document.querySelector(selector);

        if (!config.isEnabled) return;

        if (!button) return;

        window.addEventListener("scroll", function () {
            ShaplaBackToTop.toggleButton(distance, button);
        });

        button.addEventListener("click", function () {
            if (document.body.scrollTop) {
                // For Safari
                element = document.body;
            } else if (document.documentElement.scrollTop) {
                // For Chrome, Firefox, IE and Opera
                element = document.documentElement;
            }

            ShaplaBackToTop.scrollToTop(element, 300);
        });
    }

    static scrollToTop(element, duration) {
        if (duration <= 0) return;
        let difference = 0 - element.scrollTop;
        let perTick = difference / duration * 10;

        setTimeout(function () {
            element.scrollTop = element.scrollTop + perTick;
            if (element.scrollTop === 0) return;
            ShaplaBackToTop.scrollToTop(element, duration - 10);
        }, 10);
    }

    static toggleButton(distance, button) {
        if (document.body.scrollTop > distance || document.documentElement.scrollTop > distance) {
            button.classList.add('is-active');
        } else {
            button.classList.remove('is-active');
        }
    }
}

export {ShaplaBackToTop}