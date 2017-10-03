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

if( ! function_exists( 'hamilton_child_setup' ) ) :
	/**
	 * @internal Setups the theme.
	 * @return void
	 * @since 1.0.0
     * @uses get_stylesheet_directory
     * @uses load_theme_textdomain
     * @uses unregister_nav_menu
	 */
    function hamilton_child_setup() {
        // Localization
        load_theme_textdomain( 'hamilton-child', get_stylesheet_directory() . '/languages' );
        // Add Social menu (used on a front-page in case of page is used not latest posts)
        register_nav_menu( 'social-menu', __( 'Social menu', 'hamilton-child' ) );
        // Add WooCommerce support
        add_theme_support( 'woocommerce' );
    }
endif;
// Setup the theme
add_action( 'after_setup_theme', 'hamilton_child_setup' );


if( ! function_exists( 'hamilton_child_enqueue_styles' ) ) :
    /**
     * @internal Loads required CSS styles.
     * @return void
     * @since 1.0.0
	 * @uses wp_enqueue_style
	 * @uses wp_get_theme
	 * @uses get_stylesheet_directory_uri
	 * @uses get_template_directory_uri
     */
    function hamilton_child_enqueue_styles() {
        $parent_style = 'hamilton-style';
        wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
        wp_enqueue_style(
                'hamilton-child-style',
                get_stylesheet_directory_uri() . '/style.css',
                array( $parent_style ),
                wp_get_theme()->get( 'Version' )
        );
}
endif;
// Load required CSS
add_action( 'wp_enqueue_scripts', 'hamilton_child_enqueue_styles' );


// Include our customizer changes
include( dirname( __FILE__ ) . '/includes/Hamilton_Child_Customizer.php' );
