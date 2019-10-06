<?php


function ariana_header_image_add_metabox() {

      $screens = array( 'post', 'page', 'ariana-services', 'ariana-projects' );

      foreach ( $screens as $screen ) {

        add_meta_box(
        'ariana-header-image-metabox',
        esc_html__( 'Header Image', 'ariana-widgets' ),
        'ariana_header_image_metabox',
        $screen,
        'side',
        'high' );

      }

}
add_action( 'add_meta_boxes', 'ariana_header_image_add_metabox' );

// START: Add script and styles for header image
function ariana_header_image_metabox_scripts()
{

  wp_enqueue_media();

  // wp_enqueue_script(
  //   'ariana-header-image-metabox-js',
  //   plugin_dir_url( __FILE__ ) . 'js/admin.js',
  //   array( 'jquery' ),
  //   $this->version,
  //   'all'
  // );

}
add_action( 'admin_enqueue_scripts', 'ariana_header_image_metabox_scripts' );

function ariana_header_image_metabox( $post ) {
	$fields = get_post_custom( $post->ID );
  ?>
  <fieldset>
    <?php wp_nonce_field( 'ariana_header_image_metabox_nonce', '_ariana_header_image_metabox_nonce'); ?>

    <p class="post-attributes-label-wrapper">
  		<label class="post-attributes-label" for="upload_image_button"><?php _e( 'Header Image', 'ariana-widgets' ); ?></label>
			<small>
        <?php /* translators:  this is header image in services admin page */
        // _e( 'Upload your header image for services single page', 'ariana-widgets' ); ?>
      </small>
  	</p>

    <p class="hide-if-no-js">
        <a title="Set Footer Image" href="javascript:;" id="set-footer-thumbnail">Set featured image</a>
    </p>

    <div id="featured-footer-image-container" class="hidden">
        <img src="<?php echo get_post_meta( $post->ID, 'footer-thumbnail-src', true ); ?>" style="width:100%" />
    </div><!-- #featured-footer-image-container -->

    <p class="hide-if-no-js hidden">
        <a title="Remove Footer Image" href="javascript:;" id="remove-footer-thumbnail">Remove featured image</a>
    </p><!-- .hide-if-no-js -->

    <p id="featured-footer-image-meta">
        <input type="text" id="footer-thumbnail-src" name="footer-thumbnail-src" value="<?php echo get_post_meta( $post->ID, 'footer-thumbnail-src', true ); ?>" />
    </p><!-- #featured-footer-image-meta -->
		<script>
    /**
    * Callback function for the 'click' event of the 'Set Footer Image'
    * anchor in its meta box.
    *
    * Displays the media uploader for selecting an image.
    *
    * @since 0.1.0
    */
    function renderMediaUploader() {
      'use strict';

      var file_frame, image_data;

      /**
       * If an instance of file_frame already exists, then we can open it
       * rather than creating a new instance.
       */
      if ( undefined !== file_frame ) {

          file_frame.open();
          return;

      }

      /**
       * If we're this far, then an instance does not exist, so we need to
       * create our own.
       *
       * Here, use the wp.media library to define the settings of the Media
       * Uploader. We're opting to use the 'post' frame which is a template
       * defined in WordPress core and are initializing the file frame
       * with the 'insert' state.
       *
       * We're also not allowing the user to select more than one image.
       */
      file_frame = wp.media.frames.file_frame = wp.media({
          frame:    'post',
          state:    'insert',
          multiple: false
      });

      /**
       * Setup an event handler for what to do when an image has been
       * selected.
       *
       * Since we're using the 'view' state when initializing
       * the file_frame, we need to make sure that the handler is attached
       * to the insert event.
       */
      file_frame.on( 'insert', function() {

        // Read the JSON data returned from the Media Uploader
        var json = file_frame.state().get( 'selection' ).first().toJSON();

        // First, make sure that we have the URL of an image to display
        if ( 0 > $.trim( json.url.length ) ) {
            return;
        }

        // After that, set the properties of the image and display it
        $( '#featured-footer-image-container' )
            .children( 'img' )
                .attr( 'src', json.url )
                .attr( 'alt', json.caption )
                .attr( 'title', json.title )
                .show()
                .parent()
                .removeClass( 'hidden' );

        // Next, hide the anchor responsible for allowing the user to select an image
        $( '#featured-footer-image-container' )
            .prev()
            .hide();

        $( '#featured-footer-image-container' )
          .next()
          .show();

        // Store the image's information into the meta data fields
        $( '#footer-thumbnail-src' ).val( json.url );

      });

      // Now display the actual file_frame
      file_frame.open();

    }

    function resetUploadForm( $ ) {
        'use strict';

        // First, we'll hide the image
        $( '#featured-footer-image-container' )
            .children( 'img' )
            .hide();

        // Then display the previous container
        $( '#featured-footer-image-container' )
            .prev()
            .show();

        // Finally, we add the 'hidden' class back to this anchor's parent
        $( '#featured-footer-image-container' )
            .next()
            .hide()
            .addClass( 'hidden' );

        // Finally, we reset the meta data input fields
        $( '#featured-footer-image-meta' )
            .children()
            .val( '' );

    }

    function renderFeaturedImage( $ ) {

        /* If a thumbnail URL has been associated with this image
         * Then we need to display the image and the reset link.
         */
        if ( '' !== $.trim ( $( '#footer-thumbnail-src' ).val() ) ) {

            $( '#featured-footer-image-container' ).removeClass( 'hidden' );

            $( '#set-footer-thumbnail' )
                .parent()
                .hide();

            $( '#remove-footer-thumbnail' )
                .parent()
                .removeClass( 'hidden' );

        }

    }

    (function( $ ) {
      'use strict';

      $(function() {
          $( '#set-footer-thumbnail' ).on( 'click', function( evt ) {

              // Stop the anchor's default behavior
              evt.preventDefault();

              // Display the media uploader
              renderMediaUploader();

          });

          $( '#remove-footer-thumbnail' ).on( 'click', function( evt ) {

              // Stop the anchor's default behavior
              evt.preventDefault();

              // Remove the image, toggle the anchors
              resetUploadForm( $ );

          });

          renderFeaturedImage( $ );

      });

    })( jQuery );
		</script>

  </fieldset>
	<?php
}

function ariana_header_image_save_post( $post_id ) {

    if ( isset( $_REQUEST['footer-thumbnail-src'] ) ) {
        update_post_meta( $post_id, 'footer-thumbnail-src', sanitize_text_field( $_REQUEST['footer-thumbnail-src'] ) );
    }

}
add_action( 'save_post', 'ariana_header_image_save_post' );

?>
