<?php

namespace Shapla\Integrations\YITH;

use Shapla\Helpers\SvgIcon;

/**
 * WooCommerceWishlist class
 */
class WooCommerceWishlist {
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
			add_action( 'wp_enqueue_scripts', array( self::$instance, 'enqueue_custom_script' ), 20 );
			add_action( 'wp_ajax_shapla_update_wishlist_count', [ self::$instance, 'update_wishlist_count' ] );
			add_action( 'wp_ajax_nopriv_shapla_update_wishlist_count', [ self::$instance, 'update_wishlist_count' ] );
		}

		return self::$instance;
	}

	/**
	 * Update wishlist count
	 *
	 * @return void
	 */
	public function update_wishlist_count() {
		wp_send_json( [
				'count' => esc_html( yith_wcwl_count_all_products() )
		] );
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
		$wishlist_url = YITH_WCWL()->get_wishlist_url();
		?>
		<a id="header__my-account" class="header__wishlist-toggle button is-icon"
		   title="<?php esc_attr_e( 'View wishlist', 'shapla' ); ?>"
		   href="<?php echo esc_url( $wishlist_url ) ?>"
		>
			<?php echo SvgIcon::get_svg( 'ui', 'favorite', 24 ); ?>
			<span class="wishlist-item-count wishlist_products_counter_number">
				<?php echo esc_html( yith_wcwl_count_all_products() ) ?>
			</span>
		</a>
		<?php
	}

	/**
	 * Add javaScript to update favorite count.
	 *
	 * @return void
	 */
	public function enqueue_custom_script() {
		wp_add_inline_script(
				'jquery-yith-wcwl',
				"
        jQuery( function( $ ) {
          $( document ).on( 'added_to_wishlist removed_from_wishlist', function() {
            $.get( yith_wcwl_l10n.ajax_url, {
              action: 'shapla_update_wishlist_count',
            }, function( data ) {
              $('.wishlist-item-count').html( data.count );
            } );
          } );
        } );
      "
		);
	}
}
