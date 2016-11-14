<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package _s
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="container">
				<div id="entry-header" class="row">
				<div class="col-md-9">
				<?php echo '<h1 class="pez-bg main-tit hidden">'; printf( esc_html__( 'Search Results for: %s', '_s' ), '<span>' . get_search_query() . '</span>' ); echo '</h1>'; ?>
				</div>
				</div>
			</header><!-- .page-header -->

			<div id="entry-content" class="container">
			<div class="row grid">

			<?php $count = 0;
			/* Start the Loop */
			while ( have_posts() ) : the_post();
				$count++;
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				// get_template_part( 'template-parts/content', 'search' );
				// the code inside the template part doesn't work
				// get_template_part( 'template-parts/content', get_post_type().'-mosaic' );
				$perma = get_permalink();
				$tit = get_the_title();
				if ( has_post_thumbnail() ) {
//	$pi_id = get_post_thumbnail_id( $post->ID );
//	$pi_src = wp_get_attachment_url($bgi_id);
//	$pi_meta = wp_get_attachment_metadata($bgi_id);
//	$p_out = '<img src="'.$bgi_src.'" alt="";
					$img_out = get_the_post_thumbnail($post,'medium',array( 'class' => 'img-responsive' ));
				} else { $img_out = ''; }
				if ( $count == 1 ) { $class = ' grid-sizer'; } else { $class = ''; }
				echo'
				<div class="grid-item col-md-3 col-sm-4'.$class.'">
					<a href="'.$perma.'">'.$img_out.'<span class="grid-tit white-bg">'.$tit.'</span></a>
				</div>';
			endwhile;

			//the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
//get_sidebar();
get_footer();
