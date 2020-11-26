<?php
$fields = get_post_custom( $post->ID );
$image_src = isset( $fields['post_header_image'] ) ? esc_attr( $fields['post_header_image'][0] ) : '';
$image_id = isset( $fields['post_header_image_id'] ) ? esc_attr( $fields['post_header_image_id'][0] ) : '';
?>
<fieldset>
  <div class="ariana-header-image">
    <?php
      wp_nonce_field( 'ariana_header_image_metabox_nonce', '_ariana_header_image_metabox_nonce');
      //nonce exist in main save post
    ?>

    <p class="post-attributes-label-wrapper">
      <!-- <label class="post-attributes-label" for="upload_image_button"><?php _e( 'Header Image', 'ariana-widgets' ); ?></label> -->
      <small>
        <?php /* translators:  Header image metabox in admin */
        _e( 'Header background image', 'ariana-widgets' ); ?>
      </small>
    </p>

    <p class="hide-if-no-js">
        <a class="btn-set-image" title="<?php _e( 'Set Image', 'ariana-widgets' ) ?>" href="javascript:void(0);">
          <?php _e( 'Set Header Image', 'ariana-widgets' ) ?>
        </a>
    </p>

    <div class="image-preview hidden">
        <img src="<?php echo $image_src; ?>" />
    </div><!-- #header-image-container -->

    <p class="hide-if-no-js hidden">
        <a title="<?php _e( 'Remove Image', 'ariana-widgets') ?>" href="javascript:void(0);" class="btn-remove-image"><?php _e( 'Remove', 'ariana-widgets') ?></a>
        <a title="<?php _e( 'Edit Image', 'ariana-widgets' ) ?>" href="javascript:void(0);" class="btn-change-image"><?php _e( 'Edit', 'ariana-widgets' ) ?></a>
    </p><!-- .hide-if-no-js -->

    <p class="image-data">
        <input type="hidden" class="image-src" id="header-image-src" name="header-image-src" value="<?php echo $image_src; ?>" />
        <input type="hidden" class="image-id" id="header-image-id" name="header-image-id" value="<?php echo $image_id; ?>" />
    </p><!-- #header-image-meta -->
  </div>
</fieldset>
