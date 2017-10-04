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

if( ! class_exists( 'Hamilton_Child_Customizer' ) ) :
    /**
     * Class for dealing with WordPress Theme Customizer.
     * @since 1.0.0
     */
    class Hamilton_Child_Customizer {
        /**
         * Registers our customizations.
         * @link https://developer.wordpress.org/themes/customize-api/customizer-objects/
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         * @uses WP_Customize_Manager
         * @uses WP_Customize_Color_Control
         */
        public static function register( $wp_customize ) {
            // Updates "Static Front Page" section
            $wp_customize->get_section( 'static_front_page' )->active_callback = function() {
                return ( is_front_page() );
            };
            // Updates "Colors" section
            self::register_section_colors( $wp_customize );
            // Updates "Theme Options" section
            $wp_customize->get_section( 'hamilton_options' )->priority = 105;
            self::register_section_hamilton_options( $wp_customize );
            // Create "Blog Page Display" section
            self::register_section_blog_page_display( $wp_customize );
            // Create "Login Page Display" section
            self::register_section_login_page_display( $wp_customize );
            // Create "WooCommerce" section
            self::register_woocommerce_support( $wp_customize );
        }

        /**
         * @internal Updates "Colors" section in Theme Customizer.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         * @todo Udělat tři profily, první světlý (...|...|...|...),
         *       druhý světle fialový (#750743|#44002a|#ffffff|#e77243),
         *       třetí tmavě fialový (#750743|#44002a|...|...);
         *       dle zvoleného profilu nastavit i zvolené barvy
         *       (včetně defaultních hodnot). Původní "Hamilton's Dark Mode"
         *       úplně zrušit.
         */
        private static function register_section_colors( $wp_customize ) {
            // Set default color for "background_color" ...
            $wp_customize->get_setting( 'background_color' )->default = "#750743";
            // ... and add the description to its control.
            $wp_customize->get_control( 'background_color' )->description = __( 'Color for the whole background of the page.', 'hamilton-child' );
            // Secondary background color
            $wp_customize->add_setting( 'hamilton_child_bg_sec_color', [
                'capability'        => 'edit_theme_options',
                'default'           => '#2e0a23',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( new WP_Customize_Color_Control(
                $wp_customize,
                'hamilton_child_bg_sec_color', [
                    'label'       => __( 'Secondary background color', 'hamilton-child' ),
                    'section'     => 'colors',
                    'description' => __( 'This color will be used in blog posts listing for background of posts without thumbnail.', 'hamilton-child' ),
                ]
            ) );
            // Foreground color
            $wp_customize->add_setting( 'hamilton_child_fg_color', [
                'capability'        => 'edit_theme_options',
                'default'           => '#ffffff',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( new WP_Customize_Color_Control(
                $wp_customize,
                'hamilton_child_fg_color', [
                    'label'       => __( 'Foreground color', 'hamilton-child' ),
                    'section'     => 'colors',
                    'description' => __( 'Color which will be used as a main font color.', 'hamilton-child' ),
                ]
            ) );
            // Highlight color
            $wp_customize->add_setting( 'hamilton_child_hg_color', [
                'capability'        => 'edit_theme_options',
                'default'           => '#e77243',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( new WP_Customize_Color_Control(
                $wp_customize,
                'hamilton_child_hg_color', [
                    'label'       => __( 'Highlight color', 'hamilton-child' ),
                    'section'     => 'colors',
                    'description' => __( 'Color which will be used for highlighting certain texts (anchorts etc).', 'hamilton-child' ),
                ]
            ) );
        }

        /**
         * @internal Updates "Theme Options" section in Theme Customizer.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        private static function register_section_hamilton_options( $wp_customize ) {
            // Some changes to Hamilton controls
            $wp_customize->get_control( 'hamilton_alt_nav' )->priority = 10;
            $wp_customize->get_control( 'hamilton_home_title' )->priority = 30;

            // Show site description
            $wp_customize->add_setting( 'hamilton_child_show_site_description', [
                'capability' 		=> 'edit_theme_options',
                'default'           => false,
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'         => 'postMessage'
            ] );
            $wp_customize->add_control( 'hamilton_child_show_site_description', [
                'type'        => 'checkbox',
                'section'     => 'hamilton_options',
                'label'       => __( 'Show site description', 'hamilton-child' ),
                'description' => __( 'Check if you want to show site description just below the site title.', 'hamilton-child' ),
                'priority'    => 20,
            ] );

            // Footer text
            $wp_customize->add_setting( 'hamilton_child_footer_text', [
                'default'           => __( '&copy; 2017 <a href="mailto:ondrej.donek@gmail.com">Ondřej Doněk</a>.<br>Theme derrived from <strong>Hamilton</strong> theme by <a href="http://www.andersnoren.se" target="_BLANK">Anders Norén</a>.', 'hamilton-child' ),
                'capability' 		=> 'edit_theme_options',
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'hamilton_child_footer_text', [
                'type'        => 'textarea',
                'section'     => 'hamilton_options',
                'label'       => __( 'Footer text', 'hamilton-child' ),
                'description' => __( 'Set your custom footer text. You can use also simple <abbr title="Hyper Text Markup Language">HTML</abbr>.', 'hamilton-child' ),
                'priority'    => 40,
            ] );
        }

        /**
         * @internal Creates "Blog Page Display" section in Theme Customizer.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        private static function register_section_blog_page_display( $wp_customize ) {
            // Add section self
            $wp_customize->add_section(	'hamilton_child_blog_page_display', [
                'title'           => __( 'Blog Page Display', 'hamilton-child' ),
                'priority'        => 120,
                'capability'      => 'edit_theme_options',
                'description'     => __( 'Settings for how to display the <strong>Blog Page</strong>.', 'hamilton-child' ),
                'active_callback' => function() { return ( is_home() && ! is_front_page() ); },
            ] );

            // Move two settings from the "Theme Options" section
            $wp_customize->get_control( 'hamilton_max_columns' )->section = 'hamilton_child_blog_page_display';
            $wp_customize->get_control( 'hamilton_show_titles' )->section = 'hamilton_child_blog_page_display';

            // Preview content: show categories
            $wp_customize->add_setting( 'hamilton_child_preview_show_category', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'hamilton_child_preview_show_category', [
                'type'        => 'checkbox',
                'section'     => 'hamilton_child_blog_page_display',
                'label'       => __( 'Show category', 'hamilton-child' ),
                'description' => __( 'Check to show post categories inside the posts previews.', 'hamilton-child' ),
            ] );

            // Preview content: show date and time
            $wp_customize->add_setting( 'hamilton_child_preview_show_date', [
                'default'           => true,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'hamilton_child_preview_show_date', [
                'type'        => 'checkbox',
                'section'     => 'hamilton_child_blog_page_display',
                'label'       => __( 'Show date', 'hamilton-child' ),
                'description' => __( 'Check to show date and time in posts previews.', 'hamilton-child' ),
            ] );

            // Preview content: show excerpt
            $wp_customize->add_setting( 'hamilton_child_preview_show_excerpt', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'hamilton_child_preview_show_excerpt', [
                'type'        => 'checkbox',
                'section'     => 'hamilton_child_blog_page_display',
                'label'       => __( 'Show excerpt', 'hamilton-child' ),
                'description' => __( 'Check to show post excerpt inside the posts previews.', 'hamilton-child' ),
            ] );

            // Preview content: show tags
            $wp_customize->add_setting( 'hamilton_child_preview_show_tags', [
                'default'           => true,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'hamilton_child_preview_show_tags', [
                'type'        => 'checkbox',
                'section'     => 'hamilton_child_blog_page_display',
                'label'       => __( 'Show tags', 'hamilton-child' ),
                'description' => __( 'Check to show tags inside the posts previews.', 'hamilton-child' ),
            ] );

            // Show blog filter
            $wp_customize->add_setting( 'hamilton_child_blog_filter', [
                'default'           => true,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'hamilton_child_blog_filter', [
                'type'        => 'checkbox',
                'section'     => 'hamilton_child_blog_page_display',
                'label'       => __( 'Show blog filter', 'hamilton-child' ),
                'description' => __( 'Check to show filter on <strong>Blog Page</strong> above the grid with posts.', 'hamilton-child' ),
            ] );
        }

        /**
         * @internal Creates "Login Page Display" section in Theme Customizer.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        private static function register_section_login_page_display( $wp_customize ) {
            // Add section self
            $wp_customize->add_section(	'hamilton_child_login_page', [
                'title'       => __( 'Login Page Display', 'hamilton-child' ),
                'priority'    => 125,
                'capability'  => 'edit_theme_options',
                'description' => __( 'Settings for how to display the <strong>Login Page</strong> (show <a href="#" class="wp-login-page-link">Login Page</a>).', 'hamilton-child' ),
                'active_callback' => function() {
                    return ( filter_input( INPUT_GET, 'url' ) ==  get_bloginfo( 'url' ) .'/wp-login.php' );
                },
            ] );

            // Show WordPress logo
            $wp_customize->add_setting( 'hamilton_child_login_logo', [
                'default'           => true,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'hamilton_child_login_logo', [
                'type'        => 'checkbox',
                'section'     => 'hamilton_child_login_page',
                'label'       => __( 'Show logo', 'hamilton-child' ),
                'description' => __( 'Check to show <strong>WordPress</strong> or custom logo above the login form.', 'hamilton-child' ),
            ] );

            //....
        }

        /**
         * @internal Registers all what is neccessary for our WooCommerce support.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        private static function register_woocommerce_support( $wp_customize ) {
            // Our WooCommerce-aimed settings takes three sections:
            self::register_section_woocommerce_shop( $wp_customize );
            self::register_section_woocommerce_cart( $wp_customize );
            self::register_section_woocommerce_checkout( $wp_customize );
            self::register_section_woocommerce_account( $wp_customize );
        }

        /**
         * @internal Creates "Shop Page Display" section in Theme Customizer.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        private static function register_section_woocommerce_shop( $wp_customize ) {
            // Add section self
            $wp_customize->add_section(	'hamilton_child_woocommerce_shop', [
                'title'       => __( 'Shop Page Display', 'hamilton-child' ),
                'priority'    => 130,
                'capability'  => 'edit_theme_options',
                'description' => __( 'Settings for how to display <strong>WooCommerce</strong> <em>Shop</em> page.', 'hamilton-child' ),
                'active_callback' => function() {
                    if( function_exists( 'is_shop' ) ) {
                        return is_shop();
                    } else {
                        return false;
                    }
                },
            ] );

            // Show shop pages title
            $wp_customize->add_setting( 'hamilton_child_wc_pages_title', [
                'default'           => true,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'hamilton_child_wc_pages_title', [
                'type'        => 'checkbox',
                'section'     => 'hamilton_child_woocommerce_shop',
                'label'       => __( 'Show pages title', 'hamilton-child' ),
                'description' => __( 'Check to show titles on <strong>WooCommerce</strong> pages like <em>Shop</em>, <em>Cart</em> or <em>Checkout</em>.', 'hamilton-child' ),
            ] );

            // Show fancy order select
            $wp_customize->add_setting( 'hamilton_child_wc_fancy_order_select', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'hamilton_child_wc_fancy_order_select', [
                'type'        => 'checkbox',
                'section'     => 'hamilton_child_woocommerce_shop',
                'label'       => __( 'Fancy order select', 'hamilton-child' ),
                'description' => __( 'Check to show fancy order select on <em>Shop</em> page instead of the default one (plain <em>select</em> input).', 'hamilton-child' ),
            ] );

            // Use one-page shop
            $wp_customize->add_setting( 'hamilton_child_wc_one_page', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'hamilton_child_wc_one_page', [
                'type'        => 'checkbox',
                'section'     => 'hamilton_child_woocommerce_shop',
                'label'       => __( 'One-page shop', 'hamilton-child' ),
                'description' => __( 'Check to turn your <em>Shop</em> page with pagination into one page with all your products (<strong>requires One-Page Shop Plugin</strong>).', 'hamilton-child' ),
                'disabled'    => true,
            ] );
        }

        /**
         * @internal Creates "Cart Page Display" section in Theme Customizer.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        private static function register_section_woocommerce_cart( $wp_customize ) {
            // Add section self
            $wp_customize->add_section(	'hamilton_child_woocommerce_cart', [
                'title'       => __( 'Cart Page Display', 'hamilton-child' ),
                'priority'    => 131,
                'capability'  => 'edit_theme_options',
                'description' => __( 'Settings for how to display <strong>WooCommerce</strong> <em>Cart</em> page.', 'hamilton-child' ),
                'active_callback' => function() {
                    if( function_exists( 'is_cart' ) ) {
                        return is_cart();
                    } else {
                        return false;
                    }
                },
            ] );

            // Show coupon
            $wp_customize->add_setting( 'hamilton_child_wc_cart_show_coupon', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'hamilton_child_wc_cart_show_coupon', [
                'type'        => 'checkbox',
                'section'     => 'hamilton_child_woocommerce_cart',
                'label'       => __( 'Show coupon', 'hamilton-child' ),
                'description' => __( 'Check to show coupon field on <strong>Cart Page</strong> below the list of purchased items.', 'hamilton-child' ),
            ] );
        }

        /**
         * @internal Creates "Checkout Page Display" section in Theme Customizer.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        private static function register_section_woocommerce_checkout( $wp_customize ) {
            // Add section self
            $wp_customize->add_section(	'hamilton_child_woocommerce_checkout', [
                'title'       => __( 'Checkout Page Display', 'hamilton-child' ),
                'priority'    => 132,
                'capability'  => 'edit_theme_options',
                'description' => __( 'Settings for how to display <strong>WooCommerce</strong> <em>Checkout</em> page.', 'hamilton-child' ),
                'active_callback' => function() {
                    if( function_exists( 'is_checkout' ) ) {
                        return is_checkout();
                    } else {
                        return false;
                    }
                },
            ] );


            // Show coupon
            $wp_customize->add_setting( 'hamilton_child_wc_checkout_show_coupon', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'hamilton_child_wc_checkout_show_coupon', [
                'type'        => 'checkbox',
                'section'     => 'hamilton_child_woocommerce_checkout',
                'label'       => __( 'Show coupon', 'hamilton-child' ),
                'description' => __( 'Check to show coupon field on <strong>Cart Page</strong> below the list of purchased items.', 'hamilton-child' ),
            ] );

            // Show shipping choice
            $wp_customize->add_setting( 'hamilton_child_wc_checkout_shipping_choice', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'hamilton_child_wc_checkout_shipping_choice', [
                'type'        => 'checkbox',
                'section'     => 'hamilton_child_woocommerce_checkout',
                'label'       => __( 'Shipping choice', 'hamilton-child' ),
                'description' => __( 'Check to show shipping choice form on <strong>Checkout Page</strong> as before on <strong>Cart Page</strong> page.', 'hamilton-child' ),
            ] );
        }

        /**
         * @internal Creates "Account Page Display" section in Theme Customizer.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        private static function register_section_woocommerce_account( $wp_customize ) {
            // Add section self
            $wp_customize->add_section(	'hamilton_child_woocommerce_account', [
                'title'       => __( 'Account Page Display', 'hamilton-child' ),
                'priority'    => 130,
                'capability'  => 'edit_theme_options',
                'description' => __( 'Settings for how to display <strong>WooCommerce</strong> <em>Account</em> page.', 'hamilton-child' ),
                'active_callback' => function() {
                    if( function_exists( 'is_account_page' ) ) {
                        return is_account_page();
                    } else {
                        return false;
                    }
                },
            ] );

            // Hide dashboard
            $wp_customize->add_setting( 'hamilton_child_wc_account_hide_dashboard', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'hamilton_child_wc_account_hide_dashboard', [
                'type'        => 'checkbox',
                'section'     => 'hamilton_child_woocommerce_account',
                'label'       => __( 'Hide Dashboard', 'hamilton-child' ),
                'description' => __( 'Check to hide <strong>Dashboard</strong> on <strong>Account Page</strong> so the first pane become <strong>Orders</strong>.', 'hamilton-child' ),
            ] );
        }

        /**
         * @internal Registers our JavaScript the live preview.
         * @return void
         * @since 1.0.0
         * @uses get_stylesheet_directory_uri
         * @uses wp_enqueue_script
         */
        public static function register_js() {
            wp_enqueue_script(
                'hamilton-child-themecustomizer',
                get_stylesheet_directory_uri() . '/assets/js/customizer.js',
                ['jquery', 'customize-preview', 'masonry'],
                '',
                true
            );
        }

        /**
         * @internal Outputs customized style into the WP head.
         * @return void
         * @since 1.0.0
         * @uses get_theme_mod
         */
        public static function header_output() {
?>
<style type='text/css'>
/* Secondary background color */
.missing-thumbnail .preview-image { background-color: <?php echo get_theme_mod( 'hamilton_child_bg_sec_color' ) ?>; }
/* Foreground color */
body, body *, body a { color: <?php echo get_theme_mod( 'hamilton_child_fg_color' ) ?>; }
/* Site description */
.site-description { display: <?php echo ( get_theme_mod( 'hamilton_child_show_site_description' ) ) ? 'block' : 'none'; ?>; }
/* Highlight color */
.site-name, .site-title a, .alt-nav a { color: <?php echo get_theme_mod( 'hamilton_child_fg_color' ) ?>; }
.site-title a:active, .site-title a:hover,
.alt-nav a:active, .alt-nav a:hover,
#hamilton_child_footer_text a:active, #hamilton_child_footer_text a:hover {
    border-bottom: 0.25em solid <?php echo get_theme_mod( 'hamilton_child_hg_color' ) ?>;
}
.dark-mode .entry-content a { border-bottom-color: <?php echo get_theme_mod( 'hamilton_child_hg_color' ) ?>; }
.dark-mode .entry-content a:hover { color: <?php echo get_theme_mod( 'hamilton_child_hg_color' ) ?>; }
/* Preview Content: Category */
.preview-header .preview-category { display: <?php echo ( get_theme_mod( 'hamilton_child_preview_show_category' ) ) ? 'block' : 'none'; ?>; }
/* Preview Content: Date and Time */
.preview-header .preview-date { display: <?php echo ( get_theme_mod( 'hamilton_child_preview_show_date' ) ) ? 'block' : 'none'; ?>; }
/* Preview Content: Excerpt */
.preview-header .preview-excerpt { display: <?php echo ( get_theme_mod( 'hamilton_child_preview_show_excerpt' ) ) ? 'block' : 'none'; ?>; }
/* Preview Content: Tags */
.preview-header .preview-tags { display: <?php echo ( get_theme_mod( 'hamilton_child_preview_show_tags' ) ) ? 'block' : 'none'; ?>; }
/* Show blog filter */
#hamilton_child_blog_filter { display: <?php echo ( get_theme_mod( 'hamilton_child_blog_filter' ) ) ? 'block' : 'none'; ?>; }
</style>
<?php
        }

        /**
         * @internal Sanitizes checkbox values.
         * @param boolean $checked
         * @return boolean
         * @since 1.0.0
         */
        public static function sanitize_checkbox( $checked ) {
            return ( ( isset( $checked ) && true == $checked ) ? true : false );
        }
    }
endif;

// Register our customizer extension
add_action( 'customize_register', ['Hamilton_Child_Customizer', 'register'], 99 );
add_action( 'customize_preview_init', ['Hamilton_Child_Customizer', 'register_js'] );
add_action( 'wp_head' , ['Hamilton_Child_Customizer' , 'header_output'] );
