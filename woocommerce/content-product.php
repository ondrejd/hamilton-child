<?php
/**
 * @author Ondřej Doněk <ondrejd@gmail.com>
 * @link https://github.com/ondrejd/https://github.com/ondrejd/hamilton-child for the canonical source repository
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @package hamilton-child
 * @since 1.0.0
 * @global WC_Product_Simple $product
 */

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $product;

// If no product return
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

// Get product image
$thumbnail = get_post_thumbnail_id( $product->get_id() );
$image_arr = wp_get_attachment_image_src( $thumbnail, 'hamilton_preview-image' );
$image_url = '';

if( is_array( $image_arr ) ) {
    if( ! empty( $image_arr[0] ) ) {
        $image_url = $image_arr[0];
    }
}

?>
<div <?php post_class( 'post-preview tracker fallback-image missing-thumbnail' ) ?>>
    <div class="preview-image" style="background-image: url( <?php echo $image_url ?> );">
        <header class="preview-header">
	    <?php
	    /**
	     * woocommerce_before_shop_loop_item hook.
	     *
	     * @hooked woocommerce_template_loop_product_link_open - 10
	     */
	    do_action( 'woocommerce_before_shop_loop_item' );

	    /**
	     * woocommerce_before_shop_loop_item_title hook.
	     *
	     * @hooked woocommerce_show_product_loop_sale_flash - 10
	     * @hooked woocommerce_template_loop_product_thumbnail - 10
	     */
	    do_action( 'woocommerce_before_shop_loop_item_title' );

	    /**
	     * woocommerce_shop_loop_item_title hook.
	     *
	     * @hooked woocommerce_template_loop_product_title - 10
	     */
	    do_action( 'woocommerce_shop_loop_item_title' );

	    /**
	     * woocommerce_after_shop_loop_item_title hook.
	     *
	     * @hooked woocommerce_template_loop_rating - 5
	     * @hooked woocommerce_template_loop_price - 10
	     */
	    do_action( 'woocommerce_after_shop_loop_item_title' );

	    /**
	     * woocommerce_after_shop_loop_item hook.
	     *
	     * @hooked woocommerce_template_loop_product_link_close - 5
	     * @hooked woocommerce_template_loop_add_to_cart - 10
	     */
	    do_action( 'woocommerce_after_shop_loop_item' );
	    ?>
	    </header>
	</div>
</div>
