/**
 * @author Ondřej Doněk <ondrejd@gmail.com>
 * @link https://github.com/ondrejd/https://github.com/ondrejd/hamilton-child for the canonical source repository
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @package hamilton-child
 * @since 1.0.0
 */

( function( $ ) {
    // Secondary background color
	wp.customize( 'hamilton_child_bg_sec_color', function( value ) {
		value.bind( function( newval ) {
			$( '.missing-thumbnail .preview-image' ).css( 'background-color', newval );

		} );
	} );

    // Foreground color
	wp.customize( 'hamilton_child_fg_color', function( value ) {
		value.bind( function( newval ) {
			$( 'body, body *, body a' ).css( 'color', newval );
		} );
	} );

	// Show site description
	wp.customize( 'hamilton_child_show_site_description', function( value ) {
		value.bind( function( newval ) {
			if ( newval == true ) {
				$( '.site-description' ).css( 'display', 'block' );
			} else {
				$( '.site-description' ).css( 'display', 'none' );
			}
		} );
	} );
} )( jQuery );
