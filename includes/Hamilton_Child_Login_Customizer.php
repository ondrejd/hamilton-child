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


if( ! class_exists( 'Hamilton_Child_Login_Customizer' ) ) :
    /**
     * Customizes login page.
     * @since 1.0.0
     */
    class Hamilton_Child_Login_Customizer {

        /**
         * Constructor.
         * @return void
         * @since 1.0.0
         */
        public function __construct() {
            add_action( 'login_head', [$this, 'head'] );
        }

        /**
         * @internal Hook for "login_head" action.
         * @return void
         * @since 1.0.0
         */
        public function head() {
?>
<style type="text/css">
/* Hamilton Child Login */
</style>
<?php
        }
    }
endif;

// Initialize Login Page customizer
$Hamilton_Child_Login_Customizer = new Hamilton_Child_Login_Customizer();
