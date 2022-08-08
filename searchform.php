<div id="js-site-search" class="site-search" itemscope itemtype="https://schema.org/WebSite">
	<form role="search" id="searchform" class="search-form" method="get"
		  action="<?php echo esc_url( home_url( '/' ) ) ?>">
		<meta itemprop="target" content="<?php echo esc_url( home_url( '/?s={s}' ) ) ?>">
		<label for="search-field" class="screen-reader-text">
			<?php _ex( 'Search for:', 'label', 'shapla' ) ?>
		</label>
		<input itemprop="query-input" type="search" id="search-field" autocomplete="off"
			   class="input input--search search-form__input" value="<?php the_search_query() ?>" name="s"
			   placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'shapla' ) ?>"
		>
		<?php do_action( 'shapla_search_form_before_submit' ); ?>
		<button type="submit" class="search-input__button alt">
			<span class="search-input__label screen-reader-text">
				<?php echo esc_html_x( 'Submit', 'submit button', 'shapla' ) ?>
			</span>
			<?php echo \Shapla\Helpers\SvgIcon::get_svg( 'ui', 'arrow_forward', 24 ) ?>
		</button>
	</form>
</div>
