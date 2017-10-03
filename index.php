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

get_header();

?>
	<div class="section-inner">

		<?php if ( is_home() && $paged == 0 && get_theme_mod( 'hamilton_home_title' ) ) : ?>

			<header class="page-header fade-block">
				<div>
					<h2 class="title"><?php echo esc_html( get_theme_mod( 'hamilton_home_title' ) ); ?></h2>
				</div>
			</header>

		<?php elseif ( is_archive() ) : ?>

			<header class="page-header fade-block">
				<div>
					<h2 class="title"><?php the_archive_title(); ?></h2>
					<?php the_archive_description(); ?>
				</div>
			</header>

		<?php elseif ( is_search() && have_posts() ) : ?>

			<header class="page-header fade-block">
				<div>
					<h2 class="title"><?php printf( __( 'Search: %s', 'hamilton' ), '&ldquo;' . get_search_query() . '&rdquo;' ); ?></h2>
					<p><?php global $found_posts; printf( __( 'We found %s results matching your search.', 'hamilton' ), $wp_query->found_posts ); ?></p>
				</div>
			</header>

		<?php elseif ( is_search() ) : ?>

			<div class="section-inner">

				<header class="page-header fade-block">
					<div>
						<h2 class="title"><?php _e( 'No results found', 'hamilton' ); ?></h2>
						<p><?php global $found_posts; printf( __( 'We could not find any results for the search query "%s".', 'hamilton' ), get_search_query() ); ?></p>
					</div>
				</header>

			</div>

		<?php endif;

		if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
            <div id="hamilton_child_blog_filter" class="section-inner">
    			<div class="posts-filters fade-block">
    				<span class="dashicons dashicons-category"></span>
    				<?php echo get_the_category_list( ', ' ) ?>
    			</div>
    			<div class="posts-views fade-block"></div>
            </div>
			<?php endif; ?>

			<div class="posts" id="posts">

				<?php while ( have_posts() ) : the_post();

					get_template_part( 'content' );

				endwhile; ?>

			</div><!-- .posts -->

		<?php endif; ?>

	</div><!-- .section-inner -->

<?php

get_template_part( 'pagination' );

get_footer(); ?>
