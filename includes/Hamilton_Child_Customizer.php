<?php
/**
 * @author Ondřej Doněk <ondrejd@gmail.com>
 * @link https://github.com/ondrejd/https://github.com/ondrejd/hamilton-child for the canonical source repository
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @package hamilton
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
         */
        public static function register( $wp_customize ) {
            /*
            $wp_customize->add_panel();
            $wp_customize->get_panel();
            $wp_customize->remove_panel();

            $wp_customize->add_section();
            $wp_customize->get_section();
            $wp_customize->remove_section();

            $wp_customize->add_setting();
            $wp_customize->get_setting();
            $wp_customize->remove_setting();

            $wp_customize->add_control();
            $wp_customize->get_control();
            $wp_customize->remove_control();
            */
        }
    }
endif;

// Register our customizer extension
add_action('customize_register', ['Hamilton_Child_Customizer', 'register']);
