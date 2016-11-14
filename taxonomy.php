<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

get_header();

// TERM VARS
//// 
$header_text_class = "col-md-9";
$term_id = get_queried_object()->term_id;
$bgi_src = get_term_meta($term_id,'_pezestudio_header_bgimage',true);
$header_bgcolor = get_term_meta($term_id,'_pezestudio_header_bgcolor',true);
$header_height = get_term_meta($term_id,'_pezestudio_header_height',true);
$header_style_out = "";
if ( $bgi_src != '' ) {
	$bgi_id = pezestudio_get_attachment_id_from_url( $bgi_src );
	$bgi_src_huge = wp_get_attachment_image_url($bgi_id,'huge');
	$bgi_src_extralarge = wp_get_attachment_image_url($bgi_id,'extralarge');
	$bgi_src_larger = wp_get_attachment_image_url($bgi_id,'larger');
//	$bgi_meta = wp_get_attachment_metadata($bgi_id);
	$header_style_out .= "background-image: url('".$bgi_src_huge."'); background-size: cover;";
}
if ( $header_bgcolor != '' ) {
	$header_style_out .= "background-color: ".$header_bgcolor.";";
}
$header_style_out = ( $header_style_out == '' ) ? '' : ' style="'.$header_style_out.'"';

if ( $header_height != '' ) {
	$js_out = "<script type='text/javascript'>var headerHeightPercent=".$header_height."</script>";
} else { $js_out = "<script type='text/javascript'>var headerHeightPercent=25</script>"; }
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header<?php echo $header_style_out; ?> class="wrap">
				<div class="wrap-inner vspace">
				<div class="container">
				<div id="entry-header" class="row">
				<div class="<?php echo $header_text_class; ?>">
					<?php the_archive_title( '<h1 class="pez-bg main-tit">', '</h1>' );
					the_archive_description( '<div class="row"><div class="col-md-12 fp-slide-desc"><div class="pez-bg">', '</div></div></div>' ); ?>
				</div>
				</div>
				</div>
				</div>
				<?php echo $js_out; ?>
			</header><!-- .wrap -->

			<div id="entry-content" class="container">
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
					<div class="grid-item col-md-3 col-sm-4'.$class.'">
						<a href="'.$perma.'">'.$img_out.'<span class="grid-tit white-bg">'.$tit.'</span></a>
					</div>';

			
			endwhile;

			the_posts_navigation();

		else :
			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

			</div><!-- .entry-content -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
