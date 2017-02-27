<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

$header_style_out = "";
$header_bgcolor = get_post_meta($post->ID,'_pezestudio_header_bgcolor',true);
$bgimages_ids = get_post_meta($post->ID,'mfi-reloaded-images');
$args = array(
	'post__in' => array_values($bgimages_ids[0]),
	'post_type' => 'attachment',
	'nopaging' => true
);
$bgimages = get_posts($args);
foreach ( $bgimages as $bgi ) {
	$bgi_id = $bgi->ID;
//	$bgi_meta = wp_get_attachment_metadata($bgi_id);
	$bgi_src_huge = wp_get_attachment_image_url($bgi_id,'huge');
	$bgi_src_extralarge = wp_get_attachment_image_url($bgi_id,'extralarge');
	$bgi_src_larger = wp_get_attachment_image_url($bgi_id,'larger');
	$header_style_out .= "background-image: url('".$bgi_src_huge."'); background-size: cover;";
}
if ( $header_bgcolor != '' ) {
	$header_style_out .= "background-color: ".$header_bgcolor.";";
}
$header_style_out = ( $header_style_out == '' ) ? '' : ' style="'.$header_style_out.'"';

$header_height = get_post_meta($post->ID,'_pezestudio_header_height',true);
if ($header_height != '' ) {
	$js_out = "<script type='text/javascript'>var headerHeightPercent=".$header_height."</script>";
} else { $js_out = ''; }
$bgi_desc = get_post_meta($post->ID,'_pezestudio_project_subtitle',true);
$bgi_desc_out = ( $bgi_desc == '' ) ? "" : "<div class='row'><div class='col-md-12 fp-slide-desc'><div class='pez-bg'>".$bgi_desc."</div></div></div>";

// PROJECT FIELDS
$p_desc = get_post_meta($post->ID,'_pezestudio_project_description',true);
$p_desc_out = ( $p_desc == '' ) ? '' : '<div class="project-desc">'.apply_filters('the_content',$p_desc).'</div>';

$p_card_fields = array(
	array(
		'name' => 'city',
		'type' => 'tax',
		'label' => '',
		'output' => 'place'
	),
	array(
		'name' => 'country',
		'type' => 'tax',
		'label' => '',
		'output' => 'place'
	),
	array(
		'name' => '_pezestudio_project_date_begin',
		'type' => 'postmeta',
		'label' => '',
		'output' => 'date'
	),
	array(
		'name' => '_pezestudio_project_date_end',
		'type' => 'postmeta',
		'label' => '',
		'output' => 'date'
	),
	array(
		'name' => 'topic',
		'type' => 'tax multiple',
		'label' => __('Topics','_s'),
		'output' => 'list'
	),
	array(
		'name' => 'status',
		'type' => 'tax',
		'label' => __('Status','_s'),
		'output' => 'list'
	),
	array(
		'name' => '_pezestudio_project_awards',
		'type' => 'postmeta',
		'label' => __('Awards','_s'),
		'output' => 'list'
	),
	array(
		'name' => '_pezestudio_project_clients',
		'type' => 'postmeta',
		'label' => __('Clients','_s'),
		'output' => 'list'
	),
	array(
		'name' => '_pezestudio_project_team',
		'type' => 'postmeta',
		'label' => __('Team','_s'),
		'output' => 'list'
	),
	array(
		'name' => '_pezestudio_project_collaborators',
		'type' => 'postmeta',
		'label' => __('Collaborators','_s'),
		'output' => 'list'
	),
	array(
		'name' => '_pezestudio_project_collaborators_org',
		'type' => 'postmeta',
		'label' => __('Organizations involved','_s'),
		'output' => 'list'
	),
	array(
		'name' => '_pezestudio_project_links',
		'type' => 'postmeta',
		'label' => __('Related links','_s'),
		'output' => 'list'
	)
);
$list_out = '';
foreach ( $p_card_fields as $pcf ) {
	switch ( $pcf['type'] ) {
	case 'tax':
		$terms = get_the_terms($post,$pcf['name']);
		if ( $terms && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
			$value = $term->name;
			}
		} else { $value = ''; }
		break;
	case 'tax multiple':
		$value = '';
		$terms = get_the_terms($post,$pcf['name']);
		if ( $terms && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
			$value[] = $term->name;
			}
		}
		$value = ( $value != '' ) ? join(', ',$value) : '';
		break;
	case 'postmeta':
		$value = get_post_meta($post->ID,$pcf['name'],true);
	}
	switch ( $pcf['output'] ) {
	case 'list':
		$list_out .= '<dt>'.$pcf['label'].'</dt><dd>'.$value.'</dd>';
		break;	
	case 'date':
		$dates[] = $value;
		break;	
	default:
		if ( $value != '' ) $firstline[] = $value;
		break;
	}
}
$firstline_out = ( is_array($firstline) ) ? '<div class="project-card-firstline">'.join(', ',$firstline).'</div>' : '';
$dates_out = ( is_array($dates) && $dates[0] != $dates[1] ) ? '<dt>'.__('Date','_s').'</dt><dd>'.join(' -- ',$dates).'</dd>' : '';
$list_out = ( $list_out != '' ) ? '<dl>'.$list_out.'</dl>' : '';

