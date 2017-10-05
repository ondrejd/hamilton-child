<?php
/**
 * @author Ondřej Doněk <ondrejd@gmail.com>
 * @link https://github.com/ondrejd/https://github.com/ondrejd/hamilton-child for the canonical source repository
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @package hamilton-child
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>
<form class="woocommerce-ordering" method="get">
	<select name="orderby" class="orderby">
		<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
	</select>
	<div id="hamilton-child-ordering">
		<span class="dashicons dashicons-sort hamilton-child-ordering-button" title="<?php _e( 'Open product orderby menu', 'hamilton-child' ) ?>"></span>
	</div>
	<?php wc_query_string_form_fields( null, array( 'orderby', 'submit' ) ); ?>
</form>
<nav class="hamilton-child-wc-ordering" style="background-color: #750743;">
	<div class="section-inner menus group">
		<span class="dashicons dashicons-no hamilton-child-ordering-button" title="<?php _e( 'Close product orderby menu', 'hamilton-child' ) ?>"></span>
		<ul class="menu hamilton-child-wc-ordering-items">
			<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<li class="hamilton-child-wc-ordering-item" <?php selected( $orderby, $id ); ?>>
				<a href="#" data-orderby="<?php echo esc_attr( $id ) ?>"><?php echo esc_html( $name ) ?></a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</nav>
