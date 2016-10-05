<?php
/**
 * Template Name: Full Screen Background Image Template
 *
 * @package Urban_Rights
 */

get_header();

while ( have_posts() ) : the_post(); ?>

	<div id="primary" class="content-area">
		<header><?php the_title( '<h1 class="entry-title hidden">', '</h1>' ); ?></header>
		<main id="fullpage" class="site-main" role="main">

			<?php
$bgimages_ids = get_post_meta($post->ID,'mfi-reloaded-images');
$args = array(
	'post__in' => array_values($bgimages_ids[0]),
	'post_type' => 'attachment',
	'nopaging' => true
);
$bgimages = get_posts($args);
foreach ( $bgimages as $bgi ) {
	$bgi_id = $bgi->ID;
	$bgi_src = wp_get_attachment_url($bgi_id);
	$bgi_meta = wp_get_attachment_metadata($bgi_id);
	$bgi_url = get_post_meta($bgi_id,'_pezestudio_metabox_attachment_url',true);
	$bgi_desc = $bgi->post_content;
	$bgi_tit_out = ( $bgi_url == '' ) ? $bgi->post_title : "<a href='".$bgi_url."'>".$bgi->post_title."</a>";
	$bgi_desc_out = ( $bgi_desc == '' ) ? "" : "<div class='row'><div class='col-md-12 fp-slide-desc'><div class='pez-bg'>".$bgi_desc."</div></div></div>";
	echo "
	<section class='fp-slide' style='background-image:url(".$bgi_src.");'>
	<div class='container vspace'>
		<div class='row'>
			<header class='col-md-12 fp-slide-tit'><h2 class='pez-bg main-tit'>".$bgi_tit_out."</h2></header>
		</div>
		".$bgi_desc_out."
		
	</div>
	</section>
	";
}
?>
		</main><!-- #fullpage -->
	</div><!-- #primary -->

<?php
endwhile; // End of the loop.
get_footer();
