<?php

function ariana_projects_init(){
  ariana_projects_create_post_type();
  ariana_portfolio_create_taxonomis();
}
add_action( 'init', 'ariana_projects_init' );

function ariana_projects_create_post_type() {
  $posttype_labels = array(
    'name' => __( 'Projects', 'ariana-widgets' ),
    'singular_name' => __( 'Project', 'ariana-widgets' ),
    'add_new' => __( 'Add New Project', 'ariana-widgets' ),
    'add_new_item' => __( 'Add New Project', 'ariana-widgets' ),
    'edit_item' => __( 'Edit Project', 'ariana-widgets' ),
    'new_item' => __( 'New Project', 'ariana-widgets' ),
    'view_item' => __( 'View Project', 'ariana-widgets' ),
    'view_items' => __( 'View Portfolio', 'ariana-widgets' ),
    'search_items' => __( 'Search Projects', 'ariana-widgets' ),
    'not_found' => __( 'No Project Found', 'ariana-widgets' ),
    'not_found_in_trash' => __( 'No projects found in trash', 'ariana-widgets' ),
    'parent_item_colon' => '',
    'all_items' => __( 'All Projects', 'ariana-widgets' ),
  );
	register_post_type(
		'ariana-projects', //new post type
		array(
			'labels'         => $posttype_labels,
			'public'         => true,/*Post type is intended for public use. This includes on the front end and in wp-admin. */
			'supports'       => array('title','editor','thumbnail', 'excerpt', 'page-attributes'),
      'show_in_rest'   => true,//added to use gutenberg instead of classic editor
			'hierarchical'   => false,
      'has_archive'    => true,
      'rewrite'        => array( 'slug' => 'projects'),
      'menu_icon'      => __( 'dashicons-portfolio', 'ariana-widgets' )
		)
	);
}

function ariana_portfolio_create_taxonomis() {
  $portfolio_taxonomy_labels = array(
    'name'                       => __( 'Portfolios', 'ariana-widgets' ),
    'singular_name'              => __( 'Portfolio', 'ariana-widgets' ),
    'search_items'               => __( 'Search Portfolios', 'ariana-widgets' ),
		'popular_items'              => __( 'Popular Portfolios', 'ariana-widgets' ),
		'all_items'                  => __( 'All Portfolios', 'ariana-widgets' ),
		// 'parent_item'                => null,
		// 'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Portfolio', 'ariana-widgets' ),
		'update_item'                => __( 'Update Portfolio', 'ariana-widgets' ),
		'add_new_item'               => __( 'Add New Portfolio', 'ariana-widgets' ),
		'new_item_name'              => __( 'New Portfolio Name', 'ariana-widgets' ),
		'separate_items_with_commas' => __( 'Separate portfolios with commas', 'ariana-widgets' ),
		'add_or_remove_items'        => __( 'Add or remove portfolio', 'ariana-widgets' ),
		'choose_from_most_used'      => __( 'Choose from the most used portfolios', 'ariana-widgets' ),
		'not_found'                  => __( 'No portfolios found.', 'ariana-widgets' ),
		// 'menu_name'                  => __( 'Writers', 'ariana-widgets' ),
  );
  register_taxonomy( 'ariana-portfolio', 'ariana-projects', array(
    'labels'        => $portfolio_taxonomy_labels,
    'public'        => true,
    'hierarchical'  => true,
    'show_in_rest'   => true,//show this tax in block editor
    'rewrite'       => array( 'slug' => 'portfolio' ),
  ) );

  $project_types_taxonomy_labels = array(
    'name'                       => __( 'Project Type Tags', 'ariana-widgets' ),
    'singular_name'              => __( 'Project Type Tag', 'ariana-widgets' ),
    'search_items'               => __( 'Search Type Tags', 'ariana-widgets' ),
		'popular_items'              => __( 'Popular Type Tags', 'ariana-widgets' ),
		'all_items'                  => __( 'All Type Tags', 'ariana-widgets' ),
		// 'parent_item'                => null,
		// 'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Type Tag', 'ariana-widgets' ),
		'update_item'                => __( 'Update Type Tag', 'ariana-widgets' ),
		'add_new_item'               => __( 'Add New Type Tag', 'ariana-widgets' ),
		'new_item_name'              => __( 'New type tag Name', 'ariana-widgets' ),
		'separate_items_with_commas' => __( 'Separate type tags with commas', 'ariana-widgets' ),
		'add_or_remove_items'        => __( 'Add or remove type tags', 'ariana-widgets' ),
		'choose_from_most_used'      => __( 'Choose from the most used type tags', 'ariana-widgets' ),
		'not_found'                  => __( 'No type tags found.', 'ariana-widgets' ),
		// 'menu_name'                  => __( 'Type Tags', 'ariana-widgets' ),
  );
  register_taxonomy( 'ariana-type-tags', 'ariana-projects', array(
    'labels' => $project_types_taxonomy_labels,
    'public' => true,
    'hierarchical' => false,
    'show_in_rest'   => true,//show this tax in block editor
    'rewrite' => array( 'slug' => 'project-tags' ),
  ) );

  $project_technology_taxonomy_labels = array(
    'name'                       => __( 'Technologies', 'ariana-widgets' ),
    'singular_name'              => __( 'Technology', 'ariana-widgets' ),
    'search_items'               => __( 'Search Technologies', 'ariana-widgets' ),
		'popular_items'              => __( 'Popular Technologies', 'ariana-widgets' ),
		'all_items'                  => __( 'All Technologies', 'ariana-widgets' ),
		// 'parent_item'                => null,
		// 'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Technology', 'ariana-widgets' ),
		'update_item'                => __( 'Update Technology', 'ariana-widgets' ),
		'add_new_item'               => __( 'Add New Technology', 'ariana-widgets' ),
		'new_item_name'              => __( 'New Technology Name', 'ariana-widgets' ),
		'separate_items_with_commas' => __( 'Separate technologies with commas', 'ariana-widgets' ),
		'add_or_remove_items'        => __( 'Add or remove technologies', 'ariana-widgets' ),
		'choose_from_most_used'      => __( 'Choose from the most used technologies', 'ariana-widgets' ),
		'not_found'                  => __( 'No technologies found.', 'ariana-widgets' ),
		// 'menu_name'                  => __( 'Type Tags', 'ariana-widgets' ),
  );
  register_taxonomy( 'ariana-technologies', 'ariana-projects', array(
    'labels' => $project_technology_taxonomy_labels,
    'public' => true,
    'hierarchical' => false,
    'show_in_rest'   => true,//show this tax in block editor
    'rewrite' => array( 'slug' => 'technologies' ),
  ) );
}

