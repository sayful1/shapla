<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="feature-section three-col">

    <div class="col">
        <h3><?php esc_html_e( 'Go to the Customizer', 'shapla' ); ?></h3>
        <p><?php esc_html_e( 'Using the WordPress Customizer you can easily customize every aspect of the theme.', 'shapla' ); ?></p>
        <p>
            <a target="_blank" href="<?php echo admin_url( 'customize.php' ); ?>"
               class="button button-primary"><?php esc_html_e( 'Go to the Customizer', 'shapla' ); ?></a>
        </p>
    </div><!-- .col -->

    <div class="col">
        <h3><?php esc_html_e( 'Get support', 'shapla' ); ?></h3>
        <p>
			<?php esc_html_e( 'If you need support, you can try posting on the theme support forum.', 'shapla' ); ?>
        </p>
        <p>
            <a target="_blank" href="https://wordpress.org/support/theme/shapla"
               class="button button-primary"><?php esc_html_e( 'Visit support forum', 'shapla' ); ?></a>
        </p>
    </div><!-- .col -->

    <div class="col">
        <h3><?php esc_html_e( 'Contribute to Shapla', 'shapla' ); ?></h3>
        <p><?php esc_html_e( 'Would you like to translate Shapla into your language? You can get involved on WordPress.org', 'shapla' ); ?></p>
        <p><a target="_blank" href="https://translate.wordpress.org/projects/wp-themes/shapla"
              class="button button-primary"><?php esc_html_e( 'Translate Shapla', 'shapla' ); ?></a>
        </p>
    </div><!-- .col -->

</div>

<hr>
<h2><?php esc_html_e( 'Shapla Features', 'shapla' ); ?></h2>
<div class="feature-section three-col">

    <div class="col">
        <h3><?php esc_html_e( 'Zero Shortcodes', 'shapla' ); ?></h3>
        <p>
			<?php esc_html_e( 'With Shapla, you only get what you need. That means no superfluous shortcodes and other extraneous
                nonsense', 'shapla' ); ?>
        </p>
    </div><!-- .col -->

    <div class="col">
        <h3><?php esc_html_e( 'Zero Sliders', 'shapla' ); ?></h3>
        <p>
			<?php
			printf(
				esc_html__( 'Shapla lets you choose the appropriate plugin for your slider needs. You may choose free slider like %2$sNivo Image Slider%1$s, %3$sImage Slider%1$s, %4$sCarousel Slider%1$s or even premium slider like %5$sSlider Revolution%1$s, %6$sMaster Slider%1$s, %7$sLayerSlider%1$s and more.', 'shapla' ),
				'</a>',
				'<a class="thickbox" href="' . $this->plugin_thickbox_url( 'nivo-image-slider' ) . '">',
				'<a class="thickbox" href="' . $this->plugin_thickbox_url( 'image-slider-responsive' ) . '">',
				'<a class="thickbox" href="' . $this->plugin_thickbox_url( 'carousel-slider' ) . '">',
				'<a target="_blank" href="https://codecanyon.net/item/slider-revolution-responsive-wordpress-plugin/2751380">',
				'<a target="_blank" href="https://codecanyon.net/item/master-slider-wordpress-responsive-touch-slider/7467925">',
				'<a target="_blank" href="https://codecanyon.net/item/layerslider-responsive-wordpress-slider-plugin/1362246">'
			);
			?>
        </p>
    </div><!-- .col -->

    <div class="col">
        <h3><?php esc_html_e( 'Zero Page Builders', 'shapla' ); ?></h3>
        <p>
			<?php
			printf(
				esc_html__( 'Page builders are great, if you need one. If you don\'t, they\'re bloat. Shapla is compatible with all most popular free page builder like %2$sPage Builder by SiteOrigin%1$s, %3$sElementor%1$s, %4$sBeaver Builder%1$s, or even premium page builder like %5$sDivi%1$s &amp; %6$sVisual Composer%1$s', 'shapla' ),
				'</a>',
				'<a class="thickbox" href=" ' . $this->plugin_thickbox_url( 'siteorigin-panels' ) . '">',
				'<a class="thickbox" href="' . $this->plugin_thickbox_url( 'elementor' ) . '">',
				'<a class="thickbox" href="' . $this->plugin_thickbox_url( 'beaver-builder-lite-version' ) . '">',
				'<a target="_blank" href="https://www.elegantthemes.com/plugins/divi-builder/">',
				'<a target="_blank" href="https://vc.wpbakery.com/">'
			);
			?>
        </p>
    </div><!-- .col -->

</div>

<div class="feature-section three-col">

    <div class="col">
        <h3><?php esc_html_e( 'Responsive', 'shapla' ); ?></h3>
        <p><?php esc_html_e( 'Whether you view a Shapla portfolio, blog or store on a laptop / desktop computer or handheld device, it
                will adapt and display beautifully.', 'shapla' ); ?></p>
    </div><!-- .col -->

    <div class="col">
        <h3><?php esc_html_e( 'Portfolio', 'shapla' ); ?></h3>
        <p>
			<?php
			printf( esc_html__( 'Shapla has tight integration with full features of %sFilterable Portfolio%s plugin.', 'shapla' ),
				'<a class="thickbox" href="' . $this->plugin_thickbox_url( 'filterable-portfolio' ) . '">',
				'</a>'
			);
			?>
        </p>
    </div><!-- .col -->

    <div class="col">
        <h3><?php esc_html_e( 'WooCommerce', 'shapla' ); ?></h3>
        <p>
			<?php
			printf( esc_html__( 'Shapla supports all features of %sWooCommerce%s.', 'shapla' ),
				'<a class="thickbox" href="' . $this->plugin_thickbox_url( 'woocommerce' ) . '">',
				'</a>'
			);
			?>
        </p>
    </div><!-- .col -->

</div>

<div class="feature-section three-col">

    <div class="col">
        <h3><?php esc_html_e( 'Schema Markup', 'shapla' ); ?></h3>
        <p><?php esc_html_e( 'Valid schema markup for improved SEO performance.', 'shapla' ); ?></p>
    </div><!-- .col -->

    <div class="col">
        <h3><?php esc_html_e( 'Based on Underscores', 'shapla' ); ?></h3>
        <p>
			<?php
			printf( esc_html__( '%sUnderscores%s is Automattic\'s popular starter theme, used as a starting point for all WordPress themes on WordPress.com. Secure & stable.', 'shapla' ),
				'<a target="_blank" href="http://underscores.me/">',
				'</a>'
			);
			?>
        </p>
    </div><!-- .col -->

    <div class="col">
        <h3><?php esc_html_e( 'Localized', 'shapla' ); ?></h3>
        <p>
			<?php
			printf( esc_html__( 'Shapla is fully localized and ready for your translations. Download a translation file for your language, or contribute to translating Shapla on %sWordPress.org%s.', 'shapla' ),
				'<a target="_blank" href="https://translate.wordpress.org/projects/wp-themes/shapla">',
				'</a>'
			);
			?>
        </p>
    </div><!-- .col -->

</div>