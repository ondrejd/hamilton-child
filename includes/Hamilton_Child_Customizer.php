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
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         * @uses WP_Customize_Manager
         * @uses WP_Customize_Color_Control
         */
        public static function register( $wp_customize ) {
            // Set default color for "background_color" ...
            $wp_customize->get_setting( 'background_color' )->default = "#750743";
            // ... and add the description to its control.
            $wp_customize->get_control( 'background_color' )->description = __( 'Color for the whole background of the page.', 'hamilton-child' );

            // Secondary background color
            $wp_customize->add_setting( 'hamilton_child_bg_sec_color', [
                'default'    => '#7c005d',
                'transport'	 => 'postMessage',
                'capability' => 'edit_theme_options',
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
                'default'    => '#ffffff',
                'transport'	 => 'postMessage',
                'capability' => 'edit_theme_options',
            ] );
            $wp_customize->add_control( new WP_Customize_Color_Control(
                $wp_customize,
                'hamilton_child_fg_color', [
                    'label'       => __( 'Foreground color', 'hamilton-child' ),
                    'section'     => 'colors',
                    'description' => __( 'Color which will be used as a main font color.', 'hamilton-child' ),
                ]
            ) );

            // Show site description
            $wp_customize->add_setting( 'hamilton_child_show_site_description', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'hamilton_child_show_site_description', [
                'type'        => 'checkbox',
                'section'     => 'hamilton_options',
                'label'       => __( 'Show site description', 'hamilton-child' ),
                'description' => __( 'Check if you want to show site description just below the site title.', 'hamilton-child' ),
            ] );

            // Footer text
            $wp_customize->add_setting( 'hamilton_child_footer_text', [
                'default'           => __( '&copy; 2017 <a href="mailto:ondrej.donek@gmail.com">Ondřej Doněk</a>.<br>Theme derrived from <strong>Hamilton</strong> theme by <a href="http://www.andersnoren.se" target="_BLANK">Anders Norén</a>.', 'hamilton-child' ),
                'capability' 		=> 'edit_theme_options',
                //'sanitize_callback' => 'sanitize_textarea_field',
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'hamilton_child_footer_text', [
                'type'        => 'textarea',
                'section'     => 'hamilton_options',
                'label'       => __( 'Footer text', 'hamilton-child' ),
                'description' => __( 'Set your custom footer text. You can use also simple <abbr title="Hyper Text Markup Language">HTML</abbr>.', 'hamilton-child' ),
                'priority'    => 100,
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
.missing-thumbnail .preview-image {
	background-color: <?php echo get_theme_mod( 'hamilton_child_bg_sec_color' ) ?>;
}
body, body *, body a {
    color: <?php echo get_theme_mod( 'hamilton_child_fg_color' ) ?>;
}
.site-description {
    display: <?php echo ( get_theme_mod( 'hamilton_child_show_site_description' ) ) ? 'block' : 'none'; ?>;
}
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
add_action( 'customize_register', ['Hamilton_Child_Customizer', 'register'] );
add_action( 'customize_preview_init', ['Hamilton_Child_Customizer', 'register_js'] );
add_action( 'wp_head' , ['Hamilton_Child_Customizer' , 'header_output'] );
