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
            // Updates "Colors" section
            self::register_section_colors( $wp_customize );
            // Updates "Theme Options" section
            self::register_section_hamilton_options( $wp_customize );
            // Create "Blog Page Display" section
            self::register_section_blog_page_display( $wp_customize );
        }

        /**
         * @internal Updates "Colors" section in Theme Customizer.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        private static function register_section_colors( $wp_customize ) {
            // Set default color for "background_color" ...
            $wp_customize->get_setting( 'background_color' )->default = "#750743";
            // ... and add the description to its control.
            $wp_customize->get_control( 'background_color' )->description = __( 'Color for the whole background of the page.', 'hamilton-child' );
            // Secondary background color
            $wp_customize->add_setting( 'hamilton_child_bg_sec_color', [
                'capability'        => 'edit_theme_options',
                'default'           => '#ffffff',
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
                'priority'    => 100,
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
                'title'       => __( 'Blog Page Display', 'hamilton-child' ),
                'priority'    => 150,
                'capability'  => 'edit_theme_options',
                'description' => __('Settings for how to display the <strong>Blog Page</strong>.', 'hamilton-child' ),
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
