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
    'rewrite' => array( 'slug' => 'types' ),
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

/* ---- shortcodes */
add_filter('widget_text', 'do_shortcode');
//registering the shortcode to show testimonials
function ariana_projects_html_shortcode($data){
	$args = array(
		"post_type" => "ariana-projects",
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

	//getting all projects
	$posts = get_posts($args);

		foreach($posts as $post){
			//getting thumb image
			$url_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium' );
			$img_markup = '';
			if (!empty($url_thumb)){
				$img_markup = '<img src="' . $url_thumb[0] . '" alt="' . $post->post_title . '" class="img-responsive">';
			}else{
				$img_markup = '<img src="' . ARIANA_WIDGETS_ASSETS_DIR . 'img/projects-default.png" alt="' . $post->post_title . '" class="img-responsive">';
			}

      if ( $theme_mode == 'carousel' ):
        echo '<div class="item">';
        echo    '<div class="case-studio">';
        echo      '<div class="post-media">';
        echo        '<a href="' . get_the_permalink($post->ID) . '" title="' . esc_attr( $post->post_title ) . '">';
        echo          $img_markup . '</a>';
        echo      '</div><!-- end media -->';
        echo    '</div><!-- end case -->';
        echo  '</div><!-- end item -->';
      else:
        echo '<div class="col-md-3 col-sm-12">';
        echo '<div class="item margin-bottom-xl">';
        echo    '<div class="case-studio">';
        echo      '<div class="post-media">';
        echo        '<a href="' . get_the_permalink($post->ID) . '" title="' . esc_attr( $post->post_title ) . '">';
        echo          $img_markup . '</a>';
        echo      '</div><!-- end media -->';
        echo    '</div><!-- end case -->';
        echo  '</div><!-- end item -->';
        echo '</div><!-- end col -->';
      endif;

		}
}
add_shortcode("ariana_projects","ariana_projects_html_shortcode");

// create technologies HTML shortcodes
function ariana_projects_technologies_imgcol( $img, $title = '' ) {
  $img_url = ARIANA_WIDGETS_ASSETS_DIR . 'img/techs/' . $img;
  $markup =
  '<div class="col-md-2 col-sm-6">' .
      '<div class="tech-wrapper">' .
          '<img src="' . $img_url . '" alt="' . $title . '" title="' . $title . '" class="img-responsive">' .
      '</div>' .
  '</div>';
  return $markup;
}

function ariana_projects_technologies_shortcode( $data ) {

  if( isset( $data['post_id'] ) ) {
		$terms = $terms = get_the_terms( $data['post_id'], 'ariana-technologies', '', ', ', '');
    if ( ! $terms || is_wp_error( $term ) ) {
      return;
    }
	} else {
    global $post;
    $terms = $terms = get_the_terms( $post->ID, 'ariana-technologies', '', ', ', '');
    if ( ! $terms || is_wp_error( $term ) ) {
      return;
    }
  }

  $current = 0;
  $max = 6; // Maximum default
  if( isset( $data['max'] ) ) {
		$max = (int) $data['max'];
	}

  if( isset( $data['section'] ) ) {
		$add_section = $data['section'];
	}

  $html = '';

  if ( $add_section ) {
    $html .=
      '<section class="section lb">' .
          '<div class="container">' .
              '<div class="row">' .
                  '<div class="col-md-12 col-sm-12">' .
                      '<div class="section-title text-center">' .
                          '<h5>WHAT TECHNOLOGIES WE USED IN THIS PROJECT</h5>' .
                          '<h3>USED TECHNOLOGIES</h3>' .
                          '<hr>' .
                      '</div><!-- end title -->' .

                      '<div class="text-widget">' .
                          '<div class="row technologies">';
  }

  foreach ( $terms as $term ) {

      if ( ++$current <= $max ):

        $term_name = strtolower( $term->name );

        switch ( $term_name ) {
          case 'android':
              $html .= ariana_projects_technologies_imgcol( 'android.png', 'Android' );
              break;

          case 'angular':
          case 'angularjs':
          case 'angular-js':
              $html .= ariana_projects_technologies_imgcol( 'angular.png', 'AngularJS' );
              break;

          case 'asp':
          case 'asp.net':
              $html .= ariana_projects_technologies_imgcol( 'asp.png', 'ASP.NET' );
              break;

          case 'bbpress':
              $html .= ariana_projects_technologies_imgcol( 'bbpress.png', 'bbPress' );
              break;

          case 'bootstrap':
              $html .= ariana_projects_technologies_imgcol( 'bootstrap.png', 'Bootstrap' );
              break;

          case 'css':
          case 'css3':
            $html .= ariana_projects_technologies_imgcol( 'css.png', 'CSS3' );
            break;

          case 'drupal':
            $html .= ariana_projects_technologies_imgcol( 'drupal.png', 'Drupal' );
            break;

          case 'html':
          case 'html5':
          case 'xhtml':
            $html .= ariana_projects_technologies_imgcol( 'html.png', 'HTML5' );
            break;

          case 'java':
            $html .= ariana_projects_technologies_imgcol( 'java.png', 'Java' );
            break;

          case 'joomla':
            $html .= ariana_projects_technologies_imgcol( 'joomla.png', 'Joomla' );
            break;

          case 'jquery':
              $html .= ariana_projects_technologies_imgcol( 'jquery.png', 'JQuery' );
              break;

          case 'js':
          case 'javascript':
            $html .= ariana_projects_technologies_imgcol( 'js.png', 'Javascript' );
            break;

          case 'less':
            $html .= ariana_projects_technologies_imgcol( 'less.png', 'less' );
            break;

          case 'ms':
          case 'microsoft':
            $html .= ariana_projects_technologies_imgcol( 'microsoft.png', 'Microsoft' );
            break;

          case 'mysql':
          case 'my-sql':
            $html .= ariana_projects_technologies_imgcol( 'mysql.png', 'MySQL' );
            break;

          case 'node':
          case 'nodejs':
          case 'node.js':
          case 'node-js':
          case 'node js':
            $html .= ariana_projects_technologies_imgcol( 'node.png', 'Node.js' );
            break;

          case 'paypal':
          case 'pay-pal':
          case 'pay pal':
            $html .= ariana_projects_technologies_imgcol( 'paypal.png', 'PayPal' );
            break;

          case 'php':
          case 'php5':
          case 'php7':
              $html .= ariana_projects_technologies_imgcol( 'php_3.png', 'php' );
              break;

          case 'ruby':
            $html .= ariana_projects_technologies_imgcol( 'ruby.png', 'Ruby' );
            break;

          case 'sass':
            $html .= ariana_projects_technologies_imgcol( 'sass.png', 'sass' );
            break;

          case 'mssql':
          case 'sql':
            $html .= ariana_projects_technologies_imgcol( 'sql.png', 'MS SQL Server' );
            break;

          case 'themeforest':
            $html .= ariana_projects_technologies_imgcol( 'themeforest.png', 'ThemeForest' );
            break;

          case 'woocommerce':
          case 'woo':
              $html .= ariana_projects_technologies_imgcol( 'woocommerce.png', 'WooCommerce' );
              break;

          case 'wp':
          case 'wordpress':
            $html .= ariana_projects_technologies_imgcol( 'wordpress.png', 'WordPress' );
            break;

          default:
              $html .= ariana_projects_technologies_imgcol( 'default.png' );
              break;

        }

      else:
        break;
      endif;
  }

  if ( $add_section ) {
    $html .=
                '</div>' .
            '</div><!-- end text-widget -->' .
          '</div><!-- end col -->' .
        '</div><!-- end row -->' .
      '</div><!-- end container -->' .
    '</section>';
  }

  echo $html;
}
add_shortcode("ariana_projects_techs","ariana_projects_technologies_shortcode");
