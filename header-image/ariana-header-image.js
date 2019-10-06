
function renderMediaUploader( $ ) {
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
      title: 'Header Image',
            button: {
                text: 'Add Image'
            },
      multiple: false
  });

  /**
   * Setup an event handler for what to do when an image has been
   * selected.
   *
   * Since we're using the 'view' state when initializing
   * the file_frame, we need to make sure that the handler is attached
   * to the insert event.
   **/
  file_frame.on( 'insert', function() {

    // Read the JSON data returned from the Media Uploader
    var json = file_frame.state().get( 'selection' ).first().toJSON();

    // First, make sure that we have the URL of an image to display
    if ( 0 > $.trim( json.url.length ) ) {
        return;
    }

    // After that, set the properties of the image and display it
    $( '#header-image-container' )
        .children( 'img' )
            .attr( 'src', json.url )
            .attr( 'alt', json.caption )
            .attr( 'title', json.title )
            .show()
            .parent()
            .removeClass( 'hidden' );

    // Next, hide the anchor responsible for allowing the user to select an image
    $( '#header-image-container' )
        .prev()
        .hide();

    $( '#header-image-container' )
      .next()
      .show();

    // Store the image's information into the meta data fields
    $( '#header-image-src' ).val( json.url );
    $( '#header-image-id' ).val( json.id );

  });

  file_frame.on('open', function(){
      var selection = file_frame.state().get('selection');
      var selected = $('#header-image-id').val(); // the id of the image
      if (selected) {
          selection.add(wp.media.attachment(selected));
      }
  });

  // Now display the actual file_frame
  file_frame.open();

}

function resetUploadForm( $ ) {
    'use strict';

    // First, we'll hide the image
    $( '#header-image-container' )
        .children( 'img' )
        .hide();

    // Then display the previous container
    $( '#header-image-container' )
        .prev()
        .show();

    // Finally, we add the 'hidden' class back to this anchor's parent
    $( '#header-image-container' )
        .next()
        .hide()
        .addClass( 'hidden' );

    // Finally, we reset the meta data input fields
    $( '#header-image-meta' )
        .children()
        .val( '' );

}

function renderFeaturedImage( $ ) {

    /* If a thumbnail URL has been associated with this image
     * Then we need to display the image and the reset link.
     */
    if ( '' !== $.trim ( $( '#header-image-src' ).val() ) ) {

        $( '#header-image-container' ).removeClass( 'hidden' );

        $( '#set-header-image-btn' )
            .parent()
            .hide();

        $( '#remove-header-image-btn' )
            .parent()
            .removeClass( 'hidden' );

    }

}

(function( $ ) {
  'use strict';

  $(function() {
      $( '#set-header-image-btn' ).on( 'click', function( evt ) {

          // Stop the anchor's default behavior
          evt.preventDefault();

          // Display the media uploader
          renderMediaUploader( $ );

      });

      $( '#change-header-image-btn' ).on( 'click', function( evt ) {

          // Stop the anchor's default behavior
          evt.preventDefault();

          // Display the media uploader
          renderMediaUploader( $ );

      });

      $( '#remove-header-image-btn' ).on( 'click', function( evt ) {

          // Stop the anchor's default behavior
          evt.preventDefault();

          // Remove the image, toggle the anchors
          resetUploadForm( $ );

      });

      renderFeaturedImage( $ );

  });

})( jQuery );
