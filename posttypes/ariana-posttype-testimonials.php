<?php

// Create the post type 'testimonials'
function testimonials_create_post_type() {
	register_post_type(
		'testimonials',//new post type
		array(
			'labels' => array(
				'name' => __( 'Testimonials', 'ariana-widgets' ),
				'singular_name' => __( 'Testimonial', 'ariana-widgets' ),

			),
			'public' => true,/*Post type is intended for public use. This includes on the front end and in wp-admin. */
			'supports' => array('title','editor','thumbnail', 'excerpt', 'page-attributes'),
			'hierarchical' => false,
			'menu_icon' => __( 'dashicons-testimonial', 'ariana-widgets' )
		)
	);
}
add_action( 'init', 'testimonials_create_post_type' );

function testimonials_add_metabox(){
	add_meta_box( 'testimonials-additional-metabox', __( 'Additional Data', 'ariana-widgets' ), 'testimonials_render_metabox', 'testimonials', 'side', 'low' );
}
add_action( 'admin_init', 'testimonials_add_metabox' );

// HTML for the admin area
function testimonials_render_metabox() {
	global $post;
	$urllink = get_post_meta( $post->ID, 'urllink', true );
	$sign = get_post_meta( $post->ID, 'sign', true );

	//validating!
	if ( ! preg_match( "/http(s?):\/\//", $urllink ) && $urllink != "") {
		$errors = __("This URL isn't valid", 'ariana-widgets');
		$urllink = "http://";
	}

	// output invlid url message and add the http:// to the input field
	if( isset($errors) ) { echo $errors; }
?>
<fieldset>
	<p class="post-attributes-label-wrapper">
		<label class="post-attributes-label" for="siteurl">URL</label>
	</p>
	<input id="siteurl" name="siteurl" value="<?php if( isset($urllink) ) { echo $urllink; } ?>" />
	<p class="post-attributes-label-wrapper">
	  <label class="post-attributes-label" for="sign">Sign</label>
	</p>
	<input id="sign" name="sign" value="<?php if(isset($sign)){echo $sign;}?>" />
</fieldset>
<?php
}

//saves custom field data
function testimonials_save_additional_data( $post_id ) {
	global $post;

	// if ( 'testimonials' == $_POST['post_type'] ) ) {}

	if( isset($_POST['siteurl']) ) {
		update_post_meta( $post->ID, 'urllink', sanitize_text_field( $_POST['siteurl'] ) );
	}
	if(isset($_POST['sign'])){
    update_post_meta( $post->ID, 'sign', sanitize_text_field( $_POST['sign'] ) );
  }

}
add_action( 'save_post', 'testimonials_save_additional_data' );

//return URL for a post
function testimonials_get_url($post) {
	$urllink = get_post_meta( $post->ID, 'urllink', true );
	return $urllink;
}

function testimonials_get_sign($post){
  $sign = get_post_meta($post->ID, 'sign', true);
  return $sign;
}

//registering the shortcode to show testimonials
function testimonials_get_html($data){
	$args = array(
		"post_type" => "testimonials",
		"order" => "ASC",
		"orderby" => "menu_order",
		"numberposts" => 3
	);

	if( isset( $data['rand'] ) && $data['rand'] == true ) {
		$args['orderby'] = 'rand';
	}
	if( isset( $data['max'] ) ) {
		$args['numberposts'] = (int) $data['max'];
	}

	//getting all testimonials
	$posts = get_posts($args);

		foreach($posts as $post){
			//getting thumb image
			$url_thumb = wp_get_attachment_thumb_url(get_post_thumbnail_id($post->ID));
			$img_markup = '';
			if (!empty($url_thumb)){
				$img_markup = '<img src="' . $url_thumb . '" alt="' . $post->post_title . '" class="photo">';
			}else{
				$img_markup = $img_markup = '<img src="' . ARIANA_WIDGETS_ASSETS_DIR . 'img/testimonials-default-thumb.png" alt="' . $post->post_title . '" class="photo">';
			}
			$link = testimonials_get_url($post);
			$sign = testimonials_get_sign($post);
			if (! '' == $sign) {$sign = '<p>' . $sign . '</p>';}

			echo '<div class="col-md-4 col-sm-12">';
					echo '<div class="block">';
							echo '<h3><a href="'. $link . '" title="' . $post->post_title . '">' . $post->post_title . '</a></h3>';
							echo '<div class="photo">';
									echo '<a href="'. $link . '" title="' . $post->post_title . '">' . $img_markup . '</a>';
							echo '</div>';
							echo '<p class="content">' . $post->post_excerpt . '</p>';
							// echo '<p class="content">' . $post->post_content . '</p>';
							echo '<div class="sign">';
									echo $sign;
							echo '</div>';
					echo '</div>';
			echo '</div>';

			/*echo '<li>';
				if ( ! empty( $url_thumb ) ) { echo '<img class="post_thumb" src="'.$url_thumb.'" />'; }
				echo '<h2>'.$post->post_title.'</h2>';
				if ( ! empty( $post->post_content ) ) { echo '<p>'.$post->post_content.'<br />'; }
				if ( ! empty( $link ) ) { echo '<a href="'.$link.'">Visit Site</a></p>'; }
			echo '</li>';*/
		}
}
add_shortcode("testimonials","testimonials_get_html");

add_filter('widget_text', 'do_shortcode');


// add_action( 'do_meta_boxes', 'ariana_testimonials_remove_default_custom_fields', 1, 3 );
// function ariana_testimonials_remove_default_custom_fields( $post_type, $context, $post ) {
//   if ( $post_type == 'testimonials' ){
//     remove_meta_box( 'postcustom', $post_type, $context );
//   }
// } custom fields removed from post-type supports
