<?php

class Ariana_Header_Image {

    private $name;
    private $version;

    public function __construct() {

        $this->name = 'ariana_header_image_metabox';
        $this->version = '0.1.0';

    }

    public function run() {

      add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
      add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
      add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
      add_action( 'save_post', array( $this, 'save_post' ) );

    }

    public function add_meta_box() {

        $screens = array( 'post', 'page', 'ariana-services', 'ariana-projects' );

        foreach ( $screens as $screen ) {

          add_meta_box(
          'ariana-header-image-metabox',
          esc_html__( 'Header Image', 'ariana-widgets' ),
          array( $this, 'header_image_metabox' ),
          $screen,
          'side',
          'default' );

        }

    }

    public function enqueue_scripts() {

        wp_enqueue_media();

        wp_enqueue_script(
            $this->name,
            plugin_dir_url( __FILE__ ) . 'ariana-header-image.js',
            array( 'jquery' ),
            $this->version,
            'all'
        );

    }

    public function enqueue_styles() {

        wp_enqueue_style(
            $this->name,
            plugin_dir_url( __FILE__ ) . 'ariana-header-image.css',
            array()
        );

    }

    public function header_image_metabox( $post ) {
        include_once( dirname( __FILE__ ) . '/ariana-header-image-admin.php' );
    }

    public function save_post( $post_id ) {

        if ( isset( $_REQUEST['header-image-src'] ) ) {
            update_post_meta( $post_id, 'post_header_image', sanitize_text_field( $_REQUEST['header-image-src'] ) );
        }

        if ( isset( $_REQUEST['header-image-id'] ) ) {
            update_post_meta( $post_id, 'post_header_image_id', sanitize_text_field( $_REQUEST['header-image-id'] ) );
        }

    }
}


// https://code.tutsplus.com/series/getting-started-with-the-wordpress-media-uploader--cms-666
?>
