<?php
$req_perfix = 'header-section-';
$db_perfix = 'post_header_section_';

$fields = get_post_custom( $post->ID );

$is_active = isset( $fields[ $db_perfix . 'is_active' ] ) ? esc_attr( $fields[ $db_perfix . 'is_active' ][0] ) : '';
$breadcrumb = isset( $fields[ $db_perfix . 'breadcrumb' ] ) ? esc_attr( $fields[ $db_perfix . 'breadcrumb' ][0] ) : '';
$title = isset( $fields[ $db_perfix . 'title' ] ) ? esc_attr( $fields[ $db_perfix . 'title' ][0] ) : '';
$subtitle = isset( $fields[ $db_perfix . 'subtitle' ] ) ? esc_attr( $fields[ $db_perfix . 'subtitle' ][0] ) : '';
$desc = isset( $fields[ $db_perfix . 'desc' ] ) ? esc_attr( $fields[ $db_perfix . 'desc' ][0] ) : '';
$image_src = isset( $fields[ $db_perfix . 'image_src' ] ) ? esc_attr( $fields[ $db_perfix . 'image_src' ][0] ) : '';
$image_id = isset( $fields[ $db_perfix . 'image_id' ] ) ? esc_attr( $fields[ $db_perfix . 'image_id' ][0] ) : '';
$bg_image_src = isset( $fields[ $db_perfix . 'bg_image_src' ] ) ? esc_attr( $fields[ $db_perfix . 'bg_image_src' ][0] ) : '';
$bg_image_id = isset( $fields[ $db_perfix . 'bg_image_id' ] ) ? esc_attr( $fields[ $db_perfix . 'bg_image_id' ][0] ) : '';
$container_class = isset( $fields[ $db_perfix . 'container_class' ] ) ? esc_attr( $fields[ $db_perfix . 'container_class' ][0] ) : '';
?>
<fieldset>
  <div class="ariana-header-section">
    <?php
      wp_nonce_field( 'ariana_header_section_metabox_nonce', '_ariana_header_section_metabox_nonce');
      //nonce exist in main save post
    ?>
    <p class="post-attributes-label-wrapper">
      <label class="post-attributes-label" for="<?php echo $req_perfix ?>is-active">
        <?php
        /* translators:  Header section metabox in Admin - is active */
        _e( 'Use header section', 'ariana-widgets' ); ?></label>
      <input type="checkbox" name="<?php echo $req_perfix ?>is-active" id="<?php echo $req_perfix ?>is-active" <?php checked( $is_active, 'on' ); ?>>
    </p>

    <p class="post-attributes-label-wrapper">
      <label class="post-attributes-label" for="<?php echo $req_perfix ?>title">
        <?php
        /* translators:  Header section metabox in Admin - title */
        _e( 'Title', 'ariana-widgets' ); ?></label>
      <br>
    </p>
    <input type="text" class="widefat" name="<?php echo $req_perfix ?>title" id="<?php echo $req_perfix ?>title" value="<?php echo $title ?>">

    <p class="post-attributes-label-wrapper">
      <label class="post-attributes-label" for="<?php echo $req_perfix ?>subtitle">
        <?php
        /* translators:  Header section metabox in Admin - subtitle */
        _e( 'Subtitle', 'ariana-widgets' ); ?></label>
      <br>
    </p>
    <input type="text" class="widefat" name="<?php echo $req_perfix ?>subtitle" id="<?php echo $req_perfix ?>subtitle" value="<?php echo $subtitle ?>">

    <p class="post-attributes-label-wrapper">
      <label class="post-attributes-label" for="<?php echo $req_perfix ?>desc">
        <?php
        /* translators:  Header section metabox in Admin - Descriptions */
        _e( 'Descriptions', 'ariana-widgets' ); ?></label>
      <br>
    </p>
    <textarea class="widefat" name="<?php echo $req_perfix ?>desc" id="<?php echo $req_perfix ?>desc" rows="5" cols="40"><?php echo $desc ?></textarea>

    <p class="post-attributes-label-wrapper">
      <label class="post-attributes-label" for="<?php echo $req_perfix ?>container-class">
        <?php
        /* translators:  Header section metabox in Admin - Container Class */
        _e( 'Container Class', 'ariana-widgets' ); ?></label>
      <br>
    </p>
    <input type="text" name="<?php echo $req_perfix ?>container-class" id="<?php echo $req_perfix ?>container-class" value="<?php echo $container_class ?>">

    <p class="post-attributes-label-wrapper">
      <label class="post-attributes-label" for="<?php echo $req_perfix ?>is-active">
        <?php
        /* translators:  Header section metabox in Admin - breadcrumb */
        _e( 'Insert breadcrumb', 'ariana-widgets' ); ?></label>
      <input type="checkbox" name="<?php echo $req_perfix ?>breadcrumb" id="<?php echo $req_perfix ?>breadcrumb" <?php checked( $breadcrumb, 'on' ); ?>>
    </p>

    <hr>

    <div class="ariana-header-section-image">
      <p class="post-attributes-label-wrapper">
        <small>
          <?php /* translators:  Header section metabox in Admin - Image */
          _e( 'Header section image', 'ariana-widgets' ); ?>
        </small>
      </p>

      <p class="hide-if-no-js">
          <a  class="btn-set-image" title="<?php /* translators:  Header section metabox in Admin - Image */ _e( 'Set Image', 'ariana-widgets' ) ?>" href="javascript:void(0);">
            <?php /* translators:  Header section metabox in Admin - Image */ _e( 'Set Image', 'ariana-widgets' ) ?>
          </a>
      </p>

      <div class="image-preview hidden">
          <img src="<?php echo $image_src; ?>" />
      </div>

      <p class="hide-if-no-js hidden">
          <a title="<?php _e( 'Remove Image', 'ariana-widgets') ?>" href="javascript:void(0);" class="btn-remove-image"><?php _e( 'Remove', 'ariana-widgets') ?></a>
          <a title="<?php _e( 'Edit Image', 'ariana-widgets' ) ?>" href="javascript:void(0);" class="btn-change-image"><?php _e( 'Edit', 'ariana-widgets' ) ?></a>
      </p><!-- .hide-if-no-js -->

      <p class="image-data">
          <input type="hidden" class="image-src" id="<?php echo $req_perfix ?>image-src" name="<?php echo $req_perfix ?>image-src" value="<?php echo $image_src; ?>" />
          <input type="hidden" class="image-id" id="<?php echo $req_perfix ?>image-id" name="<?php echo $req_perfix ?>image-id" value="<?php echo $image_id; ?>" />
      </p>
    </div>

    <hr>

    <div class="ariana-header-section-bg-image">
      <p class="post-attributes-label-wrapper">
        <small>
          <?php /* translators:  Header section metabox in Admin - background image */
          _e( 'Header section background image', 'ariana-widgets' ); ?>
        </small>
      </p>

      <p class="hide-if-no-js">
          <a class="btn-set-image" title="<?php /* translators:  Header section metabox in Admin - background image */ _e( 'Set Background Image', 'ariana-widgets' ) ?>" href="javascript:void(0);">
            <?php /* translators:  Header section metabox in Admin - background image */ _e( 'Set Background Image', 'ariana-widgets' ) ?>
          </a>
      </p>

      <div class="image-preview hidden">
          <img src="<?php echo $bg_image_src; ?>" />
      </div>

      <p class="hide-if-no-js hidden">
          <a title="<?php _e( 'Remove Image', 'ariana-widgets') ?>" href="javascript:void(0);" class="btn-remove-image"><?php _e( 'Remove', 'ariana-widgets') ?></a>
          <a title="<?php _e( 'Edit Image', 'ariana-widgets' ) ?>" href="javascript:void(0);" class="btn-change-image"><?php _e( 'Edit', 'ariana-widgets' ) ?></a>
      </p><!-- .hide-if-no-js -->

      <p class="image-data">
          <input type="hidden" class="image-src" id="<?php echo $req_perfix ?>bg-image-src" name="<?php echo $req_perfix ?>bg-image-src" value="<?php echo $bg_image_src; ?>" />
          <input type="hidden" class="image-id" id="<?php echo $req_perfix ?>bg-image-id" name="<?php echo $req_perfix ?>bg-image-id" value="<?php echo $bg_image_id; ?>" />
      </p>
    </div>

  </div>
</fieldset>