// PROJECT IMAGES
$args = array(
	'post_type' => 'attachment',
	'nopaging' => true,
	'post_status' => null,
	'post_parent' => $post->ID,
	'orderby' => 'menu_order',
	'order' => 'ASC'
);
$attachments = get_posts($args);
$p_imgs_out = ''; // container for horozontal slider
$p_imgs_nav_out = ''; // countainer for thumbnails gallery
$count_img = 0;
if ( $attachments ) {
	foreach ( $attachments as $attachment ) {
		$img_type = $attachment->post_mime_type;
		if ( $img_type == 'image/png' || $img_type == 'image/jpeg' || $img_type == 'image/gif' ) {
		// testing if the attachment is an image
			$count_img++;
			$img_class = ( $count_img == 1 ) ? ' current' : '';
			// horizontal slider & thumbnail gallery
			$img_src = wp_get_attachment_image_url($attachment->ID,'large' );
			$thumb_src = wp_get_attachment_image_url($attachment->ID,'h300' );
			$p_imgs_nav_out .= "<a class='project-thumb".$img_class."' href='".$img_src."'><img src='".$thumb_src."' height='150px' alt='Thumbnail' /></a>";
		}
	}
}
if ( $p_imgs_nav_out != '' ) {
	$p_imgs_nav_out = '
		<div id="entry-gallery" class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="slide-wrap">
						<a href="#" class="slide-arrow slide-arrow-left"><i class="fa fa-4x fa-angle-left" aria-hidden="true"></i></a>
						<a href="#" class="slide-arrow slide-arrow-right"><i class="fa fa-4x fa-angle-right" aria-hidden="true"></i></a>
						<div id="project-imgs-nav" class="slides">'.$p_imgs_nav_out.'</div>
					</div>
				</div>
			</div>
		</div>
	';
} else {
	$p_imgs_nav_out = '';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header<?php echo $header_style_out; ?> class="wrap">
		<div class="wrap-inner vspace">
		<div class="container">
			<div id="entry-header" class="row">
				<div class="col-md-11">
				<?php the_title( '<h1 class="pez-bg main-tit">', '</h1>' ); ?>
				<?php if ( get_edit_post_link() )
					edit_post_link('<span class="edit-link">'.esc_html__( 'Edit', '_s' ).'</span>');
				echo $bgi_desc_out; ?>
				</div>
			</div>
		</div>
		</div>
		<?php echo $js_out; ?>
	</header><!-- .entry-header -->

	<?php echo $p_imgs_nav_out; ?>

	<div id="entry-content" class="container">
		<?php if ( $p_imgs_out != '' ) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="slide-wrap">
					<a href="#" class="slide-arrow slide-arrow-left"><i class="fa fa-4x fa-angle-left" aria-hidden="true"></i></a>
					<a href="#" class="slide-arrow slide-arrow-right"><i class="fa fa-4x fa-angle-right" aria-hidden="true"></i></a>
					<?php echo $p_imgs_out; ?>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="row vspace">
		<div class="project-card col-md-2 col-md-offset-2">
		<?php echo $firstline_out.$dates_out.$list_out; ?>
		</div><!-- .col-xx-y -->
		<div class="col-md-6">
		<?php 	echo $p_desc_out;
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', '_s' ),
				'after'  => '</div>',
			) );
		?>
		</div><!-- .col-xx-y -->
		</div><!-- .row -->
	</div><!-- .entry-content -->

</article><!-- #post-## -->
