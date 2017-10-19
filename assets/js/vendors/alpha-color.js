(function () {

    $(document).find('.shapla-color-picker').each(function () {
        var control = $(this);

        console.log(control);
    });

    return;

    var control = $('.customize-control-alpha-color'),
        picker = control.container.find('.shapla-color-picker'),
        clear;

    // If we have defined any extra choices, make sure they are passed-on to Iris.
    if (!_.isUndefined(control.params.choices)) {
        picker.wpColorPicker(control.params.choices);
    }

    // Tweaks to make the "clear" buttons work.
    setTimeout(function () {
        clear = control.container.find('.wp-picker-clear');
        clear.click(function () {
            control.setting.set('');
        });
    }, 200);

    // Saves our settings to the WP API
    picker.wpColorPicker({
        change: function () {

            // Small hack: the picker needs a small delay
            setTimeout(function () {
                control.setting.set(picker.val());
            }, 20);
        }
    });
})(jQuery);
