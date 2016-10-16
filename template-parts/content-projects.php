<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

$header_text_class = "col-md-9";
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
	$bgi_src = wp_get_attachment_url($bgi_id);
	$bgi_meta = wp_get_attachment_metadata($bgi_id);
	$header_style_out .= "background-image: url('".$bgi_src."'); background-size: cover;";
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
	default:
		if ( $value != '' ) $firstline[] = $value;
		break;
	}
}
$firstline_out = ( is_array($firstline) ) ? '<div class="project-card-firstline">'.join(', ',$firstline).'</div>' : '';
$list_out = ( $list_out != '' ) ? '<dl>'.$list_out.'</dl>' : '';

// PROJECT IMAGES
$args = array(
	'post_type' => 'attachment',
	'nopaging' => true,
	'post_status' => null,
	'post_parent' => $post->ID,
//	'orderby' => 'menu_order',
//	'order' => 'ASC'
);
$attachments = get_posts($args);
$p_imgs_out = '';
$count_img = 0;
if ( $attachments ) {
	foreach ( $attachments as $attachment ) {
		$img_type = $attachment->post_mime_type;
		if ( $img_type == 'image/png' || $img_type == 'image/jpeg' || $img_type == 'image/gif' ) {
		// testing if the attachment is an image
			$count_img++;
			$img_class = ( $count_img == 1 ) ? ' class="current"' : '';
			$img_vars = wp_get_attachment_image_src($attachment->ID,'big' );
			//array_push($p_imgs, "<img src='{$img_vars[0]}' width='{$img_vars[1]}' height='{$img_vars[2]}' />");
			$p_imgs_out .= "<img".$img_class." src='{$img_vars[0]}' height='300px' />";
		}
	}
}
$p_imgs_out = ( $p_imgs_out != '' ) ? '<div class="slides">'.$p_imgs_out.'</div>' : ''
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header<?php echo $header_style_out; ?> class="wrap">
		<div class="wrap-inner vspace">
		<div class="container">
		<div id="entry-header" class="row">
		<div class="<?php echo $header_text_class; ?>">
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

	<div id="entry-content" class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="slide-wrap">
					<a href="#" class="slide-arrow slide-arrow-left"><i class="fa fa-4x fa-angle-left" aria-hidden="true"></i></a>
					<a href="#" class="slide-arrow slide-arrow-right"><i class="fa fa-4x fa-angle-right" aria-hidden="true"></i></a>
					<?php echo $p_imgs_out; ?>
				</div>
			</div>
		</div>
		<div class="row vspace">
		<div class="project-card col-md-2 col-md-offset-2">
		<?php echo $firstline_out.$list_out; ?>
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
