<#
        var navi            = settings.navigation,
        showDots        = ( 'dots' === navi || 'both' === navi ),
        showArrows      = ( 'arrows' === navi || 'both' === navi ),
        buttonSize      = settings.button_size;
        if ( showArrows ) {
        var arrowsClass = 'slick-arrows-' + settings.arrows_position;
        }

        if ( showDots ) {
        var dotsClass = 'slick-dots-' + settings.dots_position;
        }
        #>

    <div class="hero-carousel-wrapper elementor-flickity-slider" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
        <div class="hero-carousel {{ dotsClass }} {{ arrowsClass }}" data-flickity=""
             data-animation="{{ settings.content_animation }}">
            <# _.each( settings.slides, function( slide ) { #>
                <div class="elementor-repeater-item-{{ slide._id }} hero-carousel__cell">
                    <#
                        var kenClass = '';

                        if ( '' != slide.background_ken_burns ) {
                            kenClass = ' shapla-ken-' + slide.zoom_direction;
                        }
                    #>
                        <div class="hero-carousel__cell__background{{ kenClass }}"></div>
                        <div class="hero-carousel__cell__inner">
                            <# if ( 'yes' === slide.background_overlay ) { #>
                                <div class="hero-carousel__cell__background_overlay"></div>
                            <# } #>
                            <div class="hero-carousel__cell__content">

                                <# if ( slide.heading ) { #>
                                    <div class="hero-carousel__cell__heading">{{{ slide.heading }}}</div>
                                <# }
                                            if ( slide.description ) { #>
                                        <div class="hero-carousel__cell__description">{{{ slide.description
                                            }}}
                                        </div>
                                        <# }
                                                if ( slide.button_text ) { #>
                                            <div class="elementor-button elementor-slide-button elementor-size-{{ buttonSize }}">
                                                {{{ slide.button_text }}}
                                            </div>
                                            <# } #>
                            </div>
                        </div>
                </div>
                <# } ); #>
        </div>
    </div>