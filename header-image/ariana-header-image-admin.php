<?php
$fields = get_post_custom( $post->ID );
$post_header_image = isset( $fields['post_header_image'] ) ? esc_attr( $fields['post_header_image'][0] ) : '';
$post_header_image_id = isset( $fields['post_header_image_id'] ) ? esc_attr( $fields['post_header_image_id'][0] ) : '';
?>
<fieldset>
  <?php
    //wp_nonce_field( 'ariana_header_image_metabox_nonce', '_ariana_header_image_metabox_nonce');
    //nonce exist in main save post
  ?>

  <p class="post-attributes-label-wrapper">
    <!-- <label class="post-attributes-label" for="upload_image_button"><?php _e( 'Header Image', 'ariana-widgets' ); ?></label> -->
    <small>
      <?php /* translators:  select header image metabox in admin */
      _e( 'Upload your header image', 'ariana-widgets' ); ?>
    </small>
  </p>

  <p class="hide-if-no-js">
      <a title="<?php _e( 'Set Header Image', 'ariana-widgets' ) ?>" href="javascript:;" id="set-header-image-btn"><?php _e( 'Set Header Image', 'ariana-widgets' ) ?></a>
  </p>

  <div id="header-image-container" class="hidden">
      <img src="<?php echo $post_header_image; ?>" />
  </div><!-- #header-image-container -->

  <p class="hide-if-no-js hidden">
      <a title="<?php _e( 'Remove Image', 'ariana-widgets') ?>" href="javascript:;" id="remove-header-image-btn"><?php _e( 'Remove', 'ariana-widgets') ?></a> |
      <a title="<?php _e( 'Edit Image', 'ariana-widgets' ) ?>" href="javascript:;" id="change-header-image-btn"><?php _e( 'Edit', 'ariana-widgets' ) ?></a>
  </p><!-- .hide-if-no-js -->

  <p id="header-image-meta">
      <input type="hidden" id="header-image-src" name="header-image-src" value="<?php echo $post_header_image; ?>" />
      <input type="hidden" id="header-image-id" name="header-image-id" value="<?php echo $post_header_image_id; ?>" />
  </p><!-- #header-image-meta -->
