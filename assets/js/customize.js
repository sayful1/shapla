wp.customize.controlConstructor['shapla-background'] = wp.customize.Control.extend({

    // When we're finished loading continue processing
    ready: function () {

        'use strict';

        var control = this;

        // Init the control.
        control.initKirkiControl();
    },

    initKirkiControl: function () {

        var control = this,
            value = control.setting._value,
            picker = control.container.find('.shapla-color-control');

        // Hide unnecessary controls if the value doesn't have an image.
        if (_.isUndefined(value['background-image']) || '' === value['background-image']) {
            control.container.find('.background-wrapper > .background-repeat').hide();
            control.container.find('.background-wrapper > .background-position').hide();
            control.container.find('.background-wrapper > .background-size').hide();
            control.container.find('.background-wrapper > .background-attachment').hide();
        }

        // Color.
        picker.wpColorPicker({
            change: function () {
                setTimeout(function () {
                    control.saveValue('background-color', picker.val());
                }, 100);
            }
        });

        // Background-Repeat.
        control.container.on('change', '.background-repeat select', function () {
            control.saveValue('background-repeat', jQuery(this).val());
        });

        // Background-Size.
        control.container.on('change click', '.background-size input', function () {
            control.saveValue('background-size', jQuery(this).val());
        });

        // Background-Position.
        control.container.on('change', '.background-position select', function () {
            control.saveValue('background-position', jQuery(this).val());
        });

        // Background-Attachment.
        control.container.on('change click', '.background-attachment input', function () {
            control.saveValue('background-attachment', jQuery(this).val());
        });

        // Background-Image.
        control.container.on('click', '.background-image-upload-button', function (e) {
            var image = wp.media({multiple: false}).open().on('select', function () {

                // This will return the selected image from the Media Uploader, the result is an object.
                var uploadedImage = image.state().get('selection').first(),
                    previewImage = uploadedImage.toJSON().sizes.full.url,
                    imageUrl,
                    imageID,
                    imageWidth,
                    imageHeight,
                    preview,
                    removeButton;

                if (!_.isUndefined(uploadedImage.toJSON().sizes.medium)) {
                    previewImage = uploadedImage.toJSON().sizes.medium.url;
                } else if (!_.isUndefined(uploadedImage.toJSON().sizes.thumbnail)) {
                    previewImage = uploadedImage.toJSON().sizes.thumbnail.url;
                }

                imageUrl = uploadedImage.toJSON().sizes.full.url;
                imageID = uploadedImage.toJSON().id;
                imageWidth = uploadedImage.toJSON().width;
                imageHeight = uploadedImage.toJSON().height;

                // Show extra controls if the value has an image.
                if ('' !== imageUrl) {
                    control.container.find('.background-wrapper > .background-repeat, .background-wrapper > .background-position, .background-wrapper > .background-size, .background-wrapper > .background-attachment').show();
                }

                control.saveValue('background-image', imageUrl);
                preview = control.container.find('.placeholder, .thumbnail');
                removeButton = control.container.find('.background-image-upload-remove-button');

                if (preview.length) {
                    preview.removeClass().addClass('thumbnail thumbnail-image').html('<img src="' + previewImage + '" alt="" />');
                }
                if (removeButton.length) {
                    removeButton.show();
                }
            });

            e.preventDefault();
        });

        control.container.on('click', '.background-image-upload-remove-button', function (e) {

            var preview,
                removeButton;

            e.preventDefault();

            control.saveValue('background-image', '');

            preview = control.container.find('.placeholder, .thumbnail');
            removeButton = control.container.find('.background-image-upload-remove-button');

            // Hide unnecessary controls.
            control.container.find('.background-wrapper > .background-repeat').hide();
            control.container.find('.background-wrapper > .background-position').hide();
            control.container.find('.background-wrapper > .background-size').hide();
            control.container.find('.background-wrapper > .background-attachment').hide();

            if (preview.length) {
                preview.removeClass().addClass('placeholder').html('No file selected');
            }
            if (removeButton.length) {
                removeButton.hide();
            }
        });
    },

    /**
     * Saves the value.
     */
    saveValue: function (property, value) {

        var control = this,
            input = jQuery('#customize-control-' + control.id.replace('[', '-').replace(']', '') + ' .background-hidden-value'),
            val = control.setting._value;

        val[property] = value;

        jQuery(input).attr('value', JSON.stringify(val)).trigger('change');
        control.setting.set(val);
    }
});
wp.customize.controlConstructor['shapla-color'] = wp.customize.Control.extend({

    // When we're finished loading continue processing
    ready: function () {
        'use strict';

        var control = this,
            picker = this.container.find('.shapla-color-control');

        // If we have defined any extra choices, make sure they are passed-on to Iris.
        if (undefined !== control.params.choices) {
            picker.wpColorPicker(control.params.choices);
        }

        // Saves our settings to the WP API
        picker.wpColorPicker({
            change: function (event, ui) {

                // Small hack: the picker needs a small delay
                setTimeout(function () {
                    control.setting.set(picker.val());
                }, 100);
            }
        });
    }
});

wp.customize.controlConstructor['shapla-radio-buttonset'] = wp.customize.Control.extend({

    ready: function () {

        'use strict';

        var control = this;

        // Change the value
        this.container.on('click', 'input', function () {
            control.setting.set(jQuery(this).val());
        });
    }

});

wp.customize.controlConstructor['shapla-radio-image'] = wp.customize.Control.extend({

    ready: function () {
        'use strict';

        var control = this;

        // Change the value
        this.container.on('click', 'input', function () {
            control.setting.set(jQuery(this).val());
        });
    }
});

wp.customize.controlConstructor['shapla-slider'] = wp.customize.Control.extend({

	ready: function() {

		'use strict';

		var control = this,
		    value,
		    thisInput,
		    inputDefault,
		    changeAction;

		// Update the text value
		jQuery( 'input[type=range]' ).on( 'mousedown', function() {
			value = jQuery( this ).attr( 'value' );
			jQuery( this ).mousemove( function() {
				value = jQuery( this ).attr( 'value' );
				jQuery( this ).closest( 'label' ).find( '.shapla_range_value .value' ).text( value );
			});
		});

		// Handle the reset button
		jQuery( '.shapla-slider-reset' ).click( function() {
			thisInput    = jQuery( this ).closest( 'label' ).find( 'input' );
			inputDefault = thisInput.data( 'reset_value' );
			thisInput.val( inputDefault );
			thisInput.change();
			jQuery( this ).closest( 'label' ).find( '.shapla_range_value .value' ).text( inputDefault );
		});

		if ( 'postMessage' === control.setting.transport ) {
			changeAction = 'mousemove change';
		} else {
			changeAction = 'change';
		}

		// Save changes.
		this.container.on( changeAction, 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}

});

wp.customize.controlConstructor['shapla-toggle'] = wp.customize.Control.extend({

    ready: function () {

        'use strict';

        var control = this,
            checkboxValue = control.setting._value;

        // Save the value
        this.container.on('change', 'input', function () {
            checkboxValue = !!(jQuery(this).is(':checked'));
            control.setting.set(checkboxValue);
        });
    }
});
