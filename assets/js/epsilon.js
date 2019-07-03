// jscs:ignore validateLineBreaks
jQuery(function( $ ) {
	var mediaControl = {

		// Initializes a new media manager or returns an existing frame.
		// @see wp.media.featuredImage.frame()
		selector: null,
		size: null,
		container: null,
		frame: function() {
			if ( this._frame ) {
                return this._frame;
			}

			this._frame = wp.media.frames.frame = wp.media({
				title: 'Media',
				button: {
					text: 'Update'
				},
				multiple: false,
				states: [
					new wp.media.controller.Library({
							title: 'Media 2',
							filterable: 'all',
							multiple: false
					})
				]
			});

			this._frame.on( 'open', this.updateFrame ).state( 'library' ).on( 'select', this.select );

			return this._frame;
		},

		updateFrame: function() {
			var selected_item_el = $( mediaControl.selector );
			var selected_item = selected_item_el.val();
			var state_selection = mediaControl.frame().state().get( 'selection' );
			state_selection.reset( selected_item ? [ wp.media.attachment( selected_item ) ] : [] );
		},

		select: function() {

			// Do something when the "update" button is clicked after a selection is made.
			var id = $( '.attachments' ).find( '.selected' ).attr( 'data-id' );
			var selector = $( '.ariana-media-control' ).find( mediaControl.selector );
      var data = {
          action: 'ariana_get_attachment_media',
          attachment_id: id
      };

			if ( ! selector.length ) {
				return false;
			}

			jQuery.post( ajaxurl, data, function( response ) {
				var ext = response.substr( ( response.lastIndexOf( '.' ) + 1 ) );
				if ( 'mp4' === ext ) {
					$( mediaControl.container ).find( '.video-path' ).text( response );
				} else {
					$( mediaControl.container ).find( 'img' ).attr( 'src', response );
				}

				// selector.val( response );
				selector.val( data['attachment_id'] );
				selector.trigger( 'change' );
			});
		},

		init: function() {
			var context = $( '#wpbody, .wp-customizer' );
			context.on( 'click', '.ariana-media-control > .upload-button', function( e ) {
			var container = $( this ).parent(),
					sibling = container.find( '.image-id' ),
					id = sibling.attr( 'id' );
      e.preventDefault();
			mediaControl.size = $( '[data-delegate="' + id + '"]' ).val();
			mediaControl.container = container;
			mediaControl.selector = '#' + id;

			mediaControl.frame().open();
			});

			context.on( 'click', '.ariana-media-control > .remove-button', function( e ) {
				var container = $( this ).parent(),
						sibling = container.find( '.image-id' ),
						img = container.find( 'img' ),
						span = container.find( '.video-path' );
        e.preventDefault();
				img.attr( 'src', '' );
				span.text( '' );
				sibling.val( '' ).trigger( 'change' );
			});
		}
	};

	mediaControl.init();
});
