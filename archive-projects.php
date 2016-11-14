<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

get_header();
?>


	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="container">
				<div id="entry-header" class="row">
				<div class="col-md-9">
				<?php if ( is_home() && ! is_front_page() ) {
					echo '<h1 class="pez-bg main-tit hidden">'; single_post_title(); echo '</h1>';
				} else {
					the_archive_title( '<h1 class="pez-bg main-tit hidden">', '</h1>' );
					the_archive_description( '<div class="row"><div class="col-md-12 fp-slide-desc"><div class="pez-bg">', '</div></div></div>' );
				} ?>
				</div>
				</div>
			</header><!-- .wrap -->

			<div id="entry-content" class="container">
			<div class="row grid">

			<?php $count = 0;
			/* Start the Loop */
			while ( have_posts() ) : the_post();
				$count++;
				// the code inside the template part doesn't work
				// get_template_part( 'template-parts/content', get_post_type().'-mosaic' );
				$perma = get_permalink();
				$tit = get_the_title();
				if ( has_post_thumbnail() ) {
//	$pi_id = get_post_thumbnail_id( $post->ID );
//	$pi_src = wp_get_attachment_url($bgi_id);
//	$pi_meta = wp_get_attachment_metadata($bgi_id);
//	$p_out = '<img src="'.$bgi_src.'" alt="";
					$img_out = get_the_post_thumbnail($post,'thumbnail',array( 'class' => 'img-responsive' ));
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
	</div><!-- #primary -->

<?php
get_footer();
