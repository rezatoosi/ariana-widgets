<?php

function ariana_services_create_post_type() {
	register_post_type(
		'ariana-services',//new post type
		array(
			'labels' => array(
				'name' => __( 'Services', 'ariana-widgets' ),
				'singular_name' => __( 'Service', 'ariana-widgets' )
			),
			'public' => true,/*Post type is intended for public use. This includes on the front end and in wp-admin. */
			'supports' => array('title','editor','thumbnail','custom-fields', 'excerpt', 'page-attributes'),
			'hierarchical' => False,
      'rewrite' => array( 'slug' => 'services'),
			'menu_icon' => __( 'dashicons-awards', 'ariana-widgets' )
		)
	);
}
add_action( 'init', 'ariana_services_create_post_type' );

//registering the shortcode to show testimonials
function ariana_services_get_html($data){
	$args = array(
		"post_type" => "ariana-services",
		"order" => "ASC",
		"orderby" => "menu_order",
		"numberposts" => -1
	);

	if( isset( $data['rand'] ) && $data['rand'] == true ) {
		$args['orderby'] = 'rand';
	}
	if( isset( $data['max'] ) ) {
		$args['numberposts'] = (int) $data['max'];
	}
  if( isset( $data['mode'] ) ) {
		$theme_mode = $data['mode'];
	}else{
    $theme_mode = 'default';
  }

	//getting all testimonials
	$posts = get_posts($args);

		foreach($posts as $post){
			//getting thumb image
			$url_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium');
			$img_markup = '';
			if (!empty($url_thumb)){
				$img_markup = '<img src="' . $url_thumb[0] . '" alt="' . $post->post_title . '" class="img-responsive">';
			}else{
				$img_markup = '<img src="' . ARIANA_WIDGETS_ASSETS_DIR . 'img/post-default.png" alt="' . $post->post_title . '" class="img-responsive">';
			}

      if ( $theme_mode == 'carousel' ):
        echo '<div class="item">';
        echo    '<div class="item-image">';
        echo      $img_markup;
        echo    '</div><!-- end item-image -->';
        echo    '<div class="item-desc">';
        echo      '<h4><a href="' . get_the_permalink($post->ID) . '" title="' . $post->post_title . '">' . $post->post_title . '</a></h4>';
        // echo      '<p>Starting from $50.00</p>';
        echo    '</div><!-- end item-desc -->';
        echo '</div><!-- end item -->';
      else:
        echo '<div class="col-md-4 col-sm-12">';
        echo    '<div class="item">';
        echo        '<div class="item-image">';
        echo            $img_markup;
        echo            '<span class="item-icon"><a href="' . get_the_permalink( $post->ID ) . '"><i class="fa fa-link"></i></a></span>';
        echo        '</div><!-- end item-image -->';
        echo        '<div class="item-desc">';
        echo            '<h4><a href="' . get_the_permalink( $post->ID ) . '" title="' . $post->post_title . '">' . $post->post_title . '</a></h4>';
        // echo            '<h5>STARTING FROM $10.00</h5>';
        // echo            '<p>' . $post->post_excerpt . '</p>';
        echo        '</div><!-- end service-desc -->';
        echo    '</div><!-- end seo-item -->';
        echo '</div><!-- end col -->';
      endif;

		}
}
add_shortcode("ariana_services","ariana_services_get_html");
add_filter('widget_text', 'do_shortcode');

/* Filtering the single_template */
add_filter('single_template', 'ariana_services_single_template_load');
function ariana_services_single_template_load($template) {
    global $post;

    if ( $post->post_type == 'ariana-services' && $template !== locate_template(array("single-ariana-services.php")) ) {
        if ( file_exists( plugin_dir_path( __FILE__ ) . 'ariana-posttype-services-template.php' ) ) {
            return plugin_dir_path( __FILE__ ) . 'ariana-posttype-services-template.php';
        }
    }

    return $template;

}
