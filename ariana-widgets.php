<?php
/*
Plugin Name: Ariana widgets
Description: Necessary widgets for ariana themes
Version: 0.1
Author: Ariana Digital Agency
License: GNU
Author: 				Ariana Digital Agency
Author URI: 			http://keihanserver.com/
Text Domain: 			ariana-widgets
Domain Path: 			/languages
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'ARIANA_WIDGETS', '2.1.2' );
define( 'ARIANA_WIDGETS_ASSETS_DIR', plugins_url( '/assets/', __FILE__ ) );

// Load Text Domain
load_plugin_textdomain( 'ariana-widgets', false, basename( dirname( __FILE__ ) ) . '/languages' );


$current_theme  = wp_get_theme();
$current_parent = $current_theme->parent();

if ( 'Ariana Digital Agency' == $current_theme->get( 'Author' ) || ( $current_parent && 'Ariana Digital Agency' == $current_parent->get( 'Author' ) ) ) {

	require_once plugin_dir_path( __FILE__ ) . 'ariana-fontawesome.php';

	// require_once plugin_dir_path( __FILE__ ) . 'widgets/ariana-widget-archive.php';
	require_once plugin_dir_path( __FILE__ ) . 'widgets/ariana-widget-category.php';
	require_once plugin_dir_path( __FILE__ ) . 'widgets/ariana-widget-feature.php';
  require_once plugin_dir_path( __FILE__ ) . 'widgets/ariana-widget-nav-menu.php';
  require_once plugin_dir_path( __FILE__ ) . 'widgets/ariana-widget-recent-post.php';
	// require_once plugin_dir_path( __FILE__ ) . 'widgets/ariana-widget-tag-cloud.php';
  require_once plugin_dir_path( __FILE__ ) . 'widgets/ariana-widget-text.php';

	require_once plugin_dir_path( __FILE__ ) . 'posttypes/ariana-posttype-testimonials.php';
	require_once plugin_dir_path( __FILE__ ) . 'posttypes/ariana-posttype-services.php';
	require_once plugin_dir_path( __FILE__ ) . 'posttypes/ariana-posttype-projects.php';

} else {

	add_action( 'admin_notices', 'ariana_widgets_admin_notice', 99 );
	function ariana_widgets_admin_notice() {
	?>
		<div class="notice-warning notice">
			<p><?php _e('"Ariana Widgets" Plugin is useless if you don\'t use one of the ariana themes.', 'ariana-widgets'); ?></p>
		</div>
		<?php
	}
}


if ( ! function_exists( 'ariana_widgets_admin_scripts' ) ) {

	function ariana_widgets_admin_scripts( $hook_suffix ) {

		wp_enqueue_style( 'ariana-widgets-admin-css', plugins_url( '/assets/css/admin.css', __FILE__ ) );
		wp_register_style( 'font-awesome', plugins_url( '/assets/css/font-awesome.min.css', __FILE__ ), array(), '4.5.0', 'all' );
		wp_register_style( 'iconpicker-css', plugins_url( '/assets/css/jquery.fonticonpicker.css', __FILE__ ) );
		wp_register_style( 'iconpicker-theme-css', plugins_url( '/assets/css/jquery.fonticonpicker.grey.min.css', __FILE__ ) );
		wp_register_script( 'iconpicker-js', plugins_url( '/assets/js/iconpicker.min.js', __FILE__ ), array( 'jquery' ) );
		// wp_enqueue_script( 'ariana-widgets-admin-js', plugins_url( '/assets/js/admin.js', __FILE__ ), array( 'jquery' ) );

		// wp_localize_script(
		// 	'ariana-widgets-admin-js', 'arianaWidgets', array(
		// 		'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
		// 	)
		// );

		if ( 'widgets.php' == $hook_suffix ) {
			wp_register_script( 'ariana-widget-text-editor-js', ARIANA_WIDGETS_ASSETS_DIR . 'js/widget-text-editor.js', false, '1.0', true );
		}

	}

	add_action( 'admin_enqueue_scripts', 'ariana_widgets_admin_scripts' );

}
