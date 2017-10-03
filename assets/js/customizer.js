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

	// Highlight color
	wp.customize( 'hamilton_child_hg_color', function( value ) {
		value.bind( function( newval ) {
			$( 'body a:active, body a:hover' ).css( 'border-bottom', '0.25em solid ' + newval );
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

	// Footer text
	wp.customize( 'hamilton_child_footer_text', function( value ) {
		value.bind( function( newval ) {
			$( '#hamilton_child_footer_text' ).html( newval );
		} );
	} );

	// Preview Content: Category
	wp.customize( 'hamilton_child_preview_show_category', function( value ) {
		value.bind( function( newval ) {
			if ( newval == true ) {
				$( '.preview-header .preview-category' ).css( 'display', 'block' );
			} else {
				$( '.preview-header .preview-category' ).css( 'display', 'none' );
			}
		} );
	} );

	// Preview Content: Date and Time
	wp.customize( 'hamilton_child_preview_show_date', function( value ) {
		value.bind( function( newval ) {
			if ( newval == true ) {
				$( '.preview-header .preview-date' ).css( 'display', 'block' );
			} else {
				$( '.preview-header .preview-date' ).css( 'display', 'none' );
			}
		} );
	} );

	// Preview Content: Excerpt
	wp.customize( 'hamilton_child_preview_show_excerpt', function( value ) {
		value.bind( function( newval ) {
			if ( newval == true ) {
				$( '.preview-header .preview-excerpt' ).css( 'display', 'block' );
			} else {
				$( '.preview-header .preview-excerpt' ).css( 'display', 'none' );
			}
		} );
	} );

	// Preview Content: Tags
	wp.customize( 'hamilton_child_preview_show_tags', function( value ) {
		value.bind( function( newval ) {
			if ( newval == true ) {
				$( '.preview-header .preview-tags' ).css( 'display', 'block' );
			} else {
				$( '.preview-header .preview-tags' ).css( 'display', 'none' );
			}
		} );
	} );

	// Show blog filter
	wp.customize( 'hamilton_child_blog_filter', function( value ) {
		value.bind( function( newval ) {
			if ( newval == true ) {
				$( '#hamilton_child_blog_filter' ).css( 'display', 'block' );
			} else {
				$( '#hamilton_child_blog_filter' ).css( 'display', 'none' );
			}
		} );
	} );
} )( jQuery );
