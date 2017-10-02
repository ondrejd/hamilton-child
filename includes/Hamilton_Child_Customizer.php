<?php
/**
 * @author Ondřej Doněk <ondrejd@gmail.com>
 * @link https://github.com/ondrejd/https://github.com/ondrejd/hamilton-child for the canonical source repository
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @package hamilton-child
 * @since 1.0.0
 */

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
            $wp_customize->get_control( 'background_color' )->description = __( 'Color for the whole background of the page.', 'hamilton' );
            // Secondary background color
            $wp_customize->add_setting( 'hamilton_child_bg_sec_color', [
                'default'    => '#7c005d',
                'transport'	 => 'postMessage',
                'capability' => 'edit_theme_options',
            ] );
            $wp_customize->add_control( new WP_Customize_Color_Control(
                $wp_customize,
                'hamilton_child_bg_sec_color', [
                    'label'       => __( 'Secondary background color', 'hamilton' ),
                    'section'     => 'colors',
                    'settings'    => 'hamilton_child_bg_sec_color',
                    'description' => __( 'This color will be used in blog posts listing for background of posts without thumbnail.', 'hamilton' ),
                ]
            ));

            // Foreground color
            $wp_customize->add_setting( 'hamilton_child_fg_color', [
                'default'    => '#ffffff',
                'transport'	 => 'postMessage',
                'capability' => 'edit_theme_options',
            ] );
            $wp_customize->add_control( new WP_Customize_Color_Control(
                $wp_customize,
                'hamilton_child_fg_color', [
                    'label'       => __( 'Foreground color', 'hamilton' ),
                    'section'     => 'colors',
                    'settings'    => 'hamilton_child_fg_color',
                    'description' => __( 'Color which will be used as a main font color.', 'hamilton' ),
                ]
            ));
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
</style>
<?php
        }
    }
endif;

// Register our customizer extension
add_action( 'customize_register', ['Hamilton_Child_Customizer', 'register'] );
add_action( 'customize_preview_init', ['Hamilton_Child_Customizer', 'register_js'] );
add_action( 'wp_head' , ['Hamilton_Child_Customizer' , 'header_output'] );
