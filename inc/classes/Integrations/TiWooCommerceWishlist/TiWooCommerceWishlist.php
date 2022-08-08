<?php

namespace Shapla\Integrations\TiWooCommerceWishlist;

use Shapla\Helpers\SvgIcon;

/**
 * TiWooCommerceWishlist
 */
class TiWooCommerceWishlist {
	/**
	 * The instance of the class
	 *
	 * @var self
	 */
	private static $instance;

	/**
	 * Only one instance of the class can be loaded
	 *
	 * @return self
	 */
	public static function init() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();

			add_action( 'shapla_header_extras', array( self::$instance, 'wishlist_icon' ), 10 );
		}

		return self::$instance;
	}

	/**
	 * Show wishlist icon
	 *
	 * @return void
	 */
	public function wishlist_icon() {
		if ( ! current_user_can( 'read' ) ) {
			return;
		}
		?>
		<a id="header__my-account" class="header__wishlist-toggle button is-icon is-hidden-mobile"
		   title="<?php esc_attr_e( 'View wishlist', 'shapla' ); ?>"
		   href="<?php echo tinv_url_wishlist_default(); ?>"
		>
			<?php echo SvgIcon::get_svg( 'ui', 'favorite', 24 ); ?>
			<span class="wishlist-item-count wishlist_products_counter_number"></span>
		</a>
		<?php
	}
}
