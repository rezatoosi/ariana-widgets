<?php

function ariana_services_create_post_type() {
	register_post_type(
		'ariana-services',//new post type
		array(
			'labels' => array(
				'name' => __( 'Services', 'ariana-widgets' ),
				'singular_name' => __( 'Service', 'ariana-widgets' ),
				'add_new' => __( 'Add New Service', 'ariana-widgets' ),
				'add_new_item' => __( 'Add New Service', 'ariana-widgets' ),
				'edit_item' => __( 'Edit Service', 'ariana-widgets' ),
		    'new_item' => __( 'New Service', 'ariana-widgets' ),
		    'view_item' => __( 'View Service', 'ariana-widgets' ),
		    'view_items' => __( 'View Services', 'ariana-widgets' ),
		    'search_items' => __( 'Search Services', 'ariana-widgets' ),
		    'not_found' => __( 'No Service(s) Found', 'ariana-widgets' ),
		    'not_found_in_trash' => __( 'No Service(s) found in trash', 'ariana-widgets' ),
		    'parent_item_colon' => '',
		    'all_items' => __( 'All Services', 'ariana-widgets' ),
			),
			'public' => true,/*Post type is intended for public use. This includes on the front end and in wp-admin. */
			'supports' => array('title','editor','thumbnail', 'excerpt', 'page-attributes'),
			'show_in_rest' => true, //added to use gutenberg instead of classic editor
			'hierarchical' => False,
			'has_archive'  => true,
      'rewrite' => array( 'slug' => 'services'),
			'menu_icon' => __( 'dashicons-awards', 'ariana-widgets' )
		)
	);
}
add_action( 'init', 'ariana_services_create_post_type' );

function ariana_services_create_tags_tax() {
	$services_tags_taxonomy_labels = array(
		'name'                       => __( 'Services Tags', 'ariana-widgets' ),
		'singular_name'              => __( 'Service Tag', 'ariana-widgets' ),
		'search_items'               => __( 'Search Tags', 'ariana-widgets' ),
		'popular_items'              => __( 'Popular Tags', 'ariana-widgets' ),
		'all_items'                  => __( 'All Tags', 'ariana-widgets' ),
		// 'parent_item'                => null,
		// 'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Tag', 'ariana-widgets' ),
		'update_item'                => __( 'Update Tag', 'ariana-widgets' ),
		'add_new_item'               => __( 'Add New Tag', 'ariana-widgets' ),
		'new_item_name'              => __( 'New tag Name', 'ariana-widgets' ),
		'separate_items_with_commas' => __( 'Separate tags with commas', 'ariana-widgets' ),
		'add_or_remove_items'        => __( 'Add or remove tags', 'ariana-widgets' ),
		'choose_from_most_used'      => __( 'Choose from the most used tags', 'ariana-widgets' ),
		'not_found'                  => __( 'No tag found.', 'ariana-widgets' ),
		// 'menu_name'                  => __( 'Type Tags', 'ariana-widgets' ),
	);
	register_taxonomy( 'ariana-services-tags', 'ariana-services', array(
		'labels' => $services_tags_taxonomy_labels,
		'public' => true,
		'hierarchical' => false,
		'show_in_rest'   => true,//show this tax in block editor
		'rewrite' => array( 'slug' => 'services-tags' ),
	) );
}
add_action( 'init', 'ariana_services_create_tags_tax' );

function ariana_services_add_meta_box() {

  add_meta_box(
    'services-additional-meta-box2',
    esc_html__( 'Services Data', 'ariana-widgets' ),
    'services_render_meta_box',
    'ariana-services',
    'normal',
    'high' );

}
add_action( 'add_meta_boxes_ariana-services', 'ariana_services_add_meta_box' );