function ariana_projects_add_meta_box() {

  add_meta_box(
    'projects-additional-meta-box2',
    esc_html__( 'Project Data', 'ariana-widgets' ),
    'projects_render_meta_box',
    'ariana-projects',
    'normal',
    'high' );
}
add_action( 'add_meta_boxes_ariana-projects', 'ariana_projects_add_meta_box' );

function projects_render_meta_box( $post_id, $post ) {
  $fields = isset( $post->ID ) ? get_post_custom( $post->ID ) : '';
  $client = isset( $fields['project_client'] ) ? esc_attr( $fields['project_client'][0] ) : '';
  $url = isset( $fields['project_url'] ) ? esc_attr( $fields['project_url'][0] ) : '';
  $pub_date = isset( $fields['project_publish_date'] ) ? esc_attr( $fields['project_publish_date'][0] ) : '';
  $post_desc = isset( $fields['post_desc'] ) ? esc_attr( $fields['post_desc'][0] ) : '';

  ?>
  <fieldset>
    <?php wp_nonce_field( 'ariana_projects_metabox_nonce', '_ariana_projects_metabox_nonce'); ?>

    <p class="post-attributes-label-wrapper">
  		<label class="post-attributes-label" for="project-client"><?php _e( 'Client', 'ariana-widgets' ); ?></label>
  	</p>
    <input id="project-client" name="project-client" value="<?php echo $client; ?>" />

    <p class="post-attributes-label-wrapper">
  		<label class="post-attributes-label" for="project-url"><?php _e( 'Launch URL', 'ariana-widgets' ); ?></label>
  	</p>
    <input id="project-url" name="project-url" class="widefat" value="<?php echo $url; ?>" />

    <p class="post-attributes-label-wrapper">
  		<label class="post-attributes-label" for="project-pub-date"><?php _e( 'Publish Date', 'ariana-widgets' ); ?></label>
  	</p>
    <input id="project-pub-date" name="project-pub-date" value="<?php echo $pub_date; ?>" placeholder="mm/dd/yyyy" />

    <p class="post-attributes-label-wrapper">
  		<label class="post-attributes-label" for="post-desc"><?php _e( 'Description', 'ariana-widgets' ); ?></label> <small><?php /* translators: text in front of Discription field label in admin */ _e( 'Single Page sub title', 'ariana-widgets' ); ?></small>
  	</p>
    <textarea id="post-desc" name="post-desc" rows="1" cols="40" class="widefat"><?php echo $post_desc; ?></textarea>
  </fieldset>
  <?php
}

function ariana_save_projects_metabox( $post_id ) {
    // Add nonce for security and authentication.
    $nonce_name   = isset( $_POST['_ariana_projects_metabox_nonce'] ) ? $_POST['_ariana_projects_metabox_nonce'] : '';
    $nonce_action = 'ariana_projects_metabox_nonce';

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


    if ( isset( $_POST['project-client'] ) ){
      update_post_meta(
        $post_id,
        'project_client',
        wp_kses( $_POST['project-client'], $allowed_tags )
      );
    }

    if ( isset( $_POST['project-url'] ) ){
      update_post_meta(
        $post_id,
        'project_url',
        sanitize_text_field( $_POST['project-url'] )
      );
    }

    if ( isset( $_POST['project-pub-date'] ) ){ //and not empty
      update_post_meta(
        $post_id,
        'project_publish_date',
        sanitize_text_field( $_POST['project-pub-date'] )
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
add_action( 'save_post', 'ariana_save_projects_metabox' );

// add_action( 'do_meta_boxes', 'ariana_projects_remove_default_custom_fields', 1, 3 );
// function ariana_projects_remove_default_custom_fields( $post_type, $context, $post ) {
//   if ( $post_type == 'ariana-projects' ){
//     remove_meta_box( 'postcustom', $post_type, $context );
//   }
// } custom fields removed from post-type supports
