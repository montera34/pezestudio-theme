<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package _s
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main container" role="main">

		<?php
		while ( have_posts() ) : the_post();

			echo '<div class="row">';
				get_template_part( 'template-parts/content', get_post_format() );
			echo '</div>';

			echo '<nav class="row tspace">';
				echo pezestudio_get_post_nav_links($post);
			echo '</nav>';

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
			echo '<div class="row tspace">';
				comments_template('/comments.php',true);
			echo '</div>';
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
