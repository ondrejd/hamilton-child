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

if ( have_posts() )  :

	while ( have_posts() ) : the_post(); ?>

		<div <?php post_class( 'section-inner' ); ?>>

			<header class="page-header section-inner thin<?php if ( has_post_thumbnail() ) echo ' fade-block'; ?>">

				<div>

					<?php
					the_title( '<h2 class="title">', '</h2>' );

					// Make sure we have a custom excerpt
					if ( has_excerpt() && ! is_front_page() ) the_excerpt();

					// Only output post meta data on single
					if ( is_front_page() ) : ?>
					<div class="meta user-meta"><?php wp_nav_menu( array(
					    'menu_class'     => 'fp-main-social-menu',
					    'container'      => '',
					    'theme_location' => 'social-menu'
					) ); ?></div>
					<?php elseif ( is_single() ) : ?>

						<div class="meta">

							<?php
							echo __( 'In', 'hamilton' ) . ' '; the_category( ', ' );

							if ( comments_open() ) : ?>
								<span>&bull;</span>
								<?php comments_popup_link(
									__( 'Add Comment', 'hamilton' ),
									__( '1 Comment', 'hamilton' ),
									sprintf( __('%s Comments', 'hamilton' ), '%' ),
									''
								); ?>
							<?php endif; ?>

						</div>

					<?php endif; ?>

				</div>

			</header><!-- .page-header -->

			<?php if ( has_post_thumbnail() ) : ?>

				<div class="featured-image">
					<?php the_post_thumbnail( 'hamilton_fullscreen-image' ); ?>
				</div>

			<?php endif; ?>

			<div class="entry-content section-inner thin">

				<?php the_content(); ?>

			</div> <!-- .content -->

			<?php

			wp_link_pages( array(
				'before' => '<p class="section-inner thin linked-pages">' . __( 'Pages:', 'hamilton' ),
			) );

			if ( get_post_type() == 'post' ) : ?>

				<div class="meta bottom section-inner thin group">

					<?php if ( get_the_tags() ) : ?>

						<p class="tags"><?php the_tags( ' #', ' #', ' ' ); ?></p>

					<?php endif; ?>

					<p><a href="<?php the_permalink(); ?>" title="<?php the_time( get_option( 'date_format' ) ); ?> <?php the_time( get_option( 'time_format' ) ); ?>"><?php the_date( get_option( 'date_format' ) ); ?></a>

				</div> <!-- .meta -->

			<?php endif; ?>

			<?php

			// If comments are open, or there are at least one comment
			if ( get_comments_number() || comments_open() ) : ?>

				<div class="section-inner thin">
					<?php comments_template(); ?>
				</div>

			<?php endif; ?>

		</div> <!-- .post -->

		<?php

		if ( get_post_type() == 'post' ) get_template_part( 'related-posts' );

	endwhile;

endif;

get_footer(); ?>
