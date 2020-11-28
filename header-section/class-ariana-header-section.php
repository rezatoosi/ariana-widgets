<?php
/*
**  Add a class to show a meta box in post types:
**  Meta box for get data about page header section
*/

class Ariana_Header_Section {

  private $name;
  private $version;

  public function __construct() {

      $this->name = 'ariana_header_section_metabox';
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
        'ariana-header-section-metabox',
        esc_html__( 'Header Section', 'ariana-widgets' ),
        array( $this, 'header_section_metabox' ),
        $screen,
        'normal',
        'default' );

      }

  }

  public function enqueue_scripts() {

      wp_enqueue_media();

      wp_enqueue_script(
          $this->name,
          plugin_dir_url( __FILE__ ) . 'ariana-header-section.js',
          array( 'jquery' ),
          $this->version,
          'all'
      );

  }

  public function enqueue_styles() {

      wp_enqueue_style(
          $this->name,
          plugin_dir_url( __FILE__ ) . 'ariana-header-section.css',
          array()
      );

  }

  public function header_section_metabox( $post ) {
      include_once( dirname( __FILE__ ) . '/ariana-header-section-admin.php' );
  }

  public function save_post( $post_id ) {
    $req_perfix = 'header-section-';
    $db_perfix = 'post_header_section_';

    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['_ariana_header_section_metabox_nonce'] ) || !wp_verify_nonce( $_POST['_ariana_header_section_metabox_nonce'], 'ariana_header_section_metabox_nonce' ) ) return;

    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;

    update_post_meta( $post_id, $db_perfix . 'is_active', ( isset( $_REQUEST[ $req_perfix . 'is-active' ] ) && ( $_REQUEST[ $req_perfix . 'is-active' ] ) ) ? 'on' : 'off' );
    update_post_meta( $post_id, $db_perfix . 'breadcrumb', ( isset( $_REQUEST[ $req_perfix . 'breadcrumb' ] ) && ( $_REQUEST[ $req_perfix . 'breadcrumb' ] ) ) ? 'on' : 'off' );

    if ( isset( $_REQUEST[ $req_perfix . 'title' ] ) ) {
        update_post_meta( $post_id, $db_perfix . 'title', sanitize_text_field( $_REQUEST[ $req_perfix . 'title' ] ) );
    }
    if ( isset( $_REQUEST[ $req_perfix . 'subtitle' ] ) ) {
        update_post_meta( $post_id, $db_perfix . 'subtitle', sanitize_text_field( $_REQUEST[ $req_perfix . 'subtitle' ] ) );
    }
    if ( isset( $_REQUEST[ $req_perfix . 'desc' ] ) ) {
        update_post_meta( $post_id, $db_perfix . 'desc', ( $_REQUEST[ $req_perfix . 'desc' ] ) );
    }
    if ( isset( $_REQUEST[ $req_perfix . 'image-src' ] ) ) {
        update_post_meta( $post_id, $db_perfix . 'image_src', sanitize_url( $_REQUEST[ $req_perfix . 'image-src' ] ) );
    }
    if ( isset( $_REQUEST[ $req_perfix . 'image-id' ] ) ) {
        update_post_meta( $post_id, $db_perfix . 'image_id', sanitize_text_field( $_REQUEST[ $req_perfix . 'image-id' ] ) );
    }
    if ( isset( $_REQUEST[ $req_perfix . 'bg-image-src' ] ) ) {
        update_post_meta( $post_id, $db_perfix . 'bg_image_src', sanitize_url( $_REQUEST[ $req_perfix . 'bg-image-src' ] ) );
    }
    if ( isset( $_REQUEST[ $req_perfix . 'bg-image-id' ] ) ) {
        update_post_meta( $post_id, $db_perfix . 'bg_image_id', sanitize_text_field( $_REQUEST[ $req_perfix . 'bg-image-id' ] ) );
    }
    if ( isset( $_REQUEST[ $req_perfix . 'container-class' ] ) ) {
        update_post_meta( $post_id, $db_perfix . 'container_class', sanitize_text_field( $_REQUEST[ $req_perfix . 'container-class' ] ) );
    }
  }
}
