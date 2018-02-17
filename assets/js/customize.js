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

wp.customize.controlConstructor['shapla-typography'] = wp.customize.Control.extend({

    ready: function () {

        'use strict';

        var control = this,
            value = control.setting._value,
            picker;

        control.renderFontSelector();
        control.renderBackupFontSelector();
        control.renderVariantSelector();
        // control.renderSubsetSelector();

        // Font-size.
        if (control.params['default']['font-size']) {
            this.container.on('change keyup paste', '.font-size input', function () {
                control.saveValue('font-size', jQuery(this).val());
            });
        }

        // Line-height.
        if (control.params['default']['line-height']) {
            this.container.on('change keyup paste', '.line-height input', function () {
                control.saveValue('line-height', jQuery(this).val());
            });
        }

        // Margin-top.
        if (control.params['default']['margin-top']) {
            this.container.on('change keyup paste', '.margin-top input', function () {
                control.saveValue('margin-top', jQuery(this).val());
            });
        }

        // Margin-bottom.
        if (control.params['default']['margin-bottom']) {
            this.container.on('change keyup paste', '.margin-bottom input', function () {
                control.saveValue('margin-bottom', jQuery(this).val());
            });
        }

        // Letter-spacing.
        if (control.params['default']['letter-spacing']) {
            value['letter-spacing'] = (jQuery.isNumeric(value['letter-spacing'])) ? value['letter-spacing'] + 'px' : value['letter-spacing'];
            this.container.on('change keyup paste', '.letter-spacing input', function () {
                value['letter-spacing'] = (jQuery.isNumeric(jQuery(this).val())) ? jQuery(this).val() + 'px' : jQuery(this).val();
                control.saveValue('letter-spacing', value['letter-spacing']);
            });
        }

        // Word-spacing.
        if (control.params['default']['word-spacing']) {
            this.container.on('change keyup paste', '.word-spacing input', function () {
                control.saveValue('word-spacing', jQuery(this).val());
            });
        }

        // Text-align.
        if (control.params['default']['text-align']) {
            this.container.on('change', '.text-align input', function () {
                control.saveValue('text-align', jQuery(this).val());
            });
        }

        // Text-transform.
        if (control.params['default']['text-transform']) {
            jQuery(control.selector + ' .text-transform select').select2().on('change', function () {
                control.saveValue('text-transform', jQuery(this).val());
            });
        }

        // Color.
        if (control.params['default'].color) {
            picker = this.container.find('.shapla-color-control');
            picker.wpColorPicker({
                change: function () {
                    setTimeout(function () {
                        control.saveValue('color', picker.val());
                    }, 100);
                }
            });
        }
    },

    /**
     * Adds the font-families to the font-family dropdown
     * and instantiates select2.
     */
    renderFontSelector: function () {

        var control = this,
            selector = control.selector + ' .font-family select',
            data = [],
            standardFonts = [],
            googleFonts = [],
            value = control.setting._value,
            fonts = control.getFonts(),
            fontSelect;

        // Format standard fonts as an array.
        if (!_.isUndefined(fonts.standard)) {
            _.each(fonts.standard, function (font) {
                standardFonts.push({
                    id: font.family.replace(/&quot;/g, '&#39'),
                    text: font.label
                });
            });
        }

        // Format google fonts as an array.
        if (!_.isUndefined(fonts.standard)) {
            _.each(fonts.google, function (font) {
                googleFonts.push({
                    id: font.family,
                    text: font.label
                });
            });
        }

        // Combine forces and build the final data.
        data = [
            {text: 'Standard Fonts', children: standardFonts},
            {text: 'Google Fonts', children: googleFonts}
        ];

        // Instantiate select2 with the data.
        fontSelect = jQuery(selector).selectWoo({
            data: data
        });

        // Set the initial value.
        if (value['font-family']) {
            fontSelect.val(value['font-family'].replace(/'/g, '"')).trigger('change');
        }

        // When the value changes
        fontSelect.on('change', function () {

            // Set the value.
            control.saveValue('font-family', jQuery(this).val());

            // Re-init the font-backup selector.
            control.renderBackupFontSelector();

            // Re-init variants selector.
            control.renderVariantSelector();

            // Re-init subsets selector.
            // control.renderSubsetSelector();
        });
    },

    /**
     * Adds the font-families to the font-family dropdown
     * and instantiates select2.
     */
    renderBackupFontSelector: function () {

        var control = this,
            selector = control.selector + ' .font-backup select',
            standardFonts = [],
            value = control.setting._value,
            fontFamily = value['font-family'],
            // variants = control.getVariants(fontFamily),
            fonts = control.getFonts(),
            fontSelect;

        if (_.isUndefined(value['font-backup']) || null === value['font-backup']) {
            value['font-backup'] = '';
        }

        // Hide if we're not on a google-font.
        // if (false !== variants) {
        //     jQuery(control.selector + ' .font-backup').show();
        // } else {
        // }
            jQuery(control.selector + ' .font-backup').hide();

        // Format standard fonts as an array.
        if (!_.isUndefined(fonts.standard)) {
            _.each(fonts.standard, function (font) {
                standardFonts.push({
                    id: font.family.replace(/&quot;/g, '&#39'),
                    text: font.label
                });
            });
        }

        // Instantiate select2 with the data.
        fontSelect = jQuery(selector).selectWoo({
            data: standardFonts
        });

        // Set the initial value.
        if ( 'undefined' !== typeof value['font-backup'] ) {
            fontSelect.val( value['font-backup'].replace( /'/g, '"' ) ).trigger( 'change' );
        }

        // When the value changes
        fontSelect.on('change', function () {

            // Set the value.
            control.saveValue('font-backup', jQuery(this).val());
        });
    },

    /**
     * Renders the variants selector using select2
     * Displays font-variants for the currently selected font-family.
     */
    renderVariantSelector: function () {

        var control = this,
            value = control.setting._value,
            fontFamily = value['font-family'],
            selector = control.selector + ' .variant select',
            data = [],
            isValid = false,
            variants = control.getVariants(fontFamily),
            fontWeight,
            variantSelector,
            fontStyle;

        if (false !== variants) {
            jQuery(control.selector + ' .variant').show();
            _.each(variants, function (variant) {
                if (value.variant === variant.id) {
                    isValid = true;
                }
                data.push({
                    id: variant.id,
                    text: variant.label
                });
            });
            if (!isValid) {
                value.variant = 'regular';
            }

            if (jQuery(selector).hasClass('select2-hidden-accessible')) {
                jQuery(selector).select2('destroy');
                jQuery(selector).empty();
            }

            // Instantiate select2 with the data.
            variantSelector = jQuery(selector).select2({
                data: data
            });
            variantSelector.val(value.variant).trigger('change');
            variantSelector.on('change', function () {
                control.saveValue('variant', jQuery(this).val());

                fontWeight = (!_.isString(value.variant)) ? '400' : value.variant.match(/\d/g);
                fontWeight = (!_.isObject(fontWeight)) ? '400' : fontWeight.join('');
                fontStyle = (-1 !== value.variant.indexOf('italic')) ? 'italic' : 'normal';

                control.saveValue('font-weight', fontWeight);
                control.saveValue('font-style', fontStyle);
            });
        } else {
            jQuery(control.selector + ' .variant').hide();
        }
    },

    /**
     * Renders the subsets selector using select2
     * Displays font-subsets for the currently selected font-family.
     */
    renderSubsetSelector: function () {

        var control = this,
            value = control.getValue(),
            fontFamily = value['font-family'],
            subsets = control.getSubsets(fontFamily),
            selector = control.selector + ' .subsets select',
            data = [],
            validValue = value.subsets,
            subsetSelector;

        if (false !== subsets) {
            jQuery(control.selector + ' .subsets').show();
            _.each(subsets, function (subset) {

                if (_.isObject(validValue)) {
                    if (-1 === validValue.indexOf(subset.id)) {
                        validValue = _.reject(validValue, function (subValue) {
                            return subValue === subset.id;
                        });
                    }
                }

                data.push({
                    id: subset.id,
                    text: subset.label
                });
            });

        } else {
            jQuery(control.selector + ' .subsets').hide();
        }

        if (jQuery(selector).hasClass('select2-hidden-accessible')) {
            jQuery(selector).select2('destroy');
            jQuery(selector).empty();
        }

        // Instantiate select2 with the data.
        subsetSelector = jQuery(selector).select2({
            data: data
        });
        subsetSelector.val(validValue).trigger('change');
        subsetSelector.on('change', function () {
            control.saveValue('subsets', jQuery(this).val());
        });
    },

    /**
     * Get fonts.
     */
    getFonts: function () {
        var control = this;

        if (!_.isUndefined(window['shaplaFonts' + control.id])) {
            return window['shaplaFonts' + control.id];
        }
        if (!_.isUndefined(shaplaAllFonts)) {
            return shaplaAllFonts;
        }
        return {
            google: [],
            standard: []
        };
    },

    /**
     * Get variants for a font-family.
     */
    getVariants: function (fontFamily) {
        var control = this,
            fonts = control.getFonts();

        var variants = false;
        _.each(fonts.standard, function (font) {
            if (fontFamily && font.family === fontFamily.replace(/'/g, '"')) {
                variants = font.variants;
                return font.variants;
            }
        });

        _.each(fonts.google, function (font) {
            if (font.family === fontFamily) {
                variants = font.variants;
                return font.variants;
            }
        });
        return variants;
    },

    /**
     * Get subsets for a font-family.
     */
    getSubsets: function (fontFamily) {

        var control = this,
            subsets = false,
            fonts = control.getFonts();

        _.each(fonts.google, function (font) {
            if (font.family === fontFamily) {
                subsets = font.subsets;
            }
        });
        return subsets;
    },

    /**
     * Gets the value.
     */
    getValue: function () {

        'use strict';

        var control = this,
            input = control.container.find('.typography-hidden-value'),
            valueJSON = jQuery(input).val();

        return JSON.parse(valueJSON);
    },

    /**
     * Saves the value.
     */
    saveValue: function (property, value) {

        var control = this,
            input   = control.container.find( '.typography-hidden-value' ),
            val     = control.setting._value;

        val[ property ] = value;

        jQuery( input ).attr( 'value', JSON.stringify( val ) ).trigger( 'change' );
        control.setting.set( val );
    }
});
