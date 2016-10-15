<?php
/**
 * The main template file.
 * 
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

get_header();

	$blog_id = get_option('page_for_posts'); //echo $blog_id;
	$blog = get_post($blog_id); //print_r($blog);
	$header_style_out = "";
	$header_bgcolor = get_post_meta($blog->ID,'_pezestudio_header_bgcolor',true);
	if ( has_post_thumbnail() ) {
		$bgi_id = get_post_thumbnail_id( $blog->ID );
		$bgi_src = wp_get_attachment_url($bgi_id);
		$bgi_meta = wp_get_attachment_metadata($bgi_id);
		$header_style_out .= "background-image: url('".$bgi_src."'); background-size: cover;";
	}
	if ( $header_bgcolor != '' ) {
		$header_style_out .= "background-color: ".$header_bgcolor.";";
	}
	$header_style_out = ( $header_style_out == '' ) ? '' : ' style="'.$header_style_out.'"';

	$header_height = get_post_meta($blog->ID,'_pezestudio_header_height',true);
	if ($header_height != '' ) {
		$js_out = "<script type='text/javascript'>var headerHeightPercent=".$header_height."</script>";
	} else { $js_out = ''; }
?>


	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>
			<header<?php echo $header_style_out; ?> class="wrap">
				<div class="wrap-inner vspace">
				<div class="container">
				<div id="entry-header" class="row">
				<div class="col-md-9">
				<?php if ( $blog_id != '' ) {
					echo '<h1 class="pez-bg main-tit">'.get_the_title($blog_id).'</h1>';
					if ( get_edit_post_link($blog_id) ) { edit_post_link('<span class="edit-link">'.esc_html__( 'Edit', '_s' ).'</span>','','',$blog_id); }
				} ?>
				</div>
				</div>
				</div>
				</div>
				<?php echo $js_out; ?>
			</header><!-- .wrap -->

			<div id="entry-content" class="container">
			<div class="row">

				<div class="col-md-9">
				<div class="row grid">

				<?php $count = 0;
				/* Start the Loop */
				while ( have_posts() ) : the_post();
					$count++;
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
					<div class="grid-item col-md-4 col-sm-4'.$class.'">
						<a href="'.$perma.'">'.$img_out.'<span class="grid-tit white-bg">'.$tit.'</span></a>
					</div>';
		
				endwhile; ?>

				</div>
				</div>
				<?php the_posts_navigation(); ?>

				<div class="col-md-3">
				<?php get_sidebar(); ?>
				</div>
		<?php else :
			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