function services_render_meta_box( $post ) {
  $fields = isset( $post->ID ) ? get_post_custom( $post->ID ) : '';
  $post_sec_title = isset( $fields['post_sec_title'] ) ? esc_attr( $fields['post_sec_title'][0] ) : '';
	$post_home_subtitle = isset( $fields['post_home_subtitle'] ) ? esc_attr( $fields['post_home_subtitle'][0] ) : '';
  $post_desc = isset( $fields['post_desc'] ) ? esc_attr( $fields['post_desc'][0] ) : '';

  ?>
  <fieldset>
    <?php wp_nonce_field( 'ariana_services_metabox_nonce', '_ariana_services_metabox_nonce'); ?>

    <p class="post-attributes-label-wrapper">
  		<label class="post-attributes-label" for="post-sec-title"><?php _e( 'Second title', 'ariana-widgets' ); ?></label>  <small><?php /* translators: text in front of second title field label in admin */ _e( 'Single Page second title', 'ariana-widgets' ); ?></small>
  	</p>
    <input id="post-sec-title" name="post-sec-title" class="widefat" value="<?php echo $post_sec_title; ?>" />

		<p class="post-attributes-label-wrapper">
  		<label class="post-attributes-label" for="post-home-subtitle"><?php _e( 'Homepage Subtitle', 'ariana-widgets' ); ?></label>  <small><?php /* translators: text in front of Homepage subtitle field label in admin */ _e( 'Home Page subtitle', 'ariana-widgets' ); ?></small>
  	</p>
    <input id="post-home-subtitle" name="post-home-subtitle" class="widefat" value="<?php echo $post_home_subtitle; ?>" />

    <p class="post-attributes-label-wrapper">
  		<label class="post-attributes-label" for="post-desc"><?php _e( 'Description', 'ariana-widgets' ); ?></label> <small><?php /* translators: text in front of Discription field label in admin */ _e( 'Single Page sub title', 'ariana-widgets' ); ?></small>
  	</p>
    <textarea id="post-desc" name="post-desc" rows="1" cols="40" class="widefat"><?php echo $post_desc; ?></textarea>
  </fieldset>
  <?php
}

function ariana_save_services_metabox( $post_id ) {
    // Add nonce for security and authentication.
    $nonce_name   = isset( $_POST['_ariana_services_metabox_nonce'] ) ? $_POST['_ariana_services_metabox_nonce'] : '';
    $nonce_action = 'ariana_services_metabox_nonce';

    // Check if nonce is valid.
    if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
        return;
    }

    // Check if user has permissions to save data.
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Check if not an autosave.
    if ( wp_is_post_autosave( $post_id ) ) {
        return;
    }

    // Check if not a revision.
    if ( wp_is_post_revision( $post_id ) ) {
        return;
    }

    $allowed_tags = array(
        'a' => array(
            'href' => array(),
            'title' => array(),
            'id' => array()
        )
    );


    if ( isset( $_POST['post-sec-title'] ) ){
      update_post_meta(
        $post_id,
        'post_sec_title',
        wp_kses( $_POST['post-sec-title'], $allowed_tags )
      );
    }

		if ( isset( $_POST['post-home-subtitle'] ) ){
      update_post_meta(
        $post_id,
        'post_home_subtitle',
        wp_kses( $_POST['post-home-subtitle'], $allowed_tags )
      );
    }

    if ( isset( $_POST['post-desc'] ) ){
      update_post_meta(
        $post_id,
        'post_desc',
        wp_kses_post( $_POST['post-desc'] )
      );
    }

}
add_action( 'save_post', 'ariana_save_services_metabox' );

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
      elseif ( $theme_mode == 'homebox' ):
				$post_home_subtitle = get_post_meta( $post->ID, 'post_home_subtitle', true );
				echo '<div class="col-md-3 col-sm-12">';
				echo 		'<div class="item mb-30">';
        echo    	'<div class="item-image">';
				echo 				'<a href="' . get_the_permalink($post->ID) . '" title="' . $post->post_title . '">';
        echo      		$img_markup;
				echo 				'</a>';
        echo    	'</div><!-- end item-image -->';
        echo    	'<div class="item-desc">';
        echo      	'<h4><a href="' . get_the_permalink($post->ID) . '" title="' . $post->post_title . '">' . $post->post_title . '</a></h4>';
        echo      	( $post_home_subtitle != '' ) ? '<p>' . $post_home_subtitle . '</p>' : '';
        echo    	'</div><!-- end item-desc -->';
        echo 		'</div><!-- end item -->';
				echo '</div><!-- end col -->';
			else:
				$post_home_subtitle = get_post_meta( $post->ID, 'post_home_subtitle', true );
        echo '<div class="col-md-3 col-sm-6">';
        echo    '<div class="item">';
        echo        '<div class="item-image">';
        echo            $img_markup;
        echo            '<span class="item-icon"><a href="' . get_the_permalink( $post->ID ) . '"><i class="fa fa-link"></i></a></span>';
        echo        '</div><!-- end item-image -->';
        echo        '<div class="item-desc text-center">';
        echo            '<h4><a href="' . get_the_permalink( $post->ID ) . '" title="' . $post->post_title . '">' . $post->post_title . '</a></h4>';
        echo            ( $post_home_subtitle != '' ) ? '<h5><a href="' . get_the_permalink( $post->ID ) . '" title="' . $post->post_title . '">' . $post_home_subtitle . '</a></h5>' : '';
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
