<?php
/**
 * @author Ondřej Doněk <ondrejd@gmail.com>
 * @link https://github.com/ondrejd/https://github.com/ondrejd/hamilton-child for the canonical source repository
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @package hamilton-child
 * @since 1.0.0
 */

if( ! defined( 'ABSPATH' ) ) {
    exit;
}


if( ! class_exists( 'Hamilton_Child_WC_Customizer' ) ) :
    /**
     * Class that holds WooCommerce customizations.
     * @since 1.0.0
     */
    class Hamilton_Child_WC_Customizer {
        /**
         * Constructor.
         * @return void
         * @since 1.0.0
         * @uses add_action
         * @uses remove_action
         * @uses get_theme_mod
         */
        public function __construct() {
            remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
            remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

            add_action( 'woocommerce_before_main_content', [$this, 'before_main_content'], 10 );
            add_action( 'woocommerce_after_main_content', [$this, 'after_main_content'], 10 );
        }

        /**
         * @internal Hook for "woocommerce_before_main_content" action.
         * @return void
         * @since 1.0.0
         */
        public function before_main_content() {
?>
    <div id="main" class="section-inner hamilton-child-wc-content-wrapper">
<?php
        }

        /**
         * @internal Hook for "woocommerce_after_main_content" action.
         * @return void
         * @since 1.0.0
         */
        public function after_main_content() {
?>
    </div>
<?php
        }
    }
endif;

// Initialize WooCommerce customizations
$Hamilton_Child_WC_Customizer = new Hamilton_Child_WC_Customizer();
